<?php
    session_start();
    include_once 'includes/admin_connection.php';

    $homePage = "Location: index.php";

    if(isset($_POST['submit']) && $_POST['submit'] != "Delete") {
        
        $check = 0;
        
        $fname = trim(mysqli_real_escape_string($dbc, $_POST['FName']));
        $lname = trim(mysqli_real_escape_string($dbc, $_POST['LName']));
        $userDob = trim(mysqli_real_escape_string($dbc, $_POST['dob']));
        $email = trim(mysqli_real_escape_string($dbc, $_POST['Email']));
        $charity = trim(mysqli_real_escape_string($dbc, $_POST['Charity']));
        $blurb = trim($_POST['Blurb']);
        $goal = trim(mysqli_real_escape_string($dbc, $_POST['Goal']));
        
        // Password Check
        if(isset($_POST['Password']) && isset($_POST['ConfirmPassword'])
            && $_POST['ConfirmPassword'] == $_POST['Password']) {
            $password = $_POST['Password'];
            $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        } elseif($_POST['submit'] == "Sign up!") {
            $_SESSION['error'] = "error'>Please make sure your passwords match";
            $check = 1;
        }
        
        /* Calculate Age */
        /* https://thisinterestsme.com/php-calculate-age-date-of-birth/ */
        $dob = new DateTime($userDob);
        $now = new DateTime();
        $difference = $now->diff($dob);
        $age = $difference->y;
        
        /* Error Checking */
        
        if (strlen($fname) > 30 || strlen($fname) == 0 && $_SESSION['loggedin'] = 1) {
            $check = 1;
            $_SESSION['error'] = "error'>First Name must be between 1 and 30 characters";
            $fname = '';
        } elseif (strlen($lname) > 30 || strlen($lname) == 0) {
            $check = 1;
            $_SESSION['error'] = "error'>Last Name must be between 1 and 30 characters";
            $lname = '';
        } elseif ($age <= 13 || $age >= 120){
            $check = 1;
            $_SESSION['error'] = "error'>You must be between 13 and 120";
            $userDob = '';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check = 1;
            $_SESSION['error'] = "error'>Please enter a valid email\n".$email;
            $email = '';
        } elseif (strlen($charity) < 0 || strlen($charity) > 50) {
            $check = 1;
            $_SESSION['error'] = "error'>Your charity name must be less than 50 characters";
            $charity = '';
        } elseif (strlen($blurb) < 0 || strlen($blurb) > 250) {
            $check = 1;
            $_SESSION['error'] = "error'>Your blurb must be less than 250 characters";
            $blurb = '';
        } elseif ($goal < 100 || $goal > 50000) {
            $check = 1;
            $_SESSION['error'] = "error'>Your goal must be more than $100 and less than $50,000";
            $goal = '';
        }
        
        if(isset($_SESSION['activeUser']['Frid'])) {
            $frid = $_SESSION['activeUser']['Frid'];
            $fundraiser = array("Frid"=> $frid,"FName"=>$fname, "LName"=>$lname, "dob"=>$userDob,
                                    "Email"=>$email, "Charity"=>$charity, "Blurb"=>$blurb, "Goal"=>$goal);
        } else {
            $fundraiser = array("FName"=>$fname, "LName"=>$lname, "dob"=>$userDob,
                                    "Email"=>$email, "Charity"=>$charity, "Blurb"=>$blurb, "Goal"=>$goal);
        }
        
        $_SESSION['activeUser'] = $fundraiser;
        
        if ($check == 1) {
            $_SESSION['activeUser'] = $fundraiser;
            header("Location: " . $_SESSION['page']);
            exit;
        }
    }

    if ($_POST['submit'] == "Sign up!") {
        $add_pledge = $dbc->prepare("INSERT INTO `Fundraiser`(`FName`, `LName`, `DoB`,
                    `Email`, `Password`, `Charity`, `Blurb`, `Goal`)
                VALUES (?,?,?,?,?,?,?,?)");
        $add_pledge->bind_param("sssssssi", $fname, $lname, $userDob, $email,
            $bcrypt_password, $charity, $blurb, $goal);
        $add_pledge->execute();
        $add_pledge->close();
        
        $dbcheck_query = "SELECT FundraiserId FROM Fundraiser WHERE Email = '".$email."'";
        $dbcheck_result = mysqli_query($dbc, $dbcheck_query);
        $dbcheck_record = mysqli_fetch_assoc($dbcheck_result);
        
        $frid = $dbcheck_record['FundraiserId'];
        $_SESSION['loggedIn'] = $frid;
        
        header("Location: fundraiser.php?frid=".$frid);
        exit;
        
    } elseif ($_POST['submit'] == "Update") {
        $user = $_SESSION['activeUser'];
        
        $update_fundraiser = $dbc->prepare("UPDATE `Fundraiser` SET `FName` = ?,`LName` = ?,
                                            `DoB` = ?,`Email` = ?,`Charity` = ?,
                                            `Blurb` = ? ,`Goal` = ? WHERE FundraiserId = ?");
        $update_fundraiser->bind_param("ssssssii", $fname, $lname, $userDob, $email, $charity, $blurb, $goal, $frid);
        $update_fundraiser->execute();
        $update_fundraiser->close();
        
        header("Location: fundraiser.php?frid=".$frid);
        exit;
        
    } elseif ($_POST['submit'] == "Delete") {
        if (isset($_POST['Password'])) {
            $pass = $_POST['Password'];
        } else {
            header($homePage);
        }
        
        $pass_query = $dbc->prepare("SELECT Password FROM Fundraiser WHERE FundraiserId = ?");
        $pass_query->bind_param('i', $_POST["frid"]);
        $pass_query->execute();
        $pass_query->bind_result($storedPass);
        $pass_query->fetch();
        $pass_query->close();
        
        if (password_verify($pass, $storedPass)) {
            $delete_user = $dbc->prepare("DELETE FROM Fundraiser WHERE FundraiserId = ?");
            $delete_user->bind_param('i', $_POST["frid"]);
            $delete_user->execute();
            $delete_user->close();

            // delete from pledges
            $delete_pledge = $dbc->prepare("DELETE FROM Pledges WHERE FundraiserId = ?");
            $delete_pledge->bind_param('i', $_POST["frid"]);
            $delete_pledge->execute();
            $delete_pledge->close();

            // Check query executed
            $test = $dbc->prepare("SELECT FundraiserId FROM Fundraiser WHERE FundraiserId = ?");
            $test->bind_param('i', $_POST["frid"]);
            $test->execute();
            $test->bind_result($test);
            $test->fetch();
            $nrows = $test->num_rows;
            $test->close();

            if ($nrows > 0) {
                $_SESSION['error'] = "error'>There was an error deleting your account. Please contact support";
                header("Location: " . $_SESSION['page']);
                exit;
            }
        } else {
            $_SESSION['error'] = "error'>Incorrect password";
            header("Location: " . $_SESSION['page']);
            exit;
        }
        
        unset($_SESSION['activeUser']);
        unset($_SESSION['loggedIn']);
        header($homePage);
        exit;
    } else {
        header($homePage);
        exit;
    }
