<?php
echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <title>$title</title>

                    <meta name="description" content="#">
                    <link href="css/styles.css" rel="stylesheet">

                    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
                    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
                    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
                    <link rel="manifest" href="images/favicon/site.webmanifest">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
                    <script src="scripts/togglehide.js"></script>
                </head>

                <body >

                <header>
                    <nav>
                        <h1 class="title"><a href="index.php">Help a Mate</a></h1>
                        <ul>
                            <li><a href="index.php">Explore</a></li>
                            <li><a href="about.php">About</a></li>
    HTML;

    if(isset($_SESSION['loggedIn'])) {
        echo "<li><button class='login' id='logout'
                onclick='window.location.href=\"process_login.php\"'>Logout</button></li>";
    } else {
        echo "<li><button class='login' id='login' onclick='toggleHide(this)'>Login / Create</button></li>";
    }

    echo <<<HTML
                </ul>
            </nav>
        </header>

        <main>
        HTML;
    
        if(isset($_SESSION["loginError"]) && !isset($_SESSION["loggedIn"]) && is_null($_SESSION["loginError"])) {
            echo '<div class="blurbg" style="display: block;"></div>';
        } else {
            echo '<div class="blurbg"></div>';
        }
