<?php
session_start();

// Comprobar si el usuario actual ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redigir al URL conveniente si no lo ha hecho
    header("Location: /HTML/index.php");
    exit();
}

// Obtener el ID del usuario de la sesion
$user_id = $_SESSION['user_id'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Captar el personaje id correspondiente al usuario que esté logeado
if(isset($_GET['personaje_id'])) {
    $character_id = $_GET['personaje_id'];

    // Traer la informacion del personaje de la base de datos
    $sql = "
    SELECT 
        p.nombre_personaje, 
        c.nombre_clase, 
        c.dado_golpe,
        c.salvacion,
        c.competencias_clase,
        c.equipo_clase,
        r.nombre_raza, 
        r.velocidad,
        r.competencias_raza,
        t.nombre_trasfondo,
        t.competencias_trasfondo,
        t.equipo_trasfondo,
        (
            SELECT GROUP_CONCAT(CONCAT(cr.nombre_rasgo, ': ', cr.descripcion_rasgo) SEPARATOR '\n')
            FROM clase_rasgo crl
            JOIN rasgo cr ON crl.rasgo_id = cr.rasgo_id
            WHERE crl.clase_id = c.clase_id
        ) AS clase_rasgos,
        (
            SELECT GROUP_CONCAT(CONCAT(rr.nombre_rasgo, ': ', rr.descripcion_rasgo) SEPARATOR '\n')
            FROM raza_rasgo rrl
            JOIN rasgo rr ON rrl.rasgo_id = rr.rasgo_id
            WHERE rrl.raza_id = r.raza_id
        ) AS raza_rasgos,
        (
            SELECT GROUP_CONCAT(CONCAT(tr.nombre_rasgo, ': ', tr.descripcion_rasgo) SEPARATOR '\n')
            FROM trasfondo_rasgo trl
            JOIN rasgo tr ON trl.rasgo_id = tr.rasgo_id
            WHERE trl.trasfondo_id = t.trasfondo_id
        ) AS trasfondo_rasgos,
        cpj.Fuerza,
        cpj.Destreza,
        cpj.Constitucion,
        cpj.Inteligencia,
        cpj.Sabiduria,
        cpj.Carisma,
        cpj.HabilidadesCheck,
        cpj.checkbox_attribute,
        cpj.FuerzaS,
        cpj.DestrezaS,
        cpj.ConstitucionS,
        cpj.InteligenciaS,
        cpj.SabiduriaS,
        cpj.CarismaS,
        cpj.AcrobaciaH,
        cpj.TratoAnimalH,
        cpj.ArcanaH,
        cpj.AtletismoH,
        cpj.EnganoH,
        cpj.HistoriaH,
        cpj.PerspicaciaH,
        cpj.IntimidacionH,
        cpj.InvestigacionH,
        cpj.MedicinaH,
        cpj.NaturalezaH,
        cpj.PercepcionH,
        cpj.InterpretacionH,
        cpj.PersuasionH,
        cpj.ReligionH,
        cpj.JuegoManoH,
        cpj.SigiloH,
        cpj.SupervivenciaH,
        cpj.AC,
        cpj.PVA,
        cpj.PVM,
        cpj.PVT,
        cpj.Percepcion_pas,
        cpj.Perspicacia_pas,
        cpj.Investigacion_pas,
        a.nombre_arma,
        a.daño_arma,
        ad.nombre_armadura,
        ad.clase_armadura,
        (SELECT GROUP_CONCAT(CONCAT(cj.nombre_conjuro, ': ', cj.descripcion_conjuro) SEPARATOR '\n') 
          FROM Clase_conjuro ccj 
          JOIN Conjuro cj ON ccj.conjuro_id = cj.conjuro_id 
          WHERE ccj.clase_id = c.clase_id) AS clase_conjuros,
        (SELECT GROUP_CONCAT(CONCAT(rj.nombre_conjuro, ': ', rj.descripcion_conjuro) SEPARATOR '\n') 
          FROM Raza_conjuro rcj 
          JOIN Conjuro rj ON rcj.conjuro_id = rj.conjuro_id 
          WHERE rcj.raza_id = r.raza_id) AS raza_conjuros
    FROM 
        Personaje p
        JOIN Clase c ON p.clase_id = c.clase_id
        JOIN Raza r ON p.raza_id = r.raza_id
        JOIN Trasfondo t ON p.trasfondo_id = t.trasfondo_id
        LEFT JOIN clase_rasgo crl ON c.clase_id = crl.clase_id
        LEFT JOIN rasgo cr ON crl.rasgo_id = cr.rasgo_id
        LEFT JOIN raza_rasgo rrl ON r.raza_id = rrl.raza_id
        LEFT JOIN rasgo rr ON rrl.rasgo_id = rr.rasgo_id
        LEFT JOIN trasfondo_rasgo trl ON t.trasfondo_id = trl.trasfondo_id
        LEFT JOIN rasgo tr ON trl.rasgo_id = tr.rasgo_id
        LEFT JOIN caracteristica_pj cpj ON p.personaje_id = cpj.personaje_id
        LEFT JOIN Arma_clase ac ON c.clase_id = ac.clase_id
        LEFT JOIN Arma a ON ac.arma_id = a.arma_id
        LEFT JOIN Armadura_clase adc ON c.clase_id = adc.clase_id
        LEFT JOIN Armadura ad ON adc.armadura_id = ad.armadura_id
    WHERE 
        p.personaje_id = ? AND p.usuario_id = ?";
    

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $character_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
      // Traer los datos del personaje
      $character = $result->fetch_assoc();
  
    // Descodificar el JSON
    $habilidadesCheck = json_decode($character['HabilidadesCheck'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // Acceso a los modificadores que devuelve el JSON
        $fuerzaM = $habilidadesCheck['FuerzaM'] ?? null;
        $destrezaM = $habilidadesCheck['DestrezaM'] ?? null;
        $constitucionM = $habilidadesCheck['ConstitucionM'] ?? null;
        $inteligenciaM = $habilidadesCheck['InteligenciaM'] ?? null;
        $sabiduriaM = $habilidadesCheck['SabiduriaM'] ?? null;
        $carismaM = $habilidadesCheck['CarismaM'] ?? null;
    } else {
        echo "Error decoding JSON: " . json_last_error_msg();
        exit();
      }

    $checkbox_des = isset($character['DestrezaS']) ? (bool)$character['DestrezaS'] : false;
    $checkbox_fue = isset($character['FuerzaS']) ? (bool)$character['FuerzaS'] : false;
    $checkbox_con = isset($character['ConstitucionS']) ? (bool)$character['ConstitucionS'] : false;
    $checkbox_int = isset($character['InteligenciaS']) ? (bool)$character['InteligenciaS'] : false;
    $checkbox_sab = isset($character['SabiduriaS']) ? (bool)$character['SabiduriaS'] : false;
    $checkbox_car = isset($character['CarismaS']) ? (bool)$character['CarismaS'] : false;

    $checkbox_acro = isset($character['AcrobaciaH']) ? (bool)$character['AcrobaciaH'] : false;
    $checkbox_trat = isset($character['TratoAnimalH']) ? (bool)$character['TratoAnimalH'] : false;
    $checkbox_arca = isset($character['ArcanaH']) ? (bool)$character['ArcanaH'] : false;
    $checkbox_atle = isset($character['AtletismoH']) ? (bool)$character['AtletismoH'] : false;
    $checkbox_enga = isset($character['EnganoH']) ? (bool)$character['EnganoH'] : false;
    $checkbox_hist = isset($character['HistoriaH']) ? (bool)$character['HistoriaH'] : false;
    $checkbox_persp = isset($character['PerspicaciaH']) ? (bool)$character['PerspicaciaH'] : false;
    $checkbox_inti = isset($character['IntimidacionH']) ? (bool)$character['IntimidacionH'] : false;
    $checkbox_inve = isset($character['InvestigacionH']) ? (bool)$character['InvestigacionH'] : false;
    $checkbox_medi = isset($character['MedicinaH']) ? (bool)$character['MedicinaH'] : false;
    $checkbox_natu = isset($character['NaturalezaH']) ? (bool)$character['NaturalezaH'] : false;
    $checkbox_perc = isset($character['PercepcionH']) ? (bool)$character['PercepcionH'] : false;
    $checkbox_inte = isset($character['InterpretacionH']) ? (bool)$character['InterpretacionH'] : false;
    $checkbox_persu = isset($character['PersuasionH']) ? (bool)$character['PersuasionH'] : false;
    $checkbox_reli = isset($character['ReligionH']) ? (bool)$character['ReligionH'] : false;
    $checkbox_jueg = isset($character['JuegoManoH']) ? (bool)$character['JuegoManoH'] : false;
    $checkbox_sigi = isset($character['SigiloH']) ? (bool)$character['SigiloH'] : false;
    $checkbox_supe = isset($character['SupervivenciaH']) ? (bool)$character['SupervivenciaH'] : false;
  } else {
      echo "No existe el personaje";
      exit();
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/proyectofinal-main/CSS/index.css">
    <link rel="stylesheet" href="/proyectofinal-main/CSS/character_sheet.css">
    <link rel="icon" type="image/x-icon" href="/Images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s">

</head>
<body>
<header class="headercs">
        <div class="container">
            <div class="row w-100">
                <nav class="navbar navbar-expand-lg w-100">
                    <a class="navbar-brand" href="#">
                        <img class="imglogo" src="/proyectofinal-main/images/5elogo.svg">
                    </a>
                    <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyectofinal-main/HTML/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../USUARIOS/character_sheet.php">Personajes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../USUARIOS/profile.php">       
                                <?php if (isset($_SESSION['username'])) : ?>
                                <?php echo $_SESSION['username'];?>
                                <?php else : ?>
                                <?php endif; ?></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../USUARIOS/logout.php">
                                    Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main>
    <form class="charsheet" id="charsheet">
  <header>
  <section class="charname">
        <label for="charname">Nombre del Personaje</label>
        <input name="charname" placeholder="Nombre PJ" value="<?php echo htmlspecialchars($character['nombre_personaje']); ?>"/>
    </section>
    <section class="misc">
      <ul>
        <li>
        <label for="class1">Clase</label>
        <?php echo htmlspecialchars($character['nombre_clase']); ?>
        </li>
        <li>
        <label for="race">Raza</label>
        <?php echo htmlspecialchars($character['nombre_raza']); ?>
        </li>
        <li>
        <label for="background">Trasfondo</label>
        <?php echo htmlspecialchars($character['nombre_trasfondo']); ?>
        </li>
        <li>
          <label for="playername">Nombre del Jugador</label>
          <?php if (isset($_SESSION['username'])) : ?>
          <?php echo $_SESSION['username'];?>
          <?php else : ?>
          <?php endif; ?></i>
        </li>
      </ul>

    </section>
  </header>
  <main>
    <section>
      <section class="attributes">
        <div class="scores">
          <ul>
            <li>
              <div class="score">
                <label for="Strengthscore">Fuerza</label><input name="Strengthscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Fuerza']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Strengthmod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($fuerzaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Dexterityscore">Destreza</label><input name="Dexterityscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Destreza']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Dexteritymod" placeholder="+0" class=statmod value="<?php echo htmlspecialchars($destrezaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Constitutionscore">Constitucion</label><input name="Constitutionscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Constitucion']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Constitutionmod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($constitucionM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Intelligencescore">Inteligencia</label><input name="Intelligencescore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Inteligencia']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Intelligencemod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($inteligenciaM);?>"/>
              </div> 
            </li>
            <li>
              <div class="score">
                <label for="Wisdomscore">Sabiduria</label><input name="Wisdomscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Sabiduria']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Wisdommod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($sabiduriaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Charismascore">Carisma</label><input name="Charismascore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Carisma']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Charismamod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($carismaM);?>"/>
              </div>
            </li>
          </ul>
        </div>
        <div class="attr-applications">
          <div class="proficiencybonus box">
            <div class="label-container">
              <label for="inspiration">Inspiracion</label>
            </div>
            <input name="inspiration" placeholder="" />
          </div>
          <div class="proficiencybonus box">
            <div class="label-container">
              <label for="proficiencybonus">Bonus Competencia</label>
            </div>
            <input name="proficiencybonus" placeholder="+2"value="<?php echo htmlspecialchars($character['checkbox_attribute']); ?>"/>
          </div>
          <div class="saves list-section box">
            <ul>
              <li>
                <label for="Strength-save">Fuerza</label><input name="Strengthsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($fuerzaM);?>"/><input name="prof-fue" type="checkbox" class="prof" value="0" <?php echo $checkbox_fue ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Dexterity-save">Destreza</label><input name="Dexteritysave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($destrezaM);?>"/><input name="prof_des" type="checkbox" class="prof" <?php echo $checkbox_des ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Constitution-save">Constitucion</label><input name="Constitutionsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($constitucionM);?>"/><input name="prof_con" type="checkbox" class="prof" <?php echo $checkbox_con ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Intelligence-save">Inteligencia</label><input name="Intelligencesave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="prof_int" type="checkbox" class="prof" value="3" <?php echo $checkbox_int ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Wisdom-save">Sabiduria</label><input name="Wisdomsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($sabiduriaM);?>" /><input name="prof_sab" type="checkbox" class="prof" value="4" <?php echo $checkbox_sab? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Charisma-save">Carisma</label><input name="Charismasave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($carismaM);?>" /><input name="prof-car" type="checkbox" class="prof" value="5" <?php echo $checkbox_car ? 'checked' : ''; ?>/>
              </li>
            </ul>
            <!-- <?php echo htmlspecialchars($character['salvacion']); ?> -->
            <div class="label">
              Tiradas Salvacion
            </div>
          </div>
          <div class="skills list-section box">
            <ul>
              <li>
                <label for="Acrobatics">Acrobacia 
                  <span class="skill">(Des)</span>
                </label>
                <input name="Acrobaticsskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM); ?>"/><input name="prof" type="checkbox" <?php echo $checkbox_acro ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Animal Handling">Trato Animales <span class="skill">(Sab)</span></label><input name="Animal-Handlingskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Animal-Handling-skill-prof" type="checkbox" <?php echo $checkbox_trat ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Arcana">Arcana <span class="skill">(Int)</span></label><input name="Arcanaskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Arcana-skill-prof" type="checkbox" <?php echo $checkbox_arca ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Athletics">Atletismo <span class="skill">(Fue)</span></label><input name="Athleticsskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($fuerzaM);?>"/><input name="Athletics-skill-prof" type="checkbox" <?php echo $checkbox_atle ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Deception">Engaño <span class="skill">(Car)</span></label><input name="Deceptionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Deception-skill-prof" type="checkbox" <?php echo $checkbox_enga ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="History">Historia <span class="skill">(Int)</span></label><input name="Historyskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="History-skill-prof" type="checkbox" <?php echo $checkbox_hist ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Insight">Perspicacia <span class="skill">(Sab)</span></label><input name="Insightskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Insight-skill-prof" type="checkbox" <?php echo $checkbox_persp ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Intimidation">Intimidacion <span class="skill">(Car)</span></label><input name="Intimidationskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Intimidation-skill-prof" type="checkbox" <?php echo $checkbox_inti ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Investigation">Investigacion <span class="skill">(Int)</span></label><input name="Investigationskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Investigation-skill-prof" type="checkbox" <?php echo $checkbox_inve ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Medicine">Medicina <span class="skill">(Sab)</span></label><input name="Medicineskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Medicine-skill-prof" type="checkbox" <?php echo $checkbox_medi ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Nature">Naturaleza <span class="skill">(Int)</span></label><input name="Natureskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Nature-skill-prof" type="checkbox" <?php echo $checkbox_natu ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Perception">Percepcion <span class="skill">(Sab)</span></label><input name="Perceptionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Perception-skill-prof" type="checkbox" <?php echo $checkbox_perc ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Performance">Interpretacion <span class="skill">(Car)</span></label><input name="Performanceskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Performance-skill-prof" type="checkbox" <?php echo $checkbox_inte ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Persuasion">Persuasion <span class="skill">(Car)</span></label><input name="Persuasionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Persuasion-skill-prof" type="checkbox" <?php echo $checkbox_persu ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Religion">Religion <span class="skill">(Int)</span></label><input name="Religionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Religion-skill-prof" type="checkbox" <?php echo $checkbox_reli ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Sleight of Hand">Juego de Manos <span class="skill">(Des)</span></label><input name="Sleight-of-Handskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM); ?>"/><input name="Sleight-of-Hand-skill-prof" type="checkbox" <?php echo $checkbox_jueg ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Stealth">Siglo <span class="skill">(Des)</span></label><input name="Stealthskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM);?>"/><input name="Stealth-skill-prof" type="checkbox" <?php echo $checkbox_sigi ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Survival">Supervivencia <span class="skill">(Sab)</span></label><input name="Survivalskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Survival-skill-prof" type="checkbox" />
              </li>
            </ul>
            <div class="label">
              Habilidades
            </div>
          </div>
        </div>
      </section>
    </section>
    <section>
      <section class="combat">
        <div class="armorclass">
          <div>
            <label for="ac">Clase Armadura</label><input name="ac" placeholder="10" type="text" value="<?php echo htmlspecialchars($character['AC']); ?>"/>
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="initiative">Iniciativa</label><input name="Dexteritymod" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM); ?>"/>
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="speed">Velocidad</label><input name="speed" placeholder="30ft" type="text" value="<?php echo htmlspecialchars($character['velocidad']); ?>"/>
          </div>
        </div>

        <div class="armorclass">
          <div>
            <label for="currenthp">Puntos de Golpe Actuales</label><input name="currenthp" placeholder="10" type="text" value="<?php echo htmlspecialchars($character['PVA']); ?>"/>
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="currenthp">Puntos de Golpe Máximos</label><input name="currenthp" placeholder="10" type="text" value="<?php echo htmlspecialchars($character['PVM']); ?>"/>
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="temphp">Puntos de Golpe Temp.</label><input name="temphp" placeholder="0" type="text" value="<?php echo htmlspecialchars($character['PVT']); ?>"/>
          </div>
        </div>
        <div class="hitdice">
          <div>
            <div class="total">
              <label for="totalhd">Total</label><input name="totalhd" placeholder="_d__" type="text" value="1d<?php echo htmlspecialchars($character['dado_golpe']); ?>"/>
            </div>
            <div class="remaining">
              <label for="remaininghd">Dado Golpe</label><input name="remaininghd" type="text" />
            </div>
          </div>
        </div>
        <div class="deathsaves">
          <div>
            <div class="label">
              <label>Salvacion contra Muerte</label>
            </div>
            <div class="marks">
              <div class="deathsuccesses">
                <label>Éxitos</label>
                <div class="bubbles">
                  <input name="deathsuccess1" type="checkbox" />
                  <input name="deathsuccess2" type="checkbox" />
                  <input name="deathsuccess3" type="checkbox" />
                </div>
              </div>
              <div class="deathfails">
                <label>Fallos</label>
                <div class="bubbles">
                  <input name="deathfail1" type="checkbox" />
                  <input name="deathfail2" type="checkbox" />
                  <input name="deathfail3" type="checkbox" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <div class="otherprofs box textblock">
          <label for="otherprofs">Otras Competencias e Idiomas</label><textarea name="otherprofs">
- Competencias de Clase: <?php echo htmlspecialchars($character['competencias_clase']); ?>&nbsp;
- Competencias de Raza: <?php echo htmlspecialchars($character['competencias_raza']); ?>&nbsp;
- Competencias de Trasfondo: <?php echo htmlspecialchars($character['competencias_trasfondo']); ?>
          </textarea>
        </div>

    </section>
    <section>
      <section class="features">
        <div>
          <label for="features-r">Rasgos y Atributos</label>
          <textarea name="features-r">
- Rasgos de Clase: <?php echo htmlspecialchars($character['clase_rasgos']); ?>

- Rasgos de Raza: <?php echo htmlspecialchars($character['raza_rasgos']); ?>

- Rasgos de Trasfondo: <?php echo htmlspecialchars($character['trasfondo_rasgos']); ?>
          </textarea>
        </div>
      </section>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveperception">Percepción Pasiva (Sabiduría)</label>
        </div>
        <input name="passiveperception" placeholder="10" value="<?php echo htmlspecialchars($character['Percepcion_pas']); ?>"/>
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinsight">Perspicacia Pasiva (Sabiduría)</label>
        </div>
        <input name="passiveinsight" placeholder="10" value="<?php echo htmlspecialchars($character['Perspicacia_pas']); ?>"/>
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinvestigation">Investigación Pasiva (Inteligencia)</label>
        </div>
        <input name="passiveinvestigation" placeholder="" value="<?php echo htmlspecialchars($character['Investigacion_pas']); ?>"/>
      </div>
    </section>

  </main>

  <header>
      <section class="attacksandspellcasting" id="inventory">
          <div>
            <label>Inventario</label>
            <textarea name="inventorynotes" placeholder="">
- Equipo de clase: <?php echo htmlspecialchars($character['equipo_clase']); ?> 
- Armas: <?php echo htmlspecialchars($character['nombre_arma']); ?>, <?php echo htmlspecialchars($character['daño_arma']); ?>&nbsp;
- Armaduras: <?php echo htmlspecialchars($character['nombre_armadura']); ?> (<?php echo htmlspecialchars($character['clase_armadura']); ?> CA)&nbsp;
- Equipo de trasfondo: <?php echo htmlspecialchars($character['equipo_trasfondo']); ?>
            </textarea>
          </div>
      </section>
  </header>

  <header>
    <section class="attacksandspellcasting" id="spells">
      <div>
        <label>Conjuros</label>
        <textarea name="spellsnotes" placeholder="">
- Conjuros de la Clase:
  <?php echo htmlspecialchars($character['clase_conjuros']); ?>
- Conjuros de la Raza: 
  <?php echo htmlspecialchars($character['raza_conjuros']); ?>
        </textarea>
      </div>
    </section>
  </header>

  <main>
    <input name="rows_attacks" type="hidden" value="2">
    <input name="rows_inventory" type="hidden" value="2"/>
    <input name="rows_spells" type="hidden" value="2"/>
  </main>

</form>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="/proyectofinal-main/js/script.js"></script>
</body>
</html> 
