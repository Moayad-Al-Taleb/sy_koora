<?php 
ob_start();
session_start();
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
        <link rel="stylesheet" href="../<?php echo $css; ?>main.css" />
        <link rel="stylesheet" href="../<?php echo $css;?>forms.css">
        </head>
        <body>
            <div class="container">
                <form action="" method="POST"  class="team-form" enctype="multipart/form-data">
                    <h2>create new league</h2>
                    <div class="input-field">
                        <label class="label" for="">
                            league full name:
                        </label>
                        <input class="input team-input" name="leagueName" type="text" placeholder="please follow the conditions">
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                Organisers:
                            </label>
                            <input class="input team-input" name="Organisers" type="text" placeholder="please follow the conditions">
                        </div>
                        <div class="input-field">
                        <label class="label" for="">
                                created date:
                            </label>
                            <input class="input team-input" name="dateCreated" type="date">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                country:
                            </label>
                            <input class="input team-input" name="Country" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                sports:
                            </label>
                            <input class="input team-input"  name="Sports" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                continent:
                            </label>
                            <input class="input team-input" name="continent" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">league manager:</label>
                            <input class="input team-input"  name="Manager" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                            numbers of participiting teams:
                            </label>
                            <input class="input team-input" name="numberTeams" type="number">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                            the winner team qualify for:
                            </label>
                            <input class="input team-input"  name="qualifyFor" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                            the loser team drop to:
                            </label>
                            <input class="input team-input"  name="dropTO" type="text">
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
                            <input class="input team-input"  name="relatedCompetitions" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                            glimpse:
                            </label>
                            <textarea name="glimpse" class="input" id="" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="input-field">
                        <input class="submit-btn" name="BTNaddLeague" type="submit" value="create">
                    </div>
                </form>
            </div>
            
        </body>
        </html>
        <?php 
        if (isset($_POST['BTNaddLeague'])) {
            if (
                !empty($_POST['leagueName'])
                && !empty($_FILES["leagueImage"]["name"])
                && !empty($_POST['dateCreated'])
                && !empty($_POST['Country'])
                && !empty($_POST['numberTeams'])
                && !empty($_POST['qualifyFor'])
                && !empty($_POST['dropTO'])
                && !empty($_POST['relatedCompetitions'])
                && !empty($_POST['glimpse'])
            ) {
                $leagueName = $_POST['leagueName'];
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
                $UserID = $_SESSION["S_UserID"];
                $fileName = basename($_FILES["leagueImage"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['leagueImage']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
        
                    $count = Check_leagueName($leagueName);
                    if ($count > 0) {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'> sorry, this league name is already exists!</div>
                        ";
                        header("REFRESH:2;URL=create-league.php");
                    } else {
                        Insert_leagues($leagueName, $imgContent, $Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $UserID);
                    }
                } else {
                    echo "
                    <div class='overlay'></div>
                    <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload</div>
                    ";
                    header("REFRESH:2;URL=create-league.php");
                }
            } else {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>please fill in all fields</div>
                ";
                header("REFRESH:2;URL=create-league.php");
            }
        }
    }
}
ob_end_flush();