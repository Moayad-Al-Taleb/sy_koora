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
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />

        <?php
        include "../" . $tpl . "team-nav.inc";

        $box = isset($_GET['box']) ? $_GET['box'] : 'show';

        if ($box == 'show') {
            $teamID = intval($_GET['teamID']);
            $teamAchievments = teamAchievements($teamID);
            $counter = 1;
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">team achievments:</span> <br>
                    <a class="btn btn-primary btn-hover" href="?box=add&teamID=<?php echo $teamID; ?>">add new one</a>
                </div>
                <?php
                if ($teamAchievments) { ?>
                    <table class="table  table-hover achievments">
                        <thead class="table-dark">
                            <tr>
                                <th class="col-2">#</th>
                                <th class="col-8">achievment</th>
                                <th class="col-2">cotrols</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($teamAchievments)) {
                                echo '
                                    <tr>
                                        <td>' . $counter . '</td>
                                        <td>' . $row['teamAchievement'] . '</td>
                                        <td>
                                        <a class="btn btn-primary" href="team-achievments.php?box=edit&teamAchievementID=' . $row['teamAchievementID'] . '">edit</a>
                                        <a class="btn btn-danger mt-1" href="team-achievments.php?box=delete&teamAchievementID=' . $row['teamAchievementID'] . '">delete</a>
                                        </td>
                                    </tr>
                                    ';
                                $counter++;
                            }
                            ?>
                        </tbody>
                    </table>

                <?php } else { ?>

                    <div class="container mt-2">
                        <div class="alert alert-info">
                            no records
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        <?php
        } elseif ($box == 'add') {

            $teamID = intval($_GET['teamID']);
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">add new achievment:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label class="label" for="">achievment:</label>
                        <input name="teamAchievement" type="text" class="input">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTN_addTeamAchievement" value="add" class="submit-btn">
                    </div>
                </form>
            </div>

            <?php
            if (isset($_POST['BTN_addTeamAchievement'])) {
                if (!empty($_POST['teamAchievement'])) {
                    $teamAchievement = $_POST['teamAchievement'];
                    $query = "INSERT INTO achievements (teamAchievement, teamID) VALUES ('$teamAchievement', '$teamID')";
                    if ($conn->query($query) === TRUE) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-success-message'>new achievment has been added successfully</div>
                        ";
                        header('REFRESH:2;URL=team-achievments.php?box=show&teamID=' . $teamID . '');
                    } else {
                        echo "Error: " . $query;
                    }
                } else {
                    echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>pleas fill in all fields</div>
                        ";
                    header('REFRESH:2;URL=team-achievments.php?box=add&teamID=' . $teamID . '');
                }
            }
        } elseif ($box == 'delete') {

            $teamAchievementID = intval($_GET['teamAchievementID']);

            $query2 = "SELECT * FROM achievements WHERE teamAchievementID = $teamAchievementID";

            $result = mysqli_query($conn, $query2);

            $row = mysqli_fetch_assoc($result);

            $teamID = $row['teamID'];

            $query = "DELETE FROM achievements WHERE teamAchievementID = '$teamAchievementID'";

            if ($conn->query($query) === TRUE) {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>achievment has been deleted successfully</div>
                ";
                header('REFRESH:2;URL=team-achievments.php?box=show&teamID=' . $teamID . '');
            } else {
                echo "Error: " . $query;
            }
        } elseif ($box == 'edit') {

            $teamAchievementID = intval($_GET['teamAchievementID']);
            $query_select = "SELECT * FROM achievements WHERE teamAchievementID = '$teamAchievementID'";
            $result = mysqli_query($conn, $query_select);
            $row_select = mysqli_fetch_assoc($result);
            $teamAchievement = $row_select['teamAchievement'];
            $teamID = $row_select['teamID'];
            ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">edit achievment:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label class="label" for="">achievment:</label>
                        <input name="teamAchievement" type="text" class="input" value="<?php echo $teamAchievement ?>">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTN_editTeamAchievement" value="edit" class="submit-btn">
                    </div>
                </form>
            </div>

        <?php
            if (isset($_POST['BTN_editTeamAchievement'])) {
                if (!empty($_POST['teamAchievement'])) {
                    $teamAchievement = $_POST['teamAchievement'];
                    $query = "UPDATE achievements SET teamAchievement = '$teamAchievement' WHERE teamAchievementID = '$teamAchievementID'";
                    if ($conn->query($query) === TRUE) {
                        echo "
                    <div class='overlay'></div>
                    <div class='handle-success-message'>new achievment has been updated successfully</div>
                    ";
                        header('REFRESH:2;URL=team-achievments.php?box=show&teamID=' . $teamID . '');
                    } else {
                        echo "Error: " . $query;
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>pleas fill in all fields</div>
                    ";
                    header('REFRESH:2;URL=team-achievments.php?box=add&teamID=' . $teamID . '');
                }
            }
        }

        ?>

<?php
        include '../' . $tpl . 'footer.inc';
    }
}
ob_end_flush();
?>