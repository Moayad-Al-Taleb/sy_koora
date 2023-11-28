<?php
session_start();
ob_start();
include "../init.php";
include "league-functions.php";

if (empty($_SESSION["S_UserID"])) {
    echo "
    <div class='overlay'></div>
    <div class='handle-error-message'>ERROR CAN\'T ENTER DIRECTLY</div>
    ";
    header('REFRESH:2;URL=../index.php');
} else {
    if ($_SESSION["S_accountType"] = !3) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>You cannot access this page. This page is reserved for the site LeagueManager</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
        $seasonID = $_GET['seasonID'];
        $result = Select_scores($seasonID);
        $counter = 1;
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>seasons.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />
        <?php
        include "../" . $tpl . "league-nav.inc";
        ?>
        <div class="container">
            <div class="heading">
                <ion-icon name="list-outline" class="list-icon"></ion-icon>
            </div>
            <div class="main-title">
                <span class="heading-title">teams rating in 2021-2022 season:</span> <br>
            </div>
            <table class="table table-hover text-center ">
                <thead class="table-dark">
                    <th>#</th>
                    <th>team name</th>
                    <th>team score</th>
                    <th>team points</th>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr class="table-row">
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['teamScore']; ?></td>
                            <td><?php echo $row['teamPoints']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


<?php
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
