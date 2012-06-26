<?php // ProtoMech Calculations

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');
//ini_set('memory_limit', '8M');
ini_set('output_buffering', '4096');

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 OR !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Includes
require('master.db.php');
require('structure.db.php');
require('locations.inc.php');
require('functions.inc.php');


// ---------------------------------
// Engine and Movement
// ---------------------------------

// Running speed
$Running = runningSpeed($_POST['Walking']);

// Engine Rating
$EngineRating = intval($_POST['Tonnage'] * $Running);

// Engine Type
$EngineTonnage = engineMassProto($EngineRating);


// ---------------------------------
// Jump Jets
// ---------------------------------

// Jump Jet weight
switch ($_POST['Tonnage']) {
	case $_POST['Tonnage'] > 5: // 5 to 9
		$JumpJetsTonnage = $_POST['Jumping'] * 0.1;
		break;
	default: // 0 to 5
		$JumpJetsTonnage = $_POST['Jumping'] * 0.05;
		break;
}


// ---------------------------------
// Other Components
// ---------------------------------

// Cockpit Type
$CockpitTonnage = 0.5;


// ---------------------------------
// Internal Structure// Running speed
// ---------------------------------

// Internal Structure Type
$ISTonnage = $_POST['Tonnage'] / 10;

// Internal Structure Points
$ISH = $arrInternalStructure[$_POST['Tonnage']]['H'];
$IST = $arrInternalStructure[$_POST['Tonnage']]['T'];
$ISL = $arrInternalStructure[$_POST['Tonnage']]['L'];
$ISA = $arrInternalStructure[$_POST['Tonnage']]['A'];


// ---------------------------------
// External Armor
// ---------------------------------

// Max armor values
$arrMaxHeadArmor = array(0,2,3,3,4,4,5,5,6,6);
$MaxHead = $arrMaxHeadArmor[$_POST['Tonnage']];
$MaxArms = $ISA * 2;
$MaxLegs = $ISL * 2;
$MaxTorso = $IST * 2;
$MaxGun = 3;

// Max out all the armor locations on a Mech
if ($_POST['ArmorPercent']) {
	$_POST['ArmorH'] = (int)(($MaxHead * $_POST['ArmorPercent']) + 0.99);
	$_POST['ArmorRA'] = (int)(($MaxArms * $_POST['ArmorPercent']) + 0.99);
	$_POST['ArmorLA'] = (int)(($MaxArms * $_POST['ArmorPercent']) + 0.99);
	$_POST['ArmorL'] = (int)(($MaxLegs * $_POST['ArmorPercent']) + 0.99);
	$_POST['ArmorT'] = (int)(($MaxTorso * $_POST['ArmorPercent']) + 0.99);
	$_POST['ArmorM'] = 3;
}

// Check if armor value is over maximum armor
$_POST['ArmorH'] = maximumValue(lessThanZero($_POST['ArmorH']), $MaxHead);
$_POST['ArmorT'] = maximumValue(lessThanZero($_POST['ArmorT']), $MaxTorso);
$_POST['ArmorL'] = maximumValue(lessThanZero($_POST['ArmorL']), $MaxLegs);
$_POST['ArmorRA'] = maximumValue(lessThanZero($_POST['ArmorRA']), $MaxArms);
$_POST['ArmorLA'] = maximumValue(lessThanZero($_POST['ArmorLA']), $MaxArms);
$_POST['ArmorM'] = maximumValue(lessThanZero($_POST['ArmorM']), $MaxGun);

// Add up Armor
$ArmorTotal = $_POST['ArmorH'] + $_POST['ArmorT'] + $_POST['ArmorL'] + $_POST['ArmorRA'] + $_POST['ArmorLA'] + $_POST['ArmorM'];
$ArmorMax = 3 + ($MaxArms * 2) + $MaxLegs + $MaxTorso + $MaxHead;

// Armor Type
$ArmorTonnage = $ArmorTotal * 0.05;
$ArmorCost = $ArmorTotal * 625 ;

// Check for Armor errors
if ($ArmorTonnage < 0) $ArmorTonnage = 0;
if ($ArmorTotal < 1) $ArmorTonnage = 0;


// ----------------------------------
// Max Slots per location
// ----------------------------------

$CritsLA_Max = 1;
$CritsRA_Max = 1;
$CritsTorso_Max = 2;
$CritsGun_Max = 1;
$Crits = 5;


// ----------------------------------
// Generate list of allocated items
// ----------------------------------

