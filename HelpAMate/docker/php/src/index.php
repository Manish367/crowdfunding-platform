<?php
    session_start();
    include_once "includes/public_connection.php";
    if(isset($_SESSION["loginerror"])) {
        session_unset($_SESSION["loginerror"]);
    }
    
    $title = "Explore | Help a Mate";
    include_once "includes/page_template.php";

    include_once "includes/login.php";

    $fundraiser_query = "SELECT FundraiserId, FName, LName, Charity, Blurb, Goal
    FROM Fundraiser";
    
    $fundraiser_result = mysqli_query($dbc, $fundraiser_query);

    $_SESSION['page'] = 'index.php';
?>

            <div id="fundraisers">
                <div class="content" id="banner">
                    <strong>This is a mock website and not to be used for actual fundraisers.</strong>
                </div>
                <?php
                    while ($fundraiser_record = (mysqli_fetch_assoc($fundraiser_result))) {
                        $pledge_query = "SELECT SUM(Pledge) FROM Pledges
                                        WHERE FundraiserId = ".$fundraiser_record["FundraiserId"];
                        $pledge_result = mysqli_query($dbc, $pledge_query);
                        $pledge_record = mysqli_fetch_assoc($pledge_result);
                        $ammt_raised = $pledge_record['SUM(Pledge)'];
                        $percentage = number_format($ammt_raised / $fundraiser_record['Goal'] * 100, 2);
                        if ($percentage >= 100) {
                            $width_percentage =100;
                        } else {
                            $width_percentage = $percentage;
                        }
                        echo <<<HTML
                                <article class='content fundraiser'>
                                    <h2>{$fundraiser_record["FName"]} {$fundraiser_record["LName"]}</h2>
                                    <div class='charity'>{$fundraiser_record["Charity"]}</div>
                                    <div class='blurb'>{$fundraiser_record["Blurb"]}</div>
                                    <div class='goal'>
                                        <div class='progress_wrapper'>
                                            <p>$percentage%</p>
                                            <div class='progress' style='width:$width_percentage%'></div>
                                        </div>
                                    </div>
                                    <div class='view'>
                                        <a href='fundraiser.php?frid={$fundraiser_record["FundraiserId"]}'>View</a>
                                    </div>
                                </article>
                            HTML;
                    }
                ?>
            </div>
            
        </main>
    </body>
</html>
