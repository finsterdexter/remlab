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
			d.getElementById('txtEngine').innerHTML = results[0];
			dF.EngineRating.value = results[0];
			d.getElementById('txtEngineTonnage').innerHTML = results[1];
			d.getElementById('txtTonsRemaining').innerHTML = results[2];
			dF.TotalTons.value = results[2];
			d.getElementById('txtTonnage').innerHTML = results[3];
			d.getElementById('txtRunning').innerHTML = results[4];
			d.getElementById('txtClass').innerHTML = results[5];
			d.getElementById('txtArmorTonnage').innerHTML = results[6];
			d.getElementById('txtCritsRemaining').innerHTML = results[7];
			d.getElementById('txtCrits').innerHTML = results[8];
			d.getElementById('txtSpecialMovement').innerHTML = results[9];
			d.getElementById('txtListWeapons').innerHTML = results[10];
			dF.MaxDamage.value = results[11];
			d.getElementById('txtMaxDamage').innerHTML = results[11];
			dF.HeatSinks.value = results[12];
			dF.TotalCost.value = results[13];
			d.getElementById('txtTotalCost').innerHTML = results[13];
			dF.TotalBV.value = results[14];
			d.getElementById('txtTotalBV').innerHTML = results[14];
			dF.ArmorTotal.value = results[15];
			d.getElementById('txtArmorTotal').innerHTML = results[15];
			d.getElementById('txtHeatSinks').innerHTML = results[16];
			dF.ArmorF.value = results[17];
			dF.ArmorLS.value = results[18];
			dF.ArmorRS.value = results[19];
			dF.ArmorR.value = results[20];
			dF.ArmorT.value = results[21];
			d.getElementById('txtDamagePerTon').innerHTML = results[22];
			dF.NumWeapons.value = results[23];
			d.getElementById('txtTargetingTonnage').innerHTML = results[24];
			d.getElementById('txtBaseCrew').innerHTML = results[25];
			dF.BaseCrew.value = results[25];
			dF.Crew.value = results[26];
			d.getElementById('txtCrewTons').innerHTML = results[27];
			d.getElementById('txtPowerAmp').innerHTML = results[28];
			dF.PowerAmp.value = results[28];
			d.getElementById('txtListEquipment').innerHTML = results[29];
			d.getElementById('txtCargo').innerHTML = results[30];
			dF.LiftEquip.value = results[31];
			dF.ControlEquip.value = results[32];
			d.getElementById('txtSpFront').innerHTML = results[33];
			d.getElementById('txtSpTop').innerHTML = results[34];
			d.getElementById('txtSpRear').innerHTML = results[35];
			d.getElementById('txtSpSides').innerHTML = results[36];

			d.getElementById('txtTonsRemaining').style.color = '#000';
			d.getElementById('txtCritsRemaining').style.color = '#000';

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
		var Tonnage = dF.TonnageInput.value;
	} else {
		var Tonnage = dF.Tonnage.value;
	}
	if (Tonnage > 100 && dF.Mods.value == 0) {
		alert("Tracked vehicles cannot exceed 100 tons.");
		Tonnage = 100;
		dF.Tonnage.value = 100;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 80 && dF.Mods.value == 1) {
		alert("Wheeled vehicles cannot exceed 80 tons.");
		Tonnage = 80;
		dF.Tonnage.value = 80;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 50 && dF.Mods.value == 2) {
		alert("Hovercrafts cannot exceed 50 tons.");
		Tonnage = 50;
		dF.Tonnage.value = 50;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 80 && dF.Mods.value == 3) {
		alert("WiGE vehicles cannot exceed 80 tons.");
		Tonnage = 80;
		dF.Tonnage.value = 80;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 300 && dF.Mods.value == 4) {
		alert("Displacement Hull vessels cannot exceed 300 tons.");
		Tonnage = 300;
		dF.TonnageInput.value = 300;
	}
	if (Tonnage > 300 && dF.Mods.value == 5) {
		alert("Submarines cannot exceed 300 tons.");
		Tonnage = 300;
		dF.TonnageInput.value = 300;
	}
	if (Tonnage > 100 && dF.Mods.value == 6) {
		alert("Hydrofoils cannot exceed 100 tons.");
		Tonnage = 100;
		dF.Tonnage.value = 100;
		dF.TonnageInput.value = null;
	}
	if (Tonnage > 30 && dF.Mods.value == 7) {
		alert("VTOLs cannot exceed 30 tons.");
		Tonnage = 30;
		dF.Tonnage.value = 30;
		dF.TonnageInput.value = null;
	}
	if (dF.SpTop.value == 1 || dF.Mods.value == 7) {
		dF.ArmorT.readOnly = false;
	} else {
		dF.ArmorT.readOnly = true;
		dF.ArmorT.value = 0;
	}
	var RunMP = Math.round(dF.Walking.value * 1.5);
	if (RunMP < 10) RunMP = '0' + RunMP;
	if ((dF.Walking.value * Tonnage) > 400) {
		alert("Engine Rating cannot exceed 400.");
		dF.Walking.value = '01';
	}
	if (!isWorking && http) {
		var url = "include/calculate.vehicle.php";
		var vars = "Tonnage=" + Tonnage +
			"&Level=" + dF.Level.value +
			"&Tech=" + dF.Tech.value +
			"&Mods=" + dF.Mods.value +
			"&Engine=" + dF.Engine.value +
			"&Armor=" + dF.Armor.value +
			"&Walking=" + dF.Walking.value +
			"&ArmorF=" + dF.ArmorF.value +
			"&ArmorLS=" + dF.ArmorLS.value +
			"&ArmorRS=" + dF.ArmorRS.value +
			"&ArmorR=" + dF.ArmorR.value +
			"&ArmorT=" + dF.ArmorT.value +
			"&ArmorTotal=" + dF.ArmorTotal.value +
			"&ArmorPercent=" + dF.ArmorPercent.value +
			"&HeatSinks=" + dF.HeatSinks.value +
			"&Targeting=" + dF.Targeting.value +
			"&Crew=" + dF.Crew.value +
			"&CargoSpace=" + dF.CargoSpace.value +
			"&SpTop=" + dF.SpTop.value +
			"&SpFront=" + dF.SpFront.value +
			"&SpSides=" + dF.SpSides.value +
			"&SpRear=" + dF.SpRear.value +
 			"&AdvanceMP=" + dF.AdvanceMP.value +
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

	removeOpt('Engine',0);
	removeOpt('SpFront',0);
	removeOpt('SpTop',0);
	removeOpt('SpSides',0);
	removeOpt('SpRear',0);
	removeOpt('Armor',0);
	removeOpt('AdvanceMP',0);
	removeOpt('Targeting',0);
	removeOpt('Abilities',0);

	addOpt('Engine','Fusion',0);
	if (dF.Mods.value != 7) {
		addOpt('SpTop','Turret',1);
	}
	if (dF.Mods.value == 7) {
		addOpt('SpFront','Sensors',3);
		addOpt('SpFront','Recon Camera',4);
	}
	if (dF.Mods.value < 2) addOpt('SpFront','Bulldozer',1);
	if (dF.Mods.value < 3) {
		addOpt('SpTop','Bridge Layer (light)',2);
		addOpt('SpTop','Bridge Layer (medium)',3);
		addOpt('SpTop','Bridge Layer (heavy)',4);
		addOpt('SpRear','Coolant System',1);
		addOpt('SpRear','MASH Unit (small)',2);
		addOpt('SpRear','MASH Unit (large)',3);
		addOpt('SpRear','Mobile HQ (small)',4);
		addOpt('SpRear','Mobile HQ (large)',5);
	 	addOpt('SpFront','Minesweeper',2);
	}
	if (dF.Edition.value > 2) {
		addOpt('Engine','Fusion XL',1);
		addOpt('Armor','Ferro-Fibrous',1);
		addOpt('Targeting','Targeting Computer',1);
		if (dF.Mods.value < 2) {
			addOpt('AdvanceMP','Amphibious',1);
			addOpt('AdvanceMP','Snowmobile',2);
		}
		if (dF.Mods.value == 1) {
			addOpt('AdvanceMP','Dune Buggy',3);
		}
	}
	if (dF.Edition.value == 5) {
		if (dF.Tech.value == 1) {
			addOpt('Engine','Light',6);
			addOpt('Engine','Compact',7);
			addOpt('Armor','Light Ferro-Fibrous',5);
			addOpt('Armor','Heavy Ferro-Fibrous',6);
		}
	}
 	if (dF.Level.value > 2 && dF.Edition.value > 2) {
		addOpt('Engine','Fusion XXL',2);
		addOpt('Engine','Fuel Cell',9);
		addOpt('Engine','Fission',10);
		addOpt('Armor','Laser-Reflective',3);
		addOpt('Armor','Reactive',4);
		addOpt('Targeting','Long-Range',2);
		addOpt('Targeting','Short-Range',3);
		addOpt('Targeting','Variable-Range',4);
		addOpt('Targeting','Anti-Aircraft',5);
		addOpt('Targeting','Multi-Trac',6);
 		addOpt('Targeting','Multi-Trac II',7);
		addOpt('Abilities','Bulls-Eye Marksman',1);
		addOpt('Abilities','Edge',3);
		addOpt('Abilities','Maneuvering Ace',4);
		addOpt('Abilities','Sixth Sense',7);
		addOpt('Abilities','Speed Demon',8);
		addOpt('Abilities','Tactical Genius',9);
		addOpt('Abilities','Weapon Specialist',10);
  		if (dF.Mods.value < 4) addOpt('AdvanceMP','Supercharger',4);
 		if (dF.Mods.value == 7) {
			addOpt('SpTop','Mast-Mount',5);
			addOpt('SpRear','Jet Boosters',6);
			addOpt('AdvanceMP','Dual Rotors',5);
			addOpt('AdvanceMP','Co-Axial Rotors',6);
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
			document.getElementById('txtSpTop').innerHTML = TurretTons;
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
	dF.FrontCrits.value = 0;
	dF.LeftCrits.value = 0;
	dF.RightCrits.value = 0;
	dF.RearCrits.value = 0;
	dF.TurretCrits.value = 0;
	dF.BodyCrits.value = 0;
}

function clearArmor() {
	dF = document.form;
	dF.ArmorF.value = 0;
	dF.ArmorLS.value = 0;
	dF.ArmorRS.value = 0;
	dF.ArmorR.value = 0;
	dF.ArmorT.value = 0;
	dF.ArmorPercent.value = 0;
	Calc();
}

function checkLegal() {
	dF = document.form;
	if (!weaponsAllocated() || lessThanZero(dF.TotalTons.value) || lessThanZero(dF.Tons.value) || lessThanZero(dF.Crits.value) || lessThanZero(dF.FrontCrits.value) || lessThanZero(dF.LeftCrits.value) || lessThanZero(dF.RightCrits.value) || lessThanZero(dF.RearCrits.value) || lessThanZero(dF.TurretCrits.value) || lessThanZero(dF.BodyCrits.value)) { 
		dF.bRS.disabled = 1;
		dF.bTR.disabled = 1;
		dF.bXML.disabled = 1;
		if (dF.Tons.value < 0) document.getElementById('txtTonsRemaining').style.color = '#D00';
		if (dF.Crits.value < 0) document.getElementById('txtCritsRemaining').style.color = '#D00';
	} else {
		dF.bRS.disabled = 0;
		dF.bTR.disabled = 0;
		dF.bXML.disabled = 0;
	}
}