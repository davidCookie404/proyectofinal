<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: /HTML/index.php");
    exit();
}

// Check if the personaje_id parameter is set in the URL
if (!isset($_GET['personaje_id']) || !is_numeric($_GET['personaje_id'])) {
    // Redirect to the profile page if personaje_id is not provided or invalid
    header("Location: profile.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL DELETE statement to delete the character from the caracteristica_pj table
$sql_caracteristica = "DELETE FROM caracteristica_pj WHERE personaje_id = ?";
$stmt_caracteristica = $conn->prepare($sql_caracteristica);
$stmt_caracteristica->bind_param("i", $_GET['personaje_id']);
$stmt_caracteristica->execute();

// Prepare and execute SQL DELETE statement to delete the character from the Personaje table
$sql_personaje = "DELETE FROM Personaje WHERE personaje_id = ? AND usuario_id = ?";
$stmt_personaje = $conn->prepare($sql_personaje);
$stmt_personaje->bind_param("ii", $_GET['personaje_id'], $_SESSION['user_id']);
$stmt_personaje->execute();

$stmt_caracteristica->close();
$stmt_personaje->close();
$conn->close();

// Redirect back to the profile page after deletion
header("Location: profile.php");
exit();
?>
