<?php
session_start();
ob_start();
include "../init.php";
include "team-function.php";
if (empty($_SESSION['S_UserID'])) {
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
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>posts.css">
        <?php
        include "../" . $tpl . "team-nav.inc";
        $result = SelectPublications_2($_SESSION["S_UserID"]);
        $result2 = SelectPublications_1($_SESSION['S_UserID']);
        ?>
        <div class="container">
            <div class="heading">
                <ion-icon name="list-outline" class="list-icon"></ion-icon>
                <a href="../logout.php" class="logout-btn">
                    <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                </a>
            </div>
            <div class="main-title">
                <span class="heading-title">all posts belongs to this team:</span> <br>
                <a href="view-post.php?box=add&userID=<?php echo $_SESSION['S_UserID'] ?>" class="btn btn-primary">add new post</a>
            </div>
            <div class="all-posts-con">
                <div class="posts-con">
                    <h2>active posts:</h2>
                    <?php if (!empty($result)) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="hz-card">
                                <div class="image">
                                    <?php echo "
                                        <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['photoPost']) . " '/>
                                        " ?>
                                </div>
                                <div class="card-content">
                                    <h2><?php echo $row['postTitle']; ?></h2>
                                    <p>
                                        <?php
                                        $myString = $row['postDetails'];
                                        if (strlen($myString) > 40) {
                                            echo substr($myString, 0, 80) . '...';
                                        } else {
                                            echo $myString;
                                        }
                                        ?>
                                    </p>
                                    <div class="card-ctrl-date">
                                        <span><?php echo $row['postData'] . ' - ' . $row['postTime'] ?></span>
                                        <a class="btn btn-primary" href="view-post.php?PublishedID=<?php echo $row['PublishedID']; ?>">view</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='alert alert-info' width='100%'>no posts here</div>";
                    }
                    ?>
                </div>
                <div class="posts-con">
                    <h2>inactive posts:</h2>
                    <?php if (!empty($result2)) {
                        while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                            <div class="hz-card">
                                <div class="image">
                                    <?php echo "
                                        <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row2['photoPost']) . " '/>
                                        " ?>
                                </div>
                                <div class="card-content">
                                    <h2><?php echo $row2['postTitle']; ?></h2>
                                    <p>
                                        <?php
                                        $myString = $row2['postDetails'];
                                        if (strlen($myString) > 40) {
                                            echo substr($myString, 0, 80) . '...';
                                        } else {
                                            echo $myString;
                                        }
                                        ?>
                                    </p>
                                    <div class="card-ctrl-date">
                                        <span><?php echo $row2['postData'] . ' - ' . $row2['postTime'] ?></span>
                                        <a class="btn btn-primary" href="view-post.php?PublishedID=<?php echo $row2['PublishedID']; ?>">view</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='alert alert-info' width='100%'>no posts here</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

<?php
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
