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
        if (isset($_GET['teamID'])) {
?>
            <link rel="stylesheet" href="../<?php echo $css; ?>forms.css">
            <?php
            include "../" . $tpl . "team-nav.inc";
            $teamID = intval($_GET['teamID']);
            $result = SelectTeam($teamID);
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
                    <span class="heading-title">edit team information:</span>
                </div>

                <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                    <div class="input-field">
                        <label class="label" for="">
                            team full name:
                        </label>
                        <input class="input team-input" name="fullName" type="text" value="<?php echo $row['fullName']; ?>" placeholder="please follow the conditions">
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                team nickname:
                            </label>
                            <input class="input team-input" name="nickName" type="text" value="<?php echo $row['nickName']; ?>" placeholder="please follow the conditions">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                staduim name:
                            </label>
                            <input class="input team-input" name="stadium" value="<?php echo $row['stadium']; ?>" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                country:
                            </label>
                            <input class="input team-input" name="country" value="<?php echo $row['country']; ?>" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                The team leader name:
                            </label>
                            <input class="input team-input" name="president" value="<?php echo $row['president']; ?>" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                The team coach name:
                            </label>
                            <input class="input team-input" name="coach" value="<?php echo $row['coach']; ?>" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">Founded year:</label>
                            <input class="input team-input" name="foundedYear" value="<?php echo $row['foundedYear']; ?>" type="date">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                team kit:
                            </label>
                            <input class="input-img" name="teamKit" type="file">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                team logo:
                            </label>
                            <input class="input-img" name="logo" type="file">
                        </div>
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTN_updateTeam" type="submit" value="update">
                    </div>
                </form>
            </div>

<?php
            include "../" . $tpl . "footer.inc";

            if (isset($_POST['BTN_updateTeam'])) {
                if (
                    !empty($_POST['nickName'])
                    && !empty($_POST['foundedYear'])
                    && !empty($_POST['stadium'])
                    && !empty($_POST['country'])
                    && !empty($_POST['president'])
                    && !empty($_POST['coach'])
                    && !empty($_FILES["teamKit"]["name"])
                    && !empty($_FILES["logo"]["name"])
                ) {
                    $nickName = $_POST['nickName'];
                    $foundedYear = $_POST['foundedYear'];
                    $stadium = $_POST['stadium'];
                    $country = $_POST['country'];
                    $president = $_POST['president'];
                    $coach = $_POST['coach'];


                    $fileName = basename($_FILES["teamKit"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    $fileName2 = basename($_FILES["logo"]["name"]);
                    $fileType2 = pathinfo($fileName, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

                    if (in_array($fileType, $allowTypes) && in_array($fileType2, $allowTypes)) {
                        $image = $_FILES['teamKit']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        $image2 = $_FILES['logo']['tmp_name'];
                        $imgContent2 = addslashes(file_get_contents($image2));

                        updateTeam($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $imgContent2, $teamID);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'> Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                        ";
                        header('REFRESH:2;URL=edit-team.php?teamID=' . $teamID);
                    }
                } elseif (
                    !empty($_POST['nickName'])
                    && !empty($_POST['foundedYear'])
                    && !empty($_POST['stadium'])
                    && !empty($_POST['country'])
                    && !empty($_POST['president'])
                    && !empty($_POST['coach'])
                    && !empty($_FILES["logo"]["name"])
                ) {
                    $nickName = $_POST['nickName'];
                    $foundedYear = $_POST['foundedYear'];
                    $stadium = $_POST['stadium'];
                    $country = $_POST['country'];
                    $president = $_POST['president'];
                    $coach = $_POST['coach'];

                    $fileName2 = basename($_FILES["logo"]["name"]);
                    $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType2, $allowTypes)) {
                        $image2 = $_FILES['logo']['tmp_name'];
                        $imgContent2 = addslashes(file_get_contents($image2));

                        updateTeam_logo($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent2, $teamID);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'> Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                        ";
                        header('REFRESH:2;URL=edit-team.php?teamID=' . $teamID);
                    }
                } elseif (
                    !empty($_POST['nickName'])
                    && !empty($_POST['foundedYear'])
                    && !empty($_POST['stadium'])
                    && !empty($_POST['country'])
                    && !empty($_POST['president'])
                    && !empty($_POST['coach'])
                    && !empty($_FILES["teamKit"]["name"])
                ) {
                    $nickName = $_POST['nickName'];
                    $foundedYear = $_POST['foundedYear'];
                    $stadium = $_POST['stadium'];
                    $country = $_POST['country'];
                    $president = $_POST['president'];
                    $coach = $_POST['coach'];
                    $fileName = basename($_FILES["teamKit"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['teamKit']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        updateTeam_teamKit($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $teamID);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'> Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                        ";
                        header('REFRESH:2;URL=edit-team.php?teamID=' . $teamID);
                    }
                } else
                if (
                    !empty($_POST['nickName'])
                    && !empty($_POST['foundedYear'])
                    && !empty($_POST['stadium'])
                    && !empty($_POST['country'])
                    && !empty($_POST['president'])
                    && !empty($_POST['coach'])
                ) {
                    $nickName = $_POST['nickName'];
                    $foundedYear = $_POST['foundedYear'];
                    $stadium = $_POST['stadium'];
                    $country = $_POST['country'];
                    $president = $_POST['president'];
                    $coach = $_POST['coach'];

                    updateTeam_2($nickName, $foundedYear, $stadium, $country, $president, $coach, $teamID);
                } else {
                    echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'> please fill in all fields.</div>
                        ";
                    header('REFRESH:2;URL=edit-team.php?teamID=' . $teamID);
                }
            }
        }
    }
}
ob_end_flush();
