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
			d.getElementById('txtTonnage').innerHTML = results[3];
			d.getElementById('txtRunning').innerHTML = results[4];
			d.getElementById('txtClass').innerHTML = results[5];
			d.getElementById('txtJumpJets').innerHTML = results[6];
			d.getElementById('txtGyroTonnage').innerHTML = results[7];
			d.getElementById('txtISTonnage').innerHTML = results[8];
			d.getElementById('txtArmorTonnage').innerHTML = results[9];
			d.getElementById('txtCritsRemaining').innerHTML = results[11];
			d.getElementById('txtCrits').innerHTML = results[12];
			d.getElementById('txtSpecialMovement').innerHTML = results[13];
			d.getElementById('txtMaxC').innerHTML = results[14];
			d.getElementById('txtMaxLT').innerHTML = results[15];
			d.getElementById('txtMaxRT').innerHTML = results[15];
			d.getElementById('txtMaxLA').innerHTML = results[16];
			d.getElementById('txtMaxRA').innerHTML = results[16];
			d.getElementById('txtMaxLL').innerHTML = results[17];
			d.getElementById('txtMaxRL').innerHTML = results[17];
			d.getElementById('txtListWeapons').innerHTML = results[18];
			dF.MaxDamage.value = results[19];
			d.getElementById('txtMaxDamage').innerHTML = results[19];
			dF.MaxHeat.value = results[20];
			d.getElementById('txtMaxHeat').innerHTML = results[20];
			dF.TotalCost.value = results[21];
			d.getElementById('txtTotalCost').innerHTML = results[21];
			dF.TotalBV.value = results[22];
			d.getElementById('txtTotalBV').innerHTML = results[22];
			dF.ArmorTotal.value = results[23];
			d.getElementById('txtArmorTotal').innerHTML = results[23];
			d.getElementById('txtArmorMax').innerHTML = results[24];
			d.getElementById('txtHeatSinks').innerHTML = results[25];
			d.getElementById('txtHeatDisapated').innerHTML = results[26];
			dF.ArmorHead.value = results[27];
			dF.ArmorCT.value = results[28];
			dF.ArmorCTR.value = results[29];
			dF.ArmorLT.value = results[30];
			dF.ArmorLTR.value = results[31];
			dF.ArmorRT.value = results[32];
			dF.ArmorRTR.value = results[33];
			dF.ArmorLA.value = results[34];
			dF.ArmorRA.value = results[35];
			dF.ArmorLL.value = results[36];
			dF.ArmorRL.value = results[37];
			d.getElementById('txtListEquipment').innerHTML = results[38];
			d.getElementById('txtListHeatSinks').innerHTML = results[39];
			d.getElementById('txtDamagePerTon').innerHTML = results[40];
			dF.HCritsMax.value = results[41];
			dF.CTCritsMax.value = results[42];
			dF.LTCritsMax.value = results[43];
			dF.RTCritsMax.value = results[44];
			dF.LACritsMax.value = results[45];
			dF.RACritsMax.value = results[46];
			dF.LLCritsMax.value = results[47];
			dF.RLCritsMax.value = results[48];
			dF.NumWeapons.value = results[49];
			d.getElementById('txtLATonnage').innerHTML = results[50];
			d.getElementById('txtRATonnage').innerHTML = results[51];
			d.getElementById('txtCockpitTonnage').innerHTML = results[52];
			d.getElementById('txtTargetingTonnage').innerHTML = results[53];

			d.getElementById('txtTonsRemaining').style.color = '#000';
			d.getElementById('txtCritsRemaining').style.color = '#000';

			checkLegal();
			displayLoc();

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

	if (dF.Engine.value > 7) {
		dF.Jumping.value = 0;
		d.getElementById('PlusTen').style.display = 'none';
	} else {
		d.getElementById('PlusTen').style.display = 'inline';	
	}
	
	if (dF.Jumping.value > dF.Walking.value) dF.Jumping.value = dF.Walking.value;

	if (dF.AdvanceMP.value == 3) {
		d.getElementById('CTCrits').innerHTML -= 1;
	}

	if (dF.Tonnage.value > 55 && dF.Mods.value == 2) {
		alert("The weight of a Land-Air Mech cannot exceed 55 tons.");
		dF.Mods.value = 0;
	}

	var RunMP = Math.round(dF.Walking.value * 1.5);
	if (RunMP < 10) RunMP = '0' + RunMP;

	if ((dF.Walking.value * dF.Tonnage.value) > 400) {
		alert("Engine Rating cannot exceed 400.");
		dF.Walking.value = '04';
	}

	if (!isWorking && http) {
		var url = "include/calculate.mech.php";
		var vars = "Tonnage=" + dF.Tonnage.value +
			"&Level=" + dF.Level.value +
			"&Tech=" + dF.Tech.value +
			"&Mods=" + dF.Mods.value +
			"&Engine=" + dF.Engine.value +
			"&ISType=" + dF.ISType.value +
			"&HSType=" + dF.HSType.value +
			"&Gyro=" + dF.Gyro.value +
			"&Armor=" + dF.Armor.value +
			"&Walking=" + dF.Walking.value +
			"&Jumping=" + parseInt(dF.Jumping.value) +
			"&ArmorHead=" + dF.ArmorHead.value +
			"&ArmorCT=" + dF.ArmorCT.value +
			"&ArmorCTR=" + dF.ArmorCTR.value +
			"&ArmorLT=" + dF.ArmorLT.value +
			"&ArmorLTR=" + dF.ArmorLTR.value +
			"&ArmorRT=" + dF.ArmorRT.value +
			"&ArmorRTR=" + dF.ArmorRTR.value +
			"&ArmorLA=" + dF.ArmorLA.value +
			"&ArmorRA=" + dF.ArmorRA.value +
			"&ArmorLL=" + dF.ArmorLL.value +
			"&ArmorRL=" + dF.ArmorRL.value +
			"&ArmorTotal=" + dF.ArmorTotal.value +
			"&ArmorPercent=" + dF.ArmorPercent.value +
			"&Legs=" + dF.Legs.value +
			"&HeatSinks=" + dF.HeatSinks.value +
			"&LAActuators=" + dF.LAActuators.value +
			"&RAActuators=" + dF.RAActuators.value +
			"&Cockpit=" + dF.Cockpit.value +
			"&Targeting=" + dF.Targeting.value +
			"&JJType=" + dF.JJType.value +
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
	
	if (dF.Level.value != 3 && dF.Mods.value == 2) {
		dF.Level.value = 3;
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
	removeOpt('HSType',0);
	removeOpt('ISType',0);
	removeOpt('Gyro',0);
	removeOpt('Armor',0);
	removeOpt('AdvanceMP',0);
	removeOpt('Cockpit',0);
	removeOpt('Targeting',0);
	removeOpt('JJType',0);
	removeOpt('RAActuators',2);
	removeOpt('LAActuators',2);
	removeOpt('Abilities',0);
	
	if (dF.Tech.value == 1) {
		addOpt('RAActuators','+ Hatchet',4);
		addOpt('LAActuators','+ Hatchet',4);
	}
	if (dF.Edition.value > 2) {
		addOpt('Engine','Fusion XL',1);
		addOpt('HSType','Double',1);
		addOpt('Armor','Ferro-Fibrous',1);
		if (dF.Mods.value != 3) {
			addOpt('ISType','Endo Steel',1);
			addOpt('AdvanceMP','MASC',1);
			addOpt('Targeting','Targeting Computer',1);
		}
		if (dF.Tech.value == 1) {
			addOpt('AdvanceMP','Triple Strength Myomer',2);
			addOpt('RAActuators','+ Sword',5);
			addOpt('LAActuators','+ Sword',5);
		}
	}
	if (dF.Edition.value == 5) {
		addOpt('JJType','Improved',1);
		addOpt('RAActuators','+ Retractable Blade',8);
		addOpt('LAActuators','+ Retractable Blade',8);
		if (dF.Tech.value == 1 && dF.Mods.value != 3) {
			addOpt('Cockpit','Small Cockpit',1);
			addOpt('Armor','Light Ferro-Fibrous',5);
			addOpt('Armor','Heavy Ferro-Fibrous',6);
			addOpt('Armor','Stealth',7);
			addOpt('Engine','Light',6);
			addOpt('Engine','Compact',7);
			addOpt('Gyro','Compact',1);
			addOpt('Gyro','Heavy-Duty',2);
			addOpt('Gyro','Extra-Light',3);
		}
		if (dF.Mods.value == 3) {
			addOpt('Engine','ICE',8);
			addOpt('Engine','Fuel Cell',9);
			addOpt('Engine','Fission',10);
		}
	}
	if (dF.Level.value > 2 && dF.Edition.value > 2 && dF.Mods.value != 3) {
		addOpt('Engine','Fusion XXL',2);
		addOpt('ISType','Composite',2);
		addOpt('ISType','Reinforced',3);
		addOpt('Armor','Hardened',2);
		addOpt('Armor','Laser-Reflective',3);
		addOpt('Armor','Reactive',4);
		addOpt('Targeting','Long-Range',2);
		addOpt('Targeting','Short-Range',3);
		addOpt('Targeting','Variable-Range',4);
		addOpt('Targeting','Anti-Aircraft',5);
		addOpt('Targeting','Multi-Trac',6);
		addOpt('Targeting','Multi-Trac II',7);
		addOpt('Targeting','Satellite Uplink',8);
		addOpt('AdvanceMP','Supercharger',3);
		addOpt('Abilities','Bulls-Eye Marksman',1);
		addOpt('Abilities','Dodge Maneuver',2);
		addOpt('Abilities','Edge',3);
		addOpt('Abilities','Maneuvering Ace',4);
		addOpt('Abilities','Melee Specialist',5);
		addOpt('Abilities','Pain Resistance',6);
		addOpt('Abilities','Sixth Sense',7);
		addOpt('Abilities','Speed Demon',8);
		addOpt('Abilities','Tactical Genius',9);
		addOpt('Abilities','Weapon Specialist',10);
		if (dF.Tech.value == 2) {
			addOpt('HSType','Laser',2);
		} else {
			addOpt('Cockpit','Enhanced Imaging',2);
			addOpt('Cockpit','Command Console',3);
			addOpt('HSType','Compact',2);
			addOpt('RAActuators','+ Mace',6);
			addOpt('LAActuators','+ Mace',6);
			addOpt('RAActuators','+ Claw',7);
			addOpt('LAActuators','+ Claw',7);
		}
	}
	Calc();
}

function checkCrits() {
	dF = document.form;
	var i = 0;
	var loc, locA, locB, SplitA, SplitB;
	displayLoc();
	
	while (i < dF.NumWeapons.value) {
		loc = dF['Location' + i].value;
		if (loc != 1) {
			if (loc == 'RTRA' || loc == 'LTLA' || loc == 'RTCT' || loc == 'LTCT') {
				if (loc == 'RTRA') {
					locA = 'RTCrits';
					locB = 'RACrits';
				}
				if (loc == 'LTLA') {
					locA = 'LTCrits';
					locB = 'LACrits';
				}
				if (loc == 'RTCT') {
					locA = 'RTCrits';
					locB = 'CTCrits';
				}
				if (loc == 'LTCT') {
					locA = 'LTCrits';
					locB = 'CTCrits';
				}
				SplitA = prompt("Enter the number of crits to be allocated to the " + locA + ".", dF[locA].value);
				if (SplitA > 12) SplitA = 12;
				SplitB = parseInt(dF['ItemCrits' + i].value) - SplitA;
				dF['ItemCrits' + i].value = SplitA + ',' + SplitB;
				dF[locA].value -= SplitA;
				dF[locB].value -= SplitB;
			} else {
				if (loc == 'HR') loc = 'H';
				if (loc == 'CTR') loc = 'CT';
				if (loc == 'LTR') loc = 'LT';
				if (loc == 'RTR') loc = 'RT';
				if (loc == 'LLR') loc = 'LL';
				if (loc == 'RLR') loc = 'RL';
				dF[loc + 'Crits'].value -= dF['ItemCrits' + i].value;
			}
		}
		i++;
	}
	checkLegal();
}

function changeLegs() {
	if (document.form.Legs.value == 4) {
		document.form.LAActuators.value = 3;
		document.form.LAActuators.value = 3;
	}
	Calc();
}

function displayLoc() {
	dF = document.form;
	dF.HCrits.value = dF.HCritsMax.value;
	dF.CTCrits.value = dF.CTCritsMax.value;
	dF.LTCrits.value = dF.LTCritsMax.value;
	dF.RTCrits.value = dF.RTCritsMax.value;
	dF.LACrits.value = dF.LACritsMax.value;
	dF.RACrits.value = dF.RACritsMax.value;
	dF.LLCrits.value = dF.LLCritsMax.value;
	dF.RLCrits.value = dF.RLCritsMax.value;
}

function clearArmor() {
	dF = document.form;
	dF.ArmorHead.value = 0;
	dF.ArmorLT.value = 0;
	dF.ArmorLTR.value = 0;
	dF.ArmorCT.value = 0;
	dF.ArmorCTR.value = 0;
	dF.ArmorRT.value = 0;
	dF.ArmorRTR.value = 0;
	dF.ArmorLA.value = 0;
	dF.ArmorRA.value = 0;
	dF.ArmorLL.value = 0;
	dF.ArmorRL.value = 0;
	dF.ArmorPercent.value = 0;
	Calc();
}

function checkLegal() {
	dF = document.form;
	if (!weaponsAllocated() || lessThanZero(dF.Tons.value) || lessThanZero(dF.Crits.value) || lessThanZero(dF.HCrits.value) || lessThanZero(dF.CTCrits.value) || lessThanZero(dF.RTCrits.value) || lessThanZero(dF.LTCrits.value) || lessThanZero(dF.RACrits.value) || lessThanZero(dF.LACrits.value) || lessThanZero(dF.RLCrits.value) || lessThanZero(dF.LLCrits.value)) { 
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