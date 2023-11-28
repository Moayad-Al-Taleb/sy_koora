<?php
session_start();
ob_start();
include "../init.php";
include "team-function.php";

if (empty($_SESSION['S_UserID'])) {
    echo "
    <div class='overlay'></div>
    <div class='handle-error-message'>ERROR CAN\'T ENTER DIRECTLY</div>
    ";
    header('REFRESH:2;URL=../index.php');
} else {
    if ($_SESSION["S_AccountType"] != 2) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>'You cannot access this page. This page is reserved for the site administrator</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
        $teamID = Select_teamID($_SESSION["S_UserID"]);
        $players = countPeople(1, $teamID);
        $administrators = countPeople(2, $teamID);
        $technicalMembers = countPeople(3, $teamID);
?>

        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-users.css" />

        <?php
        include "../" . $tpl . "team-nav.inc";
        ?>

        <div class="container">
            <div class="heading">
                <ion-icon name="list-outline" class="list-icon"></ion-icon>
                <a href="../logout.php" class="logout-btn">
                    <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                </a>
            </div>
            <div class="main-title">
                <span class="heading-title">all accounts in this team:</span> <br>
                <a class="btn btn-primary" href="peoples-team.php?box=add">add new account</a>
            </div>
            <div class="overview-cards">
                <a href="peoples-team.php?AT=2" class="overview-card-click">
                    <div class="overview-card">
                        <ion-icon name="people" class="icon-card"></ion-icon>
                        <p>all administrators<span><?php echo $administrators; ?></span></p>
                    </div>
                </a>
                <a href="peoples-team.php?AT=1" class="overview-card-click">
                    <div class="overview-card">
                        <ion-icon name="body-outline" class="icon-card"></ion-icon>
                        <p>all players<span><?php echo $players; ?></span></p>
                    </div>
                </a>
                <a href="peoples-team.php?AT=3" class="overview-card-click">
                    <div class="overview-card">
                        <ion-icon name="body-outline" class="icon-card"></ion-icon>
                        <p>all technical members <span><?php echo $technicalMembers; ?></span></p>
                    </div>
                </a>
            </div>
        </div>

<?php
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
