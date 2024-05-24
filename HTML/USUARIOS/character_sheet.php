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
    <link rel="stylesheet" href="/CSS/character_sheet.css">
    <link rel="stylesheet" href="/CSS/index.css">
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
                                <?php if (isset($username)) : ?>
                                <?php echo $username;?>
                                <?php else : ?>
                                <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <form class="charsheet" style="background-color:white">
            <header>
            <section class="charname">
                <label for="charname">Nombre Personaje</label><input name="charname"/>
            </section>
            <section class="misc">
                <ul>
                <li>
                    <label for="class">Clase</label>
                    <select name="class" onchange="updateData('class', this.value)">
                            <?php foreach ($claseOptions as $claseId => $claseNombre) { ?>
                                <option value="<?php echo $claseId; ?>"><?php echo $claseNombre; ?></option>
                            <?php } ?>
                    </select>
                </li>
                <li>
                    <label for="race">Raza</label>
                    <select name="race" onchange="updateData('race', this.value)">
                            <?php foreach ($razaOptions as $razaId => $razaNombre) { ?>
                                <option value="<?php echo $razaId; ?>"><?php echo $razaNombre; ?></option>
                            <?php } ?>
                    </select>
                </li>
                <li>
                    <label for="background">Trasfondo</label>
                    <select name="background" onchange="updateData('background', this.value)">
                            <?php foreach ($trasfondoOptions as $trasfondoId => $trasfondoNombre) { ?>
                                <option value="<?php echo $trasfondoId; ?>"><?php echo $trasfondoNombre; ?></option>
                            <?php } ?>
                    </select>
                </li>
                <li>
                    <label for="level">Nivel</label><input name="level"/>
                </li>
                <li>
                    <label for="playername">Nombre Jugador</label><input name="playername"/>
                </li>
                <li>
                    <label for="alignment">Alineamiento</label><input name="alignment"/>
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
                        <label for="Strengthscore">Fuerza</label><input name="Strengthscore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Strengthmod" placeholder="+0" />
                        </div>
                    </li>
                    <li>
                        <div class="score">
                        <label for="Dexterityscore">Destreza</label><input name="Dexterityscore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Dexteritymod" placeholder="+0" />
                        </div>
                    </li>
                    <li>
                        <div class="score">
                        <label for="Constitutionscore">Constitución</label><input name="Constitutionscore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Constitutionmod" placeholder="+0" />
                        </div>
                    </li>
                    <li>
                        <div class="score">
                        <label for="Wisdomscore">Sabiduría</label><input name="Wisdomscore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Wisdommod" placeholder="+0" />
                        </div>
                    </li>
                    <li>
                        <div class="score">
                        <label for="Intelligencescore">Inteligencia</label><input name="Intelligencescore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Intelligencemod" placeholder="+0" />
                        </div>
                    </li>
                    <li>
                        <div class="score">
                        <label for="Charismascore">Carisma</label><input name="Charismascore" placeholder="10" />
                        </div>
                        <div class="modifier">
                        <input name="Charismamod" placeholder="+0" />
                        </div>
                    </li>
                    </ul>
                </div>
                <div class="attr-applications">
                    <div class="inspiration box">
                    <div class="label-container">
                        <label for="inspiration">Inspiración</label>
                    </div>
                    <input name="inspiration" type="checkbox" />
                    </div>
                    <div class="proficiencybonus box">
                    <div class="label-container">
                        <label for="proficiencybonus">Bonus por competencia</label>
                    </div>
                    <input name="proficiencybonus" placeholder="+2" />
                    </div>
                    <div class="saves list-section box">
                    <ul>
                        <li>
                        <label for="Strength-save">Fuerza</label><input name="Strength-save" placeholder="+0" type="text" /><input name="Strength-save-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Dexterity-save">Destreza</label><input name="Dexterity-save" placeholder="+0" type="text" /><input name="Dexterity-save-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Constitution-save">Constitución</label><input name="Constitution-save" placeholder="+0" type="text" /><input name="Constitution-save-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Wisdom-save">Sabiduría</label><input name="Wisdom-save" placeholder="+0" type="text" /><input name="Wisdom-save-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Intelligence-save">Inteligencia</label><input name="Intelligence-save" placeholder="+0" type="text" /><input name="Intelligence-save-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Charisma-save">Carisma</label><input name="Charisma-save" placeholder="+0" type="text" /><input name="Charisma-save-prof" type="checkbox" />
                        </li>
                    </ul>
                    <div class="label">
                        Tiradas de Salvación
                    </div>
                    </div>
                    <div class="skills list-section box">
                    <ul>
                        <li>
                        <label for="Acrobatics">Acrobacia <span class="skill">(Des)</span></label><input name="Acrobatics" placeholder="+0" type="text" /><input name="Acrobatics-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Animal Handling">Trato con animales<span class="skill">(Sab)</span></label><input name="Animal Handling" placeholder="+0" type="text" /><input name="Animal Handling-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Arcana">Arcana<span class="skill">(Int)</span></label><input name="Arcana" placeholder="+0" type="text" /><input name="Arcana-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Athletics">Atletismo<span class="skill">(Fue)</span></label><input name="Athletics" placeholder="+0" type="text" /><input name="Athletics-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Deception">Engaño<span class="skill">(Car)</span></label><input name="Deception" placeholder="+0" type="text" /><input name="Deception-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="History">Historia<span class="skill">(Int)</span></label><input name="History" placeholder="+0" type="text" /><input name="History-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Insight">Perspicacia<span class="skill">(Sab)</span></label><input name="Insight" placeholder="+0" type="text" /><input name="Insight-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Intimidation">Intimidación<span class="skill">(Car)</span></label><input name="Intimidation" placeholder="+0" type="text" /><input name="Intimidation-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Investigation">Investigation <span class="skill">(Int)</span></label><input name="Investigation" placeholder="+0" type="text" /><input name="Investigation-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Medicine">Medicina <span class="skill">(Sab)</span></label><input name="Medicine" placeholder="+0" type="text" /><input name="Medicine-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Nature">Naturaleza <span class="skill">(Int)</span></label><input name="Nature" placeholder="+0" type="text" /><input name="Nature-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Perception">Percepción<span class="skill">(Sab)</span></label><input name="Perception" placeholder="+0" type="text" /><input name="Perception-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Performance">Interpretación<span class="skill">(Car)</span></label><input name="Performance" placeholder="+0" type="text" /><input name="Performance-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Persuasion">Persuasión<span class="skill">(Car)</span></label><input name="Persuasion" placeholder="+0" type="text" /><input name="Persuasion-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Religion">Religión<span class="skill">(Int)</span></label><input name="Religion" placeholder="+0" type="text" /><input name="Religion-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Sleight of Hand">Juego de Manos<span class="skill">(Des)</span></label><input name="Sleight of Hand" placeholder="+0" type="text" /><input name="Sleight of Hand-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Stealth">Sigilo<span class="skill">(Des)</span></label><input name="Stealth" placeholder="+0" type="text" /><input name="Stealth-prof" type="checkbox" />
                        </li>
                        <li>
                        <label for="Survival">Supervivencia<span class="skill">(Sab)</span></label><input name="Survival" placeholder="+0" type="text" /><input name="Survival-prof" type="checkbox" />
                        </li>
                    </ul>
                    <div class="label">
                        Habilidades
                    </div>
                    </div>
                </div>
                </section>
                <div class="passive-perception box">
                <div class="label-container">
                    <label for="passiveperception">Sabiduría Pasiva (Percepción)</label>
                </div>
                <input name="passiveperception" placeholder="10" />
                </div>
                <div class="otherprofs box textblock">
                <label for="otherprofs">Otras competencias e Idiomas</label><textarea name="otherprofs"></textarea>
                </div>
            </section>
            <section>
                <section class="combat">
                <div class="armorclass">
                    <div>
                    <label for="ac">Clase Armadura</label><input name="ac" placeholder="10" type="text" />
                    </div>
                </div>
                <div class="initiative">
                    <div>
                    <label for="initiative">Iniciativa</label><input name="initiative" placeholder="+0" type="text" />
                    </div>
                </div>
                <div class="speed">
                    <div>
                    <label for="speed">Velocidad</label><input name="speed" placeholder="30" type="text" />
                    </div>
                </div>
                <div class="hp">
                    <div class="regular">
                    <div class="max">
                        <label for="maxhp">Puntos de Vida Totales</label><input name="maxhp" placeholder="10" type="text" />
                    </div>
                    <div class="current">
                        <label for="currenthp">Puntos de Vida</label><input name="currenthp" type="text" />
                    </div>
                    </div>
                    <div class="temporary">
                    <label for="temphp">Puntos de Vida Temporales</label><input name="temphp" type="text" />
                    </div>
                </div>
                <div class="hitdice">
                    <div>
                    <div class="total">
                        <label for="totalhd">Total</label><input name="totalhd" placeholder="2d10" type="text" />
                    </div>
                    <div class="remaining">
                        <label for="remaininghd">Dado de Golpe</label><input name="remaininghd" type="text" />
                    </div>
                    </div>
                </div>
                <div class="deathsaves">
                    <div>
                    <div class="marks">
                        <div class="deathsuccesses">
                        <label>&nbsp;  Éxitos</label>
                        <div class="bubbles">
                            <input name="deathsuccess1" type="checkbox">
                            <input name="deathsuccess2" type="checkbox">
                            <input name="deathsuccess3" type="checkbox">
                        </div>
                        </div>
                        <div class="deathfails">
                        <label>&nbsp;  Fallos</label>
                        <div class="bubbles">
                            <input name="deathfail1" type="checkbox">
                            <input name="deathfail2" type="checkbox">
                            <input name="deathfail3" type="checkbox">
                        </div>
                        </div>
                    </div>
                    <div class="label">
                        <label>Tirada a Muerte</label>
                    </div>
                    </div>
                </div>
                </section>
                <section class="attacksandspellcasting">
                <div>
                    <label>Ataques & Lanzamiento de Conjuros</label>
                    <table>
                    <thead>
                        <tr>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Bonus Atq
                        </th>
                        <th>
                            Daño/Tipo
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>
                            <input name="atkname1" type="text" />
                        </td>
                        <td>
                            <input name="atkbonus1" type="text" />
                        </td>
                        <td>
                            <input name="atkdamage1" type="text" />
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <input name="atkname2" type="text" />
                        </td>
                        <td>
                            <input name="atkbonus2" type="text" />
                        </td>
                        <td>
                            <input name="atkdamage2" type="text" />
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <input name="atkname3" type="text" />
                        </td>
                        <td>
                            <input name="atkbonus3" type="text" />
                        </td>
                        <td>
                            <input name="atkdamage3" type="text" />
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    <textarea></textarea>
                </div>
                </section>
                <section class="equipment">
                <div>
                    <label>Equipo</label>
                    <div class="money">
                    <ul>
                        <li>
                        <label for="cp">mb</label><input name="cp" />
                        </li>
                        <li>
                        <label for="sp">mpa</label><input name="sp" />
                        </li>
                        <li>
                        <label for="ep">me</label><input name="ep" />
                        </li>
                        <li>
                        <label for="gp">mo</label><input name="gp" />
                        </li>
                        <li>
                        <label for="pp">mpo</label><input name="pp" />
                        </li>
                    </ul>
                    </div>
                    <textarea placeholder="Lista de equipo"></textarea>
                </div>
                </section>
            </section>
            <section>
                <section class="flavor">
                <div class="personality">
                    <label for="personality">Personalidad</label><textarea name="personality"></textarea>
                </div>
                <div class="ideals">
                    <label for="ideals">Ideales</label><textarea name="ideals"></textarea>
                </div>
                <div class="bonds">
                    <label for="bonds">Vínculos</label><textarea name="bonds"></textarea>
                </div>
                <div class="flaws">
                    <label for="flaws">Defectos</label><textarea name="flaws"></textarea>
                </div>
                </section>
                <section class="features">
                <div>
                    <label for="features">Características & Rasgos</label><textarea name="features"></textarea>
                </div>
                </section>
            </section>
            </main>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html> 