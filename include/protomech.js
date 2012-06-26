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
			d.getElementById('txtJumpJets').innerHTML = results[5];
			d.getElementById('txtArmorTonnage').innerHTML = results[6];
			d.getElementById('txtCritsRemaining').innerHTML = results[7];
			d.getElementById('txtCrits').innerHTML = results[8];
			d.getElementById('txtListWeapons').innerHTML = results[9];
			dF.MaxDamage.value = results[10];
			d.getElementById('txtMaxDamage').innerHTML = results[10];
			dF.TotalCost.value = results[11];
			d.getElementById('txtTotalCost').innerHTML = results[11];
			dF.TotalBV.value = results[12];
			d.getElementById('txtTotalBV').innerHTML = results[12];
			dF.ArmorTotal.value = results[13];
			d.getElementById('txtArmorTotal').innerHTML = results[13];
			d.getElementById('txtArmorMax').innerHTML = results[14];
			dF.ArmorH.value = results[15];
			dF.ArmorT.value = results[16];
			dF.ArmorM.value = results[17];
			dF.ArmorL.value = results[18];
			dF.ArmorLA.value = results[19];
			dF.ArmorRA.value = results[20];
			d.getElementById('txtListEquipment').innerHTML = results[21];
			d.getElementById('txtDamagePerTon').innerHTML = results[22];
			dF.LACritsMax.value = results[23];
			dF.RACritsMax.value = results[24];
			dF.TCritsMax.value = results[25];
			dF.MGCritsMax.value = results[26];
			dF.NumWeapons.value = results[27];
			d.getElementById('txtMaxH').innerHTML = results[28];
			d.getElementById('txtMaxT').innerHTML = results[29];
			d.getElementById('txtMaxL').innerHTML = results[30];
			d.getElementById('txtMaxM').innerHTML = results[31];
			d.getElementById('txtMaxLA').innerHTML = results[32];
			d.getElementById('txtMaxRA').innerHTML = results[33];
			dF.HeatSinks.value = results[34];

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
	var RunMP = Math.round(dF.Walking.value * 1.5);
	if (RunMP < 10) RunMP = '0' + RunMP;

	if ((dF.Walking.value * dF.Tonnage.value) > 200) {
		alert("Engine Rating cannot exceed 200.");
		dF.Walking.value = '04';
	}

	if (!isWorking && http) {
		var url = "include/calculate.proto.php";
		var vars = "Tonnage=" + dF.Tonnage.value +
			"&Level=" + dF.Level.value +
			"&Tech=" + dF.Tech.value +
			"&Mods=" + dF.Mods.value +
			"&Armor=" + dF.Armor.value +
			"&Walking=" + dF.Walking.value +
			"&Jumping=" + parseInt(dF.Jumping.value) +
			"&ArmorH=" + dF.ArmorH.value +
			"&ArmorLA=" + dF.ArmorLA.value +
			"&ArmorRA=" + dF.ArmorRA.value +
			"&ArmorT=" + dF.ArmorT.value +
			"&ArmorL=" + dF.ArmorL.value +
			"&ArmorM=" + dF.ArmorM.value +
			"&ArmorTotal=" + dF.ArmorTotal.value +
			"&ArmorPercent=" + dF.ArmorPercent.value +
			"&AMMOAC2=" + dF.AMMOAC2.value +
			"&AMMOAC5=" + dF.AMMOAC5.value +
			"&AMMOAMS=" + dF.AMMOAMS.value +
			"&AMMOHMG=" + dF.AMMOHMG.value +
			"&AMMOLMG=" + dF.AMMOLMG.value +
			"&AMMOLRM=" + dF.AMMOLRM.value +
			"&AMMOMG=" + dF.AMMOMG.value +
			"&AMMONarc=" + dF.AMMONarc.value +
			"&AMMOSRM=" + dF.AMMOSRM.value +
			"&AMMOSSRM=" + dF.AMMOSSRM.value +
			"&Weapons=" + dF.ERMC.value +
				"," + dF.ERSC.value +
				"," + dF.ERMiC.value +
				"," + dF.HSC.value +
				"," + dF.PLMC.value +
				"," + dF.PLSC.value +
				"," + dF.PLMiC.value +
				"," + dF.FlamerC.value +
				"," + dF.AMSC.value +
				"," + dF.HMGC.value +
				"," + dF.MGC.value +
				"," + dF.LMGC.value +
				"," + dF.UAC2C.value +
				"," + dF.UAC5C.value +
				"," + dF.NarcC.value +
				"," + dF.LRM1C.value +
				"," + dF.LRM2C.value +
				"," + dF.LRM3C.value +
				"," + dF.LRM4C.value +
				"," + dF.LRM5C.value +
				"," + dF.LRM6C.value +
				"," + dF.LRM7C.value +
				"," + dF.LRM8C.value +
				"," + dF.LRM9C.value +
				"," + dF.LRM10C.value +
				"," + dF.LRM11C.value +
				"," + dF.LRM12C.value +
				"," + dF.LRM13C.value +
				"," + dF.LRM14C.value +
				"," + dF.LRM15C.value +
				"," + dF.LRM16C.value +
				"," + dF.LRM17C.value +
				"," + dF.LRM18C.value +
				"," + dF.LRM19C.value +
				"," + dF.LRM20C.value +
				"," + dF.SRM1C.value +
				"," + dF.SRM2C.value +
				"," + dF.SRM3C.value +
				"," + dF.SRM4C.value +
				"," + dF.SRM5C.value +
				"," + dF.SRM6C.value +
				"," + dF.SSRM1C.value +
				"," + dF.SSRM2C.value +
				"," + dF.SSRM3C.value +
				"," + dF.SSRM4C.value +
				"," + dF.SSRM5C.value +
				"," + dF.SSRM6C.value;
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
	Calc();
}

function clearArmor() {
	dF = document.form;
	dF.ArmorH.value = 0;
	dF.ArmorT.value = 0;
	dF.ArmorM.value = 0;
	dF.ArmorL.value = 0;
	dF.ArmorLA.value = 0;
	dF.ArmorRA.value = 0;
	dF.ArmorPercent.value = 0;
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
	dF.TCrits.value = dF.TCritsMax.value;
	dF.MGCrits.value = dF.MGCritsMax.value;
	dF.LACrits.value = dF.LACritsMax.value;
	dF.RACrits.value = dF.RACritsMax.value;
}

function checkLegal() {
	dF = document.form;
	if (!weaponsAllocated() || lessThanZero(dF.Tons.value) || lessThanZero(dF.Crits.value) || lessThanZero(dF.MGCrits.value) || lessThanZero(dF.TCrits.value) || lessThanZero(dF.RACrits.value) || lessThanZero(dF.LACrits.value)) { 
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

function showAllocateP() {
	document.getElementById('T1').style.display = 'none';
	document.getElementById('T2').style.display = 'none';
	d.getElementById('T8btn').style.backgroundColor = '#DDD';
}