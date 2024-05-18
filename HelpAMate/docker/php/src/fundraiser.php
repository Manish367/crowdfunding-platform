<?php
    session_start();
    include_once "includes/public_connection.php";

    if (isset($_GET['frid'])) {
        $frId = trim(mysqli_real_escape_string($dbc, $_GET['frid']));
        $_SESSION['frId'] = $frId;
    } else {
        header("Location: index.php");
    }
    
    //add query for fundraisers
    $fundraiser_query = "SELECT * FROM Fundraiser WHERE FundraiserId = ".$frId;
    
    $fundraiser_result = mysqli_query($dbc, $fundraiser_query);
    $fundraiser_record = mysqli_fetch_assoc($fundraiser_result);
    $title = $fundraiser_record['FName']." ".$fundraiser_record['LName']." | ".$fundraiser_record['Charity'];

    if (empty($fundraiser_record)) {
        header("Location: index.php");
    }

    include_once "includes/page_template.php";
    include_once "includes/login.php";
    include_once "includes/pledge.php";
    include_once "includes/remove_pledge.php";
    $_SESSION['page'] = 'fundraiser.php?frid='.$frId;


    $sum_query = "SELECT SUM(Pledge) FROM Pledges WHERE FundraiserId = ".$frId;
    $sum_result = mysqli_query($dbc, $sum_query);
    $sum_record = mysqli_fetch_assoc($sum_result);
    $ammt_raised = $sum_record['SUM(Pledge)'];

    if($ammt_raised == '') {
        $ammt_raised = 0;
    }
    $percentage = number_format($ammt_raised / $fundraiser_record['Goal'] * 100, 2);

    if ($percentage >= 100) {
        $width_percentage =100;
    } else {
        $width_percentage = $percentage;
    }
?>


    
    <div class="content fundraiser">
        <?php
            if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == $frId
                || $_SESSION['loggedIn'] == 'admin')) {
                echo "<span id='edit'><a href='user_info.php?action=Edit'>Edit</a></span>";
                $fundraiser = array("Frid"=>$frId, "FName"=>$fundraiser_record['FName'],
                                "LName"=>$fundraiser_record['LName'], "dob"=>$fundraiser_record['DoB'],
                                    "Email"=>$fundraiser_record['Email'], "Charity"=>$fundraiser_record['Charity'],
                                    "Blurb"=>$fundraiser_record['Blurb'], "Goal"=>$fundraiser_record['Goal']);
                $_SESSION['activeUser'] = $fundraiser;
            }
            echo <<<HTML
                    <h1>{$fundraiser_record['FName']} {$fundraiser_record['LName']}</h1>
                    <div class='charity'>{$fundraiser_record["Charity"]}</div>
                    <div class='blurb'>{$fundraiser_record["Blurb"]}</div>
                    <div><br>Raised - \${$ammt_raised} of \${$fundraiser_record['Goal']}</div>
                    <div class='goal'>
                        <div class='progress_wrapper'>
                            <p>$percentage%</p>
                            <div class='progress' style='width:{$width_percentage}%'></div>
                        </div>
                    </div>
                    <div class='donate'>
                        <button onclick='toggleHide(this)' class='pledge submit'>Pledge Now!</button>
                    </div>
                HTML;
        ?>
    </div>
    
    <div id='pledges'>
        <?php
            $pledge_query = "SELECT * FROM Pledges WHERE FundraiserId = ".$frId;
            $pledge_result = mysqli_query($dbc, $pledge_query);
            while($pledge_record = mysqli_fetch_assoc($pledge_result)) {
                echo <<<HTML
                        <div class='content pledgeBox' style='margin-top: 10px;'>
                            <span class='donor'>
                                <h3>{$pledge_record["DisplayName"]}</h3>
                        HTML;
                if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == $frId
                || $_SESSION['loggedIn'] == 'admin')) {
                    echo '<div class="pledgeBox remove" onclick="toggleHide(this)" data-pledge-id="'
                        . $pledge_record["DonationId"] . '" data-pledge-name="' . $pledge_record["DisplayName"]
                        . '" data-pledge-amount="' . $pledge_record["Pledge"] . '">&#xD7;</div>';
                            }
                echo <<<HTML
                            </span>
                            <p>Pledged \${$pledge_record["Pledge"]}</p>
                        </div>
                    HTML;
            }
        ?>
    </div>
            
    </main>
    </body>
</html>
