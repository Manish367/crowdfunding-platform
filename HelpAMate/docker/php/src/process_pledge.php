<?php
    session_start();
    include_once 'includes/admin_connection.php';

    function donorCheck($dbc) {
        $dbcheckQuery = "SELECT * FROM Donors WHERE DonorEmail = '".$_SESSION['DonorEmail']."'";
        $dbcheckResult = mysqli_query($dbc, $dbcheckQuery);
        return mysqli_fetch_assoc($dbcheckResult);
    }

    function insertDonation($dbc) {
        // Check pledge is positive
        if($_SESSION['Pledge'] <= 5) {
            $_SESSION['Pledge'] = 5;
            $_SESSION['pledgeError'] = "error'>Pledge must be greater than or equal to 5";
            header("Location: ".$_SESSION['page']);
            exit;
        } elseif ($_SESSION['Pledge'] > 100) {
            $_SESSION['Pledge'] = 100;
            $_SESSION['pledgeError'] = "error'>Pledge must be less than or equal to 100";
            header("Location: ".$_SESSION['page']);
            exit;
        }

        // Insert donation in to db
        $addPledge = $dbc->prepare("INSERT INTO Pledges (DonorEmail, FundraiserId, Pledge, DisplayName)
                                    VALUES (?, ?, ?, ?)");
        $addPledge->bind_param("siis", $_SESSION['DonorEmail'], $_SESSION['frId'],
                                        $_SESSION['Pledge'], $_SESSION['DisplayName']);
        $addPledge->execute();
        $addPledge->close();
        header("Location: ".$_SESSION['page']);
        exit;
    }

    // Set variables using data sent from pledge.php form
    if (isset($_POST['DonorEmail']) && isset($_POST['DisplayName']) && isset($_POST['radio'])) {
        $email = trim(mysqli_real_escape_string($dbc, $_POST['DonorEmail']));
        $displayName = trim(mysqli_real_escape_string($dbc, $_POST['DisplayName']));
        $pledge = trim(mysqli_real_escape_string($dbc, $_POST['radio']));
        
        // Set variables to sessions
        $_SESSION['DonorEmail'] = $email;
        $_SESSION['DisplayName'] = $displayName;
        $_SESSION['Pledge'] = $pledge;
            
        // Get user inputed number when other was selected
        if($pledge == 'on') {
            $pledge = trim(mysqli_real_escape_string($dbc, $_POST['other']));
            $_SESSION['Pledge'] = $pledge;
        }
    }

    if(isset($email)) {
        // Check if email is in the data base
        $dbcheckRecord = donorCheck($dbc);
        
        if (isset($dbcheckRecord['DonorEmail']) && $dbcheckRecord['DonorEmail'] == $_SESSION['DonorEmail']) {
            $_SESSION['DonorEmail'] = $dbcheckRecord['DonorEmail'];
            header("Location: email_check.php");
            exit;
        }
        
        if(isset($dbcheckRecord['DonorEmail'])) {
            $_SESSION['DonorEmail'] = $dbcheckRecord['DonorEmail'];
        } else {
            // Add new donor
            $add_donor = $dbc->prepare("INSERT INTO Donors (DonorEmail) VALUES (?)");
            $add_donor->bind_param("s", $_SESSION['DonorEmail']);
            $add_donor->execute();
            $add_donor->close();
            // Get their Id
            $dbcheckRecord = donorCheck($dbc);
            $_SESSION['DonorEmail'] = $dbcheckRecord['DonorEmail'];
            insertDonation($dbc);
        }
        
    }

    if(isset($_POST['submit'])){
        if($_POST['submit'] == 'Yes') {
            insertDonation($dbc);
        } elseif ($_POST['submit'] == 'No') {
            // Ask for new email
            $_SESSION['pledgeError'] = "error'>Please enter a new email";
            header('Location: '.$_SESSION['page']);
            exit;
        }
    }

    header("Location: ".$_SESSION['page']);
    exit;
