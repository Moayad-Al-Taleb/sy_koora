<?php
ob_start();
include_once "init.php";
include "connect.php";
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
    $leagueID = intval($_GET['leagueID']);
    $result = league($leagueID);
    $row = mysqli_fetch_assoc($result);
?>
    <div class="container">
        <div class="control-section">
            <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
            <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
            <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
            <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
            <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
        </div>
    </div>
    <div class="header-section">
        <div class="overlay"></div>
        <div class="header-content">
            <div class="header-top">
                <div class="image league-img">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['leagueImage']) ?>" alt="">
                </div>
                <h2 class="title"><?php echo $row['leagueName'] ?></h2>
            </div>
        </div>
    </div>
    <div class="description">
        <p class="desc-content">
            <?php echo $row['glimpse'] ?>
        </p>
    </div>
<?php
} elseif ($box == 'news') {
    $leagueID = intval($_GET['leagueID']);
    $UserID = leagues_UserID($leagueID);
    $result_publications = publications_leagues($UserID);
    $count_publications = mysqli_num_rows($result_publications);
?>
    <div class="container">
        <div class="control-section">
            <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
            <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
            <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
            <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
            <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
        </div>
        <h2>all news</h2>
        <div class="news-con">
            <?php
            if ($count_publications > 0) {
                while ($row_publications = mysqli_fetch_assoc($result_publications)) {
            ?>
                    <div class="news-row">
                        <div class="hz-card">
                            <div class="hz-card-image">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo   base64_encode($row_publications['photoPost']) ?>" alt="">
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
                                    <span>post date: <span><?php echo  $row_publications['postData']  ?></span></span>
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
    $leagueID = intval($_GET['leagueID']);
    $ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : "lastSeasonID";
    if ($ctrl == 'lastSeasonID') { ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=matches&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
                <a href="?box=matches&ctrl=yesterday&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Yesterday</a>
                <a href="?box=matches&ctrl=today&leagueID=<?php echo $leagueID ?>" class="btn second-btn">today</a>
                <a href="?box=matches&ctrl=tomorrow&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Tomorrow</a>
            </div>
            <div class="main-con">
                <?php
                $seasonID = lastSeasonID($leagueID);
                $matchesType_1 = 1;
                $result_1 = seasonID_matches($seasonID, $matchesType_1);
                $count_1 = mysqli_num_rows($result_1);
                if ($count_1 > 0) {
                    while ($row_1 = mysqli_fetch_assoc($result_1)) {
                        $matchID = $row_1['matchID'];
                        $teamID1 = $row_1['teamID1'];
                        $teamID2 = $row_1['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                $matchesType_2 = 2;
                $result_2 = seasonID_matches($seasonID, $matchesType_2);
                $count_2 = mysqli_num_rows($result_2);
                if ($count_2 > 0) {
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $matchID = $row_2['matchID'];
                        $teamID1 = $row_2['teamID1'];
                        $teamID2 = $row_2['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                        ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
    } elseif ($ctrl == 'search') {
        $seasonID = $_POST['Search_seasonID'];
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=matches&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
            </div>
            <div class="main-con">
                <?php
                $matchesType_1 = 1;
                $result_1 = seasonID_matches($seasonID, $matchesType_1);
                $count_1 = mysqli_num_rows($result_1);
                if ($count_1 > 0) {
                    while ($row_1 = mysqli_fetch_assoc($result_1)) {
                        $matchID = $row_1['matchID'];
                        $teamID1 = $row_1['teamID1'];
                        $teamID2 = $row_1['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                $matchesType_2 = 2;
                $result_2 = seasonID_matches($seasonID, $matchesType_2);
                $count_2 = mysqli_num_rows($result_2);
                if ($count_2 > 0) {
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $matchID = $row_2['matchID'];
                        $teamID1 = $row_2['teamID1'];
                        $teamID2 = $row_2['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                        ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
        $leagueID = intval($_GET['leagueID']);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=matches&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
                <a href="?box=matches&ctrl=yesterday&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Yesterday</a>
                <a href="?box=matches&ctrl=today&leagueID=<?php echo $leagueID ?>" class="btn second-btn">today</a>
                <a href="?box=matches&ctrl=tomorrow&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Tomorrow</a>
            </div>
            <div class="main-con">
                <?php
                $seasonID = lastSeasonID($leagueID);
                $matchesType_1 = 1;
                $result_1 = seasonID_matches_matchDate($seasonID, $matchesType_1, $date_Yesterday);
                $count_1 = mysqli_num_rows($result_1);
                if ($count_1 > 0) {
                    while ($row_1 = mysqli_fetch_assoc($result_1)) {
                        $matchID = $row_1['matchID'];
                        $teamID1 = $row_1['teamID1'];
                        $teamID2 = $row_1['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                $matchesType_2 = 2;
                $result_2 = seasonID_matches_matchDate($seasonID, $matchesType_2, $date_Yesterday);
                $count_2 = mysqli_num_rows($result_2);
                if ($count_2 > 0) {
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $matchID = $row_2['matchID'];
                        $teamID1 = $row_2['teamID1'];
                        $teamID2 = $row_2['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                        ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
    } elseif ($ctrl == 'today') {
        $leagueID = intval($_GET['leagueID']);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=matches&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
                <a href="?box=matches&ctrl=yesterday&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Yesterday</a>
                <a href="?box=matches&ctrl=today&leagueID=<?php echo $leagueID ?>" class="btn second-btn">today</a>
                <a href="?box=matches&ctrl=tomorrow&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Tomorrow</a>
            </div>
            <div class="main-con">
                <?php
                $seasonID = lastSeasonID($leagueID);
                $matchesType_1 = 1;
                $result_1 = seasonID_matches_matchDate($seasonID, $matchesType_1, $date_Today);
                $count_1 = mysqli_num_rows($result_1);
                if ($count_1 > 0) {
                    while ($row_1 = mysqli_fetch_assoc($result_1)) {
                        $matchID = $row_1['matchID'];
                        $teamID1 = $row_1['teamID1'];
                        $teamID2 = $row_1['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                $matchesType_2 = 2;
                $result_2 = seasonID_matches_matchDate($seasonID, $matchesType_2, $date_Today);
                $count_2 = mysqli_num_rows($result_2);
                if ($count_2 > 0) {
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $matchID = $row_2['matchID'];
                        $teamID1 = $row_2['teamID1'];
                        $teamID2 = $row_2['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                        ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
        $leagueID = intval($_GET['leagueID']);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=matches&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
                <a href="?box=matches&ctrl=yesterday&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Yesterday</a>
                <a href="?box=matches&ctrl=today&leagueID=<?php echo $leagueID ?>" class="btn second-btn">today</a>
                <a href="?box=matches&ctrl=tomorrow&leagueID=<?php echo $leagueID ?>" class="btn second-btn">Tomorrow</a>
            </div>
            <div class="main-con">
                <?php
                $seasonID = lastSeasonID($leagueID);
                $matchesType_1 = 1;
                $result_1 = seasonID_matches_matchDate($seasonID, $matchesType_1, $date_Tomorrow);
                $count_1 = mysqli_num_rows($result_1);
                if ($count_1 > 0) {
                    while ($row_1 = mysqli_fetch_assoc($result_1)) {
                        $matchID = $row_1['matchID'];
                        $teamID1 = $row_1['teamID1'];
                        $teamID2 = $row_1['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                                <div class="time text-center"><?php echo $row_1['matchDate'] .  '<br>' . $row_1['matchTime']  ?></div>
                                <div class="type">first leg</div>
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
                $matchesType_2 = 2;
                $result_2 = seasonID_matches_matchDate($seasonID, $matchesType_2, $date_Tomorrow);
                $count_2 = mysqli_num_rows($result_2);
                if ($count_2 > 0) {
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $matchID = $row_2['matchID'];
                        $teamID1 = $row_2['teamID1'];
                        $teamID2 = $row_2['teamID2'];
                        $result2 = matchscores_matchID_teamID($matchID, $teamID1);
                        $count2 = mysqli_num_rows($result2);
                        $result3 = matchscores_matchID_teamID($matchID, $teamID2);
                        $count3 = mysqli_num_rows($result3);
                        if ($count2 == 0 && $count3 == 0) {
                            $team1_logo = logo($teamID1);
                            $team2_logo = logo($teamID2);
                        ?>
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="game-con">
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
                                <div class="time text-center"><?php echo $row_2['matchDate'] .  '<br>' . $row_2['matchTime']  ?></div>
                                <div class="type">second leg</div>
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
} elseif ($box == 'teams') {
    $leagueID = intval($_GET['leagueID']);
    $ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : "lastSeasonID";
    if ($ctrl == 'lastSeasonID') {
        $seasonID = lastSeasonID($leagueID);
        $result2 = seasonID_team($seasonID);
        $count = mysqli_num_rows($result2);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=teams&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
            </div>
            <div class="vt-card-container">
                <?php
                if ($count > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $teamID = $row2['teamID'];
                        $result_team = season_teamID($teamID);
                        $row_team = mysqli_fetch_assoc($result_team);
                ?>
                        <a href="team.php?teamID=<?php echo $teamID ?>" class="v-card">
                            <div class="v-card-image">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_team['logo']) ?>" alt="">
                            </div>
                            <div class="v-card-content">
                                <h5><?php echo $row_team['fullName'] ?></h5>
                            </div>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } elseif ($ctrl == 'search') {
        $seasonID = $_POST['Search_seasonID'];
        $result2 = seasonID_team($seasonID);
        $count = mysqli_num_rows($result2);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=teams&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
            </div>
            <div class="vt-card-container">
                <?php
                if ($count > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $teamID = $row2['teamID'];
                        $result_team = season_teamID($teamID);
                        $row_team = mysqli_fetch_assoc($result_team);
                ?>
                        <a href="team.php?teamID=<?php echo $teamID ?>" class="v-card">
                            <div class="v-card-image">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_team['logo']) ?>" alt="">
                            </div>
                            <div class="v-card-content">
                                <h5><?php echo $row_team['fullName'] ?></h5>
                            </div>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>


    <?php
} elseif ($box == 'ranking') {
    $leagueID = intval($_GET['leagueID']);
    $ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : "lastSeasonID";
    if ($ctrl == 'lastSeasonID') {
        $leagueID = intval($_GET['leagueID']);
        $seasonID = lastSeasonID($leagueID);
    ?>
        <div class="container">
            <div class="control-section">
                <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
                <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
                <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
                <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
                <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
            </div>
            <div class="control-section match-ctrl">
                <h3>filter by:</h3>
                <form action="?box=ranking&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                    <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                        <?php
                        $result = seasons_seasonID($leagueID);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button><i class="fas fa-search red-icon"></i></button>
                </form>
            </div>
            <?php
            if ($seasonID > 0) {
                $query4 = "SELECT `participatingteams`.*, `team`.teamID, `team`.fullName, `team`.logo, `seasons`.`seasonID`, `leagues`.`leagueID` FROM `participatingteams` inner join `team` 
                  ON `participatingteams`.`teamID` = `team`.`teamID`
                  INNER JOIN `seasons` ON `participatingteams`.`seasonID` = `seasons`.`seasonID`
                  INNER JOIN `leagues` ON `seasons`.`leagueID` = `leagues`.`leagueID` WHERE `seasons`.`seasonID` = $seasonID AND `leagues`.`leagueID` = $leagueID
                  ";
                $result4 = mysqli_query($conn, $query4);
                $count4 = mysqli_num_rows($result4);
            ?>
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
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row4['logo']); ?>" style="width: 80px; height: 80px; border-radius: 50%;" alt="">
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
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
        </div>
    <?php
            }
        } elseif ($ctrl == 'search') {
            $leagueID = intval($_GET['leagueID']);
            $seasonID = intval($_POST['Search_seasonID']);
            $query4 = "SELECT `participatingteams`.*, `team`.teamID, `team`.fullName, `team`.logo ,`seasons`.`seasonID`, `leagues`.`leagueID` FROM `participatingteams` inner join `team` 
                  ON `participatingteams`.`teamID` = `team`.`teamID`
                  INNER JOIN `seasons` ON `participatingteams`.`seasonID` = `seasons`.`seasonID`
                  INNER JOIN `leagues` ON `seasons`.`leagueID` = `leagues`.`leagueID` WHERE `seasons`.`seasonID` = $seasonID AND `leagues`.`leagueID` = $leagueID
                  ";
            $result4 = mysqli_query($conn, $query4);
            $count4 = mysqli_num_rows($result4);
    ?>
    <div class="container">
        <div class="control-section">
            <a href="?box=mainPage&leagueID=<?php echo $leagueID ?>" class="btn third-btn">main page</a>
            <a href="?box=news&leagueID=<?php echo $leagueID ?>" class="btn third-btn">news</a>
            <a href="?box=matches&leagueID=<?php echo $leagueID ?>" class="btn third-btn">matches</a>
            <a href="?box=teams&leagueID=<?php echo $leagueID ?>" class="btn third-btn">teams</a>
            <a href="?box=ranking&leagueID=<?php echo $leagueID ?>" class="btn third-btn">ranking</a>
        </div>
        <div class="control-section match-ctrl">
            <h3>filter by:</h3>
            <form action="?box=ranking&ctrl=search&leagueID=<?php echo $leagueID ?>" method="POST" class="search-field">
                <select class="form-select" aria-label="Default select example" name="Search_seasonID">
                    <?php
                    $result = seasons_seasonID($leagueID);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <option value="<?php echo $row['seasonID']; ?>"><?php echo $row['currentSeason_date']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <button><i class="fas fa-search red-icon"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table sortable table-light text-center">
                <thead>
                    <th class="col-4  no-sort">name</th>
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
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row4['logo']); ?>" style="width: 80px; height: 80px; border-radius: 50%;" alt="">
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
    </div>
<?php
        }
    }
?>

<script src="design/js/league.js"></script>

<?php
include_once "includes/templates/footer.inc";
ob_end_flush();
?>