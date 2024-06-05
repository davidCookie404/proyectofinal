    <?php
    session_start();

    // Enable detailed error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: /HTML/index.php");
        exit();
    }

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Get form data
    $nombre_personaje = $_POST['nombre0'];
    $class_id = $_POST['class0'];
    $race_id = $_POST['race0'];
    $background_id = $_POST['bg0'];
    $fuerza = $_POST['Strengthscore'];
    $destreza = $_POST['Dexterityscore'];
    $constitucion = $_POST['Constitutionscore'];
    $inteligencia = $_POST['Intelligencescore'];
    $sabiduria = $_POST['Wisdomscore'];
    $carisma = $_POST['Charismascore'];
    $fuemod = $_POST['Strengthmod'];
    $desmod = $_POST['Dexteritymod'];
    $conmod = $_POST['Constitutionmod'];
    $intmod = $_POST['Intelligencemod'];
    $sabmod = $_POST['Wisdommod'];
    $carmod = $_POST['Charismamod'];
    $proficiencyBonus = $_POST['proficiencybonus'];

    $habilidadesCheck = json_encode([
        'FuerzaM' => $fuemod,
        'DestrezaM' => $desmod,
        'ConstitucionM' => $conmod,
        'InteligenciaM' => $intmod,
        'SabiduriaM' => $sabmod,
        'CarismaM' => $carmod
    ]);

    $checkbox_fuerza = isset($_POST['Strength-save-prof']) ? 1 : 0;
    $checkbox_destreza = isset($_POST['Dexterity-save-prof']) ? 1 : 0;
    $checkbox_constitucion = isset($_POST['Constitution-save-prof']) ? 1 : 0;
    $checkbox_inteligencia = isset($_POST['Intelligence-save-prof']) ? 1 : 0;
    $checkbox_sabiduria = isset($_POST['Wisdom-save-prof']) ? 1 : 0;
    $checkbox_carisma = isset($_POST['Charisma-save-prof']) ? 1 : 0;
    $checkbox_acrobacia = isset($_POST['Acrobatics-skill-prof']) ? 1 : 0;
    $checkbox_trato_animal = isset($_POST['Animal-Handling-Skill-prof']) ? 1 : 0;
    $checkbox_arcana = isset($_POST['Arcana-skill-prof']) ? 1 : 0;
    $checkbox_atletismo = isset($_POST['Athletics-skill-prof']) ? 1 : 0;
    $checkbox_engano = isset($_POST['Deception-skill-prof']) ? 1 : 0;
    $checkbox_historia = isset($_POST['History-skill-prof']) ? 1 : 0;
    $checkbox_perspicacia = isset($_POST['Insight-skill-prof']) ? 1 : 0;
    $checkbox_intimidacion = isset($_POST['Intimidation-skill-prof']) ? 1 : 0;
    $checkbox_investigacion = isset($_POST['Investigation-skill-prof']) ? 1 : 0;
    $checkbox_medicina = isset($_POST['Medicine-skill-prof']) ? 1 : 0;
    $checkbox_naturaleza = isset($_POST['Nature-skill-prof']) ? 1 : 0;
    $checkbox_percepcion = isset($_POST['Perception-skill-prof']) ? 1 : 0;
    $checkbox_interpretacion = isset($_POST['Performance-skill-prof']) ? 1 : 0;
    $checkbox_persuasion = isset($_POST['Persuasion-skill-prof']) ? 1 : 0;
    $checkbox_religion = isset($_POST['Religion-skill-prof']) ? 1 : 0;
    $checkbox_juego_mano = isset($_POST['Sleight-of-Hand-skill-prof']) ? 1 : 0;
    $checkbox_sigilo = isset($_POST['Stealth-skill-prof']) ? 1 : 0;
    $checkbox_supervivencia = isset($_POST['Survival-skill-prof']) ? 1 : 0;

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
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        $stmt->bind_param("siiii", $nombre_personaje, $user_id, $race_id, $class_id, $background_id);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting character data: " . $stmt->error);
        }

        // Get the last inserted personaje_id
        $personaje_id = $conn->insert_id;

        // Insert data into the caracteristica_pj table
        $sql = "INSERT INTO caracteristica_pj (personaje_id, Fuerza, Destreza, Constitucion, Inteligencia, Sabiduria, Carisma, habilidadesCheck, FuerzaS, DestrezaS, ConstitucionS, InteligenciaS, SabiduriaS, CarismaS, AcrobaciaH, TratoAnimalH, ArcanaH, AtletismoH, EnganoH, HistoriaH, PerspicaciaH, IntimidacionH, InvestigacionH, MedicinaH, NaturalezaH, PercepcionH, InterpretacionH, PersuasionH, ReligionH, JuegoManoH, SigiloH, SupervivenciaH) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        
        // Binding parameters in the prepared statement
        $stmt->bind_param("iiiiiiisiiiiiiiiiiiiiiiiiiiiiiii", $personaje_id, $fuerza, $destreza, $constitucion, $inteligencia, $sabiduria, $carisma, $habilidadesCheck, $checkbox_fuerza, $checkbox_destreza, $checkbox_constitucion, $checkbox_inteligencia, $checkbox_sabiduria, $checkbox_carisma, $checkbox_acrobacia, $checkbox_trato_animal, $checkbox_arcana, $checkbox_atletismo, $checkbox_engano, $checkbox_historia, $checkbox_perspicacia, $checkbox_intimidacion, $checkbox_investigacion, $checkbox_medicina, $checkbox_naturaleza, $checkbox_percepcion, $checkbox_interpretacion, $checkbox_persuasion, $checkbox_religion, $checkbox_juego_mano, $checkbox_sigilo, $checkbox_supervivencia);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting characteristics data: " . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();
        header("Location: ../USUARIOS/character_sheet.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $conn->rollback();
        error_log($e->getMessage(), 3, '/var/log/php_errors.log');
        echo "Failed to save character data. Please try again later.";
        // Also echo the error message for debugging
        echo "Error: " . $e->getMessage();
    }

    $stmt->close();
    $conn->close();
    ?>
