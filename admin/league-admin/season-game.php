<?php
session_start();
ob_start();
include "../init.php";
include "league-functions.php";

if (empty($_SESSION["S_UserID"])) {
    echo "
    <div class='overlay'></div>
    <div class='handle-error-message'>ERROR CAN\'T ENTER DIRECTLY</div>
    ";
    header('REFRESH:2;URL=../index.php');
} else {
    if ($_SESSION["S_AccountType"] != 3) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>You cannot access this page. This page is reserved for the site LeagueManager</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>games.css" />

        <?php
        include "../" . $tpl . "league-nav.inc";

        $box = isset($_GET['box']) ? $_GET['box'] : 'allMatches';

        if ($box == "allMatches") {
            $seasonID = $_GET['seasonID'];
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">season matches:</span> <br>
                </div>
                <div class="overview-cards">
                    <a href="?box=matches_1&seasonID=<?php echo $seasonID ?>" class="overview-card-click">
                        <div class="overview-card">
                            <ion-icon name="football-outline" class="icon-card"></ion-icon>
                            <p>first leg matches
                            </p>
                        </div>
                    </a>
                    <a href="?box=matches_2&seasonID=<?php echo $seasonID ?>" class="overview-card-click">
                        <div class="overview-card">
                            <ion-icon name="football-outline" class="icon-card"></ion-icon>
                            <p>second leg matches</p>
                        </div>
                    </a>
                </div>
            </div>
        <?php
        } elseif ($box == 'matches_1') {

            $seasonID = $_GET['seasonID'];
            $result = Selct_matches($seasonID, '1');

        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">first leg matches:</span> <br>
                    <a href="?box=addMatch_1&seasonID=<?php echo $seasonID ?>" class="btn btn-primary">add new match</a>
                </div>
                <div class="games-container">
                    <?php while ($row = mysqli_fetch_assoc($result)) {

                        $row2 = Selct_teamID($row['teamID1']);
                        $row3 = Selct_teamID($row['teamID2']);

                        $matchType = '';
                        if ($row['matchesType'] == 1) {
                            $matchType = "first leg";
                        }
                    ?>
                        <div class="game-con">
                            <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row2['logo']) . " '/>" ?></div>
                            <div class="game-column team-name"><?php echo $row2['fullName'] ?></div>
                            <div class="game-column game-result">
                                <a href="?box=showMatch&matchID=<?php echo $row['matchID'] ?>" class="btn btn-primary">
                                    view
                                </a>
                            </div>
                            <div class="game-column team-name"><?php echo $row3['fullName'] ?></div>
                            <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row3['logo']) . " '/>" ?></div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        <?php
        } elseif ($box == 'matches_2') {
            $seasonID = $_GET['seasonID'];
            $result = Selct_matches($seasonID, '2');
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">second leg matches:</span> <br>
                    <a href="?box=addMatch_2&seasonID=<?php echo $seasonID ?>" class="btn btn-primary">add new match</a>
                </div>
                <div class="games-container">
                    <?php while ($row = mysqli_fetch_assoc($result)) {

                        $row2 = Selct_teamID($row['teamID1']);
                        $row3 = Selct_teamID($row['teamID2']);
                        $matchType = '';
                        if ($row['matchesType'] == 2) {
                            $matchType = "second leg";
                        }
                    ?>
                        <div class="game-con">
                            <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row2['logo']) . " '/>" ?></div>
                            <div class="game-column team-name"><?php echo $row2['fullName'] ?></div>
                            <div class="game-column game-result">
                                <a href="?box=showMatch&matchID=<?php echo $row['matchID'] ?>" class="btn btn-primary">
                                    view
                                </a>
                            </div>
                            <div class="game-column game-type"></div>
                            <div class="game-column team-name"><?php echo $row3['fullName'] ?></div>
                            <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row3['logo']) . " '/>" ?></div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        <?php
        } elseif ($box == 'addMatch_1') {
            $seasonID = $_GET['seasonID'];
            $result = Select_participatingteams($seasonID);
            $result2 = Select_participatingteams($seasonID);
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add new first leg match:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label for="" class="label">first team:</label>
                        <select name="teamID1" id="" class="input">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['teamID'] . "'>" . $row['fullName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">second team:</label>
                        <select name="teamID2" id="" class="input">
                            <?php
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                echo "<option value='" . $row2['teamID'] . "'>" . $row2['fullName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match address:</label>
                        <input type="text" name="matchAddress" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">stadium name:</label>
                        <input type="text" name="staduimName" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match date</label>
                        <input type="date" name="matchDate" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match date</label>
                        <input type="time" name="matchTime" class="input">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTNaddmatches_1" value="add game" class="submit-btn">
                    </div>
                </form>
            </div>
            <?php
            if (isset($_POST['BTNaddmatches_1'])) {
                if (
                    !empty($_POST['teamID1'])
                    && !empty($_POST['teamID2'])
                    && !empty($_POST['matchAddress'])
                    && !empty($_POST['staduimName'])
                    && !empty($_POST['matchDate'])
                    && !empty($_POST['matchTime'])
                ) {
                    $seasonID = intval($_GET['seasonID']);
                    $numberTeams = Select_numberTeams($_SESSION['S_UserID']);
                    $teamID1 = $_POST['teamID1'];
                    $teamID2 = $_POST['teamID2'];
                    $matchAddress = $_POST['matchAddress'];
                    $staduimName = $_POST['staduimName'];
                    $matchDate = $_POST['matchDate'];
                    $matchTime = $_POST['matchTime'];

                    $count1 = Select_teamID1($teamID1, $seasonID, 1);
                    if (($numberTeams - 1) > $count1) {
                        $count2 = Select_teamID2($teamID2, $seasonID, 1);
                        if (($numberTeams - 1) > $count2) {
                            $count3 = Select_teamID1ANDteamID2($teamID1, $teamID2, $seasonID, 1);
                            $count4 = Select_teamID1ANDteamID2($teamID2, $teamID1, $seasonID, 1);
                            if ($count3 == 0 && $count4 == 0) {
                                if ($teamID1 != $teamID2) {
                                    //  ✔
                                    Insert_matches($seasonID, $teamID1, $teamID2, $matchAddress, $staduimName, $matchDate, $matchTime, '1');
                                } else {
                                    echo "
                                    <div class='overlay'></div>
                                    <div class='handle-error-message'>sorry, you can't select the same team</div>
                                    ";
                                    header('REFRESH:2;URL=?box=addMatch_1&seasonID=' . $seasonID);
                                }
                            } else {
                                echo "
                                <div class='overlay'></div>
                                <div class='handle-error-message'>this match already been added !!!</div>
                                ";
                                header('REFRESH:2;URL=?box=matches_1&seasonID=' . $seasonID);
                            }
                        } else {
                            echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>this match already been added !!!!!!</div>
                        ";
                            header('REFRESH:2;URL=?box=addMatch_1&seasonID=' . $seasonID);
                        }
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>this match already been added !</div>
                        ";
                        header('REFRESH:2;URL=?box=addMatch_1&seasonID=' . $seasonID);
                    }
                } else {
                    echo 'Please fill in all fields.';
                }
            }
        } elseif ($box == 'addMatch_2') {
            $seasonID = $_GET['seasonID'];
            $result = Select_participatingteams($seasonID);
            $result2 = Select_participatingteams($seasonID);
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add new second leg match:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label for="" class="label">first team:</label>
                        <select name="teamID1" id="" class="input">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['teamID'] . "'>" . $row['fullName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">second team:</label>
                        <select name="teamID2" id="" class="input">
                            <?php
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                echo "<option value='" . $row2['teamID'] . "'>" . $row2['fullName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match address:</label>
                        <input type="text" name="matchAddress" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">stadium name:</label>
                        <input type="text" name="staduimName" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match date</label>
                        <input type="date" name="matchDate" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match date</label>
                        <input type="time" name="matchTime" class="input">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTNaddmatches_2" value="add game" class="submit-btn">
                    </div>
                </form>
            </div>
            <?php
            if (isset($_POST['BTNaddmatches_2'])) {
                if (
                    !empty($_POST['teamID1'])
                    && !empty($_POST['teamID2'])
                    && !empty($_POST['matchAddress'])
                    && !empty($_POST['staduimName'])
                    && !empty($_POST['matchDate'])
                    && !empty($_POST['matchTime'])
                ) {
                    $seasonID = intval($_GET['seasonID']);
                    $numberTeams = Select_numberTeams($_SESSION['S_UserID']);

                    $teamID1 = $_POST['teamID1'];
                    $teamID2 = $_POST['teamID2'];
                    $matchAddress = $_POST['matchAddress'];
                    $staduimName = $_POST['staduimName'];
                    $matchDate = $_POST['matchDate'];
                    $matchTime = $_POST['matchTime'];

                    $count1 = Select_teamID1($teamID1, $seasonID, 2);
                    if (($numberTeams - 1) > $count1) {
                        $count2 = Select_teamID2($teamID2, $seasonID, 2);
                        if (($numberTeams - 1) > $count2) {
                            $count3 = Select_teamID1ANDteamID2($teamID1, $teamID2, $seasonID, 2);
                            $count4 = Select_teamID1ANDteamID2($teamID2, $teamID1, $seasonID, 2);

                            if ($count3 == 0 && $count4 == 0) {
                                if ($teamID1 != $teamID2) {
                                    //  ✔
                                    Insert_matches($seasonID, $teamID1, $teamID2, $matchAddress, $staduimName, $matchDate, $matchTime, '2');
                                } else {
                                    echo 'teamID1 == teamID2';
                                    header('REFRESH:2;URL=?box=matches_2&seasonID=' . $seasonID);
                                }
                            } else {
                                echo 'Select_teamID1ANDteamID2';
                                header('REFRESH:2;URL=?box=matches_2&seasonID=' . $seasonID);
                            }
                        } else {
                            echo '($numberTeams - 1) > $count2';
                            header('REFRESH:2;URL=?box=matches_2&seasonID=' . $seasonID);
                        }
                    } else {
                        echo '($numberTeams - 1) > $count1';
                        header('REFRESH:2;URL=?box=matches_2&seasonID=' . $seasonID);
                    }
                } else {
                    echo 'Please fill in all fields.';
                }
            }
        } elseif ($box == "showMatch") {
            $matchID = $_GET['matchID'];
            $result = matches($matchID);
            $row = mysqli_fetch_assoc($result);
            $seasonID = $row['seasonID'];
            $teamID1 = $row['teamID1'];
            $teamID2 = $row['teamID2'];
            $row2 = Selct_teamID($row['teamID1']);
            $row3 = Selct_teamID($row['teamID2']);
            if ($row['matchesType'] == 1) {
                $matchType = "first leg";
            } else {
                $matchType = "second leg";
            }
            $result2 = matchscores_matchIDTeamID($matchID, $teamID1);
            $count2 = mysqli_num_rows($result2);

            $result3 = matchscores_matchIDTeamID($matchID, $teamID2);
            $count3 = mysqli_num_rows($result3);
            ?>

            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">season game information:</span> <br>
                </div>
                <div class="games-container">
                    <div class="game-con">
                        <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row2['logo']) . " '/>" ?></div>
                        <div class="game-column team-name"><?php echo $row2['fullName'] ?></div>
                        <div class="game-column game-result">
                            <?php if ($count2 == 0 && $count3 == 0) {
                                echo  '
                                 <span>0 - 0</span>
                                 <span class="game-type">' . $matchType . '</span>
                             ';
                            } else {
                                $row2 = mysqli_fetch_assoc($result2);
                                $row3 = mysqli_fetch_assoc($result3);
                                echo  '
                                    <span>' . $row2['teamScore'] . ' - ' . $row3['teamScore'] . '</span>
                                    <span class="game-type">' . $matchType . '</span>
                                ';
                            } ?>
                        </div>
                        <div class="game-column team-name"><?php echo $row3['fullName'] ?></div>
                        <div class="game-column team-pic"><?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row3['logo']) . " '/>" ?></div>
                    </div>
                    <div class="game-info">
                        <div class="g-info">stadium name: <span><?php echo $row['staduimName'] ?></span></div>
                        <div class="g-info">match address: <span><?php echo $row['matchAddress'] ?> </span></div>
                        <div class="g-info">match date: <span><?php echo $row['matchDate'] . ' - ' . $row['matchTime'] ?></span></div>
                    </div>
                    <div class="control-btn" style="width: fit-content; margin: 0 auto;">
                        <?php if ($count2 == 0 && $count3 == 0) { ?>
                            <a href="?box=addResult&matchID=<?php echo $row['matchID'];  ?>" class="btn btn-primary" style="width: 200px; margin: 0 auto;">add match result</a>
                        <?php
                        } else { ?>
                            <a href="?box=deleteResult&seasonID=<?php echo  $seasonID ?>&matchID=<?php echo $row['matchID'];  ?>" class="btn btn-primary" style="width: 200px; margin: 0 auto;">delete match result</a>
                        <?php
                        } ?>
                        <a href="?box=editMatch&matchID=<?php echo $row['matchID']; ?>&seasonID=<?php echo $row['seasonID']; ?>" class="btn btn-primary" style="width: 200px; margin: 0 auto;">edit match info</a>
                    </div>
                </div>
            </div>
        <?php
        } elseif ($box == "addResult") {
            $matchID = $_GET['matchID'];
            $result = matches($matchID);
            $row = mysqli_fetch_assoc($result);
            $teamID1 = $row['teamID1'];
            $teamID2 = $row['teamID2'];
            $seasonID = $row['seasonID'];
            $team1Data = Selct_teamID($teamID1);
            $team2Data = Selct_teamID($teamID2);
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add match result:</span> <br>
                </div>
                <div class="tips-box m-3">
                    <div class="alert alert-info">
                        <h2>some tips:</h2>
                        <span class="fs-4">1:</span> team points should be 3, 1 or 0 <br>
                        <span class="fs-4">2:</span> team points of these two teams shouldn't be the same
                    </div>
                </div>
                <form action="" method="POST" class="team-form">
                    <!-- for send the IDs -->
                    <input type="text" name="teamID1" value="<?php echo $teamID1 ?>" hidden>
                    <input type="text" name="seasonID" value="<?php echo $seasonID ?>" hidden>
                    <input type="text" name="matchID" value="<?php echo $matchID ?>" hidden>
                    <input type="text" name="teamID2" value="<?php echo $teamID2; ?>" hidden>
                    <!-- for send the IDs -->
                    <div class="field">
                        <div class="input-field">
                            <label for="" class="label">first team:</label>
                            <input type="text" value="<?php echo $team1Data['fullName'] ?>" readonly class="input">
                        </div>
                        <div class="input-field">
                            <label for="" class="label">team score:</label>
                            <input type="number" name="teamScores_team1" class="input">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label for="" class="label">second team:</label>
                            <input type="text" value="<?php echo $team2Data['fullName'] ?>" readonly class="input">
                        </div>
                        <div class="input-field">
                            <label for="" class="label">team score:</label>
                            <input type="number" name="teamScores_team2" class="input">
                        </div>
                    </div>
                    <div class="input-field">
                        <input type="submit" value="add result" name="BTNaddmatchscores" class="submit-btn">
                    </div>
                </form>
            </div>

            <?php
            if (isset($_POST['BTNaddmatchscores'])) {
                $teamID1 = intval($_POST['teamID1']);
                $teamID2 = intval($_POST['teamID2']);
                $matchID = intval($_POST['matchID']);
                $seasonID = intval($_POST['seasonID']);
                if (
                    $_POST['teamScores_team1'] != null
                    && $_POST['teamScores_team2'] != null
                    && $_POST['teamScores_team1'] >= 0
                    && $_POST['teamScores_team2'] >= 0
                ) {
                    $teamScores_team1 = $_POST['teamScores_team1'];
                    $teamPoints_team1 = 0;
                    $teamScores_team2 = $_POST['teamScores_team2'];
                    $teamPoints_team2 = 0;

                    if ($teamScores_team1 > $teamScores_team2) {
                        $teamPoints_team1 = 3;
                        $teamPoints_team2 = 0;
                    } elseif ($teamScores_team1 < $teamScores_team2) {
                        $teamPoints_team1 = 0;
                        $teamPoints_team2 = 3;
                    } elseif ($teamScores_team1 == $teamScores_team2) {
                        $teamPoints_team1 = 1;
                        $teamPoints_team2 = 1;
                    }

                    if (
                        (0 <= $teamScores_team1) && ($teamScores_team1 <= 20)
                        &&
                        (0 <= $teamScores_team2) && ($teamScores_team2 <= 20)
                    ) {
                        $query = "INSERT INTO matchscores (matchID, teamID, teamScore, teamPoints) 
                                    VALUES ('$matchID', '$teamID1', '$teamScores_team1', '$teamPoints_team1'),
                                    ('$matchID', '$teamID2', '$teamScores_team2', '$teamPoints_team2')";
                        if ($conn->query($query) === TRUE) {
                            echo "
                            <div class='overlay'></div>
                            <div class='handle-success-message'>match score has been added successfully</div>
                            ";
                            header('REFRESH:2;URL=season-game.php?box=showMatch&matchID=' . $matchID);
                        } else {
                            echo $conn->error;
                        }
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>please Follow the tips written above</div>
                        ";
                        header('REFRESH:2;URL=season-game.php?box=addResult&matchID=' . $matchID);
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=season-game.php?box=addResult&matchID=' . $matchID);
                }
            }
        } elseif ($box == 'editMatch') {
            $matchID = $_GET['matchID'];
            $seasonID = $_GET['seasonID'];
            $row = mysqli_fetch_assoc(matches($matchID));
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">edit game info:</span> <br>
                </div>
                <div class="tips-box m-3">
                    <div class="alert alert-info">
                        <h2>some tips:</h2>
                        <span class="fs-4">1:</span>you shoald type new match date and new match time fields in order to update data<br>
                    </div>
                </div>
                <form action="" method="POST" class="team-form">
                    <input type="hidden" value="<?php echo $matchID ?>" name="matchID">
                    <input type="hidden" value="<?php echo $seasonID ?>" name="seasonID">
                    <div class="input-field">
                        <label for="" class="label">match address:</label>
                        <input type="text" name="matchAddress" value="<?php echo $row['matchAddress'] ?>" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">stadium name:</label>
                        <input type="text" name="staduimName" value="<?php echo $row['staduimName'] ?>" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match date:</label>
                        <input style="background-color: #bbb ;" type="text" name="matchDate" value=" <?php echo $row['matchDate'] ?>" readonly class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">new match date:</label>
                        <input type="date" name="newMatchDate" class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">match time:</label>
                        <input style="background-color: #bbb ;" type="text" name="matchDate" value=" <?php echo $row['matchTime'] ?>" readonly class="input">
                    </div>
                    <div class="input-field">
                        <label for="" class="label">new match time:</label>
                        <input type="time" name="newMatchTime" class="input">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTNupdatematches" value="add game" class="submit-btn">
                    </div>
                </form>
            </div>

<?php
            if (isset($_POST['BTNupdatematches'])) {
                $matchID = intval($_POST['matchID']);
                $seasonID = $_POST['seasonID'];
                if (
                    !empty($_POST['matchAddress'])
                    && !empty($_POST['staduimName'])
                    && !empty($_POST['newMatchDate'])
                    && !empty($_POST['newMatchTime'])
                ) {
                    $matchAddress = $_POST['matchAddress'];
                    $staduimName = $_POST['staduimName'];
                    $newMatchDate = $_POST['newMatchDate'];
                    $newMatchTime = $_POST['newMatchTime'];

                    $query = "UPDATE matches SET matchAddress = '$matchAddress', staduimName = '$staduimName', matchDate = '$newMatchDate', matchTime = '$newMatchTime' WHERE matchID = '$matchID'";
                    if ($conn->query($query) === TRUE) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-success-message'>match info has been updated successfully</div>
                        ";
                        header('REFRESH:2;URL= season-game.php?box=showMatch&matchID=' . $matchID);
                    } else {
                        echo $conn->error;
                    }
                } elseif (
                    !empty($_POST['matchAddress'])
                    && !empty($_POST['staduimName'])
                ) {
                    $matchAddress = $_POST['matchAddress'];
                    $staduimName = $_POST['staduimName'];

                    $query = "UPDATE matches SET matchAddress = '$matchAddress', staduimName = '$staduimName' WHERE matchID = '$matchID'";
                    if ($conn->query($query) === TRUE) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-success-message'>match info has been updated successfully</div>
                        ";
                        header('REFRESH:2;URL= season-game.php?box=showMatch&matchID=' . $matchID);
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL= season-game.php?box=editMatch&matchID=' . $matchID . '&seasonID=' . $seasonID);
                }
            }
        } elseif ($box == 'deleteResult') {
            $matchID = $_GET['matchID'];
            $seasonID = $_GET['seasonID'];

            $query = "DELETE FROM matchscores WHERE matchID = '$matchID'";
            if ($conn->query($query) === TRUE) {
                echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>match result has been deleted successfully</div>
                ";
                header('REFRESH:2;URL=season-game.php?box=showMatch&matchID=' . $matchID);
            } else {
                echo $conn->error;
            }
        }
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
