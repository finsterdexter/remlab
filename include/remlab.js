var dF = document.form;
var d;
var i;

function loadApp() {
	Calc();
	changeLevel();
	switchTab('L1');
	switchCatagory('T1');
}

function getHTTPObject() {
	http = null;
	try {
		http = new XMLHttpRequest();
	} catch (e) {
		try {
			http = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			http = new ActiveXObject('Microsoft.XMLHTTP');
		}
	}
	return http;
}

function toggleLayer(l) {
	d = document;
	if (d.getElementById) {
		var style = d.getElementById(l).style;
		style.display = style.display? "":"block";
	} else if (d.all) {
		var style = d.all[l].style;
		style.display = style.display? "":"block";
	} else if (d.layers) {
		var style = d.layers[l].style;
		style.display = style.display? "":"block";
	}
}

function openLayer(l,t) {
	d = document;
	if (d.getElementById) {
		d.getElementById(l).style.display = t;
	} else if (d.all) {
		d.all[l].style.display = t;
	} else if (d.layers) {
		d.layers[l].style.display = t;
	}
}

function switchTab(t) {
	d = document;
	for (i = 1; i < 6; i++) {
		d.getElementById('L' + i).style.display = 'none';
		d.getElementById('L' + i + 'btn').style.background = '';
	}
	d.getElementById(t).style.display = 'block';
	d.getElementById(t + 'btn').style.backgroundColor = '#DDD';
}

function switchCatagory(t) {
	d = document;
	dF = document.form;
	d.getElementById('T8btn').style.backgroundColor = '';
	
	if (dF.UnitType.value == 4) {
		d.getElementById('T1btn').style.background = '';
		d.getElementById('T1').style.display = 'none';
		d.getElementById('T2btn').style.background = '';
		d.getElementById('T2').style.display = 'none';
		d.getElementById(t + 'btn').style.backgroundColor = '#DDD';		d.getElementById(t).style.display = 'block';
		pinStripeTable('WTP');	
		pinStripeTable('WT7Pc');
	} else {
		if (dF.Tech.value == 2) {
			var clan = 'c';
			d.getElementById('ClanWeapons').style.display = 'block';
		} else {
			var clan = '';
			d.getElementById('ISWeapons').style.display = 'block';
		}
		for (i = 1; i < 8; i++) {
			d.getElementById('T' + i + 'btn').style.background = '';
			d.getElementById('T' + i + clan).style.display = 'none';
			d.getElementById(t + 'btn').style.backgroundColor = '#DDD';			d.getElementById(t + clan).style.display = 'block';
		}
		pinStripeTable('W' + t + clan);	
		if (t == 'T7') pinStripeTable('WT8' + clan);
	}
}

function showAllocate() {
	document.getElementById('ISWeapons').style.display = 'none';
	document.getElementById('ClanWeapons').style.display = 'none';
	d.getElementById('T8btn').style.backgroundColor = '#DDD';
}

function pinStripeTable(t) {
	d = document;
	for (i = 1; d.getElementById(t).rows[i] != null; i++) {
		d.getElementById(t).rows[i].style.backgroundColor = '#FFF6B9';
		i++;
	}
}

function disableForm(dis) {
	dF = document.form.elements;
	for(i = 0; i < dF.length; i++) {
		dF[i].disabled = dis;
	}
}

function getElementByClass(getClass, classAction) {
	var els = document.getElementsByTagName('tr');
	var pattern = new RegExp('(^|\\s)' + getClass +'(\\s|$)');
	if (navigator.appName == 'Microsoft Internet Explorer' && classAction == 'table-row') classAction = 'block';
	for (i = 0; i < els.length; i++) {
		if (pattern.test(els[i].className)) els[i].style.display = classAction;
	}
}

function flipInput(s,i) {
	d = document;
	document.form[s].value = '';
	if (d.getElementById(i).style.display == 'none') {
		d.getElementById(s).style.display = 'none';
		d.getElementById(i).style.display = 'inline';
	} else {
		d.getElementById(s).style.display = 'inline';
		d.getElementById(i).style.display = 'none';
	}
}

