<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: /HTML/index.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get form data
$nombre_personaje = $_POST['nombre0']; // Character Name
$class_id = $_POST['class0']; // Class
$race_id = $_POST['race0']; // Race
$background_id = $_POST['bg0']; // Background
$fuerza = $_POST['Strengthscore']; // Strength
$destreza = $_POST['Dexterityscore']; // Dexterity
$constitucion = $_POST['Constitutionscore']; // Constitution
$inteligencia = $_POST['Intelligencescore']; // Intelligence
$sabiduria = $_POST['Wisdomscore']; // Wisdom
$carisma = $_POST['Charismascore']; // Charisma

// Database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a transaction
$conn->begin_transaction();

try {
    // Insert data into the character table
    $sql = "INSERT INTO Personaje (nombre_personaje, usuario_id, raza_id, clase_id, trasfondo_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $nombre_personaje, $user_id, $race_id, $class_id, $background_id);

    if (!$stmt->execute()) {
        throw new Exception("Error inserting character data: " . $stmt->error);
    }

    // Get the last inserted personaje_id
    $personaje_id = $conn->insert_id;

    // Insert data into the caracteristica_pj table
    $sql = "INSERT INTO caracteristica_pj (personaje_id, Fuerza, Destreza, Constitucion, Inteligencia, Sabiduria, Carisma) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiii", $personaje_id, $fuerza, $destreza, $constitucion, $inteligencia, $sabiduria, $carisma);

    if (!$stmt->execute()) {
        throw new Exception("Error inserting characteristics data: " . $stmt->error);
    }

    // Commit the transaction
    $conn->commit();
    echo "Character data saved successfully!";
    header("Location: ../USUARIOS/character_sheet.php");
    exit();
} catch (Exception $e) {
    // Rollback the transaction if there was an error
    $conn->rollback();
    echo "Failed to save character data: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
