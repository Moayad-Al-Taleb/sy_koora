<?php
function checkUserLeague($userID)
{
    include('connect.php');
    $query = "SELECT * FROM leagues WHERE UserID = $userID";
    $result_TeamManager = mysqli_query($conn, $query);
    return mysqli_num_rows($result_TeamManager);
}
// تحقق هل أسم الدوري قد تم أنشاءه مسبقا
function Check_leagueName($leagueName)
{
    include('../connect.php');
    $query = "SELECT * FROM leagues WHERE leagueName = '$leagueName'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}
// لأضافة بيانات دوري
function Insert_leagues($leagueName, $imgContent, $Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $UserID)
{
    include('../connect.php');
    $query = "INSERT INTO leagues (leagueName, leagueImage, Organisers, dateCreated, Sports, Country, continent, Manager, numberTeams, qualifyFor, dropTO, relatedCompetitions, glimpse, UserID) VALUES ('$leagueName', '$imgContent', '$Organisers', '$dateCreated', '$Sports', '$Country', '$continent', '$Manager', '$numberTeams', '$qualifyFor', '$dropTO', '$relatedCompetitions', '$glimpse', '$UserID')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>recored added successfully</div>
        ";
        header('REFRESH:2;URL=manage-league.php');
    } else {
        echo $conn->error;
    }
}
// dashboard Screen
// جلب بيانات الدوري وأعادتها على شكل مصفوفة
// نقوم بأرسال ال المعرف ثم نقوم بتعريف أذا كان معرف مستخدم أو معرف دوري 
function Select_leagues($ID, $WHERE)
{
    // UserID OR leagueID 
    if ($WHERE == 'UserID') {
        include('../connect.php');
        $query = "SELECT * FROM leagues WHERE UserID = '$ID'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    } elseif ($WHERE == 'leagueID') {
        include('../connect.php');
        $query = "SELECT * FROM leagues WHERE leagueID = '$ID'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}
// تابع لتعديل بيانات الدوري مع أمكانية أرفاق صورة
function Update_leagues($imgContent, $Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $leagueID)
{
    include('../connect.php');
    $query = "UPDATE leagues SET leagueImage = '$imgContent', Organisers = '$Organisers', dateCreated = '$dateCreated', Sports = '$Sports', Country = '$Country', continent = '$continent', Manager = '$Manager', numberTeams = '$numberTeams', qualifyFor = '$qualifyFor', dropTO = '$dropTO', relatedCompetitions = '$relatedCompetitions',glimpse = '$glimpse' WHERE leagueID = '$leagueID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>the league info updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-league.php');
    } else {
        echo $conn->error;
    }
}
// تابع لتعديل بيانات الدوري مع أمكانية عدم أرفاق صورة
function Update_leagues_($Organisers, $dateCreated, $Sports, $Country, $continent, $Manager, $numberTeams, $qualifyFor, $dropTO, $relatedCompetitions, $glimpse, $leagueID)
{
    include('../connect.php');
    $query = "UPDATE leagues SET Organisers = '$Organisers', dateCreated = '$dateCreated', Sports = '$Sports', Country = '$Country', continent = '$continent', Manager = '$Manager', numberTeams = '$numberTeams', qualifyFor = '$qualifyFor', dropTO = '$dropTO', relatedCompetitions = '$relatedCompetitions',glimpse = '$glimpse' WHERE leagueID = '$leagueID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>the league info updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-league.php');
    } else {
        echo $conn->error;
    }
}
// end dashboard Screen
// ____________________________________________________________________________________________________
// seasons_screen
// لجلب معرف دوري للمستخدم الذي قام بتسجيل الدخول وتجنب نقل المعرف عن طريق ال GIT
function leagueID($UserID)
{
    include('../connect.php');
    $query = "SELECT leagueID FROM leagues WHERE UserID = '$UserID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['leagueID'];
}
// جلب بيانات المواسم تابعة لدوري ما
// ويستخدم لجلب بيانات موسم تبعا لمعرف الموسم الخاص به 
function Select_seasons($ID, $WHERE)
{
    // leagueID OR seasonID 
    if ($WHERE == 'leagueID') {
        include('../connect.php');
        $query = "SELECT * FROM seasons WHERE leagueID = '$ID'";
        $result = mysqli_query($conn, $query);
        return $result;
    } elseif ($WHERE == 'seasonID') {
        include('../connect.php');
        $query = "SELECT * FROM seasons WHERE seasonID = '$ID'";
        $result = mysqli_query($conn, $query);
        return $result;
    }
}
// يقوم هذا التابع بأنشاء موسم تابع لدوري ما
// ملاحظة! يجب علينا أن نقوم بأستعلام بقوم بجلب الفريق الأكثر تتويج والفريق الذي كان متصدري في أخر موسم أو الموسم الحالي 
function Insert_seasons($leagueID, $currentSeason_date)
{
    include('../connect.php');
    $query = "INSERT INTO seasons (leagueID, currentSeason_date) VALUES('$leagueID', '$currentSeason_date')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>season has been inserted successfully</div>
        ";
        header('REFRESH:2;URL=seasons.php');
    } else {
        echo $conn->error;
    }
}
// للتحقق هل تم أدخال الفرق المشاركة أم لاء، يحق للجلسة تضمين فرق مرة واحدة
function Check_seasonID($seasonID)
{
    include('../connect.php');
    $query = "SELECT * FROM participatingteams WHERE seasonID = '$seasonID'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

// لقد قمنا بعملية جلب لبيانات الفريق للأستفادة من معرف الفريق اسم الفريق وشعار الفريق وعرضها لمدير دوري من أجل أنشاء موسم لدوري
function Select_All_Team()
{
    include('../connect.php');
    $query = "SELECT * FROM team";
    $result = mysqli_query($conn, $query);
    return $result;
}
// لقد قمنا بجلب عدد الفرق المشاركة في الدوري حتى نقوم بأختبار أن عدد الفرق المشاركة في الموسم مساوي لعدد الفرق المدخل في البيانات
function Select_numberTeams($UserID)
{
    include('../connect.php');
    $query = "SELECT numberTeams FROM leagues WHERE UserID = $UserID";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['numberTeams'];
}
// لعرض جميع الفرق المشاركة في الموسم
function Select_participatingteams($seasonID)
{
    include('../connect.php');
    $query = "SELECT participatingteams.ParticipatingteamID, participatingteams.teamID, participatingteams.seasonID,
    team.fullName, team.logo
    FROM participatingteams INNER JOIN team ON participatingteams.teamID = team.teamID WHERE seasonID = '$seasonID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// لأضافة معرف فريق لموسم تابع لدوري
function Insert_participatingteams($teamID, $seasonID)
{
    include('../connect.php');
    $query = "INSERT INTO participatingteams (teamID, seasonID) VALUES ('$teamID', '$seasonID')";
    if ($conn->query($query) === TRUE) {
    } else {
        echo $conn->error;
    }
}

// لأضافة تفاصيل مباراة تحديد الفرق التي سوف تتواجه وتفاصيل المباراة (مكان - زمان)
function Insert_matches($seasonID, $teamID1, $teamID2, $matchAddress, $staduimName, $matchDate, $matchTime, $matchesType)
{
    include('../connect.php');
    $query = "INSERT INTO matches (seasonID, teamID1, teamID2, matchAddress, staduimName, matchDate, matchTime, matchesType) VALUES ('$seasonID', '$teamID1', '$teamID2', '$matchAddress', '$staduimName', '$matchDate', '$matchTime', '$matchesType')";
    if ($conn->query($query) === TRUE) {
        echo '✔';
        if ($matchesType == 1) {
            echo "
            <div class='overlay'></div>
            <div class='handle-success-message'>match has been added successfully</div>
            ";
            header('REFRESH:2;URL=?box=matches_1&seasonID=' . $seasonID);
        } else {
            echo "
            <div class='overlay'></div>
            <div class='handle-success-message'>match has been added successfully</div>
            ";
            header('REFRESH:2;URL=?box=matches_2&seasonID=' . $seasonID);
        }
    } else {
        echo $conn->error;
    }
}

// عرض تفاصيل المباريات 
function Selct_matches($seasonID, $matchesType)
{
    include('../connect.php');
    $query = "SELECT * FROM matches WHERE seasonID = '$seasonID' AND matchesType = '$matchesType'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// يقوم بجلب تفاصيل الفريق المعرف - الاسم - الشعار
function Selct_teamID($teamID)
{
    include('../connect.php');
    $query = "SELECT teamID, logo, fullName FROM team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// يجلب عدد تكرار معرف الفريق1 في الجدول 
function Select_teamID1($teamID1, $seasonID, $matchesType)
{
    include('../connect.php');
    $query = "SELECT teamID1 FROM matches WHERE seasonID = '$seasonID' AND teamID1 = '$teamID1' AND matchesType = '$matchesType'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
};
// يجلب عدد تكرار معرف الفريق2 في الجدول 
function Select_teamID2($teamID2, $seasonID, $matchesType)
{
    include('../connect.php');
    $query = "SELECT teamID2 FROM matches WHERE seasonID = '$seasonID' AND teamID2 = '$teamID2' AND matchesType = '$matchesType'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
};
// يجلب لنا هل الفريقين قامو بمواجهة بعض أم لاء
function Select_teamID1ANDteamID2($teamID1, $teamID2, $seasonID, $matchesType)
{
    include('../connect.php');
    $query = "SELECT teamID1, teamID2 FROM matches WHERE seasonID = '$seasonID' AND teamID1 = '$teamID1' AND  teamID2 = '$teamID2' AND matchesType = '$matchesType'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
};
// يقوم بجلب تفاصيل المباراة ومعرف الفرق التي سوف تتواجه
function matches($matchID)
{
    include('../connect.php');
    $query = "SELECT * from matches WHERE matchID = '$matchID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// يقوم بجلب نتائج التي حققها الفريق في المباراة
function matchscores_matchIDTeamID($matchID, $teamID)
{
    include('../connect.php');
    $query = "
    SELECT matchscores.matchScoreID, matchscores.matchID, matchscores.teamID, matchscores.teamScore, matchscores.teamPoints,
    team.fullName, team.logo 
    FROM matchscores INNER JOIN team ON matchscores.teamID = team.teamID 
    WHERE matchID = '$matchID' AND matchscores.teamID = '$teamID'
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}
//get the teams points and score => rating
function Select_scores($seasonID)
{
    include('../connect.php');
    $query = "
    SELECT matchscores.teamID ,team.fullName, team.logo, 
    SUM(matchscores.teamScore) AS 'teamScore', 
    SUM(matchscores.teamPoints) AS 'teamPoints' 
    FROM matchscores INNER JOIN team 
    ON matchscores.teamID = team.teamID 
    INNER JOIN matches 
    ON matchscores.matchID = matches.matchID 
    WHERE matches.seasonID = '$seasonID' 
    GROUP BY matchscores.teamID, team.fullName ORDER BY SUM(matchscores.teamPoints) DESC";
    $result = mysqli_query($conn, $query);
    return $result;
};
// start posts section 
function SelectPublications1($UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM publications WHERE UserID = '$UserID' AND publicationStatus = 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}
function SelectPublications2($UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM publications WHERE UserID = '$UserID' AND publicationStatus = 2";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}
function createPost($UserID, $postTitle, $postDetails, $image)
{
    include('../connect.php');
    $query = "INSERT INTO publications (UserID, postTitle, postDetails, photoPost) VALUES ('$UserID', '$postTitle', '$postDetails', '$image')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>post has been inserted successfully</div>
        ";
        header('REFRESH:2;URL=league-posts.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}
function viewPost_ID($PublishedID)
{
    include('../connect.php');
    $query = "SELECT * FROM publications WHERE PublishedID = '$PublishedID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function updatePost($postTitle, $postDetails, $photoPost, $PublishedID)
{
    include('../connect.php');
    $query = "UPDATE publications SET postTitle = '$postTitle', postDetails = '$postDetails', photoPost = '$photoPost', publicationStatus = 1 WHERE PublishedID = '$PublishedID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>post info updated successfully</div>
        ";
        header('REFRESH:2;URL=league-posts');
    } else {
        echo "Error: " .  $conn->error;
    }
}
function updatePost_($postTitle, $postDetails, $PublishedID)
{
    include('../connect.php');
    $query = "UPDATE publications SET postTitle = '$postTitle', postDetails = '$postDetails', publicationStatus = 1 WHERE PublishedID = '$PublishedID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>post info updated successfully</div>
        ";
        header('REFRESH:2;URL=league-posts.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}
