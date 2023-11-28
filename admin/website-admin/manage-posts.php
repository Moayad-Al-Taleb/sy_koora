<?php
session_start();
ob_start();
include "../init.php";
include "function.php";
if (empty($_SESSION['S_UserID'])) {
    echo "
    <div class='overlay'></div>
    <div class='handle-error-message'>ERROR CAN\'T ENTER DIRECTLY</div>
    ";
    header('REFRESH:2;URL=../index.php');
} else {
    if ($_SESSION["S_AccountType"] != 1) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>'You cannot access this page. This page is reserved for the site administrator</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>posts.css">
        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css">
        <?php
        include "../" . $tpl . "web-nav.inc";
        // $result = TeamData();
        // if (!empty($result)) {
        ?>
        <div class="container">
            <div class="heading">
                <ion-icon name="list-outline" class="list-icon"></ion-icon>
                <a href="../logout.php" class="logout-btn">
                    <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                </a>
            </div>
            <div class="main-title">
                <span>leagues and teams posts</span>
            </div>
            <div class="overview-cards">
                <a href="team-posts.php?box=allTeams" class="overview-card-click">
                    <div class="overview-card">
                        <ion-icon name="pricetag" class="icon-card"></ion-icon>
                        <p>teams posts</p>
                    </div>
                </a>
                <a href="team-posts.php?box=allLeagues" class="overview-card-click">
                    <div class="overview-card">
                        <ion-icon name="pricetag" class="icon-card"></ion-icon>
                        <p>leagues posts</p>
                    </div>
                </a>
            </div>
        </div>
<?php
        // 
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