function raceSkills() {
	dF = document.form;
	if (dF.Race.value == 1) {
		if (dF.UnitType.value == 2) {
			dF.Gunnery.value = 6;
			dF.Piloting.value = 7;
		} else {
			dF.Gunnery.value = 4;
			dF.Piloting.value = 5;
		}
	} else {
		dF.Gunnery.value = 5;
		dF.Piloting.value = 6;
	}
}

function randStats() {
	dF = document.form;

	if (dF.Experience.value == 1) {
		var GunSkill = new Array(7,6,5,5,4,4,4,4,3);
		var PilotSkill = new Array(7,7,6,6,6,6,5,5,4);
	} 
	if (dF.Experience.value == 2) {
		var GunSkill = new Array(5,4,4,4,4,3,3,2,2);
		var PilotSkill = new Array(6,6,6,5,5,4,4,3,3);
	} 
	if (dF.Experience.value == 3) {
		var GunSkill = new Array(4,4,4,3,3,2,2,1,1);
		var PilotSkill = new Array(6,5,5,4,4,3,3,2,2);	
	} 
	if (dF.Experience.value == 4) {
		var GunSkill = new Array(4,3,3,2,2,1,1,0,0);
		var PilotSkill = new Array(5,4,4,3,3,2,2,1,1);	
	}
	var ranNumG = Math.floor((Math.random() * 6) + 1);
	var ranNumP = Math.floor((Math.random() * 6) + 1);
	if (dF.Race.value == 1) {
		if (dF.UnitType.value == 2) {
			ranNumG -= 1;
			ranNumP -= 1;
		} else {
			ranNumG += 1;
			ranNumP += 1;		
		}
	}
	dF.Gunnery.value = GunSkill[ranNumG] + 1;
	dF.Piloting.value = PilotSkill[ranNumP] + 1;
}

function diceButtonName() {
	dF = document.form;
	if (dF.diceNum.value < 1) dF.diceNum.value = 1;
	dF.diceBtn.value = 'Roll ' + dF.diceNum.value + 'd' + dF.diceSides.value;
}

function diceRoller(dSides,dNum) {
	dF = document.form;
	var dTotal = 0;
	dF.diceResultsList.value = '';
	for (i = 0; i < dNum; i++) {
		rollDice = Math.floor(Math.random() * dSides) + 1;
		dTotal += rollDice;
		dF.diceResultsList.value += rollDice + '\n';
	}
	dF.diceResults.value = dTotal;
}

function roll2d6() {
	var imgPosition = new Array();
	imgPosition[1] = -497;
	imgPosition[2] = -397;
	imgPosition[3] = -298;
	imgPosition[4] = -198;
	imgPosition[5] = -99;
	imgPosition[6] = 0;
	rollDice1 = Math.floor(Math.random() * 6) + 1;
	document.getElementById('die1').style.backgroundPosition = imgPosition[rollDice1] + 'px 0';
	rollDice2 = Math.floor(Math.random() * 6) + 1;
	document.getElementById('die2').style.backgroundPosition = imgPosition[rollDice2] + 'px 0';
	document.form.diceResults2d6.value = rollDice1 + rollDice2;
}

function armorBalance(l,r) {
	dF = document.form;	dF[r].value = dF[l].value;
}

function armorPercent(p) {
	dF = document.form;
	dF.ArmorPercent.value = p;
	Calc();
	dF.ArmorPercent.value = 0;
}

function lessThanZero(v) {
	if (v < 0 || v == 'NaN') {
		return 1;
	} else {
		return 0;
	}
}

function weaponsAllocated() {
	dF = document.form;
	for (i = 0; i < dF.NumWeapons.value; i++) {
		if (dF['Location' + i].value == 1) return 0;
	}
	return 1;
}

function submitForm(p,t) {
	dF = document.form;
	dF.target = '_blank';
	dF.method = 'post';
	if (t == 'xml' || t == 'mft') {
		dF.action = p + '.' + t;
	} else {	
		dF.action = p + '-' + t + '/';
	}
	//dF.action = 'print.php?p=' + p + '&t=' + t;
	dF.submit();
}

