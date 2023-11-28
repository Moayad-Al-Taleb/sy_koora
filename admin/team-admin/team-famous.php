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
            $teamfamous = namesfrom($teamID);
        ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">famous players in the team:</span> <br>
                    <a class="btn btn-primary btn-hover" href="team-famous.php?box=add&teamID=<?php echo $teamID; ?>">add new player</a>
                </div>
                <?php
                if ($teamfamous) { ?>
                    <table class="table table-striped table-hover achievments">
                        <thead class="table-dark">
                            <tr>
                                <th class="col-2">#</th>
                                <th class="col-7">player name</th>
                                <th class="col-2">controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($teamfamous)) {
                                $counter = 1;
                                echo '
                            <tr>
                                <td>' . $counter . '</td>
                                <td>' . $row['playerName'] . '</td>
                                <td>
                                <a class="btn btn-primary" href="team-famous.php?box=edit&playerID=' . $row['playerID'] . '">edit</a>
                                <a class="btn btn-danger mt-1" href="team-famous.php?box=delete&playerID=' . $row['playerID'] . '">delete</a>
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
        } elseif ($box == 'delete') {
            $playerID = intval($_GET['playerID']);

            $query2 = "SELECT * FROM namesfrom WHERE playerID = $playerID";

            $result = mysqli_query($conn, $query2);

            $row = mysqli_fetch_assoc($result);

            $teamID = $row['teamID'];

            $query = "DELETE FROM namesfrom WHERE playerID = '$playerID'";

            if ($conn->query($query) === TRUE) {

                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>famous recored has been deleted successfully</div>
                ";
                header('REFRESH:2;URL=team-famous.php?teamID=' . $teamID . '');
            } else {

                echo "Error: " . $query;
            }
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
                    <span class="heading-title">add new famous player:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label class="label" for="">player name:</label>
                        <input name="playerName" type="text" class="input">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTN_addNameFrom" value="add" class="submit-btn">
                    </div>
                </form>
            </div>

            <?php
            if (isset($_POST['BTN_addNameFrom'])) {
                if (!empty($_POST['playerName'])) {
                    $playerName = $_POST['playerName'];
                    include('../connect.php');
                    $query = "INSERT INTO namesfrom (playerName, teamID) VALUES ('$playerName', '$teamID')";
                    if ($conn->query($query) === TRUE) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-success-message'>new famous recored has been added successfully</div>
                        ";
                        header('REFRESH:2;URL=team-famous.php?teamID=' . $teamID . '');
                    } else {
                        echo "Error: " . $query;
                    }
                } else {
                    echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>please fill in all fields</div>
                        ";
                    header('REFRESH:2;URL=team-famous.php?box=add&teamID=' . $teamID . '');
                }
            }
        } elseif ($box == 'edit') {
            $playerID = intval($_GET['playerID']);

            $query_select = "SELECT * FROM namesfrom WHERE playerID = '$playerID'";
            $result = mysqli_query($conn, $query_select);
            $row_select = mysqli_fetch_assoc($result);
            $playerName = $row_select['playerName'];
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
                    <span class="heading-title">edit famous player:</span> <br>
                </div>
                <form action="" method="POST" class="team-form">
                    <div class="input-field">
                        <label class="label" for="">player name:</label>
                        <input name="playerName" type="text" class="input" value="<?php echo $playerName ?>">
                    </div>
                    <div class="input-field">
                        <input type="submit" name="BTN_editNameFrom" value="add" class="submit-btn">
                    </div>
                </form>
            </div>

<?php
            if (isset($_POST['BTN_editNameFrom'])) {
                if (!empty($_POST['playerName'])) {
                    $playerName = $_POST['playerName'];
                    include('../connect.php');
                    $query = "UPDATE namesfrom SET playerName = '$playerName' WHERE playerID = '$playerID'";
                    if ($conn->query($query) === TRUE) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-success-message'>new famous recored has been updated successfully</div>
                        ";
                        header('REFRESH:2;URL=team-famous.php?teamID=' . $teamID . '');
                    } else {
                        echo "Error: " . $query;
                    }
                } else {
                    echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>please fill in all fields</div>
                        ";
                    header('REFRESH:2;URL=team-famous.php?box=add&teamID=' . $teamID . '');
                }
            }
        }
    }
    include '../' . $tpl . 'footer.inc';
}
ob_end_flush();
?>