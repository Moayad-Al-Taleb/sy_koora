<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design/css/main.css">
</head>
<body>
<?php
session_start();

if (empty($_SESSION["S_Email"]) && empty($_SESSION["S_Password"])) {
    echo "<h1>";
    echo "Sorry You Cant Browse This Page Directly";
    echo "</h1>";
    header('REFRESH:2;URL=index.php');
    exit();
} else {
    if ($_SESSION["S_AccountType"] == 1) {
        header('location: website-admin/manage-users.php');
        exit();
    } elseif ($_SESSION["S_AccountType"] == 2) {
        include "team-admin/team-function.php";
        if($_SESSION['S_accountStatus'] == 2) {
            include "init.php";
            $checkUserTeam = checkUserTeam($_SESSION['S_UserID']);
             if(!empty($checkUserTeam)) {
                header('location: team-admin/manage-team.php');
            }else {
                header('location: team-admin/create-team.php');
            }
        } else {
            echo "
            <div class='overlay'></div>
            <div class='handle-error-message'>sorry, your account doesn't activited yet.</div>
            ";
            header('REFRESH:5;URL=index.php');
            exit();
        }
        exit();
    } elseif ($_SESSION["S_AccountType"] == 3) {
        include "league-admin/league-functions.php";
        if($_SESSION['S_accountStatus'] == 2) {
            include "init.php";
            $checkUserLeague = checkUserLeague($_SESSION['S_UserID']);
             if(!empty($checkUserLeague)) {
                header('location: league-admin/manage-league.php');
            }else {
                header('location: league-admin/create-league.php');
            }
        } else {
            echo "
            <div class='overlay'></div>
            <div class='handle-error-message'>sorry, your account doesn't activited yet.</div>
            ";
            header('REFRESH:5;URL=index.php');
            exit();
        }
    }
}
?>
</body>
</html>
