<?php
ob_start();
include_once "init.php";
include_once "includes/templates/navbar.inc";

$result_leagues = leagues();
$count_leagues = mysqli_num_rows($result_leagues);

$date = date('Y-m-d');
$result_matches = matches($date);
$count_matches = mysqli_num_rows($result_matches);
?>
<div class="container">
    <div class="main-con">
        <div class="side-container">
            <h3>most followed leagues</h3>
            <div class="side-con">
                <?php
                if ($count_leagues > 0) {
                    while ($row_leagues = mysqli_fetch_assoc($result_leagues)) {
                        echo "
                        <a href='league.php?leagueID=" . $row_leagues['leagueID'] . "' class='left-card'>
                            <div class='image'>
                                <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row_leagues['leagueImage']) . "' alt=''>
                            </div>
                            <div class='content'>
                                <span class='name'>" . $row_leagues['leagueName'] . "</span>
                            </div>
                        </a>";
                    }
                }
                ?>

            </div>
        </div>
        <div class="main-section">
            <h3>recent news</h3>
            <?php
            $Today = date('Y-m-d');
            $result_publications = publications($Today);
            $count_publications = mysqli_num_rows($result_publications);
            if ($count_publications > 0) {
                while ($row_publications = mysqli_fetch_assoc($result_publications)) {
            ?>
                    <div class="hz-card">
                        <div class="hz-card-image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_publications['photoPost']); ?>" alt="">
                        </div>
                        <div class="hz-card-content">
                            <h5><?php echo  $row_publications['postTitle'] ?></h5>
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
                                <span>post date: <span><?php echo $row_publications['postData']  ?></span></span>
                                <a href="viewNew.php?newID=<?php echo $row_publications['PublishedID']  ?>" class="btn main-btn">view</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="side-container">
            <h3>recent matches</h3>
            <div class="side-con">
                <?php
                $date = date('Y-m-d');
                $result_matches = matches($date);
                $count_matches = mysqli_num_rows($result_matches);
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
                            <a href="viewMatch.php?matchID=<?php echo $matchID ?>" class="min-match-card">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team1_logo['logo']) ?>" alt="">
                                <div class="time"><?php echo $row_matches['matchTime'] ?></div>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($team2_logo['logo']) ?>" alt="">
                            </a>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once "includes/templates/footer.inc";
ob_end_flush();
?>