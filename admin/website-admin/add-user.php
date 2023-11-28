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
    if ($_SESSION["S_AccountType"] = 1) {
        ?>
        <!-- link css files  -->
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css">
        <!-- link css files  -->

        <!-- include navbar  -->
        <?php
        include "../" . $tpl . "web-nav.inc";
        ?>
        <!-- include navbar  -->

        <!-- body  -->
        <div class="container">
            <div class="heading">
                <ion-icon name="list-outline" class="list-icon"></ion-icon>
                <a href="../logout.php" class="logout-btn"><ion-icon class="icons" name="log-out-outline"></ion-icon>logout</a>
            </div>
            <div class="main-title">
                <span>add new admin:</span>
            </div>
            <form class="user-form" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="input-field">
                    <label class="label" for="fullName">full name: </label>
                    <input class="input" type="text" autocomplete="off" name="fullName">
                </div>
                <div class="input-field">
                    <label class="label" for="Email">email:</label>
                    <input class="input" type="email" autocomplete="off" name="Email"> 
                </div>
                <div class="input-field">
                    <label class="label" for="Password">password:</label>
                    <input class="input" type="password" autocomplete="new-password" name="Password">
                </div>
                <div class="input-field">
                    <label class="label" for="accountType">account type: </label>
                    <select class="input" autocomplete="off" name="accountType">
                        <option value="2">team admin</option>
                        <option value="3">league admin</option>
                    </select>
                </div>

                <div class="input-field">
                    <label class="label">choose a picture:</label>
                    <input class="input input-img" type="file" name="image">
                </div>

                <div class="input-field">
                <input type="submit" class="submit-btn" name="BTNaddUser" value="add user">
                </div>
            </form>

        <?php
        if (isset($_POST['BTNaddUser'])) {
            if (
                !empty($_POST['fullName'])
                && !empty($_POST['Email'])
                && !empty($_POST['Password'])
                && !empty($_POST['accountType'])
                && !empty($_FILES["image"]["name"])
            ) {
                $fullName = $_POST['fullName'];
                $Email = $_POST['Email'];
                $Password = sha1($_POST['Password']);
                $accountType = $_POST['accountType'];
        
                $fileName = basename($_FILES["image"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['image']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                    $count = Check($Email);
                    if ($count > 0) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>this email already existed</div>
                        ";
                        header('REFRESH:2;URL=add-user.php');
                    } else {
                        addUser($fullName, $Email, $Password, "2", $accountType, $imgContent);
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload</div>
                    ";
                    header('REFRESH:2;URL=add-user.php');
                }
            } else {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>please fill in all fields</div>
                ";
                header('REFRESH:2;URL=add-user.php');
            }
        }
        include "../" . $tpl . "footer.inc";

    } else {
        echo 'You cannot access this page. This page is reserved for the site administrator';
        header('REFRESH:2;URL=../Login.php');
    }
}
ob_end_flush();