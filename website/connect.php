<?php
$servername = "localhost";
$username = "id19380517_root";
$password = "passwordPASSWORD123!";
$dbname = "id19380517_sykoora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
}
