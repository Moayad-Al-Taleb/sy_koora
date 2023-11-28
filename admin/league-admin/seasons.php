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
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>seasons.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />

        <?php
        include "../" . $tpl . "league-nav.inc";
        $leagueID = leagueID($_SESSION["S_UserID"]);
        $ID = $leagueID;
        $counter = 1;
        $box = isset($_GET['box']) ? $_GET['box'] : 'manage';
        if ($box == 'manage') { ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">manage league seasons:</span> <br>
                    <a href="?box=createSeason" class="btn btn-primary">add new season</a>
                </div>
                <?php
                $result = Select_seasons($ID, 'leagueID');
                if (!empty($result)) {
                ?>
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th class="col-6">season date</th>
                            <th>control</th>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $row['currentSeason_date']; ?></td>
                                    <td>
                                        <a href='?box=show&seasonID=<?php echo $row['seasonID']; ?>' class="btn btn-dark">view</a>
                                        <a href='?box=delete&seasonID=<?php echo $row['seasonID']; ?>' class="btn btn-delete">delete</a>
                                    </td>
                                </tr>

                            <?php $counter++;
                            } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "<div class='alert alert-success> no records yet! </div>";
                }
                ?>
            </div>
        <?php
        } elseif ($box == 'createSeason') { ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add new season:</span> <br>
                </div>
                <form action="?box=insertSeason" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>create new season</h2>
                    <div class="input-field">
                        <label class="label" for="">
                            season date:
                        </label>
                        <input class="input team-input" name="currentSeason_date" type="text">
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNaddSeason" type="submit" value="create">
                    </div>
                </form>
            </div>
            <?php
        } elseif ($box == 'insertSeason') {
            if (!empty($_POST["currentSeason_date"])) {
                $currentSeason_date = $_POST['currentSeason_date'];
                Insert_seasons($leagueID, $currentSeason_date);
            } else {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>please fill in all fields</div>
                ";
                header('REFRESH:2;URL=seasons.php?box=createSeason');
            }
        } elseif ($box == 'show') {
            if (!empty($_GET["seasonID"])) {
                $seasonID = $_GET['seasonID'];
                $result = Select_seasons($seasonID, "seasonID");

                $query = "SELECT * FROM leagues INNER JOIN seasons ON leagues.leagueID = seasons.leagueID WHERE seasonID = $seasonID";

                $myRes = mysqli_query($conn, $query);

                $row2 = mysqli_fetch_assoc($myRes);

                $row = mysqli_fetch_assoc($result);

                $count = Check_seasonID($seasonID);
            ?>
                <div class="container">
                    <div class="heading">
                        <ion-icon name="list-outline" class="list-icon"></ion-icon>
                        <a href="../logout.php" class="logout-btn">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                        </a>
                    </div>
                    <div class="main-title">
                        <span class="heading-title">league <?php echo $row["currentSeason_date"]; ?> season teams:</span> <br>
                    </div>
                    <div class="season-con">
                        <?php
                        if ($count > 0) {
                            $result3 = Select_participatingteams($seasonID); ?>
                            <div class="teams-con">
                                <div class="season-teams">
                                    <div class="season-teams-con">
                                        <?php while ($row3 = mysqli_fetch_assoc($result3)) { ?>
                                            <div class="content">
                                                <?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row3['logo']) . " '/> " ?>
                                                <div class="column-content abs-content"><?php echo $row3['fullName']; ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="btns">
                                        <a href="season-game.php?seasonID=<?php echo $seasonID; ?>" class="btn btn-dark">all matches</a>
                                        <a href="teams-rating.php?seasonID=<?php echo $seasonID; ?>" class="btn btn-primary">teams rating</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            $result2 = Select_All_Team();
                            if (!empty($result2)) {
                            ?>
                                <div class="teams-con">
                                    <form action="" method="POST" class="season-teams">
                                        <div class="season-teams-con">
                                            <?php while ($row3 = mysqli_fetch_assoc($result2)) { ?>
                                                <div class="content">
                                                    <?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row3['logo']) . " '/> " ?>
                                                    <div class="column-content abs-content"><?php echo $row3['fullName']; ?></div>
                                                    <div class="input-field btn btn-primary">
                                                        <input class="checkbox" name="check_list[]" value="<?php echo $row3['teamID']; ?>" type="checkbox">
                                                        choose
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </div>
                                        <div class="control">
                                            <input class="btn btn-primary mb-4" type="submit" name="submit" value="add teams">
                                        </div>
                                    </form>
                                </div>
                            <?php
                            } ?>
                    </div>
                </div>
    <?php
                        }
                        if (isset($_POST['submit'])) {
                            if (!empty($_POST['check_list'])) {
                                // عدد الفرق المشاركة في الدوري، يجب علينا أن نقوم بشرط في حال عدد الفرق الذي قام بتحديدها المستخدم مساوي لهذا العدد نسمح له بالأضافة
                                $numberTeams = Select_numberTeams($_SESSION["S_UserID"]);

                                // count($_POST['check_list']);
                                if ($numberTeams ==  count($_POST['check_list'])) {
                                    foreach ($_POST['check_list'] as $selected) {
                                        // $seasonID
                                        // $selected
                                        Insert_participatingteams($selected, $seasonID);
                                    }
                                    echo "
                            <div class='overlay'></div>
                            <div class='handle-success-message'>teams has been inserted successfully</div>
                            ";
                                    header('REFRESH:2;URL=?box=show&seasonID=' . $seasonID);
                                } else {
                                    echo "
                            <div class='overlay'></div>
                            <div class='handle-error-message'>please Choose the number of teams that matches the number of teams in the league </div>
                            ";
                                    header('REFRESH:2;URL=?box=show&seasonID=' . $seasonID);
                                }
                            } else {
                                echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>please Choose the number of teams that matches the number of teams in the league </div>
                        ";
                                header('REFRESH:2;URL=?box=show&seasonID=' . $seasonID);
                            }
                        }
                    }
                } elseif ($box == 'delete') {
                    $seasonID = $_GET['seasonID'];
                    $query = "DELETE FROM seasons WHERE seasonID = '$seasonID'";
                    if ($conn->query($query) === TRUE) {
                        echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>season has been deleted successfully</div>
                ";
                        header('REFRESH:2;URL=seasons.php');
                    } else {
                        echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>sorry, can not delete cuz it's has a data</div>
                ";
                        header('REFRESH:2;URL=seasons.php');
                    }
                }
    ?>
<?php include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
