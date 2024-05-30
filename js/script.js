var rows_attacks = 2;
var rows_inventory = 2;
var rows_spells = 2;

function save_character() {
  var filename = ".dnd";
  if (document.getElementById('charname').value == "") {
    filename = "CharacterSheet" + filename;
  } else {
    filename = document.getElementById('charname').value + filename;
  }

  const formId = "charsheet";
  var url = location.href;
  const formIdentifier = `${url} ${formId}`;

  let form = document.querySelector(`#${formId}`);
  let formElements = form.elements;

  let data = { [formIdentifier]: {} };

  for (const element of formElements) {
    if (element.name.length > 0) {
      if (element.type == 'checkbox') {
        var checked = ($("[name='" + element.name + "']").prop("checked") ? 'checked' : 'unchecked');
        data[formIdentifier][element.name] = checked;
      } else {
        data[formIdentifier][element.name] = element.value;
      }
    }
  }

  data = JSON.stringify(data[formIdentifier], null, 2);
  type = 'application/json';

  var file = new Blob([data], {type: type});
  if (window.navigator.msSaveOrOpenBlob)
    window.navigator.msSaveOrOpenBlob(file, filename);
  else {
    var a = document.createElement("a"),
            url = URL.createObjectURL(file);

    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();

    setTimeout(function() {
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }, 0); 
  }
}

window.onbeforeunload = function(){
  if ($("[name='autosave']").prop("checked") == true) {
    save_character();
  }
}

function load_character(e) {
  if ($("[name='autosave']").prop("checked") == true) {
    save_character();
  }

  var file = e.target.files[0];
  if (!file) {
    return;
  }
  var reader = new FileReader();
  reader.onload = function(e) {
    var contents = e.target.result;

    var savedData = JSON.parse(contents);

    while (rows_attacks > parseInt(savedData.rows_attacks)) {
      remove_last_row('attacktable');
    }
    while (rows_attacks < parseInt(savedData.rows_attacks)) {
      add_attack();
    }
    while (rows_inventory > parseInt(savedData.rows_inventory)) {
      remove_last_row('inventorytable');
    }
    while (rows_inventory < parseInt(savedData.rows_inventory)) {
      add_inventory();
    }
    while (rows_spells > parseInt(savedData.rows_spells)) {
      remove_last_row('spelltable');
    }
    while (rows_spells < parseInt(savedData.rows_spells)) {
      add_spell();
    }

    const formId = "charsheet";
    var url = location.href;
    const formIdentifier = `${url} ${formId}`;
    let form = document.querySelector(`#${formId}`);
    let formElements = form.elements;

    savedData = JSON.parse(contents);
    for (const element of formElements) {
      if (element.name in savedData) {
        if (element.type == 'checkbox') {
          var checked = (savedData[element.name] == 'checked');
          $("[name='" + element.name + "']").prop("checked", checked);
        } else {
          element.value = savedData[element.name];
        }
      }
    }
  };
  reader.readAsText(file);
}

document.getElementById('buttonload').addEventListener('change', load_character, false);

function long_rest() {
  $("[name='currenthp']").val($("[name='maxhp']").val())
  $("[name='remaininghd']").val($("[name='totalhd']").val())

  $("[name='spellslots1']").val($("[name='spellslotsmax1']").val())
  $("[name='spellslots2']").val($("[name='spellslotsmax2']").val())
  $("[name='spellslots3']").val($("[name='spellslotsmax3']").val())
  $("[name='spellslots4']").val($("[name='spellslotsmax4']").val())
  $("[name='spellslots5']").val($("[name='spellslotsmax5']").val())
  $("[name='spellslots6']").val($("[name='spellslotsmax6']").val())
  $("[name='spellslots7']").val($("[name='spellslotsmax7']").val())
  $("[name='spellslots8']").val($("[name='spellslotsmax8']").val())
  $("[name='spellslots9']").val($("[name='spellslotsmax9']").val())

  $("[name='deathsuccess1']").prop("checked", false);
  $("[name='deathsuccess2']").prop("checked", false);
  $("[name='deathsuccess3']").prop("checked", false);
  $("[name='deathfail1']").prop("checked", false);
  $("[name='deathfail2']").prop("checked", false);
  $("[name='deathfail3']").prop("checked", false);

  alert("Hit points, hit dice, and spell slots have been refreshed.\n\nPlease remember to reset Limited Use abilities, temporary hit points, and other effects as needed.")
}

