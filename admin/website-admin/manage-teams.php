<?php
session_start();
ob_start();
include "../init.php";
include "function.php";
//! للتأكد بأن المستخدم سجل دخوله 
if (empty($_SESSION["S_UserID"])) {
    echo "
    <div class='overlay'></div>
    <div class='handle-error-message'>ERROR CAN\'T ENTER DIRECTLY</div>
    ";
    header('REFRESH:2;URL=../index.php');
} else {
    //! للتحقق من هوية المستخدم اذا كان يحق له الوصول أم لأ من خلال نوع حسابه
    if ($_SESSION["S_AccountType"] != 1) {
        echo "
        <div class='overlay'></div>
        <div class='handle-error-message'>'You cannot access this page. This page is reserved for the site administrator</div>
        ";
        header('REFRESH:2;URL=../index.php');
    } else { ?>

        <link rel="stylesheet" href="../<?php echo $css; ?>posts.css">
        <link rel="stylesheet" href="../<?php echo $css; ?>manage-team.css">
        <!-- navbar include  -->
        <?php
        include "../" . $tpl . "web-nav.inc";
        //جلب بيانات كل الفرق الموجودة في الموقع
        $result = TeamData();
        //لتخزين ال بوكس في متحول 
        $box = isset($_GET['box']) ? $_GET['box'] : 'show';

        if ($box == 'show') {
            if (!empty($result)) {
        ?>
                <div class="container">
                    <div class="heading">
                        <ion-icon name="list-outline" class="list-icon"></ion-icon>
                        <a href="../logout.php" class="logout-btn">
                            <ion-icon class="icons" name="log-out-outline"></ion-icon>logout
                        </a>
                    </div>
                    <div class="main-title">
                        <span>all teams in the website</span>
                    </div>
                    <div class="cards-container">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="v-card">
                                <a href="manage-teams.php?box=view-team&teamID=<?php echo $row['teamID']; ?>">
                                    <div class="image">
                                        <?php
                                        echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['logo']) . "'/>";
                                        ?>
                                    </div>
                                    <div class="card-content">
                                        <p class=""><?php echo $row['fullName']; ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            } else { ?>
                <div class="alert alert-info">
                    there is no teams to show
                </div>
            <?php
            }
        } elseif ($box == 'view-team') {
            $teamData = SelectTeamData($_GET['teamID']);
            if (mysqli_num_rows($teamData) > 0) {
                $row = mysqli_fetch_assoc($teamData);
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
                    <span class="heading-title">team information:</span>
                </div>
                <div class="team-info">
                    <div class="header-logo">
                        <div class="left-logo">
                            <?php
                            echo "
                                <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['logo']) . " ' width='10%'/>
                                ";
                            ?>
                            <h3 class="team-name"><?php echo $row['fullName']; ?></h3>
                        </div>
                        <div class="right-logo">
                            <?php
                            echo "
                                <img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['teamKit']) . " ' width='20%' border='1'/>
                                ";
                            ?>
                        </div>
                    </div>
                    <div class="main-info">
                        <div class="team-info">
                            <div class="column with-shadow">
                                Team Nickname:
                                <span><?php echo $row['nickName']; ?></span>
                            </div>
                            <div class="column with-shadow">
                                Staduim Name:
                                <span><?php echo $row['stadium']; ?></span>
                            </div>
                            <div class="column">
                                team Country:
                                <span><?php echo $row['country']; ?></span>
                            </div>
                            <div class="column">
                                The Team Leader Name:
                                <span><?php echo $row['president']; ?></span>
                            </div>
                            <div class="column with-shadow">
                                The Team Coach Name:
                                <span><?php echo $row['coach']; ?></span>
                            </div>
                            <div class="column with-shadow">
                                Founded Year:
                                <span><?php echo $row['foundedYear']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php
        }
    }
    include "../" . $tpl . "footer.inc";
}
ob_end_flush();
