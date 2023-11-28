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
    if ($_SESSION["S_AccountType"] != 3) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>You cannot access this page. This page is reserved for the site LeagueManager</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else {
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>dashboard.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css" />

        <?php
        include "../" . $tpl . "league-nav.inc";
        $ID = $_SESSION["S_UserID"];
        $row = Select_leagues($ID, 'UserID');

        $box = isset($_GET['box']) ? $_GET['box'] : 'show';
        if ($box == 'show') {  ?>
            <div class="container">
                <div class="heading">
                    <ion-icon name="list-outline" class="list-icon"></ion-icon>
                    <a href="../logout.php" class="logout-btn">
                        <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                    </a>
                </div>
                <div class="main-title">
                    <span class="heading-title">manage league information:</span>
                </div>
                <div class="team-info">
                    <div class="header-logo">
                        <div class="left-logo">
                            <?php
                            echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['leagueImage']) . " ' width='10%'/>";
                            ?>
                            <h3 class="team-name"><?php echo $row['leagueName'] ?></h3>
                        </div>
                    </div>
                    <div class="main-info">
                        <div class="team-info">
                            <div class="column ">Organisers: <span><?php echo $row['Organisers'] ?></span></div>
                            <div class="column">date Created: <span><?php echo $row['dateCreated'] ?></span></div>
                            <div class="column with-shadow">Sports: <span><?php echo $row['Sports'] ?></span></div>
                            <div class="column with-shadow">Country: <span><?php echo $row['Country'] ?></span></div>
                            <div class="column">continent: <span><?php echo $row['continent'] ?></span></div>
                            <div class="column">Manager: <span><?php echo $row['Manager'] ?></span></div>
                            <div class="column with-shadow">number of participiting Teams : <span><?php echo $row['numberTeams'] ?></span></div>
                            <div class="column with-shadow">the winner team qualify For: <span><?php echo $row['qualifyFor'] ?></span></div>
                            <div class="column">drop: <span><?php echo $row['dropTO'] ?></span></div>
                            <div class="column">related Competitions: <span><?php echo $row['relatedCompetitions'] ?></span></div>
                            <div class="column with-shadow">glimpse: <span><?php echo $row['glimpse'] ?></span></div>
                        </div>
                    </div>
                    <div class="controls">
                        <a class="controlBtn" href="?box=edit">edit league information</a>
                        <a href="seasons.php" class="controlBtn">league seasons</a>
                    </div>
                </div>
            </div>
        <?php
        } elseif ($box == 'edit') { ?>
            <div class="container">
                <form action="?box=update&leagueID=<?php echo $row['leagueID']; ?>" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>edit league information</h2>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                Organisers:
                            </label>
                            <input class="input team-input" name="Organisers" type="text" value="<?php echo $row['Organisers'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                created date:
                            </label>
                            <input class="input team-input" name="dateCreated" type="date" value="<?php echo $row['dateCreated'] ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                country:
                            </label>
                            <input class="input team-input" name="Country" type="text" value="<?php echo $row['Country'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                sports:
                            </label>
                            <input class="input team-input" name="Sports" type="text" value="<?php echo $row['Sports'] ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                continent:
                            </label>
                            <input class="input team-input" name="continent" type="text" value="<?php echo $row['continent'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">league manager:</label>
                            <input class="input team-input" name="Manager" type="text" value="<?php echo $row['Manager'] ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                numbers of participiting teams:
                            </label>
                            <input class="input team-input" name="numberTeams" type="number" value="<?php echo $row['numberTeams'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                the winner team qualify for:
                            </label>
                            <input class="input team-input" name="qualifyFor" type="text" value="<?php echo $row['qualifyFor'] ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                the loser team drop to:
                            </label>
                            <input class="input team-input" name="dropTO" type="text" value="<?php echo $row['dropTO'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                league logo:
                            </label>
                            <input class="input-img" name="leagueImage" type="file">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                related competitions:
                            </label>
                            <input class="input team-input" name="relatedCompetitions" type="text" value="<?php echo $row['relatedCompetitions'] ?>">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                glimpse:
                            </label>
                            <textarea name="glimpse" class="input" id="" rows="3"><?php echo $row['glimpse'] ?></textarea>
                        </div>
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNaddLeague" type="submit" value="create">
                    </div>
                </form>
            </div>
<?php
        } elseif ($box == 'update') {
            if (
                !empty($_FILES["leagueImage"]["name"])
                && !empty($_POST['dateCreated'])
                && !empty($_POST['Country'])
                && !empty($_POST['numberTeams'])
                && !empty($_POST['qualifyFor'])
                && !empty($_POST['dropTO'])
                && !empty($_POST['relatedCompetitions'])
                && !empty($_POST['glimpse'])
            ) {

                $Organisers = $_POST['Organisers'];
                $dateCreated = $_POST['dateCreated'];
                $Sports = $_POST['Sports'];
                $Country = $_POST['Country'];
                $continent = $_POST['continent'];
                $Manager = $_POST['Manager'];
                $numberTeams = $_POST['numberTeams'];
                $qualifyFor = $_POST['qualifyFor'];
                $dropTO = $_POST['dropTO'];
                $relatedCompetitions = $_POST['relatedCompetitions'];
                $glimpse = $_POST['glimpse'];
                $leagueID = $_GET['leagueID'];

                $fileName = basename($_FILES["leagueImage"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['leagueImage']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                    Update_leagues($imgContent, $Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $leagueID);
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                    ";
                    header('REFRESH:2;URL=manage-league.php?box=edit');
                }
            } elseif (
                !empty($_POST['dateCreated'])
                && !empty($_POST['Country'])
                && !empty($_POST['numberTeams'])
                && !empty($_POST['qualifyFor'])
                && !empty($_POST['dropTO'])
                && !empty($_POST['relatedCompetitions'])
                && !empty($_POST['glimpse'])
            ) {
                $Organisers = $_POST['Organisers'];
                $dateCreated = $_POST['dateCreated'];
                $Sports = $_POST['Sports'];
                $Country = $_POST['Country'];
                $continent = $_POST['continent'];
                $Manager = $_POST['Manager'];
                $numberTeams = $_POST['numberTeams'];
                $qualifyFor = $_POST['qualifyFor'];
                $dropTO = $_POST['dropTO'];
                $relatedCompetitions = $_POST['relatedCompetitions'];
                $glimpse = $_POST['glimpse'];
                $leagueID = $_GET['leagueID'];

                Update_leagues_($Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $leagueID);
            } else {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>please fill in all fields.</div>
                ";
                header('REFRESH:2;URL=manage-league.php?box=edit');
            }
        }
        include "../" . $tpl . "footer.inc";
    }
}
ob_end_flush();
