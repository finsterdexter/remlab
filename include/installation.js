var http = getHTTPObject();
var dF;
var d;
var isWorking = false;

function handleHttpResponse() {
	dF = document.form;
	d = document;
	if (http.readyState == 4 || http.readyState == 'complete') {
		if (http.responseText.indexOf('invalid') == -1) {
			disableForm(0);
			results = http.responseText.split('||');
			d.getElementById('txtTonsRemaining').innerHTML = results[0];
			dF.Tons.value = results[0];
			dF.TotalTons.value = results[1];
			d.getElementById('txtClass').innerHTML = results[2];
			d.getElementById('txtArmorTonnage').innerHTML = results[3];
			d.getElementById('txtTonsAvailable').innerHTML = results[4];
			d.getElementById('txtListWeapons').innerHTML = results[5];
			dF.MaxDamage.value = results[6];
			d.getElementById('txtMaxDamage').innerHTML = results[6];
			dF.TotalCost.value = results[7];
			d.getElementById('txtTotalCost').innerHTML = results[7];
			dF.TotalBV.value = results[8];
			d.getElementById('txtTotalBV').innerHTML = results[8];
			dF.ArmorTotal.value = results[9];
			d.getElementById('txtArmorTotal').innerHTML = results[9];
			dF.ArmorB.value = results[10];
			d.getElementById('txtMaxB').innerHTML = results[11];
			d.getElementById('txtArmorMax').innerHTML = results[11];
			d.getElementById('txtDamagePerTon').innerHTML = results[12];
			dF.NumWeapons.value = results[13];
			d.getElementById('txtBaseCrew').innerHTML = results[14];
			dF.BaseCrew.value = results[14];
			d.getElementById('txtListEquipment').innerHTML = results[15];
			d.getElementById('txtATonsAvailable').innerHTML = results[16];
			d.getElementById('txtATonsRemaining').innerHTML = results[17];
			dF.AmmoTons.value = results[17];
			dF.HeatSinks.value = results[18];
			dF.PowerAmp.value = results[19];

			d.getElementById('txtTonsRemaining').style.color = '#000';
			d.getElementById('txtATonsRemaining').style.color = '#000';

			checkLegal();

			d.getElementById('Processing').innerHTML = '';
			isWorking = false;
		}
	} else {
			disableForm(1);
			d.getElementById('Processing').innerHTML = '<img src="resources/progbar.gif"><br>Calculating...';
	}
}

function Calc() {
	dF = document.form;
	d = document;
	if (dF.Tech.value == 2 && dF.Level.value == 1) {
		dF.Level.value = 2;
		changeLevel();
	}
	if (dF.Tech.value == 2) {
		d.getElementById('ISWeapons').style.display = 'none';
		d.getElementById('ClanWeapons').style.display = 'block';
	} else {
		d.getElementById('ClanWeapons').style.display = 'none';
		d.getElementById('ISWeapons').style.display = 'block';
	}
	
	if (dF.TonnageInput.value) {
		if (dF.TonnageInput.value > 150) {
			dF.TonnageInput.value = 150;
			var Tonnage = 150;
		} else {
			var Tonnage = dF.TonnageInput.value;
		}
	} else {
		var Tonnage = dF.Tonnage.value;
	}
	if (Tonnage > 90 && dF.Mods.value == 1) {
		alert("Standard buildings cannot exceed 90 CF.");
		Tonnage = 90;
		dF.Tonnage.value = 90;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 75 && dF.Mods.value == 2) {
		alert("Hangars cannot exceed 75 CF.");
		Tonnage = 75;
		dF.Tonnage.value = 75;
		dF.TonnageInput.value = null;
	}
	if (dF.Mods.value > 0) {
		dF.Turret.checked = 0;
	}
	if (dF.Mods.value > 2) {
		dF.Door.checked = 0;
		dF.Basement.value = 0;
		dF.Levels.value = 1;
	}
	if (dF.Turret.checked) {
		dF.Turret.value = 1;
	} else {
		dF.Turret.value = 0;	
	}
	if (!isWorking && http) {
		var url = "include/calculate.install.php";
		var vars = "Tonnage=" + Tonnage +
			"&Level=" + dF.Level.value +
			"&Tech=" + dF.Tech.value +
			"&Mods=" + dF.Mods.value +
			"&Levels=" + dF.Levels.value +
			"&Basement=" + dF.Basement.value +
			"&Hexes=" + dF.Hexes.value +
			"&Turret=" + dF.Turret.value +
			"&Door=" + dF.Door.value +
			"&DoorLevels=" + dF.DoorLevels.value +
			"&ArmorB=" + dF.ArmorB.value +
			"&ArmorPercent=" + dF.ArmorPercent.value +
			"&Turret=" + dF.Turret.value +
 			calcWeapons();
		http.open('post', url, true);
		http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length",vars.length);
		http.setRequestHeader("Connection","close");
		http.onreadystatechange = handleHttpResponse;
		isWorking = true;
		http.send(vars);
	}
	if (!http) {
		alert("Your browser is not supported by REMLAB.");
	}
}

