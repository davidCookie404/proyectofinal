<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // Si es así, se le asigna el nombre de usuario que haya introducido
    $username = $_SESSION['username'];
} else {
    // Si no es así, se redirige al usuario al URL correspondiente
    header("Location: /HTML/index.php");
    exit();
}
?>

<?php

include 'database.php';

// Conectar a la base de datos
$conn = connectToDatabase();

// Obtener opciones de la base de datos
$claseOptions = getOptionsFromDatabase($conn, "clase", "clase_id", "nombre_clase");
$trasfondoOptions = getOptionsFromDatabase($conn, "trasfondo", "trasfondo_id", "nombre_trasfondo");
$razaOptions = getOptionsFromDatabase($conn, "raza", "raza_id", "nombre_raza");

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Personaje - SØ</title>
    <link rel="stylesheet" href="/proyectofinal-main/CSS/index.css">
    <link rel="stylesheet" href="/proyectofinal-main/CSS/character_sheet.css">
    <link rel="icon" type="image/x-icon" href="/proyecyofinal-main/images/favicon.ico">
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
    <form class="charsheet" id="charsheet" action="updatecharacter.php" method="post">
  <header>
    <section class="charname">
      <label for="charname">Nombre del Personaje</label><input name="nombre0" id="charname" placeholder="Nombre PJ" />
    </section>
    <section class="misc">
      <ul>
        <li>
        <label for="class1">Clase</label>
                <select name="class0" id="" onchange="updateData('class', this.value)">
                    <option value="">-</option>
                        <?php foreach ($claseOptions as $claseId => $claseNombre) { ?>
                            <option value="<?php echo $claseId; ?>"><?php echo $claseNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="race">Raza</label>
                <select name="race0" id="" onchange="updateData('race', this.value)">
                    <option value="">-</option>
                        <?php foreach ($razaOptions as $razaId => $razaNombre) { ?>
                            <option value="<?php echo $razaId; ?>"><?php echo $razaNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="background">Trasfondo</label>
                <select name="bg0" id="" onchange="updateData('background', this.value)">
                    <option value="">-</option>
                        <?php foreach ($trasfondoOptions as $trasfondoId => $trasfondoNombre) { ?>
                            <option value="<?php echo $trasfondoId; ?>"><?php echo $trasfondoNombre; ?></option>
                        <?php } ?>
                </select>
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
  <main class="mb-3">
    <section>
      <section class="attributes">
        <div class="scores">
          <ul>
            <li>
              <div class="score">
                <label for="Strengthscore">Fuerza</label><input name="Strengthscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Strengthmod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Dexterityscore">Destreza</label><input name="Dexterityscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Dexteritymod" placeholder="+0" class=statmod/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Constitutionscore">Constitucion</label><input name="Constitutionscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Constitutionmod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Intelligencescore">Inteligencia</label><input name="Intelligencescore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Intelligencemod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Wisdomscore">Sabiduria</label><input name="Wisdomscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Wisdommod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Charismascore">Carisma</label><input name="Charismascore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Charismamod" placeholder="+0" class="statmod"/>
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
            <input name="proficiencybonus" value="+2" />
          </div>
          <div class="saves list-section box">
            <ul>
              <li>
                <label for="Strength-save">Fuerza</label><input name="Strengthsave" placeholder="+0" type="text" class="statsave"/><input name="Strength-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Dexterity-save">Destreza</label><input name="Dexteritysave" placeholder="+0" type="text" class="statsave"/><input name="Dexterity-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Constitution-save">Constitucion</label><input name="Constitutionsave" placeholder="+0" type="text" class="statsave"/><input name="Constitution-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Intelligence-save">Inteligencia</label><input name="Intelligencesave" placeholder="+0" type="text" class="statsave"/><input name="Intelligence-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Wisdom-save">Sabiduria</label><input name="Wisdomsave" placeholder="+0" type="text" class="statsave"/><input name="Wisdom-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Charisma-save">Carisma</label><input name="Charismasave" placeholder="+0" type="text" class="statsave"/><input name="Charisma-save-prof" type="checkbox" class="prof"/>
              </li>
            </ul>
            <div class="label">
              Tiradas Salvacion
            </div>
          </div>
          <div class="skills list-section box">
            <ul>
              <li>
                <label for="Acrobatics">Acrobacia <span class="skill">(Des)</span></label>
                <input name="Acrobaticsskill" placeholder="+0" type="text" />
                <input name="Acrobatics-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Animal Handling">Trato Animales <span class="skill">(Sab)</span></label>
                <input name="Animal-Handlingskill" placeholder="+0" type="text" />
                <input name="Animal-Handling-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Arcana">Arcana <span class="skill">(Int)</span></label>
                <input name="Arcanaskill" placeholder="+0" type="text" />
                <input name="Arcana-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Athletics">Atletismo <span class="skill">(Fue)</span></label>
                <input name="Athleticsskill" placeholder="+0" type="text" />
                <input name="Athletics-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Deception">Engaño <span class="skill">(Car)</span></label>
                <input name="Deceptionskill" placeholder="+0" type="text" />
                <input name="Deception-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="History">Historia <span class="skill">(Int)</span></label>
                <input name="Historyskill" placeholder="+0" type="text" />
                <input name="History-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Insight">Perspicacia <span class="skill">(Sab)</span></label>
                <input name="Insightskill" placeholder="+0" type="text" />
                <input name="Insight-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Intimidation">Intimidacion <span class="skill">(Car)</span></label>
                <input name="Intimidationskill" placeholder="+0" type="text" />
                <input name="Intimidation-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Investigation">Investigacion <span class="skill">(Int)</span></label>
                <input name="Investigationskill" placeholder="+0" type="text" />
                <input name="Investigation-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Medicine">Medicina <span class="skill">(Sab)</span></label>
                <input name="Medicineskill" placeholder="+0" type="text" />
                <input name="Medicine-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Nature">Naturaleza <span class="skill">(Int)</span></label>
                <input name="Natureskill" placeholder="+0" type="text" />
                <input name="Nature-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Perception">Percepcion <span class="skill">(Sab)</span></label>
                <input name="Perceptionskill" placeholder="+0" type="text" />
                <input name="Perception-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Performance">Interpretacion <span class="skill">(Car)</span></label>
                <input name="Performanceskill" placeholder="+0" type="text" />
                <input name="Performance-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Persuasion">Persuasion <span class="skill">(Car)</span></label>
                <input name="Persuasionskill" placeholder="+0" type="text" />
                <input name="Persuasion-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Religion">Religion <span class="skill">(Int)</span></label>
                <input name="Religionskill" placeholder="+0" type="text" />
                <input name="Religion-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Sleight of Hand">Juego de Manos <span class="skill">(Des)</span></label>
                <input name="Sleight-of-Handskill" placeholder="+0" type="text" />
                <input name="Sleight-of-Hand-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Stealth">Sigilo <span class="skill">(Des)</span></label>
                <input name="Stealthskill" placeholder="+0" type="text" />
                <input name="Stealth-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Survival">Supervivencia <span class="skill">(Sab)</span></label>
                <input name="Survivalskill" placeholder="+0" type="text" />
                <input name="Survival-skill-prof" type="checkbox" class="prof"/>
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
            <label for="ac">Clase Armadura</label><input name="ac" placeholder="10" type="text" />
            <input type="hidden" name="baseac" value="0">
          </div>
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="initiative">Iniciativa</label><input name="Dexteritymod" placeholder="+0" type="text" />
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="speed">Velocidad</label><input name="speed" placeholder="30ft" type="text" />
          </div>
        </div>

        <div class="armorclass">
          <div>
            <label for="currenthp">Puntos de Golpe Actuales</label><input name="currenthp" placeholder="10" type="text" />
            <input type="hidden" name="basehp" value="0">
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="maxhp">Puntos de Golpe Máximos</label><input name="maxhp" placeholder="10" type="text" />
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="temphp">Puntos de Golpe Temp.</label><input name="temphp" placeholder="0" type="text" />
          </div>
        </div>
        <div class="hitdice">
          <div>
            <div class="total">
              <label for="totalhd">Total</label><input name="totalhd" placeholder="_d__" type="text" />
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
          <label for="otherprofs">Otras Competencias e Idiomas</label><textarea name="otherprofs"></textarea>
        </div>

    </section>
    <section>
      <section class="features">
        <div>
          <label for="features-r">Rasgos y Atributos</label><textarea name="features-r"></textarea>
        </div>
      </section>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveperception">Percepción Pasiva (Sabiduría)</label>
        </div>
        <input name="passiveperception" placeholder="10" />
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinsight">Perspicacia Pasiva (Sabiduría)</label>
        </div>
        <input name="passiveinsight" placeholder="10" />
      </div>
      <div class="passive-perception box">
        <div class="label-container">
          <label for="passiveinvestigation">Investigación Pasiva (Inteligencia)</label>
        </div>
        <input name="passiveinvestigation" placeholder="10" />
      </div>
    </section>

  </main>

  <header>
      <section class="attacksandspellcasting" id="inventory">
          <div>
            <label>Inventario</label>
            <textarea name="inventorynotes" placeholder=""></textarea>
          </div>
      </section>
  </header>

  <header class="mb-3">
    <section class="attacksandspellcasting" id="spells">
      <div>
        <label>Conjuros</label>
        <textarea name="spellsnotes" placeholder=""></textarea>
      </div>
    </section>
  </header>

<header>
  <section>
    <button name="buttonsave" type="submit" value="save" style="width:100px;margin-bottom:5px;margin-right:30px;">Guardar Personaje</button>
    <a class="d-flex align-items-end text-muted" id="buttonload" style="width:100px;margin-bottom:5px;margin-right:30px;text-decoration:none;" href="profile.php">Cargar Personaje</a>
</section>
</header>

  <main>
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
    <script src="/proyectofinal-main/js/script.js"></script>
</body>
</html>