function add_attack() {
  var tableRef = document.getElementById('attacktable');

  var row = tableRef.insertRow(tableRef.rows.length);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);

  cell0.innerHTML = "<td><input name='atkname" + rows_attacks + "' type='text'/></td>";
  cell1.innerHTML = "<td><input name='atkbonus" + rows_attacks + "' type='text'/></td>";
  cell2.innerHTML = "<td><input name='atkdamage" + rows_attacks + "' type='text'/></td>";
  cell3.innerHTML = "<td colspan='2'><input name='atknotes" + rows_attacks + "' type='text'/></td>";

  rows_attacks += 1;
  $("[name='rows_attacks']").val(rows_attacks);
}

function add_spell() {
  var tableRef = document.getElementById('spelltable');

  var row = tableRef.insertRow(tableRef.rows.length);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  var cell4 = row.insertCell(4);
  var cell5 = row.insertCell(5);
  var cell6 = row.insertCell(6);
  var cell7 = row.insertCell(7);
  var cell8 = row.insertCell(8);
  var cell9 = row.insertCell(9);

  cell0.innerHTML = "<td><input name='spellprep" + rows_spells + "' type='checkbox' /></td>";
  cell1.innerHTML = "<td><input name='spellname" + rows_spells + "' type='text' /></td>";
  cell2.innerHTML = "<td><input name='spelllevel" + rows_spells + "' type='text' /></td>";
  cell3.innerHTML = "<td><input name='spellsource" + rows_spells + "' type='text' /></td>";
  cell4.innerHTML = "<td><input name='spellattacksave" + rows_spells + "' type='text' /></td>";
  cell5.innerHTML = "<td><input name='spelltime" + rows_spells + "' type='text' /></td>";
  cell6.innerHTML = "<td><input name='spellrange" + rows_spells + "' type='text' /></td>";
  cell7.innerHTML = "<td><input name='spellduration" + rows_spells + "' type='text' /></td>";
  cell8.innerHTML = "<td><input name='spellcomponents" + rows_spells + "' type='text' /></td>";
  cell9.innerHTML = "<td><input name='spellnotes" + rows_spells + "' type='text' /></td>";

  rows_spells += 1;
  $("[name='rows_spells']").val(rows_spells);
}

function add_inventory() {
  var tableRef = document.getElementById('inventorytable');

  var row = tableRef.insertRow(tableRef.rows.length);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  var cell4 = row.insertCell(4);
  var cell5 = row.insertCell(5);

  cell0.innerHTML = "<td><input name='itemequipped" + rows_inventory + "' type='checkbox' /></td>";
  cell1.innerHTML = "<td><input name='itemname" + rows_inventory + "' type='text' /></td>";
  cell2.innerHTML = "<td><input name='itemcount" + rows_inventory + "' type='text' onchange='calc_carry_weight()' /></td>";
  cell3.innerHTML = "<td><input name='itemweight" + rows_inventory + "' type='text' onchange='calc_carry_weight()' /></td>";
  cell4.innerHTML = "<td><input name='itemvalue" + rows_inventory + "' type='text' /></td>";
  cell5.innerHTML = "<td><input name='itemnotes" + rows_inventory + "' type='text' /></td>";

  rows_inventory += 1;
  $("[name='rows_inventory']").val(rows_inventory);
}

function remove_last_row(tableId) {
  var tableRef = document.getElementById(tableId);
  var rowCount = tableRef.rows.length;

  tableRef.deleteRow(rowCount - 1);

  switch(tableId) {
    case 'attacktable':
      rows_attacks -= 1;
      if (rows_attacks < 0) {
        rows_attacks = 0;
      }
      break;
    case 'attunementtable':
      rows_attunements -= 1;
      if (rows_attunements < 0) {
        rows_attunements = 0;
      }
      break;
    case 'inventorytable':
      rows_inventory -= 1;
      if (rows_inventory < 0) {
        rows_inventory = 0;
      }
      break;
    case 'spelltable':
      rows_spells -= 1;
      if (rows_spells < 0) {
        rows_spells = 0;
      }
      break;
  }

  $("[name='rows_attacks']").val(rows_attacks);
  $("[name='rows_attunements']").val(rows_attunements);
  $("[name='rows_inventory']").val(rows_inventory);
  $("[name='rows_spells']").val(rows_spells);
}







