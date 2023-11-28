<?php
ob_start();
include_once "init.php";
include_once "connect.php";
?>
<link rel="stylesheet" href="<?php echo $css; ?>match-new.css">
<link rel="stylesheet" href="<?php echo $css; ?>news.css">
<?php
include_once "includes/templates/navbar.inc";
$postID = $_GET['newID'];
$result = posts_postID($postID);
$row = mysqli_fetch_assoc($result);
?>

<div class="container new-con">
    <div class="title">
        <?php echo $row['postTitle'] ?>
    </div>
    <p class="new-name">
        <?php
        if (!empty($row['fullName'])) {
            echo $row['fullName'];
        } else {
            echo $row['leagueName'];
        }
        ?>
    </p>
    <div class="date">
        <i class="fa fa-clock fa-2x text-primary" aria-hidden="true"></i>
        <span><?php echo $row['postData'] . ' - ' . $row['postTime'] ?></span>
    </div>
    <div class="image">
        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['photoPost']) ?>" alt="">
    </div>
    <div class="desc">
        <?php echo $row['postDetails'] ?>
    </div>
</div>
<?php
$userID = $row['UserID'];
$query = "SELECT * FROM publications WHERE UserID = $userID AND PublishedID != $postID AND publicationStatus = 2 ORDER BY postData DESC LIMIT 6";
$result_UserID = mysqli_query($conn, $query);
$count_publications = mysqli_num_rows($result_UserID);
?>
<div class="container">
    <h2 class="title">related news</h2>
    <div class="news-con mt-3">
        <?php
        if ($count_publications > 0) {
            while ($row_UserID = mysqli_fetch_assoc($result_UserID)) { ?>
                <div class="news-row">
                    <div class="hz-card">
                        <div class="hz-card-image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo   base64_encode($row_UserID['photoPost']) ?>" alt="">
                        </div>
                        <div class="hz-card-content">
                            <h5><?php echo $row_UserID['postTitle'] ?></h5>
                            <span class="news-refer">hello</span>
                            <div class="content-desc">
                                <?php
                                if (strlen($row_UserID['postDetails']) > 100) {
                                    echo substr($row_UserID['postDetails'], 0, 100) . " ...";
                                } else {
                                    echo $row_UserID['postDetails'];
                                }
                                ?>
                            </div>
                            <div class="hz-card-ctrl">
                                <span>post date: <span><?php echo  $row_UserID['postData']  ?></span></span>
                                <a href="viewNew.php?newID=<?php echo $row_UserID['PublishedID'] ?>" class="btn main-btn">view</a>
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