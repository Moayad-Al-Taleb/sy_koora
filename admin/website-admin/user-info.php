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
        <link rel="stylesheet" href="../<?php echo $css; ?>user-info.css">
        <?php
        include "../" . $tpl . "web-nav.inc";

        if (isset($_GET['box'])) {
            if ($_GET['box'] == 'View') {
                $UserID = intval($_GET['UserID']);
                $result = viewUserById($UserID);
                while ($row = mysqli_fetch_assoc($result)) {
                    $fullName = $row["fullName"];
                    $email = $row["Email"];
                    $accountStatus = $row["accountStatus"];
                    $accountType = $row["accountType"];

                    if ($row["accountStatus"] == 1) {
                        $accountStatus = "Inactive";
                    } elseif ($row["accountStatus"] == 2) {
                        $accountStatus = "Active";
                    }

                    if ($row["accountType"] == 2) {
                        $accountType = "TeamManager";
                    } elseif ($row["accountType"] == 3) {
                        $accountType = "LeagueManager";
                    }
                    $image = base64_encode($row['image']);
                }
        ?>

                <div class="container">
                    <div class="heading">
                        <ion-icon name="list-outline" class="list-icon"></ion-icon>
                        <a href="../logout.php" class="logout-btn">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                        </a>
                    </div>
                    <div class="main-title">
                        <span><?php echo $fullName; ?> profile:</span>
                    </div>
                    <div class="user-info">
                        <div class="user-image">
                            <?php
                            echo "<img class='user-img' src='data:image/jpg;charset=utf8;base64," . $image . " ' width='100%'/>";
                            ?>
                        </div>
                        <div class="user-content">
                            <div class="user-info-col">
                                <span>full name:</span>
                                <?php echo  $fullName ?>
                            </div>
                            <div class="user-info-col">
                                <span>email:</span>
                                <?php echo  $email ?>
                            </div>
                            <div class="user-info-col">
                                <span>account status:</span>
                                <?php echo  $accountStatus ?>
                            </div>
                            <div class="user-info-col">
                                <span>account type:</span>
                                <?php echo  $accountType ?>
                            </div>
                        </div>
                    </div>
                </div>

<?php
            } elseif ($_GET['box'] == 'Active') {
                include('../connect.php');
                $UserID = intval($_GET['UserID']);
                $query = "UPDATE user SET accountStatus = '2' WHERE UserID='$UserID'";

                if ($conn->query($query) === TRUE) {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-success-message'>account activited successfully</div>
                    ";
                    header('REFRESH:1;URL=manage-users.php');
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } elseif ($_GET['box'] == 'InActive') {
                include('../connect.php');
                $UserID = intval($_GET['UserID']);
                $query = "UPDATE user SET accountStatus = '1' WHERE UserID='$UserID'";

                if ($conn->query($query) === TRUE) {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-success-message'>account disabled successfully</div>
                    ";
                    header('REFRESH:1;URL=manage-users.php');
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } elseif ($_GET['box'] == 'Delete') {
                include('../connect.php');
                $UserID = intval($_GET['UserID']);
                $query = "DELETE FROM user WHERE UserID='$UserID'";

                if ($conn->query($query) === TRUE) {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-success-message'>account deleted successfully</div>
                    ";
                    header('REFRESH:1;URL=manage-users.php');
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>you can't delete this account cuz it has a data</div>
                    ";
                    header('REFRESH:2;URL=manage-users.php');
                }
            }
        }

        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
