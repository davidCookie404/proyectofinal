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

// Database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the character ID from the GET parameters
if(isset($_GET['personaje_id'])) {
    $character_id = $_GET['personaje_id'];

    // Retrieve character data from the database
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
      cr.nombre_rasgo AS clase_nombre_rasgo,
      cr.descripcion_rasgo AS clase_descripcion_rasgo,
      rr.nombre_rasgo AS raza_nombre_rasgo,
      rr.descripcion_rasgo AS raza_descripcion_rasgo,
      tr.nombre_rasgo AS trasfondo_nombre_rasgo,
      tr.descripcion_rasgo AS trasfondo_descripcion_rasgo,
      cpj.Fuerza,
      cpj.Destreza,
      cpj.Constitucion,
      cpj.Inteligencia,
      cpj.Sabiduria,
      cpj.Carisma,
      cpj.HabilidadesCheck,
      cpj.checkbox_attribute,
      cpj.SalvacionHabilidad
  FROM Personaje p
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
  WHERE p.personaje_id = ? AND p.usuario_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $character_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
      // Fetch the character data
      $character = $result->fetch_assoc();
  
    // Decode the JSON data from HabilidadesCheck
    $habilidadesCheck = json_decode($character['HabilidadesCheck'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // Access individual ability modifiers from the decoded JSON object
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
      // Set checkbox states based on the retrieved data
      $checkbox_des = isset($character['SalvacionHabilidad']) ? (bool)$character['SalvacionHabilidad'] : false;
      $checkbox_fue = isset($character['checkbox_fue']) ? (bool)$character['checkbox_fue'] : false;
  } else {
      echo "No existe el personaje";
      exit();
  }

  $stmt->close();
  $conn->close();
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Character</title>
</head>
<body>
    <h1>Character Details</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($character['nombre_personaje']); ?></p>x
    <p><strong>Class:</strong> <?php echo htmlspecialchars($character['nombre_clase']); ?></p>x
    <p><strong>Race:</strong> <?php echo htmlspecialchars($character['dado_golpe']); ?></p>x
    <p><strong>Background:</strong> <?php echo htmlspecialchars($character['salvacion']); ?>x
    <?php echo htmlspecialchars($character['clase_comp_habilidad']); ?>
    <?php echo htmlspecialchars($character['competencias_clase']); ?>x
    <?php echo htmlspecialchars($character['equipo_clase']); ?>x
    <?php echo htmlspecialchars($character['conjurador']); ?>
    <?php echo htmlspecialchars($character['espacio_conjuro']); ?>
    <?php echo htmlspecialchars($character['caracteristica_conjuro']); ?>
    <?php echo htmlspecialchars($character['ritual']); ?>
    <?php echo htmlspecialchars($character['nombre_raza']); ?>x
    <?php echo htmlspecialchars($character['velocidad']); ?>x
    <?php echo htmlspecialchars($character['raza_comp_habilidad']); ?>
    <?php echo htmlspecialchars($character['competencias_raza']); ?>x
    <?php echo htmlspecialchars($character['nombre_trasfondo']); ?>x
    <?php echo htmlspecialchars($character['trasfondo_comp_habilidad']); ?>
    <?php echo htmlspecialchars($character['competencias_trasfondo']); ?>x
    <?php echo htmlspecialchars($character['equipo_trasfondo']); ?>
    <p><strong>Class Features:</strong> <?php echo htmlspecialchars($character['clase_rasgos']); ?></p>
<p><strong>Race Features:</strong> <?php echo htmlspecialchars($character['raza_rasgos']); ?></p>
<p><strong>Background Features:</strong> <?php echo htmlspecialchars($character['trasfondo_rasgos']); ?></p>
  </p>
    
    Add more fields as needed
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/index.css">
    <link rel="stylesheet" href="/CSS/character_sheet.css">
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
                        <img class="imglogo" src="/images/5elogo.svg">
                    </a>
                    <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/HTML/index.php">Inicio</a>
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
        <label for="charname">Character Name</label>
        <input name="charname" placeholder="Character Name" value="<?php echo htmlspecialchars($character['nombre_personaje']); ?>"/>
    </section>
    <section class="misc">
      <ul>
        <li>
        <label for="class1">Class</label>
        <?php echo htmlspecialchars($character['nombre_clase']); ?>
        </li>
        <li>
        <label for="race">Race</label>
        <?php echo htmlspecialchars($character['nombre_raza']); ?>
        </li>
        <li>
        <label for="background">Background</label>
        <?php echo htmlspecialchars($character['nombre_trasfondo']); ?>
        </li>
        <li>
          <label for="playername">Player Name</label>
          <?php if (isset($_SESSION['username'])) : ?>
          <?php echo $_SESSION['username'];?>
          <?php else : ?>
          <?php endif; ?></i>
        </li>
      </ul>
      <p>Hover over this text to see the description: </p>

    </section>
  </header>
  <main>
    <section>
      <section class="attributes">
        <div class="scores">
          <ul>
            <li>
              <div class="score">
                <label for="Strengthscore">Strength</label><input name="Strengthscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Fuerza']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Strengthmod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($fuerzaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Dexterityscore">Dexterity</label><input name="Dexterityscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Destreza']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Dexteritymod" placeholder="+0" class=statmod value="<?php echo htmlspecialchars($destrezaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Constitutionscore">Constitution</label><input name="Constitutionscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Constitucion']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Constitutionmod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($constitucionM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Intelligencescore">Intelligence</label><input name="Intelligencescore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Inteligencia']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Intelligencemod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($inteligenciaM);?>"/>
              </div> 
            </li>
            <li>
              <div class="score">
                <label for="Wisdomscore">Wisdom</label><input name="Wisdomscore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Sabiduria']); ?>"/>
              </div>
              <div class="modifier">
                <input name="Wisdommod" placeholder="+0" class="statmod" value="<?php echo htmlspecialchars($sabiduriaM);?>"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Charismascore">Charisma</label><input name="Charismascore" placeholder="10" class="stat" value="<?php echo htmlspecialchars($character['Carisma']); ?>"/>
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
              <label for="inspiration">Inspiration</label>
            </div>
            <input name="inspiration" placeholder="" />
          </div>
          <div class="proficiencybonus box">
            <div class="label-container">
              <label for="proficiencybonus">Proficiency Bonus</label>
            </div>
            <input name="proficiencybonus" placeholder="+2"value="<?php echo htmlspecialchars($character['checkbox_attribute']); ?>"/>
          </div>
          <div class="saves list-section box">
            <ul>
              <li>
                <label for="Strength-save">Strength</label><input name="Strengthsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($fuerzaM);?>"/><input name="prof-fue" type="checkbox" class="prof" value="0"/>
              </li>
              <li>
                <label for="Dexterity-save">Dexterity</label><input name="Dexteritysave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($destrezaM);?>"/><input name="prof_des" type="checkbox" class="prof" <?php echo $checkbox_des ? 'checked' : ''; ?>/>
              </li>
              <li>
                <label for="Constitution-save">Constitution</label><input name="Constitutionsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($constitucionM);?>"/><input name="prof_con" type="checkbox" class="prof" value="2"/>
              </li>
              <li>
                <label for="Intelligence-save">Intelligence</label><input name="Intelligencesave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="prof_int" type="checkbox" class="prof" value="3"/>
              </li>
              <li>
                <label for="Wisdom-save">Wisdom</label><input name="Wisdomsave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($sabiduriaM);?>" /><input name="prof_sab" type="checkbox" class="prof" value="4"/>
              </li>
              <li>
                <label for="Charisma-save">Charisma</label><input name="Charismasave" placeholder="+0" type="text" class="statsave" value="<?php echo htmlspecialchars($carismaM);?>" /><input name="prof-car" type="checkbox" class="prof" value="5"/>
              </li>
            </ul>
            <!-- <?php echo htmlspecialchars($character['salvacion']); ?> -->
            <div class="label">
              Saving Throws
            </div>
          </div>
          <div class="skills list-section box">
            <ul>
              <li>
                <label for="Acrobatics">Acrobatics 
                  <span class="skill">(Dex)</span>
                </label>
                <input name="Acrobaticsskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM); ?>"/><input name="prof" type="checkbox" />
              </li>
              <li>
                <label for="Animal Handling">Animal Handling <span class="skill">(Wis)</span></label><input name="Animal-Handlingskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Animal-Handling-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Arcana">Arcana <span class="skill">(Int)</span></label><input name="Arcanaskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Arcana-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Athletics">Athletics <span class="skill">(Str)</span></label><input name="Athleticsskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($fuerzaM);?>"/><input name="Athletics-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Deception">Deception <span class="skill">(Cha)</span></label><input name="Deceptionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Deception-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="History">History <span class="skill">(Int)</span></label><input name="Historyskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="History-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Insight">Insight <span class="skill">(Wis)</span></label><input name="Insightskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Insight-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Intimidation">Intimidation <span class="skill">(Cha)</span></label><input name="Intimidationskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Intimidation-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Investigation">Investigation <span class="skill">(Int)</span></label><input name="Investigationskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Investigation-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Medicine">Medicine <span class="skill">(Wis)</span></label><input name="Medicineskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Medicine-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Nature">Nature <span class="skill">(Int)</span></label><input name="Natureskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Nature-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Perception">Perception <span class="skill">(Wis)</span></label><input name="Perceptionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Perception-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Performance">Performance <span class="skill">(Cha)</span></label><input name="Performanceskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Performance-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Persuasion">Persuasion <span class="skill">(Cha)</span></label><input name="Persuasionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($carismaM);?>"/><input name="Persuasion-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Religion">Religion <span class="skill">(Int)</span></label><input name="Religionskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($inteligenciaM);?>"/><input name="Religion-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Sleight of Hand">Sleight of Hand <span class="skill">(Dex)</span></label><input name="Sleight-of-Handskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM); ?>"/><input name="Sleight-of-Hand-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Stealth">Stealth <span class="skill">(Dex)</span></label><input name="Stealthskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($destrezaM);?>"/><input name="Stealth-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Survival">Survival <span class="skill">(Wis)</span></label><input name="Survivalskill" placeholder="+0" type="text" value="<?php echo htmlspecialchars($sabiduriaM);?>"/><input name="Survival-skill-prof" type="checkbox" />
              </li>
            </ul>
            <div class="label">
              Skills
            </div>
          </div>
        </div>
      </section>
    </section>
    <section>
      <section class="combat">
        <div class="armorclass">
          <div>
            <label for="ac">Armor Class</label><input name="ac" placeholder="10" type="text" />
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="initiative">Initiative</label><input name="Dexteritymod" placeholder="+0" type="text" />
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="speed">Speed</label><input name="speed" placeholder="30ft" type="text" value="<?php echo htmlspecialchars($character['velocidad']); ?>"/>
          </div>
        </div>

        <!-- Copy above format for HP -->
        <div class="armorclass">
          <div>
            <label for="currenthp">Current Hit Points</label><input name="currenthp" placeholder="10" type="text" value="<?php echo htmlspecialchars($character['dado_golpe']); ?>"/>
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="currenthp">Current Hit Points</label><input name="currenthp" placeholder="10" type="text" value="<?php echo htmlspecialchars($character['dado_golpe']); ?>"/>
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="temphp">Temporary Hit Points</label><input name="temphp" placeholder="0" type="text" />
          </div>
        </div>
        <div class="hitdice">
          <div>
            <div class="total">
              <label for="totalhd">Total</label><input name="totalhd" placeholder="_d__" type="text" />
            </div>
            <div class="remaining">
              <label for="remaininghd">Hit Dice</label><input name="remaininghd" type="text" />
            </div>
          </div>
        </div>
        <div class="deathsaves">
          <div>
            <div class="label">
              <label>Death Saves</label>
            </div>
            <div class="marks">
              <div class="deathsuccesses">
                <label>Successes</label>
                <div class="bubbles">
                  <input name="deathsuccess1" type="checkbox" />
                  <input name="deathsuccess2" type="checkbox" />
                  <input name="deathsuccess3" type="checkbox" />
                </div>
              </div>
              <div class="deathfails">
                <label>Failures</label>
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
          <label for="otherprofs">Other Proficiencies and Languages</label><textarea name="otherprofs">
- Competencias de Clase: <?php echo htmlspecialchars($character['competencias_clase']); ?>&nbsp;
- Competencias de Raza: <?php echo htmlspecialchars($character['competencias_raza']); ?>&nbsp;
- Competencias de Trasfondo: <?php echo htmlspecialchars($character['competencias_trasfondo']); ?>
          </textarea>
        </div>

    </section>
    <section>
      <section class="features">
        <div>
          <label for="features-r">Features, Traits, & Feats</label>
          <textarea name="features-r">
- Rasgos de Clase: <?php echo htmlspecialchars($character['clase_nombre_rasgo']); ?>: <?php echo htmlspecialchars($character['clase_descripcion_rasgo']); ?>&nbsp;

- Rasgos de Raza: <?php echo htmlspecialchars($character['raza_nombre_rasgo']); ?>: <?php echo htmlspecialchars($character['raza_descripcion_rasgo']); ?>&nbsp;

- Rasgos de Trasfondo: <?php echo htmlspecialchars($character['trasfondo_nombre_rasgo']); ?>: <?php echo htmlspecialchars($character['trasfondo_descripcion_rasgo']); ?>

          </textarea>
        </div>
      </section>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveperception">Passive Wisdom (Perception)</label>
        </div>
        <input name="passiveperception" placeholder="10" />
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinsight">Passive Wisdom (Insight)</label>
        </div>
        <input name="passiveinsight" placeholder="10" />
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinvestigation">Passive Intelligence (Investigation)</label>
        </div>
        <input name="passiveinvestigation" placeholder="10" />
      </div>
    </section>

  </main>

  <header>
      <section class="attacksandspellcasting" id="inventory">
          <div>
            <label>Inventory</label>
            <textarea name="inventorynotes" placeholder="Additional inventory notes">
- <?php echo htmlspecialchars($character['equipo_clase']); ?> 
- <?php echo htmlspecialchars($character['equipo_trasfondo']); ?>
            </textarea>
          </div>
      </section>
  </header>

  <header>
    <section class="attacksandspellcasting" id="spells">
      <div>
        <label>Spells</label>
        <textarea name="spellsnotes" placeholder="Additional spell notes"></textarea>
      </div>
    </section>
  </header>

  <main>
    <!-- Hidden fields for dynamic tables -->
    <input name="rows_attacks" type="hidden" value="2"/>
    <input name="rows_inventory" type="hidden" value="2"/>
    <input name="rows_spells" type="hidden" value="2"/>
  </main>

</form>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="/js/script.js"></script>
</body>
</html> 