function changeLevel() {
	var dF = document.form;

	if (dF.Tech.value == 2) {
		dF.Race.value = 1;
		raceSkills();
	} else {
		dF.Race.value = 0;
		raceSkills();
	}

	getElementByClass('L12', 'table-row');
	getElementByClass('L22', 'none');
	getElementByClass('L23', 'none');
	getElementByClass('L24', 'none');
	getElementByClass('L25', 'none');
	getElementByClass('L33', 'none');
	getElementByClass('L34', 'none');
	getElementByClass('L35', 'none');

	if (dF.Edition.value == 5) {
		getElementByClass('L22', 'table-row');
		getElementByClass('L23', 'table-row');
		getElementByClass('L24', 'table-row');
		getElementByClass('L25', 'table-row');
		if (dF.Level.value > 2) {
			getElementByClass('L32', 'table-row');
			getElementByClass('L33', 'table-row');
			getElementByClass('L34', 'table-row');
			getElementByClass('L35', 'table-row');		
		}
	} else if (dF.Edition.value == 4) {
		getElementByClass('L22', 'table-row');
		getElementByClass('L23', 'table-row');
		getElementByClass('L24', 'table-row');
		if (dF.Level.value > 2) {
			getElementByClass('L32', 'table-row');
			getElementByClass('L33', 'table-row');
			getElementByClass('L34', 'table-row');		
		}
	} else if (dF.Edition.value == 3) {
		getElementByClass('L22', 'table-row');
		getElementByClass('L23', 'table-row');
		if (dF.Level.value > 2) {
			getElementByClass('L32', 'table-row');
			getElementByClass('L33', 'table-row');	
		}
	} else if (dF.Edition.value == 2) {
		getElementByClass('L22', 'table-row');
		if (dF.Level.value > 2) {
			getElementByClass('L32', 'table-row');	
		}
	}
	
	Calc();
}

function checkCrits() {
	dF = document.form;
	var i = 0;
	var loc;
	var TurretTons = 0;
	var TotalTons = dF.TotalTons.value;
	displayLoc();

	while (i < dF.NumWeapons.value) {
		loc = dF['Location' + i].value;
		if (loc != 1) dF[loc + 'Crits'].value++;
		if (loc == 'Turret') {
			TurretTons = roundToHalf((parseInt(dF.TurretTons.value) + parseInt(dF['ItemTons' + i].value)) * 0.1);
			TotalTons -= TurretTons;
			document.getElementById('txtTonsRemaining').innerHTML = TotalTons;
			document.getElementById('txtTurret').innerHTML = TurretTons;
		}
		i++;
	}
	checkLegal();
}

function roundToHalf(value) {
   var converted = parseFloat(value);
   var decimal = (converted - parseInt(converted, 10));
   decimal = Math.round(decimal * 10);
   if (decimal == 5) return (parseInt(converted, 10) + 0.5);
   if ((decimal < 3) || (decimal > 7)) {
      return Math.round(converted) + '.0';
   } else {
      return (parseInt(converted, 10) + 0.5);
   }
}

function displayLoc() {
	dF = document.form;
	dF.NorthCrits.value = 0;
	dF.EastCrits.value = 0;
	dF.WestCrits.value = 0;
	dF.TurretCrits.value = 0;
}

function clearArmor() {
	dF = document.form;
	dF.ArmorB.value = 0;
	dF.ArmorPercent.value = 0;
	Calc();
}

function checkLegal() {
	dF = document.form;
	if (!weaponsAllocated() || lessThanZero(dF.TotalTons.value) || lessThanZero(dF.Tons.value) || lessThanZero(dF.AmmoTons.value)) { 
		dF.bRS.disabled = 1;
		dF.bTR.disabled = 1;
		dF.bXML.disabled = 1;
		if (dF.Tons.value < 0) document.getElementById('txtTonsRemaining').style.color = '#D00';
		if (dF.AmmoTons.value < 0) document.getElementById('txtATonsRemaining').style.color = '#D00';
	} else {
		dF.bRS.disabled = 0;
		dF.bTR.disabled = 0;
		dF.bXML.disabled = 0;
	}
}