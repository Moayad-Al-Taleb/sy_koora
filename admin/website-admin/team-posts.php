<?php
session_start();
ob_start();
include "../init.php";
include "function.php";
if (empty($_SESSION['S_UserID'])) {
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
        <link rel="stylesheet" href="../<?php echo $css; ?>posts.css">
        <?php
        include "../" . $tpl . "web-nav.inc";

        $box = isset($_GET['box']) ? $_GET['box'] : 'allTeams';

        if ($box == 'allTeams') {
            $result = TeamData();
            if (!empty($result)) {
        ?>
                <div class="container">
                    <div class="heading">
                        <ion-icon name="list-outline" class="list-icon"></ion-icon>
                        <a href="../logout.php" class="logout-btn">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                        </a>
                    </div>
                    <div class="main-title">
                        <span>all teams posts</span>
                    </div>
                    <div class="cards-container">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="v-card">
                                <a href="?box=teamPosts&ID=<?php echo $row['UserID']; ?>">
                                    <div class="image">
                                        <?php
                                        echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['logo']) . "'/>";
                                        ?>
                                    </div>
                                    <div class="card-content">
                                        <p><?php echo $row['fullName']; ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            }
        } elseif ($box == 'allLeagues') {
            $result = leaguesData();
            if (!empty($result)) {
            ?>
                <div class="container">
                    <div class="heading">
                        <ion-icon name="list-outline" class="list-icon"></ion-icon>
                        <a href="../logout.php" class="logout-btn">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                        </a>
                    </div>
                    <div class="main-title">
                        <span>all leagues posts</span>
                    </div>
                    <div class="cards-container">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="v-card">
                                <a href="?box=leaguePosts&ID=<?php echo $row['UserID']; ?>">
                                    <div class="image">
                                        <?php
                                        echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['leagueImage']) . "'/>";
                                        ?>
                                    </div>
                                    <div class="card-content">
                                        <p class=""><?php echo $row['leagueName']; ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            <?php
            }
        } elseif ($box == 'teamPosts') {
            $ID = intval($_GET["ID"]);
            $result = ActivePublications($ID);
            $rows1 = mysqli_num_rows($result);
            $result2 = InActivePublications($ID);
            $rows2 = mysqli_num_rows($result2);
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
                </div>
                <div class="all-posts-con">
                    <div class="posts-con">
                        <h2>active posts:</h2>
                        <?php if ($rows1 > 0) {
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
                                            <span>post date: <?php echo $row['postData']; ?></span>
                                            <a class="btn btn-primary" href="team-posts.php?box=showPost&ID=<?php echo $ID ?>&PublishedID=<?php echo $row['PublishedID']; ?>">view</a>
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
                        <?php if ($rows2 > 0) {
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
                                            <span>post date: <?php echo $row2['postData']; ?></span>
                                            <a class="btn btn-primary" href="team-posts.php?box=showPost&ID=<?php echo $ID ?>&PublishedID=<?php echo $row2['PublishedID']; ?>">view</a>
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
        } elseif ($box == 'leaguePosts') {
            $ID = intval($_GET["ID"]);
            $result = ActivePublications($ID);
            $rows1 = mysqli_num_rows($result);
            $result2 = InActivePublications($ID);
            $rows2 = mysqli_num_rows($result2);
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
                </div>
                <div class="all-posts-con">
                    <div class="posts-con">
                        <h2>active posts:</h2>
                        <?php if ($rows1 > 0) {
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
                                            <span>post date: 2/ 2/ 2022</span>
                                            <a class="btn btn-primary" href="team-posts.php?box=showPost&ID=<?php echo $ID ?>&PublishedID=<?php echo $row['PublishedID']; ?>">view</a>
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
                        <?php if ($rows2 > 0) {
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
                                            <span>post date: 2/ 2/ 2022</span>
                                            <a class="btn btn-primary" href="team-posts.php?box=showPost&ID=<?php echo $ID ?>&PublishedID=<?php echo $row2['PublishedID']; ?>">view</a>
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
        } elseif ($box == 'showPost') {
            $PublishedID = intval($_GET['PublishedID']);
            $ID = intval($_GET['ID']);
            $row = mysqli_fetch_assoc(viewPost_ID($PublishedID));
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title"><?php echo $row['postTitle']; ?></span> <br>
                </div>
                <div class="post-date">post date: <span><?php echo $row['postData']; ?></span></div>
                <div class="post-info">
                    <div class="post-image">
                        <?php echo "
                      <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['photoPost']) . "'/>"; ?>
                    </div>
                    <p class="post-desc">
                        <?php echo $row['postDetails']; ?>
                    </p>
                </div>
                <div class="post-btns">
                    <?php
                    if ($row['publicationStatus'] == 1) { ?>
                        <div class="btns">
                            <a class="btn btn-delete" href="?box=active&ID=<?php echo $ID ?>&PublishedID=<?php echo $row['PublishedID'] ?>">active</a>
                        </div>
                    <?php
                    } else { ?>
                        <div class="btns">
                            <a class="btn btn-delete" href="?box=inactive&ID=<?php echo $ID ?>&PublishedID=<?php echo $row['PublishedID'] ?>">inActive</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
<?php
        } elseif ($box == 'active') {
            $ID = intval($_GET['ID']);
            $PublishedID = intval($_GET['PublishedID']);
            $query_accountType = "SELECT accountType FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE PublishedID = $PublishedID";
            $result_accountType = mysqli_query($conn, $query_accountType);
            $row_accountType = mysqli_fetch_assoc($result_accountType);
            $accountType = $row_accountType['accountType'];
            $query = "UPDATE publications SET publicationStatus = '2' WHERE PublishedID='$PublishedID'";
            if ($conn->query($query) === TRUE) {
                echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>post has been activited</div>
                ";
                if ($accountType == 2) {
                    header('REFRESH:2;URL=?box=teamPosts&ID=' . $ID);
                } else {
                    header('REFRESH:2;URL=?box=leaguePosts&ID=' . $ID);
                }
                // header('REFRESH:2;URL=manage-posts.php');
            } else {
                echo "Error: " . $query;
            }
        } elseif ($box == 'inactive') {
            $ID = intval($_GET['ID']);
            $PublishedID = intval($_GET['PublishedID']);
            $query_accountType = "SELECT accountType FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE PublishedID = $PublishedID";
            $result_accountType = mysqli_query($conn, $query_accountType);
            $row_accountType = mysqli_fetch_assoc($result_accountType);
            $accountType = $row_accountType['accountType'];
            $query = "UPDATE publications SET publicationStatus = '1' WHERE PublishedID='$PublishedID'";
            if ($conn->query($query) === TRUE) {
                echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>post has been disabled</div>
                ";
                if ($accountType == 2) {
                    header('REFRESH:2;URL=?box=teamPosts&ID=' . $ID);
                } else {
                    header('REFRESH:2;URL=?box=leaguePosts&ID=' . $ID);
                }
                // header('REFRESH:2;URL=manage-posts.php');
            } else {
                echo "Error: " . $query;
            }
        }
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
