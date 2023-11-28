<?php
function checkUserTeam($userID)
{
    include('connect.php');
    $query = "SELECT * FROM team WHERE UserID = $userID";
    $result_TeamManager = mysqli_query($conn, $query);
    return mysqli_num_rows($result_TeamManager);
}
function checkTeam($S_UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE UserID = '$S_UserID'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}
function checkTeam_fullName($fullName)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE fullName = '$fullName'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    return $count;
}
function addTeam($UserID, $fullName, $nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $imgContent2)
{
    include('../connect.php');
    $query = "INSERT INTO team(UserID, fullName, nickName, foundedYear, stadium, country, president, coach, teamKit, logo) VALUES ('$UserID', '$fullName', '$nickName', '$foundedYear', '$stadium', '$country', '$president', '$coach', '$imgContent', '$imgContent2')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info has been inserted successfully</div>
        ";
        header('REFRESH:2;URL=manage-team.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}
function SelectTeamData($S_UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE UserID = '$S_UserID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function SelectTeam($teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function updateTeam($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $imgContent2, $teamID)
{
    include('../connect.php');
    $query = "UPDATE team SET nickName = '$nickName', foundedYear = '$foundedYear', stadium = '$stadium', country = '$country', president = '$president', coach = '$coach', teamKit = '$imgContent', logo = '$imgContent2' WHERE teamID = '$teamID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-team.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}

function updateTeam_logo($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent2, $teamID)
{
    include('../connect.php');
    $query = "UPDATE team SET nickName = '$nickName', foundedYear = '$foundedYear', stadium = '$stadium', country = '$country', president = '$president', coach = '$coach', logo = '$imgContent2' WHERE teamID = '$teamID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully/div>
        ";
        header('REFRESH:2;URL=manage-team.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}

function updateTeam_teamKit($nickName, $foundedYear, $stadium, $country, $president, $coach, $imgContent, $teamID)
{
    include('../connect.php');
    $query = "UPDATE team SET nickName = '$nickName', foundedYear = '$foundedYear', stadium = '$stadium', country = '$country', president = '$president', coach = '$coach', teamKit = '$imgContent' WHERE teamID = '$teamID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-team.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}
function updateTeam_2($nickName, $foundedYear, $stadium, $country, $president, $coach, $teamID)
{
    include('../connect.php');
    $query = "UPDATE team SET nickName = '$nickName', foundedYear = '$foundedYear', stadium = '$stadium', country = '$country', president = '$president', coach = '$coach' WHERE teamID = '$teamID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-team.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

function additionalData($glimpse, $establishing, $UserID)
{
    include('../connect.php');
    $query = "UPDATE team SET glimpse = '$glimpse', establishing = '$establishing' WHERE UserID = '$UserID' ";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully</div>
        ";
        header('REFRESH:2;URL=team-info.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}
function SelectTeamAdditionalData($teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function UpdateTeamAdditionalData($glimpse, $establishing, $teamID)
{
    include('../connect.php');
    $query = "UPDATE team SET glimpse = '$glimpse', establishing = '$establishing' WHERE teamID = '$teamID'";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>team info updated successfully</div>
        ";
        header('REFRESH:2;URL=team-info.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}

function teamAchievements($teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM achievements WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}

function namesfrom($teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM namesfrom WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}

function SelectPublications_1($UserID)
{
    include('../connect.php');
    $query = "SELECT * FROM publications WHERE UserID = '$UserID' AND publicationStatus = 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}
function SelectPublications_2($UserID)
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
        <div class='handle-success-message'>post created successfully</div>
        ";
        header('REFRESH:2;URL=manage-posts.php');
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
        <div class='handle-success-message'>post updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-posts.php');
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
        <div class='handle-success-message'>post updated successfully</div>
        ";
        header('REFRESH:2;URL=manage-posts.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}

// !start people in teams functions 

function Select_teamID($S_UserID)
{
    // teamID
    include('../connect.php');
    $query = "SELECT teamID FROM team WHERE UserID = '$S_UserID'";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $row['teamID'];
}
function countPeople($Type, $teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM peoplesteam WHERE personType = '$Type' AND teamID = '$teamID'";
    return mysqli_num_rows(mysqli_query($conn, $query));
}
function Select_peoplesteam($Type, $teamID)
{
    include('../connect.php');
    $query = "SELECT * FROM peoplesteam WHERE personType = '$Type' AND teamID = '$teamID' ORDER by Person_specialty DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function addPeople($teamID, $Person_fullName,  $Person_specialty, $person_nationality, $player_number, $Type, $person_img)
{
    include('../connect.php');
    $query = "INSERT INTO peoplesteam (teamID, Person_fullName, Person_specialty, Person_Nationality, Person_number, personType, Person_image) 
    VALUES ('$teamID', '$Person_fullName', '$Person_specialty', '$person_nationality', '$player_number', '$Type', '$person_img')";
    if ($conn->query($query) === TRUE) {
        echo "
        <div class='overlay'></div>
        <div class='handle-success-message'>new account created successfully</div>
        ";
        header('REFRESH:2;URL=manage-users.php');
    } else {
        echo "Error: " .  $conn->error;
    }
}

function Select_Type($PersonID)
{
    include('../connect.php');
    $query = "SELECT personType FROM peoplesteam WHERE PersonID = '$PersonID'";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $row['personType'];
}

//get the leagues and seasons team has joined
function SelectTeamIDBy_UserID($UserID)
{
    include('../connect.php');
    $query = "SELECT teamID FROM team WHERE UserID = '$UserID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['teamID'];
}

function SelectLeaguesBy_teamID($teamID)
{
    include('../connect.php');
    $query = "SELECT leagues.leagueID, leagues.leagueName FROM leagues INNER JOIN seasons ON leagues.leagueID = seasons.leagueID INNER JOIN participatingteams ON seasons.seasonID = participatingteams.seasonID WHERE participatingteams.teamID = '$teamID' GROUP BY participatingteams.teamID";
    $result = mysqli_query($conn, $query);
    return $result;
}

function SelectSeasonsByLeagueID_teamID($teamID, $leagueID)
{
    include('../connect.php');
    $query = "
    SELECT leagues.leagueID, leagues.leagueName, seasons.seasonID, seasons.currentSeason_date 
    FROM leagues INNER JOIN seasons ON leagues.leagueID = seasons.leagueID 
    INNER JOIN participatingteams ON seasons.seasonID = participatingteams.seasonID 
    WHERE participatingteams.teamID = '$teamID' AND seasons.leagueID = '$leagueID'
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}
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
// !end people in teams functions 