// Set Globals to zero
$MaxHeat = 0;
$MaxDamage = 0;
$WeaponsCost = 0;
$WeaponsBV = 0;
$AmmoBV = 0;
$DirectFireWeapons = 0;
$id = 0;
$Amplifier = 0;


// Display Selected Weapons
$Weapons = preg_split("/,/", $_POST['Weapons']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Weapons[$w]) {
			// Create the entry in the Allocate box
			$ListWeapons .= startSelect($id);
			$ListWeapons .= $LocationsPM;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsProto[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsProto[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsProto[$w]['crits'] . "\" /> ";
			$ListWeapons .= $WeaponsProto[$w]['name'] . " [" . $WeaponsProto[$w]['crits'] . "]</li>";

			// Get totals for laser and ballistic weapons
			//if ($WeaponsOnly[$w]['type'] == 1 || $WeaponsOnly[$w]['type'] == 2 && $WeaponsOnly[$w]['name'] == 'Flamer' && $WeaponsOnly[$w]['name'] == 'Machine Gun' && $WeaponsOnly[$w]['name'] == 'Flamer (Vehicle)') {
			//	$DirectFireWeapons += $WeaponsOnly[$w]['tons'];
			//	$DirectFireWeaponsBV += $WeaponsOnly[$w]['bv'];
			//}
			
			// Add up heat from energy weapons
			if ($WeaponsProto[$w]['type'] == 1) $Totalheat += $WeaponsProto[$w]['heat'];

			// Add to the totals
			$TotalWeaponsTonnage += $WeaponsProto[$w]['tons'];
			$TotalWeaponsCrits += 1;
			$MaxDamage += $WeaponsProto[$w]['damage'];
			$WeaponsCost += $WeaponsProto[$w]['cost'];
			$WeaponsBV += $WeaponsProto[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Weapons[$w]);
	$w++;
} while (count($WeaponsProto) > $w);

// Add heat sinks
$HeatSinkTons = $Totalheat * 0.25;


// Display Selected Equipment
$Equipment = preg_split("/,/", $_POST['Equipment']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Equipment[$w]) {
			$ListEquipment .= startSelect($id);
			$ListEquipment .= $LocationsPMT;
			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsProto[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsProto[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsProto[$w]['crits'] . "\" /> ";
			$ListEquipment .= $WeaponsProto[$w]['name'] . " [" . $WeaponsProto[$w]['crits'] . "]</li>";
			
			$TotalWeaponsTonnage += $WeaponsProto[$w]['tons'];
			$TotalWeaponsCrits += 2;
			$WeaponsCost += $WeaponsProto[$w]['cost'];
			$WeaponsBV += $WeaponsProto[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Equipment[$w]);
	$w++;
} while (count($WeaponsProto) > $w);


// Display Selected Ammo
$AmmoTonnage = ($_POST['AMMOAC2'] * 0.02) + ($_POST['AMMOAC5'] * 0.05) + ($_POST['AMMOAMS'] * 0.04) + ($_POST['AMMOHMG'] * 0.01) + ($_POST['AMMOLMG'] * 0.005) + ($_POST['AMMOMG'] * 0.005) + ($_POST['AMMOLRM'] * 0.025) + ($_POST['AMMOSRM'] * 0.01) + ($_POST['AMMOSSRM'] * 0.01) + ($_POST['AMMONarc'] * 0.15);
$AmmoCost = ($_POST['AMMOAC2'] * 23) + ($_POST['AMMOAC5'] * 450) + ($_POST['AMMOAMS'] * 167) + ($_POST['AMMOHMG'] * 10) + ($_POST['AMMOLMG'] * 3) + ($_POST['AMMOMG'] * 5) + ($_POST['AMMOLRM'] * 1250) + ($_POST['AMMOSRM'] * 540) + ($_POST['AMMOSSRM'] * 1080) + ($_POST['AMMONarc'] * 1000);//$AmmoBV = ($_POST['AMMOAC2'] * 0.02) + ($_POST['AMMOAC5'] * 0.05) + ($_POST['AMMOAMS'] * 0.04) + ($_POST['AMMOHMG'] * 0.01) + ($_POST['AMMOLMG'] * 0.005) + ($_POST['AMMOMG'] * 0.005) + ($_POST['AMMOLRM'] * 0.025) + ($_POST['AMMOSRM'] * 0.01) + ($_POST['AMMOSSRM'] * 0.01) + ($_POST['AMMONarc'] * 0.15);


// ---------------------------------
// Final Totals
// ---------------------------------

// Tonnage Remaining
$TonnageRemaining = $_POST['Tonnage'] - $CockpitTonnage - $EngineTonnage - $ISTonnage - $JumpJetsTonnage - $ArmorTonnage - $HeatSinkTons - $TotalWeaponsTonnage - $AmmoTonnage;

// Crits Remaining
$CritsRemaining = $Crits - $TotalWeaponsCrits;

// Total Cost
$TotalCost = 500000 + 75000 + ($_POST['Tonnage'] * 2000) + ($_POST['Tonnage'] * 2000) + ($_POST['Tonnage'] * 400) + ((5000 * $EngineRating * $_POST['Tonnage']) / 75) + ($_POST['Tonnage'] * ($_POST['Jumping'] * $_POST['Jumping']) * 200) + ($Totalheat * 2000) + ($_POST['Tonnage'] * 540) + ($_POST['Tonnage'] * 360) + $ArmorCost + $WeaponsCost + $AmmoCost;

$TotalCost *= (1 + ($_POST['Tonnage'] / 100));

// BV Defense
$DefenceBV = $_POST['Tonnage'] + ($ArmorTotal * 2) + ((($ISA * 2) + 1 + $ISH + $ISL + $IST) * 1.5);

if ($_POST['Jumping'] > 4) {
	$Walk = $_POST['Walking'];
	$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Walk] + 0.1];
} else {
	$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Running] + 0.1];
}

