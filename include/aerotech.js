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
			dF.Tons.value = results[2];
			d.getElementById('txtTonnage').innerHTML = results[3];
			d.getElementById('txtRunning').innerHTML = results[4];
			d.getElementById('txtClass').innerHTML = results[5];
			d.getElementById('txtArmorTonnage').innerHTML = results[6];
			d.getElementById('txtCritsRemaining').innerHTML = results[7];
			dF.Crits.value = results[7];
			d.getElementById('txtCrits').innerHTML = results[8];
			d.getElementById('txtSpecialMovement').innerHTML = results[9];
			d.getElementById('txtListWeapons').innerHTML = results[10];
			dF.MaxDamage.value = results[11];
			d.getElementById('txtMaxDamage').innerHTML = results[11];
			dF.TotalCost.value = results[12];
			d.getElementById('txtTotalCost').innerHTML = results[12];
			dF.TotalBV.value = results[13];
			d.getElementById('txtTotalBV').innerHTML = results[13];
			dF.ArmorTotal.value = results[14];
			d.getElementById('txtArmorTotal').innerHTML = results[14];
			d.getElementById('txtHeatSinks').innerHTML = results[15];
			d.getElementById('txtHeatDisapated').innerHTML = results[16];
			d.getElementById('txtMaxHeat').innerHTML = results[17];
			dF.MaxHeat.value = results[17];
			dF.ArmorN.value = results[18];
			dF.ArmorLW.value = results[19];
			dF.ArmorRW.value = results[20];
			dF.ArmorA.value = results[21];
			d.getElementById('txtDamagePerTon').innerHTML = results[22];
			dF.NumWeapons.value = results[23];
			d.getElementById('txtTargetingTonnage').innerHTML = results[24];
			d.getElementById('txtBaseCrew').innerHTML = results[25];
			dF.BaseCrew.value = results[25];
			dF.Crew.value = results[26];
			d.getElementById('txtCrewTons').innerHTML = results[27];
			d.getElementById('txtListEquipment').innerHTML = results[28];
			d.getElementById('txtCargo').innerHTML = results[29];
			d.getElementById('txtFuel').innerHTML = results[30];
			dF.NCritsMax.value = results[31];
			dF.LWCritsMax.value = results[32];
			dF.RWCritsMax.value = results[33];
			dF.ACritsMax.value = results[34];
			dF.ControlEquip.value = results[35];
			dF.StructuralIntegrity.value = results[36];
			d.getElementById('txtSI').innerHTML = results[37];
			d.getElementById('txtPassengers').innerHTML = results[38];
			d.getElementById('txtLifeboat').innerHTML = results[39];
			d.getElementById('txtArmorMax').innerHTML = results[40];
			dF.Gunners.value = results[41];
			d.getElementById('txtGunnerTons').innerHTML = results[42];
			checkCrits();
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
	if (dF.Tonnage.value > 100 && dF.Mods.value == 0) {
		alert("AeroSpace fighters cannot exceed 100 tons.");
		dF.Tonnage.value = 100;
	}
	if (dF.Tonnage.value > 50 && dF.Mods.value == 1) {
		alert("Conventional fighter cannot exceed 50 tons.");
		dF.Tonnage.value = 50;
	}
	if (dF.Tonnage.value < 100 && dF.Mods.value == 2) {
		alert("Small Crafts cannot weigh less than 100 tons.");
		dF.Tonnage.value = 100;
	}
	if (dF.Tonnage.value < 100 && dF.Mods.value == 3) {
		alert("Small Crafts cannot weigh less than 100 tons.");
		dF.Tonnage.value = 100;
	}
	var RunMP = Math.round(dF.Walking.value * 1.5);
	if (RunMP < 10) RunMP = '0' + RunMP;
	if ((dF.Walking.value * dF.Tonnage.value) > 400 && dF.Mods.value < 2) {
		alert("Engine Rating cannot exceed 400.");
		dF.Walking.value = '03';
	}
	if (dF.Lifeboat.checked) {
		dF.Lifeboat.value = 1;
	} else {
		dF.Lifeboat.value = 0;	
	}
	if (!isWorking && http) {
		var url = "include/calculate.aerotech.php";
		var vars = "Tonnage=" + dF.Tonnage.value +
			"&Level=" + dF.Level.value +
			"&Tech=" + dF.Tech.value +
			"&Mods=" + dF.Mods.value +
			"&Engine=" + dF.Engine.value +
			"&Walking=" + dF.Walking.value +
			"&Armor=" + dF.Armor.value +
			"&ArmorN=" + dF.ArmorN.value +
			"&ArmorLW=" + dF.ArmorLW.value +
			"&ArmorRW=" + dF.ArmorRW.value +
			"&ArmorA=" + dF.ArmorA.value +
			"&ArmorTotal=" + dF.ArmorTotal.value +
			"&ArmorPercent=" + dF.ArmorPercent.value +
			"&HSType=" + dF.HSType.value +
			"&HeatSinks=" + dF.HeatSinks.value +
			"&Targeting=" + dF.Targeting.value +
			"&Crew=" + dF.Crew.value +
			"&Passengers=" + dF.Passengers.value +
			"&Lifeboat=" + dF.Lifeboat.value +
			"&Fuel=" + dF.Fuel.value +
			"&CargoSpace=" + dF.CargoSpace.value +
 			"&AdvanceMP=" + dF.AdvanceMP.value +
 			"&StructuralIntegrity=" + dF.StructuralIntegrity.value +
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
	removeOpt('Armor',0);
	removeOpt('AdvanceMP',0);
	removeOpt('Targeting',0);
	removeOpt('Fuel',0);
	removeOpt('HSType',0);
	removeOpt('Abilities',0);
	
	if (dF.Mods.value == 1) {
		addOpt('Engine','Turbine',8);
		for (var f=1;f<10;f++) addOpt('Fuel',f*160,f);
	} else {
		for (var f=1;f<40;f++) addOpt('Fuel',f*80,f);	
	}
	addOpt('AdvanceMP','VSTOL',1);
	if (dF.Edition.value > 2) {
		if (dF.Mods.value == 0) addOpt('Engine','Fusion XL',1);
		addOpt('Armor','Ferro-Aluminum',1);
		addOpt('Targeting','Targeting Computer',1);
		addOpt('HSType','Double',1);
	}
	if (dF.Edition.value == 5 && dF.Tech.value == 1) {
		if (dF.Mods.value == 0) { 
			addOpt('Engine','Light',6);
			addOpt('Engine','Compact',7);
		}
		addOpt('Armor','Light Ferro-Aluminum',5);
		addOpt('Armor','Heavy Ferro-Aluminum',6);
	}
 	if (dF.Level.value > 2 && dF.Edition.value > 2) {
 		if (dF.Mods.value == 0) addOpt('Engine','Fusion XXL',2);
 		addOpt('Armor','Laser-Reflective',3);
 		addOpt('Armor','Reactive',4);
 		addOpt('Targeting','Long-Range',2);
 		addOpt('Targeting','Short-Range',3);
 		addOpt('Targeting','Variable-Range',4);
 		addOpt('Targeting','Multi-Trac',6);
 		addOpt('Targeting','Multi-Trac II',7);
 		addOpt('Abilities','Bulls-Eye Marksman',1);
		addOpt('Abilities','Edge',3);
		addOpt('Abilities','Maneuvering Ace',4);
		addOpt('Abilities','Sixth Sense',7);
		addOpt('Abilities','Speed Demon',8);
		addOpt('Abilities','Tactical Genius',9);
		addOpt('Abilities','Weapon Specialist',10);
	}
	Calc();
}

