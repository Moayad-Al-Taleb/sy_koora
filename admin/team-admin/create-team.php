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
        if (isset($_POST['addTeam'])) {
            if (
                !empty($_POST['fullName'])
                && !empty($_POST['nickName'])
                && !empty($_POST['foundedYear'])
                && !empty($_POST['stadium'])
                && !empty($_POST['country'])
                && !empty($_POST['president'])
                && !empty($_POST['coach'])
                && !empty($_FILES["teamKit"]["name"])
                && !empty($_FILES["logo"]["name"])
            ) {
                $UserID = $_SESSION['S_UserID'];

                $count = checkTeam($UserID);
                if ($count > 0) {
                    echo 'You cannot create a team';
                    header('REFRESH:2;URL=team-dashboard.php');
                } else {
                    $fullName = $_POST['fullName'];
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

                        $count = checkTeam_fullName($fullName);
                        if ($count > 0) {
                            echo "
                            <div class='overlay'></div>
                            <div class='handle-error-message'>sorry, this team name is already exists!</div>
                            ";
                            header('REFRESH:2;URL=create-team.php');
                        } else {
                            addTeam($UserID, $fullName, $nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $imgContent2);
                        }
                    } else {
                        echo "
                        <div class='overlay'></div>
                        <div class='handle-error-message'>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
                        ";
                        header('REFRESH:2;URL=create-team.php');
                    }
                }
            } else {
                echo "
                <div class='overlay'></div>
                <div class='handle-error-message'>Please fill in all fields.</div>
                ";
                header('REFRESH:2;URL=create-team.php');
            }
        }
?>
        <link rel="stylesheet" href="../<?php echo $css; ?>main.css" />
        <link rel="stylesheet" href="../<?php echo $css; ?>forms.css">
        </head>

        <body>
            <div class="container">
                <form action="" method="POST" class="team-form" enctype="multipart/form-data">
                    <h2>create new team</h2>
                    <div class="input-field">
                        <label class="label" for="">
                            team full name:
                        </label>
                        <input class="input team-input" name="fullName" type="text" placeholder="please follow the conditions">
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                team nickname:
                            </label>
                            <input class="input team-input" name="nickName" type="text" placeholder="please follow the conditions">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                staduim name:
                            </label>
                            <input class="input team-input" name="stadium" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                country:
                            </label>
                            <input class="input team-input" name="country" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">
                                The team leader name:
                            </label>
                            <input class="input team-input" name="president" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <div class="input-field">
                            <label class="label" for="">
                                The team coach name:
                            </label>
                            <input class="input team-input" name="coach" type="text">
                        </div>
                        <div class="input-field">
                            <label class="label" for="">Founded year:</label>
                            <input class="input team-input" name="foundedYear" type="date">
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
                        <input class="submit-btn" name="addTeam" type="submit" value="create">
                    </div>
                </form>
            </div>

        </body>

        </html>
<?php
    }
}
ob_end_flush();
?>