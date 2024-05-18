<?php
if(isset($_SESSION["loginError"]) && !isset($_SESSION["loggedIn"]) && is_null($_SESSION["loginError"])) {
    echo '<div class="display-box loginpopup" style="display: block;">';
} else {
    echo '<div class="display-box loginpopup">';
}
echo <<<HTML
                <form method="post" action="process_login.php" >
                    <div class="form">
                        <span class="close login" onclick='toggleHide(this)'>&#xD7;</span>
                        <h2>Login</h2>
    HTML;
    
if(isset($_SESSION["loginError"])) {
    echo "<p id='".$_SESSION["loginError"]."</p>";
}

echo <<<HTML
            <input type="text" name="username" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <span>
                <input name="submit" type="submit" value="Create Fundraiser" class="submit">
                <input name="submit" type="submit" value="Login" class="submit">
            </span>
        </div>
    </form>
</div>
HTML;
