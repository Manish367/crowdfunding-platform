<?php
    session_start();
    include_once 'includes/admin_connection.php';

    $remove_pledge = $dbc->prepare("DELETE FROM Pledges WHERE DonationId = ?");
    $remove_pledge->bind_param("i", $_POST['pledgeId']);
    $remove_pledge->execute();
    $remove_pledge->close();
    header("Location: ".$_SESSION['page']);
