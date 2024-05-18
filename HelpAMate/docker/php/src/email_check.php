<?php

    session_start();

    $title = "Email Check";
    include_once "includes/page_template.php";


echo <<<HTML
    <div class="content">
        <form method='post' action="process_pledge.php">
            <div class="form" id="emailcheck">
                <span>You have used this email address before: <br></span>
                <span id='email'>{$_SESSION['DonorEmail']}<br></span>
                <span>Would you like to use it again?<br></span>
                <span?>
                    <input type="submit" name='submit' class="submit" value="Yes">
                    <input type="submit" name='submit' class="submit" value="No">
                </span>
            </div>
        </form>
    </div>
    
</main>

    </body>
</html>
HTML;
