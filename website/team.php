<?php
ob_start();
include_once "init.php";
include_once "connect.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>league-team.css">
<link rel="stylesheet" href="<?php echo $css; ?>matches.css">
<link rel="stylesheet" href="<?php echo $css; ?>news.css">
<link rel="stylesheet" href="design/sortable js/sortable.min.css" />
<script src="design/sortable js/sortable.min.js"></script>
<?php
include_once "includes/templates/navbar.inc";
$box = isset($_GET['box']) ? $_GET['box'] : 'mainPage';

$date_Yesterday = date('Y-m-d', strtotime("yesterday"));
$date_Today = date('Y-m-d');
$date_Tomorrow = date('Y-m-d', strtotime("tomorrow"));

if ($box == 'mainPage') {
    $teamID = intval($_GET['teamID']);
    $result = teaminfo($teamID);
    $row = mysqli_fetch_assoc($result);

    $team_achievments = "SELECT * FROM achievements 
                        inner join team 
                        ON achievements.teamID = team.teamID 
                        WHERE achievements.teamID = $teamID";
    $team_achievments_result = mysqli_query($conn, $team_achievments);
    $team_achievments_rowCount = mysqli_num_rows($team_achievments_result);

    $team_names_from = "SELECT * FROM namesfrom 
                        inner join team 
                        ON namesfrom.teamID = team.teamID 
                        WHERE namesfrom.teamID = $teamID";
    $team_names_from_result = mysqli_query($conn, $team_names_from);
    $team_names_from_rowCount = mysqli_num_rows($team_names_from_result);
?>
    <div class="container">
        <div class="control-section">
            <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
            <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
            <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
            <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
        </div>
    </div>
    <div class="header-section">
        <div class="overlay"></div>
        <div class="header-content">
            <div class="header-top">
                <div class="image league-img">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['logo']) ?>" alt="">
                </div>
                <h2 class="title"><?php echo $row['fullName'] ?></h2>
            </div>
            <div class="header-bottom">
                <div class="image">
                    <img src="design/icons8-stadium-50.png" alt="">
                </div>
                <div class="name"><?php echo $row['stadium'] ?></div>
            </div>
        </div>
    </div>
    <div class="description">
        <p class="desc-content">
            <?php echo $row['glimpse'] ?>
        </p>
    </div>
    <div class="description">
        <h3 class="title">
            establishment
        </h3>
        <p class="desc-content">
            <?php echo $row['establishing'] ?>
        </p>
    </div>
    <?php if ($team_achievments_rowCount > 0) { ?>
        <h3 class="section-title">achievments</h3>
        <div class="table-responsive">
            <table class="table" style="width: 60%; margin: 10px auto;">
                <thead>
                    <th>#</th>
                    <th>achievment</th>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($team_achievments_result)) {
                        echo '
                    <tr>
                        <td>1</td>
                        <td>' . $row['teamAchievement'] . '</td>
                    </tr>
                    ';
                    } ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    if ($team_names_from_rowCount > 0) { ?>
        <h3 class="section-title">famous players</h3>
        <div class="table-responsive">
            <table class="table" style="width: 60%; margin: 10px auto;">
                <thead>
                    <th>#</th>
                    <th>player name</th>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($team_names_from_result)) {
                        echo '
                    <tr>
                        <td>1</td>
                        <td>' . $row['playerName'] . '</td>
                    </tr>
                    ';
                    } ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    $personType_1 = 1;
    $result_players = peoplesteam($teamID, $personType_1);
    $count_players = mysqli_num_rows($result_players);
    if ($count_players > 0) { ?>
        <h3 class="section-title">players</h3>
        <div class="players-section">
            <?php
            while ($row_players = mysqli_fetch_assoc($result_players)) {
            ?>
                <div class="player-card">
                    <div class="top">
                        <div class="image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_players['Person_image']) ?>" alt="">
                        </div>
                        <h5 class="name"><?php echo $row_players['Person_fullName'] ?></h5>
                    </div>
                    <div class="bottom">
                        <div class="position"><?php echo $row_players['Person_specialty'] ?></div>
                        <div class="nationality"><?php echo $row_players['Person_Nationality'] ?></div>
                        <div class="number">player number: <span><?php echo $row_players['Person_number'] ?></span></div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        </div>
        <?php
        $personType_2 = 2;
        $result_players2 = peoplesteam($teamID, $personType_2);
        $count_players2 = mysqli_num_rows($result_players2);
        if ($count_players > 0) { ?>
            <h3 class="section-title">adminstrators</h3>
            <div class="players-section">
                <?php
                while ($row_players2 = mysqli_fetch_assoc($result_players2)) {
                ?>
                    <div class="player-card">
                        <div class="top">
                            <div class="image">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_players2['Person_image']) ?>" alt="">
                            </div>
                            <h5 class="name"><?php echo $row_players2['Person_fullName'] ?></h5>
                        </div>
                        <div class="bottom">
                            <div class="position"><?php echo $row_players2['Person_specialty'] ?></div>
                            <div class="nationality"><?php echo $row_players2['Person_Nationality'] ?></div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            </div>
            <?php
            $personType_3 = 3;
            $result_players3 = peoplesteam($teamID, $personType_3);
            $count_players3 = mysqli_num_rows($result_players3);
            if ($count_players3 > 0) { ?>
                <h3 class="section-title">technical members</h3>
                <div class="players-section">
                    <?php
                    while ($row_players3 = mysqli_fetch_assoc($result_players3)) {
                    ?>
                        <div class="player-card">
                            <div class="top">
                                <div class="image">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_players3['Person_image']) ?>" alt="">
                                </div>
                                <h5 class="name"><?php echo $row_players3['Person_fullName'] ?></h5>
                            </div>
                            <div class="bottom">
                                <div class="position"><?php echo $row_players3['Person_specialty'] ?></div>
                                <div class="nationality"><?php echo $row_players3['Person_Nationality'] ?></div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                </div>


            <?php
        } elseif ($box == 'news') {
            $teamID = intval($_GET['teamID']);
            $UserID = team_UserID($teamID);
            ?>
                <div class="container">
                    <div class="control-section">
                        <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                        <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                        <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                        <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                    </div>
                    <h2>latest news</h2>
                    <div class="news-con">
                        <?php
                        $result_publications = publications_team($UserID);
                        $count_publications = mysqli_num_rows($result_publications);
                        if ($count_publications > 0) {
                            while ($row_publications = mysqli_fetch_assoc($result_publications)) {
                        ?>
                                <div class="news-row">
                                    <div class="hz-card">
                                        <div class="hz-card-image">
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo  base64_encode($row_publications['photoPost']) ?>" alt="">
                                        </div>
                                        <div class="hz-card-content">
                                            <h5><?php echo $row_publications['postTitle'] ?></h5>
                                            <div class="content-desc">
                                                <?php
                                                if (strlen($row_publications['postDetails']) > 100) {
                                                    echo substr($row_publications['postDetails'], 0, 100) . " ...";
                                                } else {
                                                    echo $row_publications['postDetails'];
                                                }
                                                ?>
                                            </div>
                                            <div class="hz-card-ctrl">
                                                <span>post date: <span></span><?php echo $row_publications['postData'] ?></span>
                                                <a href="viewNew.php?newID=<?php echo $row_publications['PublishedID'] ?>" class="btn main-btn">view</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>

                <?php
            } elseif ($box == 'matches') {
                $teamID = intval($_GET['teamID']);
                $ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'today';
                if ($ctrl == 'today') {
                    $result = matches_teamID($teamID, $date_Today);
                    $count = mysqli_num_rows($result);
                ?>
                    <div class="container">
                        <div class="control-section">
                            <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                            <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                            <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                            <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                        </div>
                        <div class="control-section match-ctrl">
                            <h3>filter by:</h3>
                            <a href="?box=matches&ctrl=all&teamID=<?php echo $teamID ?>" class="btn second-btn">all matches</a>
                            <a href="?box=matches&ctrl=yesterday&teamID=<?php echo $teamID ?>" class="btn second-btn">Yesterday</a>
                            <a href="?box=matches&ctrl=today&teamID=<?php echo $teamID ?>" class="btn second-btn">today</a>
                            <a href="?box=matches&ctrl=tomorrow&teamID=<?php echo $teamID ?>" class="btn second-btn">Tomorrow</a>
                        </div>
                        <div class="main-con">
                            <?php
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $matchID = $row['matchID'];
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
                                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                            <div class="time text-center"><?php echo  $row['matchDate'] . '<br>' . $row['matchTime'] ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                                            <div class="time text-center"><?PHP echo $row['matchDate'] . '<br>' . $row['matchTime']  ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                } elseif ($ctrl == 'yesterday') {
                    $result = matches_teamID($teamID, $date_Yesterday);
                    $count = mysqli_num_rows($result);
                ?>
                    <div class="container">
                        <div class="control-section">
                            <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                            <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                            <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                            <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                        </div>
                        <div class="control-section match-ctrl">
                            <h3>filter by:</h3>
                            <a href="?box=matches&ctrl=all&teamID=<?php echo $teamID ?>" class="btn second-btn">all matches</a>
                            <a href="?box=matches&ctrl=yesterday&teamID=<?php echo $teamID ?>" class="btn second-btn">Yesterday</a>
                            <a href="?box=matches&ctrl=today&teamID=<?php echo $teamID ?>" class="btn second-btn">today</a>
                            <a href="?box=matches&ctrl=tomorrow&teamID=<?php echo $teamID ?>" class="btn second-btn">Tomorrow</a>
                        </div>
                        <div class="main-con">
                            <?php
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $matchID = $row['matchID'];
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
                                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                            <div class="time text-center"><?php echo  $row['matchDate'] . '<br>' . $row['matchTime'] ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                                            <div class="time text-center"><?PHP echo $row['matchDate'] . '<br>' . $row['matchTime']  ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                } elseif ($ctrl == 'tomorrow') {
                    $result = matches_teamID($teamID, $date_Tomorrow);
                    $count = mysqli_num_rows($result);
                ?>
                    <div class="container">
                        <div class="control-section">
                            <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                            <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                            <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                            <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                        </div>
                        <div class="control-section match-ctrl">
                            <h3>filter by:</h3>
                            <a href="?box=matches&ctrl=all&teamID=<?php echo $teamID ?>" class="btn second-btn">all matches</a>
                            <a href="?box=matches&ctrl=yesterday&teamID=<?php echo $teamID ?>" class="btn second-btn">Yesterday</a>
                            <a href="?box=matches&ctrl=today&teamID=<?php echo $teamID ?>" class="btn second-btn">today</a>
                            <a href="?box=matches&ctrl=tomorrow&teamID=<?php echo $teamID ?>" class="btn second-btn">Tomorrow</a>
                        </div>
                        <div class="main-con">
                            <?php
                            if ($count > 0) {
                                $matchType = '';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $matchID = $row['matchID'];

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
                                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                            <div class="time text-center"><?php echo  $row['matchDate'] . '<br>' . $row['matchTime'] ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                                            <div class="time text-center"><?PHP echo $row['matchDate'] . '<br>' . $row['matchTime']  ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                } elseif ($ctrl == 'all') {
                    $result = matches_teamID_all($teamID);
                    $count = mysqli_num_rows($result);
                ?>
                    <div class="container">
                        <div class="control-section">
                            <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                            <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                            <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                            <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                        </div>
                        <div class="control-section match-ctrl">
                            <h3>filter by:
                            </h3>

                            <a href="?box=matches&ctrl=all&teamID=<?php echo $teamID ?>" class="btn second-btn">all matches</a>
                            <a href="?box=matches&ctrl=yesterday&teamID=<?php echo $teamID ?>" class="btn second-btn">Yesterday</a>
                            <a href="?box=matches&ctrl=today&teamID=<?php echo $teamID ?>" class="btn second-btn">today</a>
                            <a href="?box=matches&ctrl=tomorrow&teamID=<?php echo $teamID ?>" class="btn second-btn">Tomorrow</a>
                        </div>
                        <div class="main-con">
                            <?php
                            if ($count > 0) {
                                $matchType = '';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $matchID = $row['matchID'];
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
                                        <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                            <div class="time text-center"><?php echo  $row['matchDate'] . '<br>' . $row['matchTime'] ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                                            <div class="time text-center"><?PHP echo $row['matchDate'] . '<br>' . $row['matchTime']  ?></div>
                                            <div class="type">
                                                <?php
                                                if ($row['matchesType'] == 1) {
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
                ?>
            <?php
            } elseif ($box == 'joinedLeagues') {
                $teamID = intval($_GET['teamID']);
                $result = leagues_team($teamID);
                $count = mysqli_num_rows($result);
            ?>
                <div class="container">
                    <div class="control-section">
                        <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                        <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                        <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                        <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                    </div>
                    <h2 class="mt-4">all league the team has joined:</h2>
                    <div class="table-responsive">
                        <table class="table team-table text-center">
                            <thead>
                                <th>#</th>
                                <th>league name</th>
                                <th>view</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 0;
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $counter++;
                                ?>
                                        <tr>
                                            <td><?php echo $counter; ?></td>
                                            <td><?php echo $row['leagueName'] ?></td>
                                            <td><a href="?box=leagueSeason&teamID=<?php echo $teamID; ?>&leagueID=<?php echo $row['leagueID'] ?>" class="btn second-btn">view</a></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php
            } elseif ($box == 'leagueSeason') {
                $teamID = intval($_GET['teamID']);
                $leagueID = intval($_GET['leagueID']);
                $result = seasons_team($leagueID, $teamID);
                $count = mysqli_num_rows($result);
            ?>
                <div class="container">
                    <div class="control-section">
                        <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                        <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                        <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                        <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                    </div>
                    <h2 class="mt-4">all seasons referensing to league name:</h2>
                    <div class="table-responsive">
                        <table class="table team-table text-center">
                            <thead>
                                <th>#</th>
                                <th class="col-8">season date</th>
                                <th>view</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 0;
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $counter++;
                                ?>
                                        <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $row['currentSeason_date'] ?></td>
                                            <td><a href="?box=seasonRanking&leagueID=<?php echo $leagueID ?>&seasonID=<?php echo $row['seasonID'] ?>&teamID=<?php echo $teamID ?>" class="btn second-btn">view</a></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            } elseif ($box == 'seasonRanking') {
                $leagueID = intval($_GET['leagueID']);
                $seasonID = intval($_GET['seasonID']);
                $teamID = intval($_GET['teamID']);
                $query4 = "SELECT `participatingteams`.*, `team`.teamID, `team`.fullName, `team`.logo ,`seasons`.`seasonID`, `leagues`.`leagueID` FROM `participatingteams` inner join `team` 
                ON `participatingteams`.`teamID` = `team`.`teamID`
                INNER JOIN `seasons` ON `participatingteams`.`seasonID` = `seasons`.`seasonID`
                INNER JOIN `leagues` ON `seasons`.`leagueID` = `leagues`.`leagueID` WHERE `seasons`.`seasonID` = $seasonID AND `leagues`.`leagueID` = $leagueID";
                $result4 = mysqli_query($conn, $query4);
                $count4 = mysqli_num_rows($result4);
            ?>
                <div class="container">
                    <div class="control-section">
                        <a href="?box=mainPage&teamID=<?php echo $teamID ?>" class="btn third-btn">main page</a>
                        <a href="?box=news&teamID=<?php echo $teamID ?>" class="btn third-btn">news</a>
                        <a href="?box=matches&teamID=<?php echo $teamID ?>" class="btn third-btn">matches</a>
                        <a href="?box=joinedLeagues&teamID=<?php echo $teamID ?>" class="btn third-btn">joined leagues</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table sortable table-light text-center">
                            <thead>
                                <th class="col-4">name</th>
                                <th class="col-1">played</th>
                                <th class="col-1">wins</th>
                                <th class="col-1">taadol</th>
                                <th class="col-1">loses</th>
                                <th class="col-1">goals</th>
                                <th class="col-2">points</th>
                            </thead>
                            <tbody>
                                <?php
                                if ($count4 > 0) {
                                    $counter = 0;
                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                        $counter++;
                                        $teamID = $row4['teamID'];
                                        //to get the points and scores for this team id
                                        $query5 = "SELECT SUM(`matchscores`.`teamPoints`) AS 'teamPoint', SUM(`matchscores`.`teamScore`) AS 'teamScore'	FROM `matchscores`
                        INNER JOIN `matches` ON `matchscores`.`matchID` = `matches`.`matchID`
                        INNER JOIN `seasons` ON `matches`.`seasonID` = `seasons`.`seasonID`
                        WHERE teamID = $teamID
                        AND `seasons`.`seasonID` = $seasonID
                        GROUP BY teamID";
                                        $result5 = mysqli_query($conn, $query5);
                                        $count5 = mysqli_num_rows($result5);
                                        $row5 = mysqli_fetch_assoc($result5);
                                        //to get all matches that this team has played
                                        $query6 = "SELECT COUNT(`matchscores`.`matchScoreID`) AS 'matchPlayed' FROM `matchscores`
                                    INNER JOIN `matches` ON `matchscores`.`matchID` = `matches`.`matchID`
                                    INNER JOIN `seasons` ON `matches`.`seasonID` = `seasons`.`seasonID`
                                    WHERE teamID = $teamID 
                                    AND `seasons`.`seasonID` = $seasonID
                                    GROUP BY teamID";
                                        $result6 = mysqli_query($conn, $query6);
                                        $count6 = mysqli_num_rows($result6);
                                        $row6 = mysqli_fetch_assoc($result6);
                                        //to get all game that this team has win
                                        $query7 = "SELECT COUNT(`matchscores`.`matchScoreID`) AS 'matchWins' FROM `matchscores`
                            INNER JOIN `matches` ON `matchscores`.`matchID` = `matches`.`matchID`
                            INNER JOIN `seasons` ON `matches`.`seasonID` = `seasons`.`seasonID`
                            WHERE `matchscores`.`teamPoints` = 3
                            AND `seasons`.`seasonID` = $seasonID
                            AND teamID = $teamID
                            GROUP BY teamID";
                                        $result7 = mysqli_query($conn, $query7);
                                        $count7 = mysqli_num_rows($result7);
                                        $row7 = mysqli_fetch_assoc($result7);
                                        //to get all game that this team has tied
                                        $query8 = "SELECT COUNT(`matchscores`.`matchScoreID`) AS 'matchTieds' FROM `matchscores`
                        INNER JOIN `matches` ON `matchscores`.`matchID` = `matches`.`matchID`
                        INNER JOIN `seasons` ON `matches`.`seasonID` = `seasons`.`seasonID`
                        WHERE `matchscores`.`teamPoints` = 1
                        AND teamID = $teamID
                        AND `seasons`.`seasonID` = $seasonID
                        GROUP BY teamID";
                                        $result8 = mysqli_query($conn, $query8);
                                        $count8 = mysqli_num_rows($result8);
                                        $row8 = mysqli_fetch_assoc($result8);
                                        //to get all game that this team has lose
                                        $query9 = "SELECT COUNT(`matchscores`.`matchScoreID`) AS 'matchLoses' FROM `matchscores`
                        INNER JOIN `matches` ON `matchscores`.`matchID` = `matches`.`matchID`
                        INNER JOIN `seasons` ON `matches`.`seasonID` = `seasons`.`seasonID`
                        WHERE `matchscores`.`teamPoints` = 0
                        AND teamID = $teamID
                        AND `seasons`.`seasonID` = $seasonID
                        GROUP BY teamID";
                                        $result9 = mysqli_query($conn, $query9);
                                        $count9 = mysqli_num_rows($result9);
                                        $row9 = mysqli_fetch_assoc($result9);

                                ?>
                                        <tr>
                                            <td>
                                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row4['logo']) ?>" style="width: 80px; height: 80px; border-radius: 50%;" alt="">
                                                <?php echo $row4['fullName'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count6 > 0) {
                                                    echo $row6['matchPlayed'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count7 > 0) {
                                                    echo $row7['matchWins'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count8 > 0) {
                                                    echo $row8['matchTieds'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count9 > 0) {
                                                    echo $row9['matchLoses'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count5 > 0) {
                                                    echo $row5['teamScore'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php
                                                if ($count5 > 0) {
                                                    echo $row5['teamPoint'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "there is no info";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
            }
                ?>
                <?php
                include_once "includes/templates/footer.inc";
                ob_end_flush();
                ?>