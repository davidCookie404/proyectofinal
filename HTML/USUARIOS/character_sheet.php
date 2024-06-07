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
    <form class="charsheet" id="charsheet" action="updatecharacter.php" method="post">
  <header>
    <section class="charname">
      <label for="charname">Character Name</label><input name="nombre0" id="charname" placeholder="Character Name" />
    </section>
    <section class="misc">
      <ul>
        <li>
        <label for="class1">Class</label>
                <select name="class0" id="" onchange="updateData('class', this.value)">
                    <option value="">-</option>
                        <?php foreach ($claseOptions as $claseId => $claseNombre) { ?>
                            <option value="<?php echo $claseId; ?>"><?php echo $claseNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="race">Race</label>
                <select name="race0" id="" onchange="updateData('race', this.value)">
                    <option value="">-</option>
                        <?php foreach ($razaOptions as $razaId => $razaNombre) { ?>
                            <option value="<?php echo $razaId; ?>"><?php echo $razaNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="background">Background</label>
                <select name="bg0" id="" onchange="updateData('background', this.value)">
                    <option value="">-</option>
                        <?php foreach ($trasfondoOptions as $trasfondoId => $trasfondoNombre) { ?>
                            <option value="<?php echo $trasfondoId; ?>"><?php echo $trasfondoNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
          <label for="playername">Player Name</label>
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
                <label for="Strengthscore">Strength</label><input name="Strengthscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Strengthmod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Dexterityscore">Dexterity</label><input name="Dexterityscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Dexteritymod" placeholder="+0" class=statmod/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Constitutionscore">Constitution</label><input name="Constitutionscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Constitutionmod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Intelligencescore">Intelligence</label><input name="Intelligencescore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Intelligencemod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Wisdomscore">Wisdom</label><input name="Wisdomscore" placeholder="10" class="stat"/>
              </div>
              <div class="modifier">
                <input name="Wisdommod" placeholder="+0" class="statmod"/>
              </div>
            </li>
            <li>
              <div class="score">
                <label for="Charismascore">Charisma</label><input name="Charismascore" placeholder="10" class="stat"/>
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
              <label for="inspiration">Inspiration</label>
            </div>
            <input name="inspiration" placeholder="" />
          </div>
          <div class="proficiencybonus box">
            <div class="label-container">
              <label for="proficiencybonus">Proficiency Bonus</label>
            </div>
            <input name="proficiencybonus" value="+2" />
          </div>
          <div class="saves list-section box">
            <ul>
              <li>
                <label for="Strength-save">Strength</label><input name="Strengthsave" placeholder="+0" type="text" class="statsave"/><input name="Strength-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Dexterity-save">Dexterity</label><input name="Dexteritysave" placeholder="+0" type="text" class="statsave"/><input name="Dexterity-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Constitution-save">Constitution</label><input name="Constitutionsave" placeholder="+0" type="text" class="statsave"/><input name="Constitution-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Intelligence-save">Intelligence</label><input name="Intelligencesave" placeholder="+0" type="text" class="statsave"/><input name="Intelligence-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Wisdom-save">Wisdom</label><input name="Wisdomsave" placeholder="+0" type="text" class="statsave"/><input name="Wisdom-save-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Charisma-save">Charisma</label><input name="Charismasave" placeholder="+0" type="text" class="statsave"/><input name="Charisma-save-prof" type="checkbox" class="prof"/>
              </li>
            </ul>
            <div class="label">
              Saving Throws
            </div>
          </div>
          <div class="skills list-section box">
            <ul>
              <li>
                <label for="Acrobatics">Acrobatics <span class="skill">(Dex)</span></label>
                <input name="Acrobaticsskill" placeholder="+0" type="text" />
                <input name="Acrobatics-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Animal Handling">Animal Handling <span class="skill">(Wis)</span></label>
                <input name="Animal-Handlingskill" placeholder="+0" type="text" />
                <input name="Animal-Handling-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Arcana">Arcana <span class="skill">(Int)</span></label>
                <input name="Arcanaskill" placeholder="+0" type="text" />
                <input name="Arcana-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Athletics">Athletics <span class="skill">(Str)</span></label>
                <input name="Athleticsskill" placeholder="+0" type="text" />
                <input name="Athletics-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Deception">Deception <span class="skill">(Cha)</span></label>
                <input name="Deceptionskill" placeholder="+0" type="text" />
                <input name="Deception-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="History">History <span class="skill">(Int)</span></label>
                <input name="Historyskill" placeholder="+0" type="text" />
                <input name="History-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Insight">Insight <span class="skill">(Wis)</span></label>
                <input name="Insightskill" placeholder="+0" type="text" />
                <input name="Insight-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Intimidation">Intimidation <span class="skill">(Cha)</span></label>
                <input name="Intimidationskill" placeholder="+0" type="text" />
                <input name="Intimidation-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Investigation">Investigation <span class="skill">(Int)</span></label>
                <input name="Investigationskill" placeholder="+0" type="text" />
                <input name="Investigation-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Medicine">Medicine <span class="skill">(Wis)</span></label>
                <input name="Medicineskill" placeholder="+0" type="text" />
                <input name="Medicine-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Nature">Nature <span class="skill">(Int)</span></label>
                <input name="Natureskill" placeholder="+0" type="text" />
                <input name="Nature-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Perception">Perception <span class="skill">(Wis)</span></label>
                <input name="Perceptionskill" placeholder="+0" type="text" />
                <input name="Perception-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Performance">Performance <span class="skill">(Cha)</span></label>
                <input name="Performanceskill" placeholder="+0" type="text" />
                <input name="Performance-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Persuasion">Persuasion <span class="skill">(Cha)</span></label>
                <input name="Persuasionskill" placeholder="+0" type="text" />
                <input name="Persuasion-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Religion">Religion <span class="skill">(Int)</span></label>
                <input name="Religionskill" placeholder="+0" type="text" />
                <input name="Religion-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Sleight of Hand">Sleight of Hand <span class="skill">(Dex)</span></label>
                <input name="Sleight-of-Handskill" placeholder="+0" type="text" />
                <input name="Sleight-of-Hand-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Stealth">Stealth <span class="skill">(Dex)</span></label>
                <input name="Stealthskill" placeholder="+0" type="text" />
                <input name="Stealth-skill-prof" type="checkbox" class="prof"/>
              </li>
              <li>
                <label for="Survival">Survival <span class="skill">(Wis)</span></label>
                <input name="Survivalskill" placeholder="+0" type="text" />
                <input name="Survival-skill-prof" type="checkbox" class="prof"/>
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
            <input type="hidden" name="baseac" value="0">
          </div>
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="initiative">Initiative</label><input name="Dexteritymod" placeholder="+0" type="text" />
          </div>
        </div>
        <div class="speed">
          <div>
            <label for="speed">Speed</label><input name="speed" placeholder="30ft" type="text" />
          </div>
        </div>

        <!-- Copy above format for HP -->
        <div class="armorclass">
          <div>
            <label for="currenthp">Current Hit Points</label><input name="currenthp" placeholder="10" type="text" />
            <input type="hidden" name="basehp" value="0">
          </div>
        </div>
        <div class="initiative">
          <div>
            <label for="maxhp">Hit Point Maximum</label><input name="maxhp" placeholder="10" type="text" />
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
          <label for="otherprofs">Other Proficiencies and Languages</label><textarea name="otherprofs"></textarea>
        </div>

    </section>
    <section>
      <section class="features">
        <div>
          <label for="features-r">Features, Traits, & Feats</label><textarea name="features-r"></textarea>
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
            <textarea name="inventorynotes" placeholder="Additional inventory notes"></textarea>
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

<header>
  <section>
    <button name="buttonsave" type="submit" value="save" onclick="save_character()" style="width:100px;margin-bottom:5px;margin-right:30px;">Save Character</button>
    <label for="buttonload" id="loadlabel" style="text-transform:Capitalize;">Load Character</label><input name="buttonload" id="buttonload" type="file" style="width:200px;margin-bottom:5px;" />
    <button name="buttonrest" type="button" onclick="long_rest()" style="width:100px;margin-bottom:5px;margin-left:30px;">Long Rest</button>
    <label for="autosave" style="text-transform:Capitalize;font-weight:bold;padding:0px 10px;">Autosave?</label><input name="autosave" id="autosave" type="checkbox" />
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
    <script src="/proyectofinal-main/js/script.js"></script>
</body>
</html>
