<?php
ob_start();
include_once "init.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>news.css">
<?php
include_once "includes/templates/navbar.inc";

$Today = date('Y-m-d');
$result_publications = publications($Today);
$count_publications = mysqli_num_rows($result_publications);
?>
<div class="container">
    <h2>all news</h2>
    <div class="news-con">
        <?php
        if ($count_publications > 0) {
            while ($row_publications = mysqli_fetch_assoc($result_publications)) { ?>
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
include_once "includes/templates/footer.inc";
ob_end_flush();
?>