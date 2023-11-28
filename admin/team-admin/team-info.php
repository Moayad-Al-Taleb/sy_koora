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
    } else { ?>
        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />

        <?php

        include "../" . $tpl . "team-nav.inc";
        $box = isset($_GET['box']) ? $_GET['box'] : 'show';
        if ($box == 'show') {
            $teamData = SelectTeamData($_SESSION['S_UserID']);
            if (mysqli_num_rows($teamData) > 0) {

                $row = mysqli_fetch_assoc($teamData);

                if (empty($row['glimpse']) && empty($row['establishing'])) { ?>

                    <div class="container">
                        <div class="heading">
                            <ion-icon name="list-outline" class="list-icon"></ion-icon>
                            <a href="../logout.php" class="logout-btn">
                                <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                            </a>
                        </div>
                        <div class="main-title">
                            <span class="heading-title">team glimpse and establishing:</span>
                        </div>
                        <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                            <h2>add team glimpse and establishing</h2>
                            <div class="input-field">
                                <label class="label" for="">
                                    team glimpse:
                                </label>
                                <textarea name="glimpse" class="input" rows="5"></textarea>
                            </div>
                            <div class="input-field">
                                <label class="label" for="">
                                    team establishing:
                                </label>
                                <textarea name="establishing" class="input" rows="5"></textarea>
                            </div>
                            <div class="input-field">
                                <input class="submit-btn" name="BTN_Additional_data" type="submit" value="add">
                            </div>
                        </form>
                    </div>
                <?php
                } else {
                ?>
                    <div class="container">
                        <div class="heading">
                            <ion-icon name="list-outline" class="list-icon"></ion-icon>
                            <a href="../logout.php" class="logout-btn">
                                <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                            </a>
                        </div>
                        <div class="main-title">
                            <span class="heading-title">team glimpse and establishing:</span>
                        </div>
                        <div class="main-info">
                            <div class="full-column">
                                <?php echo $row['fullName']; ?> glimpse:
                                <textarea readonly rows="5"><?php echo $row['glimpse']; ?></textarea>
                            </div>
                            <div class="full-column">
                                <?php echo $row['fullName']; ?> establishing:
                                <textarea readonly rows="5"><?php echo $row['establishing']; ?></textarea>
                            </div>
                            <div class="full-column">
                                <a href="team-info.php?box=edit-info&teamID=<?php echo $row['teamID']; ?>">edit team info</a>
                            </div>

                        </div>
                    </div>

            <?php
                }
            }
            if (isset($_POST['BTN_Additional_data'])) {
                if (
                    !empty($_POST['glimpse'])
                    && !empty($_POST['establishing'])
                ) {
                    $UserID = $_SESSION['S_UserID'];

                    $glimpse = $_POST['glimpse'];
                    $establishing = $_POST['establishing'];
                    additionalData($glimpse, $establishing, $UserID);
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=team-info.php');
                }
            }
        } elseif ($_GET['box'] == 'edit-info') {
            $teamID = intval($_GET['teamID']);
            $result = SelectTeamAdditionalData($teamID);
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
                    <span class="heading-title">team glimpse and establishing:</span>
                </div>
                <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>edit team glimpse and establishing</h2>
                    <div class="input-field">
                        <label class="label" for="">
                            team glimpse:
                        </label>
                        <textarea name="glimpse" class="input" rows="5"><?php echo $row['glimpse']; ?></textarea>
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            team establishing:
                        </label>
                        <textarea name="establishing" class="input" rows="5"><?php echo $row['establishing']; ?></textarea>
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTN_Additional_data_update" type="submit" value="edit">
                    </div>
                </form>
            </div>
<?php
            if (isset($_POST['BTN_Additional_data_update'])) {
                if (
                    !empty($_POST['glimpse'])
                    && !empty($_POST['establishing'])
                ) {
                    $glimpse = $_POST['glimpse'];
                    $establishing = $_POST['establishing'];
                    UpdateTeamAdditionalData($glimpse, $establishing, $teamID);
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=team-info.php');
                }
            }
        }
    }

    include "../" . $tpl . "footer.inc";
    ob_end_flush();
}
