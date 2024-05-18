<?php
    session_start();
    include_once "includes/public_connection.php";
    
    $title = "About | Help a Mate";

    include_once "includes/page_template.php";
    include_once "includes/login.php";

    $_SESSION['page'] = 'about.php';

    echo <<<HTML


    <div class="content" id="about-image" title="Photo by Adonyi Gábor from Pexels"
            alt="Photo of yellow flowers by Adonyi Gábor from Pexels">
    </div>
    
    <div class="content">

        <h2>About</h2>
        
        <p>
            Here at Help a Mate we are dedicated to providing a platform for people to spread love
            and bring joy to other people's lifes. Fundraisers can create an account to raise funds for
            anything from personal adventures to starting a charity event.
            Find something you are passionate about and share it with the world!
        </p>
        <p>
            <br>
            <strong>Please note that this is a mock website and is not intended to be used for fundraising</strong>
            <br>
            This was created for my NCEA level 3 Web development course where we learnt about PHP, JavaScript and SQL.
            We were tasked with making a fundraising website that links to a backend
            database with secure logins and fast responses times.
        </p>

    </div>
            
</main>

        
    </body>
</html>
HTML;
