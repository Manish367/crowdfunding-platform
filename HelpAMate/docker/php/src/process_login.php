<?php
    session_start();
    include_once 'includes/admin_connection.php';

    $previous_page_redirect = "Location: ".$_SESSION['page'];


    function error() {
        global $previous_page_redirect;
        unset($_SESSION['loggedin']);
        $_SESSION['loginError'] = "error'> Incorrect Login Info";
        header($previous_page_redirect);
        exit;
    }

    if(isset($_POST['username']) && $_POST['username'] !== "") {
        $user = strtolower(trim($_POST['username']));
        $pass = trim($_POST['password']);
        
        if ($user == "admin") {
            $login_query = $dbc->prepare("SELECT Password FROM Admin WHERE Username = ?");
            $login_query->bind_param('s', $user);
            $login_query->execute();
            $login_query->bind_result($storedPass);
            $login_query->fetch();
            
            if($verify = password_verify($pass, $storedPass)) {
                $_SESSION['loggedIn'] = 'admin';
                unset($_SESSION['loginError']);
                header($previous_page_redirect);
                exit;
            } else {
                error();
            }
        } else {
                $login_query = $dbc->prepare("SELECT FundraiserId, Password FROM Fundraiser WHERE Email = ?");
                $login_query->bind_param('s', $user);
                $login_query->execute();
                $login_query->bind_result($frid, $storedPass);
                $login_query->fetch();
            
                if(isset($frid) && isset($storedPass)) {
                    if($verify = password_verify($pass, $storedPass)) {
                        $_SESSION['loggedIn'] = $frid;
                        unset($_SESSION['loginError']);
                        header("Location: fundraiser.php?frid=".$frid);
                        exit;
                    } else {
                        error();
                    }
                } else {
                    error();
                }
            }

        } elseif (isset($_POST['submit']) && $_POST['submit'] == "Create Fundraiser") {
            header("Location: user_info.php?action=Create");
            exit;
        } else {
            foreach($_SESSION as $key => $val) {
                if ($key !== 'page') {
                  unset($_SESSION[$key]);
                }
            }
            header($previous_page_redirect);
            exit;
        }