// Function to handle input changes and calculate the modifier
$('.stat').bind('input', function() {
  const inputName = $(this).attr('name');
  let mod = parseInt($(this).val()) - 10;
  mod = Math.floor(mod / 2); // Calculate modifier using floor division for both even and odd numbers
  mod = isNaN(mod) ? "" : (mod >= 0 ? "+" + mod : mod);

  const scoreName = inputName.slice(0, inputName.indexOf("score"));
  const modName = scoreName + "mod";
  const saveName = scoreName + "save";

  $("[name='" + modName + "']").val(mod);
  $("[name='" + saveName + "']").val(mod);
  updateSkills(scoreName, mod);
});

// Function to update skill modifiers based on corresponding stat modifiers
function updateSkills(attribute, mod) {
  const skills = {
      Strength: ["Athleticsskill"],
      Dexterity: ["Acrobaticsskill", "Sleight-of-Handskill", "Stealthskill"],
      Intelligence: ["Arcanaskill", "Historyskill", "Investigationskill", "Natureskill", "Religionskill"],
      Wisdom: ["Animal-Handlingskill", "Insightskill", "Medicineskill", "Perceptionskill", "Survivalskill"],
      Charisma: ["Deceptionskill", "Intimidationskill", "Performanceskill", "Persuasionskill"]
  };

  if (skills[attribute]) {
      skills[attribute].forEach(function(skill) {
          $("[name='" + skill + "']").val(mod);
      });
  }
}

// Function to handle changes in the stat mod inputs
$('.statmod').bind('change', function() {
  const name = $(this).attr('name');
  name = "uses" + name.slice(0, name.indexOf('mod'));
});

// Function to handle changes in the stat save inputs
$('.statsave').bind('change', function() {
  const name = $(this).attr('name');
  name = "uses" + name.slice(0, name.indexOf('save'));
});

// Function to handle checkbox changes
$('.prof').bind('change', function() {
  const checkboxName = $(this).attr('name');
  const saveName = checkboxName.slice(0, checkboxName.indexOf('-save-prof')) + 'save';
  const skillName = checkboxName.slice(0, checkboxName.indexOf('-skill-prof')) + 'skill';
  const saveInput = $("[name='" + saveName + "']");
  const skillInput = $("[name='" + skillName + "']");
  let currentSaveValue = parseInt(saveInput.val());
  let currentSkillValue = parseInt(skillInput.val());

  currentSaveValue = isNaN(currentSaveValue) ? 0 : currentSaveValue;
  currentSkillValue = isNaN(currentSkillValue) ? 0 : currentSkillValue;

  const adjustment = $(this).is(':checked') ? 2 : -2;

  currentSaveValue += adjustment;
  currentSkillValue += adjustment;

  saveInput.val((currentSaveValue >= 0 ? "+" : "") + currentSaveValue);
  skillInput.val((currentSkillValue >= 0 ? "+" : "") + currentSkillValue);
});


$("[name='class']").bind('input', function() {
  $("[name='proficiencybonus']").val("+2");
});




