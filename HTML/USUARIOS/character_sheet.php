<?php

include 'database.php';

// Conectar a la base de datos
$conn = connectToDatabase();

// Obtener opciones de la base de datos
$claseOptions = getOptionsFromDatabase($conn, "clase", "clase_id", "nombre_clase");
$razaOptions = getOptionsFromDatabase($conn, "raza", "raza_id", "nombre_raza");
$trasfondoOptions = getOptionsFromDatabase($conn, "trasfondo", "trasfondo_id", "nombre_trasfondo");

// Cerrar la conexion
$conn->close();

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Character Sheet</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<form class="charsheet" id="charsheet">
  <header>
    <section class="charname">
      <label for="charname">Character Name</label><input name="charname" id="charname" placeholder="Character Name" />
    </section>
    <section class="misc">
      <ul>
        <li>
        <label for="class">Class</label>
                <select name="class" onchange="updateData('class', this.value)">
                    <option value="">-</option>
                        <?php foreach ($claseOptions as $claseId => $claseNombre) { ?>
                            <option value="<?php echo $claseId; ?>"><?php echo $claseNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="race">Race</label>
                <select name="race" onchange="updateData('race', this.value)">
                    <option value="">-</option>
                        <?php foreach ($razaOptions as $razaId => $razaNombre) { ?>
                            <option value="<?php echo $razaId; ?>"><?php echo $razaNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
        <label for="background">Background</label>
                <select name="background" onchange="updateData('background', this.value)">
                    <option value="">-</option>
                        <?php foreach ($trasfondoOptions as $trasfondoId => $trasfondoNombre) { ?>
                            <option value="<?php echo $trasfondoId; ?>"><?php echo $trasfondoNombre; ?></option>
                        <?php } ?>
                </select>
        </li>
        <li>
          <label for="playername">Player Name</label><input name="playername" placeholder="Player Name">
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
            <input name="proficiencybonus" placeholder="+2" />
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
                <label for="Acrobatics">Acrobatics <span class="skill">(Dex)</span></label><input name="Acrobaticsskill" placeholder="+0" type="text" /><input name="Acrobatics-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Animal Handling">Animal Handling <span class="skill">(Wis)</span></label><input name="Animal-Handlingskill" placeholder="+0" type="text" /><input name="Animal-Handling-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Arcana">Arcana <span class="skill">(Int)</span></label><input name="Arcanaskill" placeholder="+0" type="text" /><input name="Arcana-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Athletics">Athletics <span class="skill">(Str)</span></label><input name="Athleticsskill" placeholder="+0" type="text" /><input name="Athletics-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Deception">Deception <span class="skill">(Cha)</span></label><input name="Deceptionskill" placeholder="+0" type="text" /><input name="Deception-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="History">History <span class="skill">(Int)</span></label><input name="Historyskill" placeholder="+0" type="text" /><input name="History-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Insight">Insight <span class="skill">(Wis)</span></label><input name="Insightskill" placeholder="+0" type="text" /><input name="Insight-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Intimidation">Intimidation <span class="skill">(Cha)</span></label><input name="Intimidationskill" placeholder="+0" type="text" /><input name="Intimidation-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Investigation">Investigation <span class="skill">(Int)</span></label><input name="Investigationskill" placeholder="+0" type="text" /><input name="Investigation-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Medicine">Medicine <span class="skill">(Wis)</span></label><input name="Medicineskill" placeholder="+0" type="text" /><input name="Medicine-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Nature">Nature <span class="skill">(Int)</span></label><input name="Natureskill" placeholder="+0" type="text" /><input name="Nature-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Perception">Perception <span class="skill">(Wis)</span></label><input name="Perceptionskill" placeholder="+0" type="text" /><input name="Perception-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Performance">Performance <span class="skill">(Cha)</span></label><input name="Performanceskill" placeholder="+0" type="text" /><input name="Performance-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Persuasion">Persuasion <span class="skill">(Cha)</span></label><input name="Persuasionskill" placeholder="+0" type="text" /><input name="Persuasion-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Religion">Religion <span class="skill">(Int)</span></label><input name="Religionskill" placeholder="+0" type="text" /><input name="Religion-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Sleight of Hand">Sleight of Hand <span class="skill">(Dex)</span></label><input name="Sleight-of-Handskill" placeholder="+0" type="text" /><input name="Sleight-of-Hand-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Stealth">Stealth <span class="skill">(Dex)</span></label><input name="Stealthskill" placeholder="+0" type="text" /><input name="Stealth-skill-prof" type="checkbox" />
              </li>
              <li>
                <label for="Survival">Survival <span class="skill">(Wis)</span></label><input name="Survivalskill" placeholder="+0" type="text" /><input name="Survival-skill-prof" type="checkbox" />
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
            <label for="speed">Speed</label><input name="speed" placeholder="30ft" type="text" />
          </div>
        </div>

        <!-- Copy above format for HP -->
        <div class="armorclass">
          <div>
            <label for="currenthp">Current Hit Points</label><input name="currenthp" placeholder="10" type="text" />
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
      <section class="attacksandspellcasting">
          <div>
            <label>Attacks & Spellcasting</label>
            <table>
              <thead>
                <tr>
                  <th>
                    Name
                  </th>
                  <th>
                    Attack Bonus
                  </th>
                  <th>
                    Damage/Type
                  </th>
                  <th colspan="2">
                    Notes
                  </th>
                </tr>
              </thead>
              <tbody id="attacktable">
                <tr>
                  <td>
                    <input name="atkname0" type="text" />
                  </td>
                  <td>
                    <input name="atkbonus0" type="text" />
                  </td>
                  <td>
                    <input name="atkdamage0" type="text" />
                  </td>
                  <td colspan="2">
                    <input name="atknotes0" type="text" />
                  </td>
                </tr>
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
                  <td colspan="2">
                    <input name="atknotes1" type="text" />
                  </td>
                </tr>
              </tbody>
            </table>
            <span>
              <button name="button-addattack" type="button" onclick="add_attack()" style="width:20%;">Add New Attack</button>
              <button name="button-removeattack" type="button" onclick="remove_last_row('attacktable')" style="width:20%;">Remove Attack</button>
            </span>
            <textarea name="attacksnotes"></textarea>
          </div>
      </section>
  </header>

  <header>
    <section class="attacksandspellcasting" id="spellslots">
      <div>
        <label>Spell Slots</label>
        <table>
          <thead>
            <tr>
              <th>Level</th>
              <th>1</th>
              <th>2</th>
              <th>3</th>
              <th>4</th>
              <th>5</th>
              <th>6</th>
              <th>7</th>
              <th>8</th>
              <th>9</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Available</td>
              <td><input name="spellslots1" type="text" placeholder=""/></td>
              <td><input name="spellslots2" type="text" placeholder=""/></td>
              <td><input name="spellslots3" type="text" placeholder=""/></td>
              <td><input name="spellslots4" type="text" placeholder=""/></td>
              <td><input name="spellslots5" type="text" placeholder=""/></td>
              <td><input name="spellslots6" type="text" placeholder=""/></td>
              <td><input name="spellslots7" type="text" placeholder=""/></td>
              <td><input name="spellslots8" type="text" placeholder=""/></td>
              <td><input name="spellslots9" type="text" placeholder=""/></td>
            </tr>
            <tr>
              <td>Maximum</td>
              <td><input name="spellslotsmax1" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax2" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax3" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax4" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax5" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax6" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax7" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax8" type="text" placeholder="0"/></td>
              <td><input name="spellslotsmax9" type="text" placeholder="0"/></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </header>

  <header>
    <section class="attacksandspellcasting" id="spells">
      <div>
        <label>Spell List</label>
        <table>
          <thead>
            <tr>
              <th>
                Prepared
              </th>
              <th>
                Name
              </th>
              <th>
                Level
              </th>
              <th>
                Source
              </th>
              <th>
                Attack/Save
              </th>
              <th>
                Cast Time
              </th>
              <th>
                Range/Shape
              </th>
              <th>
                Duration
              </th>
              <th>
                Components
              </th>
              <th>
                Notes
              </th>
            </tr>
          </thead>
          <tbody id="spelltable">
            <tr>
              <td>
                <input name="spellprep1" type="checkbox" />
              </td>
              <td>
                <input name="spellname0" type="text" />
              </td>
              <td>
                <input name="spelllevel0" type="text" />
              </td>
              <td>
                <input name="spellsource0" type="text" />
              </td>
              <td>
                <input name="spellattacksave0" type="text" />
              </td>
              <td>
                <input name="spelltime0" type="text" />
              </td>
              <td>
                <input name="spellrange0" type="text" />
              </td>
              <td>
                <input name="spellduration0" type="text" />
              </td>
              <td>
                <input name="spellcomponents0" type="text" />
              </td>
              <td>
                <input name="spellnotes0" type="text" />
              </td>
            </tr>
            <tr>
              <td>
                <input name="spellprep1" type="checkbox" />
              </td>
              <td>
                <input name="spellname1" type="text" />
              </td>
              <td>
                <input name="spelllevel1" type="text" />
              </td>
              <td>
                <input name="spellsource1" type="text" />
              </td>
              <td>
                <input name="spellattacksave1" type="text" />
              </td>
              <td>
                <input name="spelltime1" type="text" />
              </td>
              <td>
                <input name="spellrange1" type="text" />
              </td>
              <td>
                <input name="spellduration1" type="text" />
              </td>
              <td>
                <input name="spellcomponents1" type="text" />
              </td>
              <td>
                <input name="spellnotes1" type="text" />
              </td>
            </tr>
          </tbody>
        </table>
        <span>
          <button name="button-addspell" type="button" onclick="add_spell()" style="width:20%;">Add New Spell</button>
          <button name="button-removespell" type="button" onclick="remove_last_row('spelltable')" style="width:20%;">Remove Spell</button>
        </span>
        <textarea name="spellsnotes" placeholder="Additional spell notes"></textarea>
      </div>
    </section>
  </header>

  <header>
      <section class="attacksandspellcasting" id="inventory">
          <div>
            <label>Inventory</label>
            <table>
              <thead>
                <tr>
                  <th>
                    Equipped
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Count
                  </th>
                  <th>
                    Weight
                  </th>
                  <th>
                    Value
                  </th>
                  <th>
                    Notes
                  </th>
                </tr>
              </thead>
              <tbody id="inventorytable">
                <tr>
                  <td>
                    <input name="itemequipped0" type="checkbox" />
                  </td>
                  <td>
                    <input name="itemname0" type="text" />
                  </td>
                  <td>
                    <input name="itemcount0" type="text" onchange="calc_carry_weight()" />
                  </td>
                  <td>
                    <input name="itemweight0" type="text" onchange="calc_carry_weight()" />
                  </td>
                  <td>
                    <input name="itemvalue0" type="text" />
                  </td>
                  <td>
                    <input name="itemnotes0" type="text" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name="itemequipped1" type="checkbox" />
                  </td>
                  <td>
                    <input name="itemname1" type="text" />
                  </td>
                  <td>
                    <input name="itemcount1" type="text" onchange="calc_carry_weight()" />
                  </td>
                  <td>
                    <input name="itemweight1" type="text" onchange="calc_carry_weight()" />
                  </td>
                  <td>
                    <input name="itemvalue1" type="text" />
                  </td>
                  <td>
                    <input name="itemnotes1" type="text" />
                  </td>
                </tr>
              </tbody>
            </table>
            <span>
              <button name="button-additem" type="button" onclick="add_inventory()" style="width:20%;">Add New Item</button>
              <button name="button-removeitem" type="button" onclick="remove_last_row('inventorytable');calc_carry_weight();" style="width:20%;">Remove Item</button>
            </span>
            <textarea name="inventorynotes" placeholder="Additional inventory notes"></textarea>
          </div>
      </section>
  </header>

<header>
  <section>
    <button name="buttonsave" type="button" onclick="save_character()" style="width:100px;margin-bottom:5px;margin-right:30px;">Save Character</button>
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
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <script  src="./script.js"></script>

</body>
</html>
