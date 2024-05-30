<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $database = "SessionZero";

    // Crear la conexion
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexion
    if ($conn->connect_error) {
        die("Conexion fallida: " . $conn->connect_error);
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

function getRelationalData($conn, $mainTable, $relationalTable, $foreignKey, $id) {
    // Obtener el nombre de la columna que contiene la clave externa en la tabla principal
    $foreignKeyColumn = $mainTable . '_id';

    // Usar consultas preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT * FROM $relationalTable WHERE $foreignKeyColumn = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $stmt->close();
    return $data;
}

function mapRelationalData($conn, &$data, $table, $idField, $nameFields) {
    foreach ($data as &$item) {
        $id = $item[$idField];
        $fields = implode(", ", $nameFields);
        $result = $conn->query("SELECT $fields FROM $table WHERE $idField = $id")->fetch_assoc();
        foreach ($nameFields as $field) {
            $item[$field] = $result[$field];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    // Conectar a la base de datos
    $conn = connectToDatabase();
    
    if ($_POST['action'] == 'getClassData' && isset($_POST['classId'])) {
        // Obtener el ID de la clase del POST
        $classId = $_POST['classId'];

        // Usar consultas preparadas
        $stmt = $conn->prepare("SELECT * FROM Clase WHERE clase_id = ?");
        $stmt->bind_param("i", $classId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Devolver los detalles de la clase como JSON
            $row = $result->fetch_assoc();

            // Obtener datos relacionales
            $row['armas'] = getRelationalData($conn, 'Clase', 'Arma_Clase', 'clase_id', $classId);
            mapRelationalData($conn, $row['armas'], 'Arma', 'arma_id', ['nombre_arma']);
            $row['armaduras'] = getRelationalData($conn, 'Clase', 'Armadura_Clase', 'clase_id', $classId);
            mapRelationalData($conn, $row['armaduras'], 'Armadura', 'armadura_id', ['nombre_armadura']);
            $row['rasgos'] = getRelationalData($conn, 'Clase', 'Clase_Rasgo', 'clase_id', $classId);
            mapRelationalData($conn, $row['rasgos'], 'Rasgo', 'rasgo_id', ['nombre_rasgo', 'descripcion_rasgo']);
            $row['conjuros'] = getRelationalData($conn, 'Clase', 'Clase_Conjuro', 'clase_id', $classId);
            mapRelationalData($conn, $row['conjuros'], 'Conjuro', 'conjuro_id', ['nombre_conjuro', 'descripcion_conjuro']);

            echo json_encode($row);
        } else {
            // Manejar el caso en que no se encuentre la clase
            echo json_encode(['error' => 'Clase no encontrada']);
        }
        $stmt->close();

    } elseif ($_POST['action'] == 'getRaceData' && isset($_POST['raceId'])) {
        // Obtener el ID de la raza del POST
        $raceId = $_POST['raceId'];

        // Usar consultas preparadas
        $stmt = $conn->prepare("SELECT * FROM Raza WHERE raza_id = ?");
        $stmt->bind_param("i", $raceId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Devolver los detalles de la raza como JSON
            $row = $result->fetch_assoc();

            // Obtener datos relacionales
            $row['rasgos'] = getRelationalData($conn, 'Raza', 'Raza_Rasgo', 'raza_id', $raceId);
            mapRelationalData($conn, $row['rasgos'], 'Rasgo', 'rasgo_id', ['nombre_rasgo', 'descripcion_rasgo']);
            $row['conjuros'] = getRelationalData($conn, 'Raza', 'Raza_Conjuro', 'raza_id', $raceId);
            mapRelationalData($conn, $row['conjuros'], 'Conjuro', 'conjuro_id', ['nombre_conjuro', 'descripcion_conjuro']);

            echo json_encode($row);
        } else {
            // Manejar el caso en que no se encuentre la raza
            echo json_encode(['error' => 'Raza no encontrada']);
        }
        $stmt->close();

    } elseif ($_POST['action'] == 'getBackgroundData' && isset($_POST['backgroundId'])) {
        // Obtener el ID de la trasfondo del POST
        $backgroundId = $_POST['backgroundId'];

        // Usar consultas preparadas
        $stmt = $conn->prepare("SELECT * FROM Trasfondo WHERE trasfondo_id = ?");
        $stmt->bind_param("i", $backgroundId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Devolver los detalles de la trasfondo como JSON
            $row = $result->fetch_assoc();

            // Obtener datos relacionales
            $row['rasgos'] = getRelationalData($conn, 'Trasfondo', 'Trasfondo_Rasgo', 'trasfondo_id', $backgroundId);
            mapRelationalData($conn, $row['rasgos'], 'Rasgo', 'rasgo_id', ['nombre_rasgo', 'descripcion_rasgo']);

            echo json_encode($row);
        } else {
            // Manejar el caso en que no se encuentre la trasfondo
            echo json_encode(['error' => 'Trasfondo no encontrado']);
        }
        $stmt->close();
    }

    // Cerrar la conexion a la base de datos
    $conn->close();
}

?>