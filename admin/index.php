<?php
session_start();
ob_start();
include "init.php";

if (isset($_POST['BTNLOG'])) {

    if (empty($_POST["Email"]) || empty($_POST["Password"])) {
        echo "<div class='container text-center'><div class='alert alert-danger'>the fields must be entered</div></div>";
    } else {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $hashedPass = sha1($Password);
        $query = "SELECT * FROM user WHERE Email='$Email' AND Password='$hashedPass'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
            while ($row = mysqli_fetch_array($result)) {
                $_SESSION["S_UserID"] = $row['UserID'];
                $_SESSION["S_fullName"] = $row['fullName'];
                $_SESSION["S_Email"] = $row['Email'];
                $_SESSION["S_Password"] = $row['Password'];
                $_SESSION["S_AccountType"] = $row['accountType'];
                $_SESSION["S_accountStatus"] = $row['accountStatus'];
            }
            header('REFRESH:0;URL=check.php');
            exit();
        } else {
            echo "<div class='container text-center'><div class='alert alert-danger'> Please check the data there is an error</div></div>";
        }
    }
}

?>
<!-- main css file link  -->
<link rel="stylesheet" href="<?php echo $css; ?>main.css" />
<link rel="stylesheet" href="<?php echo $css; ?>forms.css">
</head>

<body style="height: 100vh;">
    <div class="login-form">
        <h2>login page</h2>
        <form action="" method="POST">
            <div class="input-field">
                <label for="" class="label">
                    email:
                </label>
                <input type="text" name="Email" class="input" placeholder="enter your name" autocomplete="off">
            </div>
            <div class="input-field">
                <label for="" class="label">
                    password:
                </label>
                <input type="password" name="Password" class="input" placeholder="enter your password" autocomplete="new-password">
            </div>
            <div class="submit-field">
                <input type="submit" name="BTNLOG" class="submit-btn">
            </div>

        </form>
    </div>

    <?php
    include $tpl . "footer.inc";
    ob_end_flush();
    ?>