// BV Offense
$SpeedBV = $_POST['Jumping'] + $Running;

$Y = $WeaponsBV / 2;

if ($SpeedBV > 26) {
	$OffenceBV = $Y * 4.12;
} else {
	$OffenceBV = $Y * $arrSpeedFac[$SpeedBV];
}

$TotalBV = $DefenceBV + $OffenceBV;


// ---------------------------------
// Final Output
// ---------------------------------

// Split value
define('SPLIT', '||');

// Return data to the client
echo $EngineRating; // Engine Rating
echo SPLIT . decimalPlaces($EngineTonnage, 2); // Engine Tonnage
echo SPLIT . decimalPlaces($TonnageRemaining, 2); // Tonnage Remaining
echo SPLIT . decimalPlaces($_POST['Tonnage'], 1); // Tonnage
echo SPLIT . $Running; // Running
echo SPLIT . decimalPlaces($JumpJetsTonnage, 2); // JumpJets Tonnage
echo SPLIT . decimalPlaces($ArmorTonnage, 2); // Armor Tonnage
echo SPLIT . $CritsRemaining; // Crits Remaining
echo SPLIT . $Crits; // Total Crits
echo SPLIT . $ListWeapons; // All Weapons
echo SPLIT . $MaxDamage; // Total Weapon Damage
echo SPLIT . largeNumber($TotalCost); // Total Cost
echo SPLIT . largeNumber($TotalBV); // Total Battle Value
echo SPLIT . $ArmorTotal; // Total Armor Points
echo SPLIT . $ArmorMax; // Max Armor Points
echo SPLIT . $_POST['ArmorH']; // Head Armor
echo SPLIT . $_POST['ArmorT']; // Torso Armor
echo SPLIT . $_POST['ArmorM']; // Main Gun Armor
echo SPLIT . $_POST['ArmorL']; // Legs Armor
echo SPLIT . $_POST['ArmorLA']; // LA Armor
echo SPLIT . $_POST['ArmorRA']; // RA Armor
echo SPLIT . $ListEquipment; // All Equipment and Jumpjets
echo SPLIT . decimalPlaces($MaxDamage / $_POST['Tonnage'], 2); // Damage Per Ton
echo SPLIT . $CritsLA_Max; // LA Crits
echo SPLIT . $CritsRA_Max; // RA Crits
echo SPLIT . $CritsTorso_Max; // Torso Crits
echo SPLIT . $CritsGun_Max; // Main Gun Crits
echo SPLIT . $id; // Number of Weapons
echo SPLIT . $MaxHead; // Head Armor
echo SPLIT . $MaxTorso; // Torso Armor
echo SPLIT . $MaxLegs; // Legs Armor
echo SPLIT . $MaxGun; // Main Gun Armor
echo SPLIT . $MaxArms; // LA Armor
echo SPLIT . $MaxArms; // RA Armor
echo SPLIT . $HeatSinkTons; // Heat Sinks

?>