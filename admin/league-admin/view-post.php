<?php 
session_start();
ob_start();
include "../init.php";
include "league-functions.php";
if(empty($_SESSION['S_UserID'])) {
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
        <link rel="stylesheet" href="../<?php echo $css;?>posts.css">
        <link rel="stylesheet" href="../<?php echo $css;?>forms.css">
        <?php
        include "../" . $tpl . "league-nav.inc";
        $box = isset($_GET['box']) ? $_GET['box'] : 'show';
        if($box == 'show') {
            $PublishedID = intval($_GET['PublishedID']);
            $row = mysqli_fetch_assoc(viewPost_ID($PublishedID));
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn"><ion-icon class="icons" name="log-out-outline"></ion-icon>logout</a>
                </div>
                <div class="main-title">
                    <span class="heading-title"><?php echo $row['postTitle'];?></span> <br>
                </div>
                <div class="post-date">post date: <span><?php echo $row['postData'] . ' - ' . $row['postTime']?></span></div>
                <div class="post-info">
                    <div class="post-image">
                        <?php echo "
                        <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['photoPost']) . "'/>"
                        ;?>
                    </div>
                    <p class="post-desc">
                        <?php echo $row['postDetails'];?>
                    </p>
                </div>
                <div class="post-btns">
                    <div class="btns">
                        <a class="btn btn-dark" href="?box=edit&PublishedID=<?php echo $row['PublishedID'] ?>">edit</a>
                        <a class="btn btn-delete" href=?box=delete&PublishedID=<?php echo $row['PublishedID'] ?>">delete</a>
                    </div>
                </div>
            </div>
        <?php
        } elseif($box == 'add') { 
            $UserID = intval($_GET['userID']);
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn"><ion-icon class="icons" name="log-out-outline"></ion-icon>logout</a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add new post:</span>
                </div>
                <form action="" method="POST"  class="team-form" enctype="multipart/form-data">
                    <h2>type post information</h2>
                    <div class="input-field">
                        <label for="" class="label">post title:</label>
                        <input type="text" name="postTitle" class="input">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            post description:
                        </label>
                        <textarea name="postDetails" class="input" rows="4"></textarea>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">post date:</label>
                        <input type="file" name="photoPost" class="input input-img">
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNcreatePost" type="submit" value="add">
                    </div>
                </form>
            </div>
            <?php
            if (isset($_POST['BTNcreatePost'])) {
                if (
                    !empty($_POST['postTitle'])
                    && !empty($_POST['postDetails'])
                    && !empty($_FILES["photoPost"]["name"])
                ) {
                    $postTitle = $_POST['postTitle'];
                    $postDetails = $_POST['postDetails'];
                    $fileName2 = basename($_FILES["photoPost"]["name"]);
                    $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType2, $allowTypes)) {
                        $image = $_FILES['photoPost']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));
                        createPost($UserID, $postTitle, $postDetails, $imgContent);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload</div>
                        ";
                        header('REFRESH:2;URL=view-post.php?box=add&userID=' . $UserID);
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=view-post.php?box=add&userID=' . $UserID);
                }
            }
        ?>
        <?php
        } elseif($box == 'edit') { 
            $PublishedID = intval($_GET['PublishedID']);
            $row = mysqli_fetch_assoc(viewPost_ID($PublishedID));
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn"><ion-icon class="icons" name="log-out-outline"></ion-icon>logout</a>
                </div>
                <div class="main-title">
                    <span class="heading-title">edit post information:</span>
                </div>
                <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>edit information</h2>
                    <div class="input-field">
                        <label for="" class="label">post title:</label>
                        <input type="text" class="input" name="postTitle" value="<?php echo $row['postTitle'] ?>">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            post description:
                        </label>
                        <textarea name="postDetails" class="input" rows="4"><?php echo $row['postDetails'] ?></textarea>
                    </div>
                    <div class="input-field">
                        <label for="" class="label">post picture:</label>
                        <input type="file" name="photoPost" class="input input-img">
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNupdatePost" type="submit" value="add">
                    </div>
                </form>
            </div>
            <?php
            if (isset($_POST['BTNupdatePost'])) {
                if (
                    !empty($_POST['postTitle'])
                    && !empty($_POST['postDetails'])
                    && !empty($_FILES["photoPost"]["name"])
                ) {
                    $postTitle = $_POST['postTitle'];
                    $postDetails = $_POST['postDetails'];
                    $fileName = basename($_FILES["photoPost"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['photoPost']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));
                        updatePost($postTitle, $postDetails, $imgContent, $PublishedID);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload</div>
                        ";
                        header('REFRESH:2;URL=view-post.php?box=edit&PublishedID=' . $PublishedID);
                    }
                } elseif (
                    !empty($_POST['postTitle'])
                    && !empty($_POST['postDetails'])
                ) {
                    $postTitle = $_POST['postTitle'];
                    $postDetails = $_POST['postDetails'];
                    updatePost_($postTitle, $postDetails, $PublishedID);
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=view-post.php?box=edit&PublishedID=' . $PublishedID);
                }
            }
        } elseif($box == 'delete') {
            $PublishedID = intval($_GET['PublishedID']);
            $query = "DELETE FROM publications WHERE PublishedID = '$PublishedID'";
            if ($conn->query($query) === TRUE) {
                echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>post deleted successfully</div>
                ";
                header('REFRESH:2;URL=league-posts.php');
            } else {
                echo "Error: " . $query;
            }

        }
        
        include "../" .$tpl ."footer.inc";
    }
}
ob_end_flush();
?>