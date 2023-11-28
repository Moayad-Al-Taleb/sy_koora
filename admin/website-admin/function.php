<?php
//جلب عدد الحسابات ضمن جدول معين نمرره حسب البارامتر
function counts($select, $from)
{
    include('../connect.php');
    $query = "SELECT $select FROM $from";
    $result = mysqli_query($conn, $query);
    $usersCount = mysqli_num_rows($result);
    if($from == "user") {
        return ($usersCount - 1);
    } else {
        return ($usersCount);
    }
}
//تقوم بجلب بيانات مدراء الفرق
function TeamManager()
{
    include('../connect.php');
    $query = "SELECT * FROM user WHERE accountType = 2";
    $result_TeamManager = mysqli_query($conn, $query);
    if (mysqli_num_rows($result_TeamManager) > 0) {
        return $result_TeamManager;
    }
}
//نقوم بجلب بيانات مدراء الدوريات
function LeagueManager()
{
    include('../connect.php');
    $query = "SELECT * FROM user WHERE accountType = 3";
    $result_LeagueManager = mysqli_query($conn, $query);
    if (mysqli_num_rows($result_LeagueManager) > 0) {
        return $result_LeagueManager;
    }
}

//تقوم بجلب بيانات فريق معين نمرره عبر البارامتر
function SelectTeamData($teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE teamID = '$teamID' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}
function selectLeagueData($leagueID)
{
    include('../connect.php');
    $query = "SELECT UserID FROM leagues WHERE leagueID = '$leagueID' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}
//جلب بيانات المستخدم عبر رقم مستخدم محدد
function viewUserById($UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM user WHERE UserID = '$UserID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
//جلب جميع بيانات الفرق في الموقع
function TeamData()
{
    include('../connect.php');
    $query = "SELECT * FROM team";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    } 
}
function LeaguesData()
{
    include('../connect.php');
    $query = "SELECT * FROM leagues";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    } 
}
function ActivePublications($userID)
{
    include('../connect.php');
    $query = "SELECT publications.PublishedID, publications.UserID, publications.postTitle, publications.postDetails, publications.photoPost, publications.postData, publications.publicationStatus, user.fullName FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE publications.UserID = '$userID'  AND publicationStatus = 2 ORDER BY publications.publicationStatus ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function InActivePublications($ID)
{
    include('../connect.php');
    $query = "SELECT publications.PublishedID, publications.UserID, publications.postTitle, publications.postDetails, publications.photoPost, publications.postData, publications.publicationStatus, user.fullName FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE publications.UserID = '$ID' AND publicationStatus = 1 ORDER BY publications.publicationStatus ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
// جلب بيانات منشور محدد عبر رقم المنشور 
function viewPost_ID($PublishedID)
{
    include('../connect.php');
    $query = "SELECT * FROM publications WHERE PublishedID = '$PublishedID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function Check($Email)
{
    include('../connect.php');
    $query = "SELECT * FROM user WHERE Email = '$Email'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    return $count;
}
function addUser($fullName, $Email, $Password, $accountStatus, $accountType, $image)
{
    include('../connect.php');
    $query = "INSERT INTO user(fullName, Email, Password, accountStatus, accountType, image) 
    VALUES ('$fullName', '$Email', '$Password', '$accountStatus', '$accountType', '$image')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>account created successfully</div>
        ";
        header('REFRESH:2;URL=manage-users.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
function Selectleague($leagueID)
{
    include('../connect.php');
    $query = "SELECT * FROM leagues WHERE leagueID = '$leagueID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
?>