function addOpt(el,aName,aValue) {
	dF = document.form[el];
	y = document.createElement('option');
	y.text = aName;
	y.value = aValue;
	try {
		dF.add(y,null);
	} catch(ex) {
		dF.add(y);
	}
}

function removeOpt(el,base) {
	dF = document.form[el];
	for (i = dF.length; i > base; i--) dF.remove(i);
}

function calcWeapons() {
	dF = document.form;
	return "&Weapons=" + dF.LL.value +
	"," + dF.ML.value +
	"," + dF.SL.value +
	"," + dF.PPC.value +
	"," + dF.Flamer.value +
	"," + dF.ERL.value +
	"," + dF.ERM.value +
	"," + dF.ERS.value +
	"," + dF.ERPPC.value +
	"," + dF.PLL.value +
	"," + dF.PLM.value +
	"," + dF.PLS.value +
	"," + dF.HPPC.value +
	"," + dF.LPPC.value +
	"," + dF.SNPPC.value +
	"," + dF.PlasmaR.value +
	"," + dF.XPL.value +
	"," + dF.XPM.value +
	"," + dF.XPS.value +
	"," + dF.LAMS.value +
	"," + dF.PPCCap.value +
	"," + dF.ERPPCCap.value +
	"," + dF.AC2.value +
	"," + dF.AC5.value +
	"," + dF.AC10.value +
	"," + dF.AC20.value +
	"," + dF.MG.value +
	"," + dF.FlamerV.value +
	"," + dF.UAC2.value +
	"," + dF.UAC5.value +
	"," + dF.UAC10.value +
	"," + dF.UAC20.value +
	"," + dF.LB2X.value +
	"," + dF.LB5X.value +
	"," + dF.LB10X.value +
	"," + dF.LB20X.value +
	"," + dF.RAC2.value +
	"," + dF.RAC5.value +
	"," + dF.LGR.value +
	"," + dF.GR.value +
	"," + dF.HGR.value +
	"," + dF.AMS.value +
	"," + dF.HMG.value +
	"," + dF.LMG.value +
	"," + dF.HFlamer.value +
	"," + dF.LAC2.value +
	"," + dF.LAC5.value +
	"," + dF.LTCan.value +
	"," + dF.SCan.value +
	"," + dF.TCan.value +
	"," + dF.Grenade.value +
	"," + dF.LRM5.value +
	"," + dF.LRM10.value +
	"," + dF.LRM15.value +
	"," + dF.LRM20.value +
	"," + dF.SRM2.value +
	"," + dF.SRM4.value +
	"," + dF.SRM6.value +
	"," + dF.SSRM2.value +
	"," + dF.SSRM4.value +
	"," + dF.SSRM6.value +
	"," + dF.MRM10.value +
	"," + dF.MRM20.value +
	"," + dF.MRM30.value +
	"," + dF.MRM40.value +
	"," + dF.Narc.value +
	"," + dF.MML3.value +
	"," + dF.MML5.value +
	"," + dF.MML7.value +
	"," + dF.MML9.value +
	"," + dF.RL10.value +
	"," + dF.RL15.value +
	"," + dF.RL20.value +
	"," + dF.TB5.value +
	"," + dF.TB10.value +
	"," + dF.TB15.value +
	"," + dF.TB20.value +
	"," + dF.ELRM5.value +
	"," + dF.ELRM10.value +
	"," + dF.ELRM15.value +
	"," + dF.ELRM20.value +
	"," + dF.ArrowIV.value +
	"," + dF.LongTom.value +
	"," + dF.Sniper.value +
	"," + dF.Thumper.value +
	"," + dF.ERLC.value +
	"," + dF.ERMC.value +
	"," + dF.ERSC.value +
	"," + dF.ERMiC.value +
	"," + dF.HLC.value +
	"," + dF.HMC.value +
	"," + dF.HSC.value +
	"," + dF.PLLC.value +
	"," + dF.PLMC.value +
	"," + dF.PLSC.value +
	"," + dF.PLMiC.value +
	"," + dF.FlamerC.value +
	"," + dF.ERPPCC.value +
	"," + dF.PlasmaC.value +
	"," + dF.ERPLC.value +
	"," + dF.ERPMC.value +
	"," + dF.ERPSC.value +
	"," + dF.LAMSC.value +
	"," + dF.AMSC.value +
	"," + dF.FlamerVC.value +
	"," + dF.GRC.value +
	"," + dF.HMGC.value +
	"," + dF.MGC.value +
	"," + dF.LMGC.value +
	"," + dF.LB2XC.value +
	"," + dF.LB5XC.value +
	"," + dF.LB10XC.value +
	"," + dF.LB20XC.value +
	"," + dF.UAC2C.value +
	"," + dF.UAC5C.value +
	"," + dF.UAC10C.value +
	"," + dF.UAC20C.value +
	"," + dF.APGaussC.value +
	"," + dF.HAGauss20C.value +
	"," + dF.HAGauss30C.value +
	"," + dF.HAGauss40C.value +
	"," + dF.RAC2C.value +
	"," + dF.RAC5C.value +
	"," + dF.RAC10C.value +
	"," + dF.RAC20C.value +
	"," + dF.NarcC.value +
	"," + dF.LRM5C.value +
	"," + dF.LRM10C.value +
	"," + dF.LRM15C.value +
	"," + dF.LRM20C.value +
	"," + dF.SRM2C.value +
	"," + dF.SRM4C.value +
	"," + dF.SRM6C.value +
	"," + dF.SSRM2C.value +
	"," + dF.SSRM4C.value +
	"," + dF.SSRM6C.value +
	"," + dF.ATM3C.value +
	"," + dF.ATM6C.value +
	"," + dF.ATM9C.value +
	"," + dF.ATM12C.value +
	"," + dF.SLRM5C.value +
	"," + dF.SLRM10C.value +
	"," + dF.SLRM15C.value +
	"," + dF.SLRM20C.value +
	"," + dF.ArrowIVC.value +
	"," + dF.LongTomC.value +
	"," + dF.SniperC.value +
	"," + dF.ThumperC.value +
	"&Ammunition=" + dF.AAC2.value +
	"," + dF.AAC5.value +
	"," + dF.AAC10.value +
	"," + dF.AAC20.value +
	"," + dF.AMGFull.value +
	"," + dF.AMGHalf.value +
	"," + dF.AFlamer.value +
	"," + dF.AUAC2.value +
	"," + dF.AUAC5.value +
	"," + dF.AUAC10.value +
	"," + dF.AUAC20.value +
	"," + dF.ALB2X.value +
	"," + dF.ALB5X.value +
	"," + dF.ALB10X.value +
	"," + dF.ALB20X.value +
	"," + dF.ArAC2.value +
	"," + dF.ArAC5.value +
	"," + dF.ALGR.value +
	"," + dF.AGR.value +
	"," + dF.AHGR.value +
	"," + dF.AAMS.value +
	"," + dF.AHMG.value +
	"," + dF.ALMG.value +
	"," + dF.APlasma.value +
	"," + dF.ANail.value +
	"," + dF.AHFlamer.value +
	"," + dF.ALAC2.value +
	"," + dF.ALAC5.value +
	"," + dF.ALongTomCan.value +
	"," + dF.ASniperCan.value +
	"," + dF.AThumperCan.value +
	"," + dF.ALRM5.value +
	"," + dF.ALRM10.value +
	"," + dF.ALRM15.value +
	"," + dF.ALRM20.value +
	"," + dF.ASRM2.value +
	"," + dF.ASRM4.value +
	"," + dF.ASRM6.value +
	"," + dF.ASSRM2.value +
	"," + dF.ASSRM4.value +
	"," + dF.ASSRM6.value +
	"," + dF.AMRM10.value +
	"," + dF.AMRM20.value +
	"," + dF.AMRM30.value +
	"," + dF.AMRM40.value +
	"," + dF.ANarc.value +
	"," + dF.ATBolt5.value +
	"," + dF.ATBolt10.value +
	"," + dF.ATBolt15.value +
	"," + dF.ATBolt20.value +
	"," + dF.AELRM5.value +
	"," + dF.AELRM10.value +
	"," + dF.AELRM15.value +
	"," + dF.AELRM20.value +
	"," + dF.AArrowIV.value +
	"," + dF.ALongTom.value +
	"," + dF.ASniper.value +
	"," + dF.AThumper.value +
	"," + dF.AHMGC.value +
	"," + dF.AMGFullC.value +
	"," + dF.AMGHalfC.value +
	"," + dF.ALMGC.value +
	"," + dF.ALMGHalfC.value +
	"," + dF.AFlamerC.value +
	"," + dF.AUAC2C.value +
	"," + dF.AUAC5C.value +
	"," + dF.AUAC10C.value +
	"," + dF.AUAC20C.value +
	"," + dF.ALB2XC.value +
	"," + dF.ALB5XC.value +
	"," + dF.ALB10XC.value +
	"," + dF.ALB20XC.value +
	"," + dF.AGRC.value +
	"," + dF.AAMSC.value +
	"," + dF.AAPGaussC.value +
	"," + dF.AHAGauss20C.value +
	"," + dF.AHAGauss30C.value +
	"," + dF.AHAGauss40C.value +
	"," + dF.APlasmaC.value +
	"," + dF.ANailC.value +
	"," + dF.ARAC2C.value +
	"," + dF.ARAC5C.value +
	"," + dF.ARAC10C.value +
	"," + dF.ARAC20C.value +
	"," + dF.ALRM5C.value +
	"," + dF.ALRM10C.value +
	"," + dF.ALRM15C.value +
	"," + dF.ALRM20C.value +
	"," + dF.ASRM2C.value +
	"," + dF.ASRM4C.value +
	"," + dF.ASRM6C.value +
	"," + dF.ASSRM2C.value +
	"," + dF.ASSRM4C.value +
	"," + dF.ASSRM6C.value +
	"," + dF.ANarcC.value +
	"," + dF.AATM3C.value +
	"," + dF.AATM6C.value +
	"," + dF.AATM9C.value +
	"," + dF.AATM12C.value +
	"," + dF.ASLRM5C.value +
	"," + dF.ASLRM10C.value +
	"," + dF.ASLRM15C.value +
	"," + dF.ASLRM20C.value +
	"," + dF.AArrowIVC.value +
	"," + dF.ALongTomC.value +
	"," + dF.ASniperC.value +
	"," + dF.AThumperC.value +
	"&Equipment=" + dF.APP.value +
	"," + dF.ABAP.value +
	"," + dF.Art4.value +
	"," + dF.BAP.value +
	"," + dF.C3M.value +
	"," + dF.C3S.value +
	"," + dF.C3i.value +
	"," + dF.GECM.value +
	"," + dF.TAG.value +
	"," + dF.CASE.value +
	"," + dF.CASE2.value +
	"," + dF.BloodAP.value +
	"," + dF.AECM.value +
	"," + dF.Cool.value +
	"," + dF.APC.value +
	"," + dF.LAPC.value +
	"," + dF.APPC.value +
	"," + dF.ECMC.value +
	"," + dF.TAGC.value +
	"," + dF.LTAGC.value +
	"," + dF.Art4C.value +
	"," + dF.WatchdogC.value +
	"," + dF.Art5C.value +
	"," + dF.AECMC.value +
	"," + dF.CASE2C.value +
	"," + dF.CoolC.value +
	"&Industrial=" + dF.Cargo.value +
	"," + dF.Chainsaw.value +
	"," + dF.Combine.value +
	"," + dF.Lift.value +
	"," + dF.Backhoe.value +
	"," + dF.DualSaw.value +
	"," + dF.MineDrill.value +
	"," + dF.NailGun.value +
	"," + dF.PileDriver.value +
	"," + dF.Searchlight.value +
	"," + dF.Welder.value +
	"," + dF.WreckBall.value +
	"," + dF.CargoC.value +
	"," + dF.ChainsawC.value +
	"," + dF.CombineC.value +
	"," + dF.LiftC.value +
	"," + dF.BackhoeC.value +
	"," + dF.DualSawC.value +
	"," + dF.MineDrillC.value +
	"," + dF.NailGunC.value +
	"," + dF.PileDriverC.value +
	"," + dF.SearchlightC.value +
	"," + dF.WelderC.value +
	"," + dF.WreckBallC.value;
}

prog = new Image(140,16);
prog.src = 'resources/progbar.gif'; 