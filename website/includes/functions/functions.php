<?php
// ____________________________________________________________________________________________________
function leagues()
{
    include('connect.php');
    $query = "SELECT * FROM leagues ORDER BY leagues.leagueID DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    return $result;
}

function publications($Today)
{
    include('connect.php');
    $query = "SELECT * FROM publications WHERE publications.publicationStatus = 2 AND postData = '$Today' ORDER BY publications.PublishedID DESC LIMIT 15";
    $result = mysqli_query($conn, $query);
    return $result;
}

function matches($date)
{
    include('connect.php');
    $query = "SELECT * FROM matches WHERE matches.matchDate = '$date' LIMIT 5";
    $result = mysqli_query($conn, $query);
    return $result;
}

function matchscores_matchID_teamID($matchID, $teamID)
{
    include('connect.php');
    $query = "
    SELECT matchscores.matchScoreID, matchscores.matchID, matchscores.teamID, matchscores.teamScore, matchscores.teamPoints,
    team.fullName, team.logo 
    FROM matchscores INNER JOIN team ON matchscores.teamID = team.teamID 
    WHERE matchscores.matchID = '$matchID' AND  matchscores.teamID = '$teamID'
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}

function logo($teamID)
{
    include('connect.php');
    $query = "SELECT logo, fullName FROM team WHERE team.teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}
// ____________________________________________________________________________________________________
function publications_($Today, $accountType)
{
    include('connect.php');
    $query = "
    SELECT publications.* 
    FROM publications INNER JOIN user ON publications.UserID = user.UserID  
    WHERE publications.publicationStatus = 2 AND postData = '$Today' AND accountType = '$accountType' ORDER BY publications.PublishedID DESC LIMIT 15
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}
function leagues_()
{
    include('connect.php');
    $query = "SELECT * FROM leagues ORDER BY leagues.leagueID";
    $result = mysqli_query($conn, $query);
    return $result;
}
// ____________________________________________________________________________________________________
function league($leagueID)
{
    include('connect.php');
    $query = "SELECT * FROM leagues WHERE leagueID = '$leagueID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// ____________________________________________________________________________________________________
function team()
{
    include('connect.php');
    $query = "SELECT * FROM team ORDER BY team.teamID DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}
// ____________________________________________________________________________________________________
function matches_day($day)
{
    include('connect.php');
    $query = "SELECT * FROM matches WHERE matchDate = '$day'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// ____________________________________________________________________________________________________
/////////////////////////////////////////////
//// for league page
function leagues_UserID($leagueID)
{
    include('connect.php');
    $query = "SELECT UserID FROM leagues WHERE leagueID = '$leagueID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['UserID'];
}
function publications_leagues($UserID)
{
    include('connect.php');
    $query = "SELECT publications.* FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE publicationStatus = 2 AND publications.UserID = '$UserID' ORDER BY postData ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function seasons_seasonID($leagueID)
{
    include('connect.php');
    $query = "SELECT seasonID, currentSeason_date FROM seasons WHERE leagueID = '$leagueID' ORDER BY seasonID ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function lastSeasonID($leagueID)
{
    include('connect.php');
    $query = "SELECT seasonID FROM seasons WHERE leagueID = '$leagueID' ORDER BY seasonID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row != null) {
        return $row['seasonID'];
    }
}
function seasonID_team($seasonID)
{
    include('connect.php');
    $query = "SELECT teamID FROM participatingteams WHERE seasonID = '$seasonID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function season_teamID($teamID)
{
    include('connect.php');
    $query = "SELECT team.teamID, team.fullName, team.logo from team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function seasonID_scores($seasonID)
{
    include('connect.php');
    $query = "
    SELECT matchscores.teamID ,team.fullName, team.logo,
    SUM(matchscores.teamScore) AS 'teamScore',
    SUM(matchscores.teamPoints) AS 'teamPoints'
    FROM matchscores INNER JOIN team
    ON matchscores.teamID = team.teamID
    INNER JOIN matches
    ON matchscores.matchID = matches.matchID
    WHERE matches.seasonID = '$seasonID'
    GROUP BY matchscores.teamID, team.fullName ORDER BY SUM(matchscores.teamPoints) DESC
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}
function seasonID_matches($seasonID, $matchesType)
{
    include('connect.php');
    $query = "SELECT * FROM matches WHERE seasonID = '$seasonID' AND matchesType = '$matchesType' ORDER BY matchDate ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function seasonID_matches_matchDate($seasonID, $matchesType, $matchDate)
{
    include('connect.php');
    $query = "SELECT * FROM matches WHERE seasonID = '$seasonID' AND matchesType = '$matchesType' AND matchDate = '$matchDate' ORDER BY matchDate ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
//// for league page
// ____________________________________________________________________________________________________
/////////////////////////////////////////////
//// for team page
function teaminfo($teamID)
{
    include('connect.php');
    $query = "SELECT * FROM team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function peoplesteam($teamID, $personType)
{
    include('connect.php');
    $query = "SELECT * FROM peoplesteam WHERE teamID = '$teamID' AND personType = '$personType'
    ORDER BY Person_specialty ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function team_UserID($teamID)
{
    include('connect.php');
    $query = "SELECT UserID FROM team WHERE teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['UserID'];
}
function publications_team($UserID)
{
    include('connect.php');
    $query = "SELECT publications.* FROM publications INNER JOIN user ON publications.UserID = user.UserID WHERE publicationStatus = 2 AND publications.UserID = '$UserID' ORDER BY postData ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}

function matches_teamID($teamID, $matchDate)
{
    include('connect.php');
    $query = "SELECT * from matches WHERE matchDate = '$matchDate' AND ( teamID1 = '$teamID' OR teamID2 = '$teamID' ) ORDER BY matchDate ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function matches_teamID_all($teamID) {
    include('connect.php');
    $query = "SELECT * from matches WHERE (teamID1 = '$teamID' OR teamID2 = '$teamID') ORDER BY matchDate DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}
function leagues_team($teamID)
{
    include('connect.php');
    $query = "SELECT leagues.leagueID, leagues.leagueName FROM leagues INNER JOIN seasons ON leagues.leagueID = seasons.leagueID INNER JOIN participatingteams ON seasons.seasonID = participatingteams.seasonID WHERE participatingteams.teamID = '$teamID' GROUP BY teamID";
    $result = mysqli_query($conn, $query);
    return $result;
}
function seasons_team($leagueID, $teamID)
{
    include('connect.php');
    $query = "SELECT seasons.seasonID, seasons.currentSeason_date FROM seasons INNER JOIN participatingteams ON seasons.seasonID = participatingteams.seasonID WHERE seasons.leagueID = '$leagueID' AND participatingteams.teamID = '$teamID'";
    $result = mysqli_query($conn, $query);
    return $result;
}
// __________
function matches_matchID($matchID)
{
    include('connect.php');
    $query = "SELECT `leagues`.`leagueName`, `matches`.* FROM `leagues` INNER JOIN `seasons` ON `leagues`.`leagueID` = `seasons`.`leagueID`
    INNER JOIN `matches` ON `seasons`.`seasonID` = `matches`.`seasonID`
    WHERE `matches`.`matchID` = $matchID";
    $result = mysqli_query($conn, $query);
    return $result;
}
function posts_postID ($postID) {
    include('connect.php');
    $sql = "SELECT  `user`.`accountType` FROM publications INNER JOIN `user` ON `publications`.`UserID` = `user`.`UserID`
    WHERE `publications`.`PublishedID` = $postID";
    $result_sql = mysqli_query($conn, $sql);
    $row_sql = mysqli_fetch_assoc($result_sql);
    if ($row_sql['accountType'] == 2) {
        $query = "SELECT team.fullName, publications.* FROM publications INNER JOIN user
                    ON publications.UserID = user.UserID INNER JOIN team 
                    ON user.UserID = team.UserID
                    WHERE PublishedID = $postID";
        $result = mysqli_query($conn, $query);
        return $result;
    }elseif($row_sql['accountType'] == 3){
        $query = "SELECT leagues.leagueName, publications.* FROM publications INNER JOIN user
                    ON publications.UserID = user.UserID INNER JOIN leagues 
                    ON user.UserID = leagues.UserID
                    WHERE PublishedID = $postID";
        $result = mysqli_query($conn, $query);
        return $result;
    }
}