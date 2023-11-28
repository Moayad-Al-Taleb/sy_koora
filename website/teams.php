<?php
ob_start();
include_once "init.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>league-team.css">
<?php
include_once "includes/templates/navbar.inc";
$Today = date('Y-m-d');
$accountType = 2;
$result_publications = publications_($Today, $accountType);
$count_publications = mysqli_num_rows($result_publications);
?>

<div class="container">
    <div class="main-con">
        <div class="main-section">
            <h3>recent news for all teams</h3>
            <?php
            if ($count_publications > 0) {
                while ($row_publications = mysqli_fetch_assoc($result_publications)) { ?>
                    <div class="hz-card">
                        <div class="hz-card-image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_publications['photoPost']) ?>" alt="">
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
                                <span>post date: <span><?php echo $row_publications['postData'] ?></span></span>
                                <a href="viewNew.php?newID=<?php echo $row_publications['PublishedID'] ?>" class="btn main-btn">view</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="side-container">
            <h3>all teams</h3>
            <div class="side-con">
                <?php
                $result_team = team();
                $count_team = mysqli_num_rows($result_team);
                if ($count_team > 0) {
                    while ($row_team = mysqli_fetch_assoc($result_team)) { ?>
                        <div class="left-card">
                            <div class="image">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_team['logo']) ?>" alt="">
                            </div>
                            <div class="content">
                                <span class="name"><?php echo $row_team['fullName'] ?></span>
                                <a href="team.php?box=mainPage&teamID=<?php echo $row_team['teamID'] ?>" class="btn second-btn">view</a>
                            </div>
                        </div>
                <?php
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