function updateClassData(response) {
  if (response.error) {
    console.error(response.error);
    return;
  }

  $('textarea[name="inventorynotes"]').val((i, val) => {
    // Limpiar la información antigua de clase
    val = val.replace(/Equipo de la clase: ([\s\S]*?)\./, '');
    // Añadir nueva información de clase
    return val + "\nEquipo de la clase: " + response.equipo_clase;
  });

  $('input[name="maxhp"]').val(response.dado_golpe);
  $('input[name="currenthp"]').val(response.dado_golpe);
  $('input[name="temphp"]').val(0);
  $('input[name="totalhd"]').val("1d" + response.dado_golpe);
  $('input[name="remaininghd"]').val("1d" + response.dado_golpe);

  $('textarea[name="otherprofs"]').val((i, val) => {
    // Limpiar la información antigua de competencias de clase
    val = val.replace(/Competencias de la clase: ([\s\S]*?)\./, '');
    // Añadir nueva información de competencias de clase
    return val + "Competencias de la clase: " + response.competencias_clase;
  });

  // Añadir armas de la clase
  if (response.armas) {
    $('textarea[name="inventorynotes"]').val((i, val) => {
      let armas = response.armas.map(a => a.nombre_arma).join(', ');
      return val + "\nArmas de la clase: " + armas;
    });
  }

  // Añadir armaduras de la clase
  if (response.armaduras) {
    $('textarea[name="inventorynotes"]').val((i, val) => {
      let armaduras = response.armaduras.map(a => a.nombre_armadura).join(', ');
      return val + "\nArmaduras de la clase: " + armaduras;
    });
  }

  // Añadir rasgos de la clase
  if (response.rasgos) {
    $('textarea[name="features-r"]').val((i, val) => {
      let rasgos = response.rasgos.map(r => r.nombre_rasgo + ": " + r.descripcion_rasgo).join('\n');
      return val + "\nRasgos de la clase:\n" + rasgos;
    });
  }

  // Añadir conjuros de la clase
  if (response.conjuros) {
    $('textarea[name="attacksnotes"]').val((i, val) => {
      let conjuros = response.conjuros.map(c => c.nombre_conjuro + ": " + c.descripcion_conjuro).join('\n');
      return val + "\nConjuros de la clase:\n" + conjuros;
    });
  }
}

function updateRaceData(response) {
  if (response.error) {
    console.error(response.error);
    return;
  }

  $('input[name="speed"]').val(response.velocidad);

  $('textarea[name="otherprofs"]').val((i, val) => {
    // Limpiar la información antigua de competencias de raza
    val = val.replace(/Competencias de la raza: ([\s\S]*?)\./, '');
    // Añadir nueva información de competencias de raza
    return val + "Competencias de la raza: " + response.competencias_raza;
  });

  // Añadir rasgos de la raza
  if (response.rasgos) {
    $('textarea[name="features-r"]').val((i, val) => {
      let rasgos = response.rasgos.map(r => r.nombre_rasgo + ": " + r.descripcion_rasgo).join('\n');
      return val + "\nRasgos de la raza:\n" + rasgos;
    });
  }

  // Añadir conjuros de la raza
  if (response.conjuros) {
    $('textarea[name="spells"]').val((i, val) => {
      let conjuros = response.conjuros.map(c => c.nombre_conjuro + ": " + c.descripcion_conjuro).join('\n');
      return val + "\nConjuros de la raza:\n" + conjuros;
    });
  }
}

function updateBackgroundData(response) {
  if (response.error) {
    console.error(response.error);
    return;
  }

  $('textarea[name="inventorynotes"]').val((i, val) => {
    // Limpiar la información antigua de equipo de trasfondo
    val = val.replace(/Equipo del trasfondo: ([\s\S]*?)\./, '');
    // Añadir nueva información de equipo de trasfondo
    return val + "\nEquipo del trasfondo: " + response.equipo_trasfondo;
  });

  $('textarea[name="otherprofs"]').val((i, val) => {
    // Limpiar la información antigua de competencias de trasfondo
    val = val.replace(/Competencias del trasfondo: ([\s\S]*?)\./, '');
    // Añadir nueva información de competencias de trasfondo
    return val + "\nCompetencias del trasfondo: " + response.competencias_trasfondo;
  });

  // Añadir rasgos del trasfondo
  if (response.rasgos) {
    $('textarea[name="features-r"]').val((i, val) => {
      let rasgos = response.rasgos.map(r => r.nombre_rasgo + ": " + r.descripcion_rasgo).join('\n');
      return val + "\nRasgos del trasfondo:\n" + rasgos;
    });
  }
}

// Función que actualiza la información y la coloca en la hoja
function updateData(field, value) {
  let action, dataKey, successCallback;

  switch (field) {
      case 'race':
          action = 'getRaceData';
          dataKey = 'raceId';
          successCallback = updateRaceData;
          break;
      case 'class':
          action = 'getClassData';
          dataKey = 'classId';
          successCallback = updateClassData;
          break;
      case 'background':
          action = 'getBackgroundData';
          dataKey = 'backgroundId';
          successCallback = updateBackgroundData;
          break;
  }

  $.ajax({
      url: 'database.php',
      method: 'POST',
      data: { action: action, [dataKey]: value },
      dataType: 'json',
      success: function(response) {
          successCallback(response);
      },
      error: function(xhr, status, error) {
          console.error(error);
      }
  });
}
