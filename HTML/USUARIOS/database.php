<?php
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $database = "SessionZero";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

function getOptionsFromDatabase($conn, $tableName, $idColumnName, $nameColumnName) {
    $sql = "SELECT $idColumnName, $nameColumnName FROM $tableName";
    $result = $conn->query($sql);

    $options = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[$row[$idColumnName]] = $row[$nameColumnName];
        }
    }
    return $options;
}
?>
