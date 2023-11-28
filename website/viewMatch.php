<?php
ob_start();
include_once "init.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>matches.css">
<link rel="stylesheet" href="<?php echo $css; ?>match-new.css">

<?php
include_once "includes/templates/navbar.inc";
$matchID = $_GET['matchID'];
$result = matches_matchID($matchID);
$row = mysqli_fetch_assoc($result);
?>
<div class="container match-details">
    <div class="match-stad">
        <div class="image">
            <img src="design/icons8-stadium-50.png" alt="">
        </div>
        <div class="name"><?php echo $row['staduimName'] ?></div>
    </div>
    <div class="match-time">
        <i class="fa fa-clock fa-2x text-primary" aria-hidden="true"></i>
        <div class="time-date">
            <span><?php echo $row['matchTime'] ?></span>
            <span><?php echo $row['matchDate'] ?></span>
        </div>
    </div>
</div>
<?php
$teamID1 = $row['teamID1'];
$teamID2 = $row['teamID2'];
$result2 = matchscores_matchID_teamID($matchID, $teamID1);
$count2 = mysqli_num_rows($result2);
$result3 = matchscores_matchID_teamID($matchID, $teamID2);
$count3 = mysqli_num_rows($result3);
if ($count2 == 0 && $count3 == 0) {
    $team1_logo = logo($teamID1);
    $team2_logo = logo($teamID2);
?>
    <div class="header-section">
        <div class="overlay"></div>
        <div class="header-teams">
            <div class="header-team">
                <div class="logo"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team1_logo['logo']) ?>" alt=""></div>
                <div class="name text-center"><?php echo $team1_logo['fullName'] ?></div>
            </div>
            <div class="match-score">
                <div class="score"> 0 - 0</div>
                <div class="league-name text-center"><?php echo $row['leagueName'] ?></div>
                <div class="type">
                    <?php
                    if ($row['matchesType'] == 1) {
                        echo "first leg";
                    } else {
                        echo "second leg";
                    }
                    ?>
                </div>
            </div>
            <div class="header-team">
                <div class="logo"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team2_logo['logo']) ?>" alt=""></div>
                <div class="name text-center"><?php echo $team2_logo['fullName'] ?></div>
            </div>
        </div>
    </div>
<?php
} else {
    $row2 = mysqli_fetch_assoc($result2);
    $row3 = mysqli_fetch_assoc($result3);
?>
    <div class="header-section">
        <div class="overlay"></div>
        <div class="header-teams">
            <div class="header-team">
                <div class="logo"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row2['logo']) ?>" alt=""></div>
                <div class="name text-center"><?php echo $row2['fullName'] ?></div>
            </div>
            <div class="match-score">
                <div class="score">
                    <?php echo $row2['teamScore'] ?> - <?php echo $row3['teamScore'] ?>
                </div>
                <div class="league-name text-center"><?php echo $row['leagueName'] ?></div>
                <div class="type">
                    <?php
                    if ($row['matchesType'] == 1) {
                        echo "first leg";
                    } else {
                        echo "second leg";
                    }
                    ?>
                </div>
            </div>
            <div class="header-team">
                <div class="logo"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row3['logo']) ?>" alt=""></div>
                <div class="name text-center"><?php echo $row3['fullName'] ?></div>
            </div>
        </div>
    </div>
<?php
}
?>


<?php
include_once "includes/templates/footer.inc";
ob_end_flush();
?>