function checkCrits() {
	dF = document.form;
	var i = 0;
	var loc;
	displayLoc();
	while (i < dF.NumWeapons.value) {
		loc = dF['Location' + i].value;
		if (loc != 1) dF[loc + 'Crits'].value--;
		i++;
	}
	checkLegal();
}

function displayLoc() {
	dF = document.form;
	dF.NoseCrits.value = dF.NCritsMax.value;
	dF.LeftCrits.value = dF.LWCritsMax.value;
	dF.RightCrits.value = dF.RWCritsMax.value;
	dF.AftCrits.value = dF.ACritsMax.value;
}

function clearArmor() {
	dF = document.form;
	dF.ArmorN.value = 0;
	dF.ArmorLW.value = 0;
	dF.ArmorRW.value = 0;
	dF.ArmorA.value = 0;
	dF.ArmorPercent.value = 0;
	Calc();
}

function checkLegal() {
	dF = document.form;
	if (!weaponsAllocated() || lessThanZero(dF.Tons.value) || lessThanZero(dF.Crits.value) || lessThanZero(dF.NoseCrits.value) || lessThanZero(dF.LeftCrits.value) || lessThanZero(dF.RightCrits.value) || lessThanZero(dF.AftCrits.value)) { 
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

function hardPoints() {
	dF = document.form;
	hP = dF.Tonnage.value / 5;

	for (var j = 1; j < 21; j++) {
		document.getElementById('HPTitle').style.display = 'none';
		document.getElementById('Hardpoints').style.display = 'none';
		//dF['Hardpoint'+j].style.display = 'none';
		for (i = dF['Hardpoint'+j].length; i > 0; i--) dF['Hardpoint'+j].remove(i);
	}

	if (dF.Mods.value < 2) {
		document.getElementById('HPTitle').style.display = 'block';
		document.getElementById('Hardpoints').style.display = 'block';
		for (var h = 1; h <= hP; h++) {
			dF['Hardpoint'+h].style.display = 'block';
		}
		for (var i = 1; i < 21; i++) {
			addOpt('Hardpoint'+i,'High Explosive',1);
			addOpt('Hardpoint'+i,'Inferno',2);
			addOpt('Hardpoint'+i,'Cluster',3);
			addOpt('Hardpoint'+i,'Laser Guided',4);
			addOpt('Hardpoint'+i,'Rocket Launcher',5);
			addOpt('Hardpoint'+i,'Mine',6);
			addOpt('Hardpoint'+i,'Arrow IV',7);
			addOpt('Hardpoint'+i,'TAG',8);
			addOpt('Hardpoint'+i,'Fuel Pod',9);
		}
	}
}