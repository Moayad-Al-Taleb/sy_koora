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
    if ($_SESSION["S_AccountType"] != 1) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>'You cannot access this page. This page is reserved for the site administrator</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
?>
        <!-- link css files  -->
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-users.css">
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
                <a href="../logout.php" class="logout-btn">
                    <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                </a>
            </div>
            <div class="main-title">
                <span>all admins in the website:</span>
                <a href="add-user.php" class="btn btn-primary">add new admin</a>
            </div>
            <div class="panel">
                <p class="panel-title">teams admins:</p>
                <div class="panel-content active">
                    <?php //جلب  حسابات مدراء الفرق
                    $result_TeamManager = TeamManager();
                    if (!empty($result_TeamManager)) {
                        while ($row = mysqli_fetch_assoc($result_TeamManager)) {
                            if ($row['accountStatus'] == 1) {
                                //?  تقسيم الصفحة المطلوبة باستخدام get['box'] حيث نمرر قيمة ونستعملهااااا
                                echo '
                                <div class="user-column">
                                    <div class="user-info">
                                        <div class="image"><img src="data:image/jpg;charset=utf8;base64,' . base64_encode($row['image']) . ' " alt="no image"/></div>
                                        <div class="user-col">' . $row['fullName'] . '</div>
                                        <div class="email">' . $row["Email"] . '</div>
                                    </div>
                                    <div class="user-ctrl">
                                        <div class="user-btn"><a href="user-info.php?box=View&UserID=' . $row['UserID'] . '">view</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=Active&UserID=' . $row['UserID'] . '">Active</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=Delete&UserID=' . $row['UserID'] . '">delete</a></div>
                                    </div>
                                </div>
                                ';
                            } elseif ($row['accountStatus'] == 2) {
                                echo '
                                <div class="user-column">
                                    <div class="user-info">
                                        <div class="image"><img src="data:image/jpg;charset=utf8;base64,' . base64_encode($row['image']) . '" alt="no image"/></div>
                                        <div class="user-col">' . $row['fullName'] . '</div>
                                        <div class="email">' . $row["Email"] . '</div>
                                    </div>
                                    <div class="user-ctrl">
                                        <div class="user-btn"><a href="user-info.php?box=View&UserID=' . $row['UserID'] . '">view</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=InActive&UserID=' . $row['UserID'] . '">inActive</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=Delete&UserID=' . $row['UserID'] . '">delete</a></div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                    } else {
                        echo '<div class="alert alert-info">no accounts</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="panel">
                <p class="panel-title">leagues admins:
                </p>
                <div class="panel-content active">
                    <?php  // جلب حسابات مدراء الدوريات 
                    $result_LeagueManager = LeagueManager();
                    if (!empty($result_LeagueManager)) {
                        while ($row = mysqli_fetch_assoc($result_LeagueManager)) {
                            if ($row['accountStatus'] == 1) {

                                echo '
                                <div class="user-column">
                                    <div class="user-info">
                                        <div class="image"><img src="data:image/jpg;charset=utf8;base64,' . base64_encode($row['image']) . ' "/></div>
                                        <div class="user-col">' . $row['fullName'] . '</div>
                                        <div class="email">' . $row["Email"] . '</div>
                                    </div>
                                    <div class="user-ctrl">
                                        <div class="user-btn"><a href="user-info.php?box=View&UserID=' . $row['UserID'] . '">view</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=Active&UserID=' . $row['UserID'] . '">Active</a></div>
                                        <div class="user-btn"><a href="user-info.php?box=Delete&UserID=' . $row['UserID'] . '">delete</a></div>
                                    </div>
                                </div>
                                ';
                            } elseif ($row['accountStatus'] == 2) {
                                echo '
                                <div class="user-column">
                                    <div class="user-info">
                                        <div class="image"><img src="data:image/jpg;charset=utf8;base64,' . base64_encode($row['image']) . ' "/></div>
                                        <div class="user-col">' . $row['fullName'] . '</div>
                                        <div class="email">' . $row["Email"] . '</div>
                                    </div>
                                    <div class="user-ctrl">
                                        <div class="user-btn">
                                            <a href="user-info.php?box=View&UserID=' . $row['UserID'] . '">view</a>
                                        </div>
                                        <div class="user-btn">
                                            <a href="user-info.php?box=InActive&UserID=' . $row['UserID'] . '">inActive</a>
                                        </div>
                                        <div class="user-btn">
                                            <a href="user-info.php?box=Delete&UserID=' . $row['UserID'] . '">delete</a>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                    } else {
                        echo '<div class="alert alert-info">no accounts</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- body  -->

<?php
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
