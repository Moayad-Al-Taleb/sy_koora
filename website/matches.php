<?php
ob_start();
include_once "init.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>matches.css">
<?php
include_once "includes/templates/navbar.inc";

$date_Yesterday = date('Y-m-d', strtotime("yesterday"));

$date_Today = date('Y-m-d');

$date_Tomorrow = date('Y-m-d', strtotime("tomorrow"));

$box = isset($_GET['box']) ? $_GET['box'] : "Today";

if ($box == "Today") {
    $result_matches = matches_day($date_Today);
    $count_matches = mysqli_num_rows($result_matches);
?>
    <div class="container">
        <div class="control-section">
            <h3>filter by:</h3>
            <a href="?box=Yesterday" class="btn third-btn">Yesterday</a>
            <a href="?box=Today" class="btn third-btn">today</a>
            <a href="?box=Tomorrow" class="btn third-btn">Tomorrow</a>
        </div>
        <div class="main-con">
            <?php
            if ($count_matches > 0) {
                while ($row_matches = mysqli_fetch_assoc($result_matches)) {
                    $matchID = $row_matches['matchID'];

                    $teamID1 = $row_matches['teamID1'];
                    $teamID2 = $row_matches['teamID2'];

                    $result2 = matchscores_matchID_teamID($matchID, $teamID1);

                    $count2 = mysqli_num_rows($result2);

                    $result3 = matchscores_matchID_teamID($matchID, $teamID2);

                    $count3 = mysqli_num_rows($result3);

                    if ($count2 == 0 && $count3 == 0) {

                        $team1_logo = logo($teamID1);
                        $team2_logo = logo($teamID2);
            ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?php echo  $row_matches['matchDate'] . '<br>' . $row_matches['matchTime'] ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team1_logo['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team2_logo['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $team1_logo['fullName'] ?> <span>0</span></h5>
                                <h5 class="team"><?php echo $team2_logo['fullName'] ?> <span>0</span></h5>
                            </div>
                        </a>
                    <?php
                    } else {
                        $row2 = mysqli_fetch_assoc($result2);
                        $row3 = mysqli_fetch_assoc($result3);
                    ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?PHP echo $row_matches['matchDate'] . '<br>' . $row_matches['matchTime']  ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row2['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row3['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $row2['fullName'] ?> <span><?php echo $row2['teamScore'] ?></span></h5>
                                <h5 class="team"><?php echo $row3['fullName'] ?> <span><?php echo $row3['teamScore'] ?></span></h5>
                            </div>
                        </a>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
<?php
} elseif ($box == "Yesterday") {
    $result_matches = matches_day($date_Yesterday);
    $count_matches = mysqli_num_rows($result_matches);
?>
    <div class="container">
        <div class="control-section">
            <h3>filter by:</h3>
            <a href="?box=Yesterday" class="btn third-btn">Yesterday</a>
            <a href="?box=Today" class="btn third-btn">today</a>
            <a href="?box=Tomorrow" class="btn third-btn">Tomorrow</a>
        </div>
        <div class="main-con">
            <?php
            if ($count_matches > 0) {
                while ($row_matches = mysqli_fetch_assoc($result_matches)) {
                    $matchID = $row_matches['matchID'];

                    $teamID1 = $row_matches['teamID1'];
                    $teamID2 = $row_matches['teamID2'];

                    $result2 = matchscores_matchID_teamID($matchID, $teamID1);

                    $count2 = mysqli_num_rows($result2);

                    $result3 = matchscores_matchID_teamID($matchID, $teamID2);

                    $count3 = mysqli_num_rows($result3);

                    if ($count2 == 0 && $count3 == 0) {

                        $team1_logo = logo($teamID1);
                        $team2_logo = logo($teamID2);
            ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?php echo  $row_matches['matchDate'] . '<br>' . $row_matches['matchTime'] ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team1_logo['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team2_logo['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $team1_logo['fullName'] ?> <span>0</span></h5>
                                <h5 class="team"><?php echo $team2_logo['fullName'] ?> <span>0</span></h5>
                            </div>
                        </a>
                    <?php
                    } else {
                        $row2 = mysqli_fetch_assoc($result2);
                        $row3 = mysqli_fetch_assoc($result3);
                    ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?PHP echo $row_matches['matchDate'] . '<br>' . $row_matches['matchTime']  ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row2['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row3['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $row2['fullName'] ?> <span><?php echo $row2['teamScore'] ?></span></h5>
                                <h5 class="team"><?php echo $row3['fullName'] ?> <span><?php echo $row3['teamScore'] ?></span></h5>
                            </div>
                        </a>
            <?php
                    }
                }
            }
            ?>

        </div>
    </div>
<?php
} elseif ($box == "Tomorrow") {
    $result_matches = matches_day($date_Tomorrow);
    $count_matches = mysqli_num_rows($result_matches);
?>
    <div class="container">
        <div class="control-section">
            <h3>filter by:</h3>
            <a href="?box=Yesterday" class="btn third-btn">Yesterday</a>
            <a href="?box=Today" class="btn third-btn">today</a>
            <a href="?box=Tomorrow" class="btn third-btn">Tomorrow</a>
        </div>
        <div class="main-con">
            <?php
            if ($count_matches > 0) {
                while ($row_matches = mysqli_fetch_assoc($result_matches)) {
                    $matchID = $row_matches['matchID'];

                    $teamID1 = $row_matches['teamID1'];
                    $teamID2 = $row_matches['teamID2'];

                    $result2 = matchscores_matchID_teamID($matchID, $teamID1);

                    $count2 = mysqli_num_rows($result2);

                    $result3 = matchscores_matchID_teamID($matchID, $teamID2);

                    $count3 = mysqli_num_rows($result3);

                    if ($count2 == 0 && $count3 == 0) {

                        $team1_logo = logo($teamID1);
                        $team2_logo = logo($teamID2);
            ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?php echo  $row_matches['matchDate'] . '<br>' . $row_matches['matchTime'] ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team1_logo['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team2_logo['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $team1_logo['fullName'] ?> <span>0</span></h5>
                                <h5 class="team"><?php echo $team2_logo['fullName'] ?> <span>0</span></h5>
                            </div>
                        </a>
                    <?php
                    } else {
                        $row2 = mysqli_fetch_assoc($result2);
                        $row3 = mysqli_fetch_assoc($result3);
                    ?>
                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                            <div class="time text-center"><?PHP echo $row_matches['matchDate'] . '<br>' . $row_matches['matchTime']  ?></div>
                            <div class="type">
                                <?php
                                if ($row_matches['matchesType'] == 1) {
                                    echo "first leg";
                                } else {
                                    echo "second leg";
                                }
                                ?>
                            </div>
                            <div class="teams">
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row2['logo']) ?>" alt="">
                                </div>
                                <div class="team">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row3['logo']) ?>" alt="">
                                </div>
                            </div>
                            <div class="teams-name">
                                <h5 class="team"><?php echo $row2['fullName'] ?> <span><?php echo $row2['teamScore'] ?></span></h5>
                                <h5 class="team"><?php echo $row3['fullName'] ?> <span><?php echo $row3['teamScore'] ?></span></h5>
                            </div>
                        </a>
            <?php
                    }
                }
            }
            ?>

        </div>
    </div>
<?php
}
include_once "includes/templates/footer.inc";
ob_end_flush();
?>