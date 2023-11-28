<?php
session_start();
ob_start();
include "../init.php";
include "function.php";
if (empty($_SESSION["S_UserID"])) {
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
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css">
        <?php
        include "../" . $tpl . "web-nav.inc";
        $result = LeaguesData();
        $counter = 0;

        $box = isset($_GET['box']) ? $_GET["box"] : "show";

        if ($box == "show") {
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span>all leagues</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>league name</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($result)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $counter++;
                            ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $row['leagueName'] ?></td>
                                        <td><a href="?box=league&leagueID=<?php echo $row['leagueID'] ?>" class="btn btn-primary">view</a></td>
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
        } elseif ($box == 'league') {
            $leagueID = intval($_GET['leagueID']);
            $result = Selectleague($leagueID);
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">manage league information:</span>
                </div>
                <div class="team-info">
                    <div class="header-logo">
                        <div class="left-logo">
                            <?php
                            echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['leagueImage']) . " ' width='10%'/>";
                            ?>
                            <h3 class="team-name"><?php echo $row['leagueName'] ?></h3>
                        </div>
                    </div>
                    <div class="main-info">
                        <div class="team-info">
                            <div class="column ">Organisers: <span><?php echo $row['Organisers'] ?></span></div>
                            <div class="column">date Created: <span><?php echo $row['dateCreated'] ?></span></div>
                            <div class="column with-shadow">Sports: <span><?php echo $row['Sports'] ?></span></div>
                            <div class="column with-shadow">Country: <span><?php echo $row['Country'] ?></span></div>
                            <div class="column">continent: <span><?php echo $row['continent'] ?></span></div>
                            <div class="column">Manager: <span><?php echo $row['Manager'] ?></span></div>
                            <div class="column with-shadow">number of participiting Teams : <span><?php echo $row['numberTeams'] ?></span></div>
                            <div class="column with-shadow">the winner team qualify For: <span><?php echo $row['qualifyFor'] ?></span></div>
                            <div class="column">drop: <span><?php echo $row['dropTO'] ?></span></div>
                            <div class="column">related Competitions: <span><?php echo $row['relatedCompetitions'] ?></span></div>
                            <div class="column with-shadow">glimpse: <span><?php echo $row['glimpse'] ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
