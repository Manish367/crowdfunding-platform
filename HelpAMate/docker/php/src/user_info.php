<?php
session_start();

include_once "includes/public_connection.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    header("Location: " . $_SESSION['page']);
}

$_SESSION['page'] = "user_info.php?action=" . $action;


if ($action == 'Create' && isset($_SESSION['activeUser'])) {
    $title = "Sign up!";
} elseif ($action == 'Edit' && isset($_SESSION['activeUser'])) {
    $title = "Update";
} elseif ($action == 'Create') {
    $title = "Sign up!";
} else {
    header("Location: index.php");
}

include_once "includes/page_template.php";
include_once "includes/login.php";

if ($title == "Update") {
    include_once "includes/delete.php";
}
$user = $_SESSION['activeUser'];
$value = "value='";

echo <<<HTML
    <div class="content">
        <form method='post' action='process_fundraiser.php'>
            <div class='form' id="create_fundraiser">
                <h2>$title</h2>
    HTML;

if (isset($_SESSION['error'])) {
    echo "<p id='" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

echo "<label for='FName'>First Name</label>\n";
if (isset($user['FName'])) {
    echo "<input type='text' id='FName' name='FName' placeholder='First Name' required
            value='" . $user['FName'] . "'>\n";
} else {
    echo "<input type='text' id='FName' name='FName' placeholder='First Name' required>\n";
}

echo "<label for='LName'>Last Name</label>\n";
if (isset($user['LName'])) {
    echo "<input type='text' id='LName' name='LName' placeholder='Last Name' required
            value='" . $user['LName'] . "'>\n";
} else {
    echo "<input type='text' id='LName' name='LName' placeholder='Last Name' required>\n";
}

echo "<label for='dob'>Date of Birth</label>\n";
if (isset($user['dob'])) {
    echo "<input type='date' id='dob' name='dob' placeholder='Date of Birth' required
            value='" . $user['dob'] . "'>\n";
} else {
    echo "<input type='date' id='dob' name='dob' placeholder='Date of Birth' required>\n";
}

echo "<label for='email'>Email</label>\n";
if (isset($user['Email'])) {
    echo "<input type='email' id='email' name='Email' placeholder='Email' required
            value='" . $user['Email'] . "'>\n";
} else {
    echo "<input type='email' id='email' name='Email' placeholder='Email' required>\n";
}


if ($title == "Sign up!") {
    echo <<<HTML
        <label for='Password'>Password</label>
        <input type='password' id='Password' name='Password' placeholder='Password' required>
        <label for='ConfirmPassword'>Confirm Password</label>
        <input type='password' id='ConfirmPassword' name='ConfirmPassword'
            placeholder='Confirm Password' required>
        HTML;
}

echo "<label for='Charity'>Charity to Support</label>\n";
if (isset($user['Charity'])) {
    echo "<input type='text' id='Charity' name='Charity' placeholder='Charity to Support' required
            value='" . $user['Charity'] . "'>\n";
} else {
    echo "<input type='text' id='Charity' name='Charity' placeholder='Charity to Support' required>\n";
}

echo "<label for='Blurb'>Blurb</label>\n";
if (isset($user['Blurb'])) {
    echo "<textarea type='text' id='Blurb' name='Blurb' placeholder='Blurb' required>"
            . $user['Blurb'] . "</textarea>\n";
} else {
    echo "<textarea type='text' id='Blurb' name='Blurb' placeholder='Blurb' required></textarea>\n";
}

echo "<label for='Goal'>Goal</label>
            <div class='flex'>
                <span class='currency'>$</span>\n";
if (isset($user['Goal'])) {
    echo "<input type='number' id='Goal' name='Goal' placeholder='100' max='50000' min='100' required
            value='" . $user['Goal'] . "'>\n";
} else {
    echo "<input type='number' id='Goal' name='Goal' placeholder='100' max='50000' min='100' required>\n";
}
echo <<<HTML
            </div>
            <input type="submit" name="submit" value="$title" class="submit">
        </div>
    </form>
</div>
HTML;

if ($title == "Update") {
    echo <<<HTML
    <div class="content">
        <div class="form">
            <h3>Delete</h3>
            <button class='delete' onclick='toggleHide(this)'>Delete</button>
        </div>
    </div>
    HTML;
}

echo <<<HTML
</main>


    </body>
</html>
HTML;
