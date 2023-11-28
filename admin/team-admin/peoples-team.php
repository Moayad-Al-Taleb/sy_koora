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

        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-users.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />

        <?php
        include "../" . $tpl . "team-nav.inc";
        $box = isset($_GET['box']) ? $_GET['box'] : 'show';
        if ($box == 'show') {
            $accountType = intval($_GET['AT']);
            $teamID = Select_teamID($_SESSION["S_UserID"]);
            $result = Select_peoplesteam($accountType, $teamID);
            $count = mysqli_num_rows($result);
        ?>

            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">all accounts in this team:</span> <br>
                </div>
                <?php
                if ($accountType == 1) {
                    $accountTypeName = 'player';
                    $Person_specialty = 'position';
                    $personPic = 'picture';
                } elseif ($accountType == 2) {
                    $accountTypeName = 'administrator';
                    $Person_specialty = 'job';
                    $personPic = 'picture';
                } elseif ($accountType == 3) {
                    $accountTypeName = 'TM';
                    $Person_specialty = 'job';
                    $personPic = 'picture';
                }
                if ($accountType == 2 || $accountType == 3) {
                ?>
                    <table class="table table-hover text-center peoples-table">
                        <thead class="table-dark">
                            <th class="col-1">#</th>
                            <th class="col-1"><?php echo $personPic; ?></th>
                            <th class="col-4"><?php echo $accountTypeName ?> name</th>
                            <th class="col-4"><?php echo $Person_specialty; ?></th>
                            <th class="col-1">nationality</th>
                            <th class="col-1">controls</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($count > 0) {
                                $counter = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $counter++;
                                    echo "
                                        <tr align='center'>
                                            <td>" . $counter . "</td>
                                            <td> <img style='width: 80px; height: 80px; border-radius: 50%;' src='data:image/jpg;charset=utf8;base64," . base64_encode($row['Person_image']) . "'></td>
                                            <td>" . $row['Person_fullName'] . " </td>
                                            <td>" . $row['Person_specialty'] . " </td>
                                            <td>" . $row['Person_Nationality'] . " </td>
                                            <td>
                                                <a class='btn btn-delete' href='peoples-team.php?box=delete&personID=" . $row['PersonID'] . "'>
                                                    delete
                                                </a>
                                            </td>
                                        </tr>
                                        ";
                                }
                            } else {
                                echo '
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-info">no records</div> 
                                    </td>
                                </tr> ';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <table class="table table-hover text-center peoples-table">
                        <thead class="table-dark">
                            <th class="col-1">#</th>
                            <th class="col-1"><?php echo $personPic; ?></th>
                            <th class="col-4"><?php echo $accountTypeName ?> name</th>
                            <th class="col-3"><?php echo $Person_specialty; ?></th>
                            <th class="col-1">nationality</th>
                            <th class="col-1">number</th>
                            <th class="col-1">controls</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($count > 0) {
                                $counter = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $counter++;
                                    echo "
                                        <tr align='center'>
                                            <td>" . $counter . "</td>
                                            <td> <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['Person_image']) . "' style='width: 100px; height: 100px; border-radius: 50%;'></td>
                                            <td>" . $row['Person_fullName'] . " </td>
                                            <td>" . $row['Person_specialty'] . " </td>
                                            <td>" . $row['Person_Nationality'] . " </td>
                                            <td>" . $row['Person_number'] . " </td>
                                            <td>
                                                <a class='btn btn-delete' href='peoples-team.php?box=delete&personID=" . $row['PersonID'] . "'>
                                                    delete
                                                </a>
                                            </td>
                                        </tr>
                                        ";
                                }
                            } else {
                                echo '
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-info">no records</div> 
                                    </td>
                                </tr> ';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>

            </div>

        <?php
        }
        if ($box == 'add') { ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title"> add new person:</span> <br>
                </div>
                <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>add information</h2>
                    <div class="input-field">
                        <label class="label" for="">
                            full name:
                        </label>
                        <input class="input team-input" name="Person_fullName" type="text" placeholder="person name">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            Person's specialty:
                        </label>
                        <input class="input team-input" name="Person_specialty" type="text" placeholder="person speciality">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            Person's nationality:
                        </label>
                        <input class="input team-input" name="Person_nationality" type="text" placeholder="person nationality">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            player's number:
                        </label>
                        <input class="input team-input" name="player_number" type="text" placeholder="if person is a player please type his number">
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            Type:
                        </label>
                        <select name="Type" class="input">
                            <option value="1">player</option>
                            <option value="2">administrator</option>
                            <option value="3">trainer</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label class="label" for="">
                            person picture:
                        </label>
                        <input class="input-img" name="person_pic" type="file" required>
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNAddPeople" type="submit" value="create">
                    </div>
                </form>
            </div>
<?php
            if (isset($_POST['BTNAddPeople'])) {
                $teamID = Select_teamID($_SESSION["S_UserID"]);
                if (
                    !empty($_POST['Person_fullName'])
                    && !empty($_POST['Person_specialty'])
                    && !empty($_POST['Person_nationality'])
                    && !empty($_POST['Type'])
                    && !empty($_FILES['person_pic']['name'])
                ) {
                    $Person_fullName = $_POST['Person_fullName'];
                    $Type = $_POST['Type'];
                    $Person_nationality = $_POST['Person_nationality'];
                    $player_number = $_POST['player_number'];
                    $Person_specialty = $_POST['Person_specialty'];
                    $fileName = basename($_FILES["person_pic"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['person_pic']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));
                        addPeople($teamID, $Person_fullName, $Person_specialty, $Person_nationality, $player_number, $Type, $imgContent);
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                        ";
                        header('REFRESH:2;URL=peoples-team.php?box=add');
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>please fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=peoples-team.php?box=add');
                }
            }
        } elseif ($box == 'delete') {
            $personID = intval($_GET['personID']);
            $type = Select_Type($personID);
            $query = "DELETE FROM peoplesteam WHERE personID = $personID";
            if ($conn->query($query) == true) {
                echo "
                <div class='overlay'></div>
                <div class='handle-success-message'>recored deleted successfully</div>
                ";
                header('REFRESH:2;URL=manage-users.php');
            }
        }
    }
    include "../" . $tpl . "footer.inc";
}
ob_end_flush();
