<?php
session_start();
ob_start();
include "../init.php";
include "team-function.php";
if (empty($_SESSION["S_UserID"])) {
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
        include "../" . $tpl . "team-nav.inc";

        $box = isset($_GET['box']) ? $_GET['box'] : 'leagues';
        if ($box == 'leagues') {
            $teamID = SelectTeamIDBy_UserID($_SESSION["S_UserID"]);
            $result = SelectLeaguesBy_teamID($teamID);
            $counter = 0;
?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span>all leagues the team has joined</span>
                </div>
                <div class="teable-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>league name</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $counter++;
                            ?>
                                <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo $row['leagueName']; ?></td>
                                    <td><a href="?box=viewSeasons&teamID=<?php echo $teamID; ?>&leagueID=<?php echo $row['leagueID']; ?>" class="btn btn-primary">view</a></td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } elseif ($box == 'viewSeasons') {
            $teamID = $_GET['teamID'];
            $leagueID = $_GET['leagueID'];
            $result = SelectSeasonsByLeagueID_teamID($teamID, $leagueID);
            $counter = 0;
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span>all seasons in this league:</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>season date</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $counter++;
                            ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $row['currentSeason_date']; ?></td>
                                    <td><a href="?box=Season&seasonID=<?php echo $row['seasonID']; ?>&teamID=<?php echo $teamID; ?>" class="btn btn-primary">View</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } elseif ($box == 'Season') {
            $seasonID = $_GET['seasonID'];
            $teamID = $_GET['teamID'];
            $result = Select_scores($seasonID);
            $counter = 0;
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span>all teams rating in this season</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>team name</th>
                            <th>team scores</th>
                            <th>team points</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $counter++;
                                if ($row['teamID'] == $teamID) {
                            ?>
                                    <tr class="table-info fw-bold">
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $row['fullName'] ?></td>
                                        <td><?php echo $row['teamScore'] ?></td>
                                        <td><?php echo $row['teamPoints'] ?></td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $row['fullName'] ?></td>
                                        <td><?php echo $row['teamScore'] ?></td>
                                        <td><?php echo $row['teamPoints'] ?></td>
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
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
