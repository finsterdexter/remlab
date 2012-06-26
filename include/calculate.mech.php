<?php // Mech Calculations

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');
//ini_set('memory_limit', '8M');
ini_set('output_buffering', '4096');

// Check for cross-site scripting
if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > 7 OR !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) die();

// Includes
require('master.db.php');
require('locations.inc.php');
require('functions.inc.php');


// ---------------------------------
// Technology Variables
// ---------------------------------

if ($_POST['Tech'] == 2) {
	// Clan
	$FerroCrits = 7;
	$LaserRefCrits = 5;
	$SpISCrits = 7;
	$SpEngineCrits = 2;
	$SpHSCrits = 2;
	$MASC = 25;
} else {
	// Inner Sphere
	$FerroCrits = 14;
	$LaserRefCrits = 10;
	$SpISCrits = 14;
	$SpEngineCrits = 3;
	$SpHSCrits = 3;
	$MASC = 20;
}

// LAM Conversion
if ($_POST['Mods'] == 2 && $_POST['Tonnage'] < 60) $LAMTonnage = $_POST['Tonnage'] / 10;


// ---------------------------------
// Engine and Movement
// ---------------------------------

// Engine Rating
$EngineRating = intval(roundUpFive($_POST['Tonnage']) * $_POST['Walking']);
if ($EngineRating < 10) $EngineRating = 10;

// Running speed
$Running = runningSpeed($_POST['Walking']);

// Engine Type
switch ($_POST['Engine']) {
	case 1: // Fusion XL
		$EngineCrits = $SpEngineCrits;
		$EngineTonnage = engineMass(2, 0, $EngineRating);
		$EngineCost = 20000;
		$EngineBV = 0.75;
		break;
	case 2: // Fusion XXL
		$EngineCrits = $SpEngineCrits + 1;
		$EngineTonnage = engineMass(3, 0, $EngineRating);
		$EngineCost = 100000;
		$EngineBV = 0.5;
		break;
	case 3: // Fusion Large
		$EngineCrits = $SpEngineCrits + 2;
		$EngineTonnage = engineMass(0, 0, $EngineRating);
		$EngineCost = 10000;
		$EngineBV = 1.5;
		break;
	case 4: // Fusion XL Large
		$EngineCrits = ($SpEngineCrits * 2) + 2;
		$EngineTonnage = engineMass(2, 0, $EngineRating);
		$EngineCost = 40000;
		$EngineBV = 0.75;
		break;
	case 5: // Fusion XXL Large
		$EngineCrits = (($SpEngineCrits + 1) * 2) + 2;
		$EngineTonnage = engineMass(3, 0, $EngineRating);
		$EngineCost = 200000;
		$EngineBV = 0.5;
		break;
	case 6: // Light
		$EngineCrits = 2;
		$EngineTonnage = engineMass(1.5, 0, $EngineRating);
		$EngineCost = 15000;
		$EngineBV = 1.5;
		break;
	case 7: // Compact
		$EngineCrits = 0;
		$CTEngineCrits = (-3);
		$EngineTonnage = engineMass(1.5, 1, $EngineRating);
		$EngineCost = 10000;
		$EngineBV = 1.5;
		break;
	case 8: // ICE
		$EngineCrits = 0;
		$EngineTonnage = engineMass(2, 1, $EngineRating);
		$EngineCost = 1250;
		$EngineBV = 1;
		$_POST['Jumping'] = 0;
		break;
	case 9: // Fuel Cell
		$EngineCrits = 0;
		$EngineTonnage = engineMass(1.2, 1, $EngineRating);
		$EngineCost = 3500;
		$EngineBV = 1;
		$_POST['Jumping'] = 0;
		break;
	case 10: // Fission
		$EngineCrits = 0;
		$EngineTonnage = engineMass(1.75, 1, $EngineRating);
		$EngineCost = 7500;
		$EngineBV = 1;
		$_POST['Jumping'] = 0;
		break;
	default: // Fusion
		$EngineCrits = 0;
		$EngineTonnage = engineMass(0, 0, $EngineRating);
		$EngineCost = 5000;
		$EngineBV = 1.5;
		break;
}

// ---------------------------------
// Jump Jets
// ---------------------------------

// Jump Jet weight
switch ($_POST['Tonnage']) {
	case $_POST['Tonnage'] > 59 && $_POST['Tonnage'] < 86: // 60 to 85
		$JumpJetsTonnage = $_POST['Jumping'];
		$JumpJetSN = 'JJ1';
		break;
	case $_POST['Tonnage'] > 86 && $_POST['Tonnage'] < 201: // 90 to 100
		$JumpJetsTonnage = $_POST['Jumping'] * 2;
		$JumpJetSN = 'JJ2';
		break;
	default: // 0 to 55
		$JumpJetsTonnage = $_POST['Jumping'] * 0.5;
		$JumpJetSN = 'JJ0';
		break;
}

// Imporved Jump Jets
if ($_POST['JJType']) { // Improved
	$JJTitle = "Improved Jump Jet";
	$JumpJetsTonnage *= 2;
	$JJCost = 500;
	$JJCrit = 2;
	$JJCrits = $_POST['Jumping'] * 2;
	$JumpJetSN = 'i' . $JumpJetSN;
} else { // Standard
	$JJTitle = "Jump Jet";
	$JJCost = 200;
	$JJCrit = 1;
	$JJCrits = $_POST['Jumping'];
}


// Advanced Movement Types
switch ($_POST['AdvanceMP']) {
	case 1: // MASC
		$SpecialTonnage = (int)(($_POST['Tonnage'] / $MASC) + 0.9);
		$SpecialCrits = (int)(($_POST['Tonnage'] / $MASC) + 0.9);
		$AdvancedCost = $EngineRating * $SpecialTonnage * 1000;
		$MascBV = 1;
		break;
	case 2: // Triple Strength
		$SpecialCrits = 6;
		$MascBV = 1;
		$AdvancedCost = $_POST['Tonnage'] * 14000;
		break;
	case 3: // Supercharger
		$SpecialTonnage = (int)(($EngineTonnage * 0.1) + 0.9);
		$SpecialCrits = 1;
		$AdvancedCost = $EngineRating * 10000;
		$MascBV = 1;
		break;
	default: // None
		$MascBV = 0;
		break;
}


// ---------------------------------
// Heat Sinks
// ---------------------------------

// Heat Sink Settings
if ($_POST['Engine'] > 7) {
	// ICE Engine
	$HSInternal = 0;
	$HSCrits = $_POST['HeatSinks'];
	$HSEngine = 0;
} else {
	$HSInternal = round(($EngineRating / 25) - 0.49);
	$HSCrits = ((10 - $HSInternal) + $_POST['HeatSinks']);
	if ($HSCrits < 0) $HSCrits = 0;
	$HSEngine = 10;
}

// Heat Sink Type
switch ($_POST['HSType']) {
	case 1: // Double
		$HSTotalCrits = $HSCrits * $SpHSCrits;
		$HeatDissapated = ($_POST['HeatSinks'] + $HSEngine) * 2;
		$HSCost = 6000;
		if ($_POST['Tech'] == 2) {
			// Clan
			$HSType = 4;	
		} else {
			// Inner Sphere
			$HSType = 1;
		}
		break;
	case 2: // Compact or Laser
		$HSTotalCrits = $HSCrits * $SpHSCrits;
		$HeatDissapated = ($_POST['HeatSinks'] + $HSEngine) * 2;
		if ($_POST['Tech'] == 1) {
			// Compact
			$HSCost = 3000;
			$HSType = 2;
		} else {
			// Laser
			$HSCost = 6000;
			$HSType = 3;	
		}
		break;
	default: // Single
		$HSTotalCrits = $HSCrits;
		$HeatDissapated = $_POST['HeatSinks'] + $HSEngine;
		$HSCost = 2000;
		$HSType = 0;
		break;
}


// ---------------------------------
// Other Components
// ---------------------------------
 
// Gyro Type
switch ($_POST['Gyro']) {
	case 1: // Compact
		$GyroTonnage = gyroTonnage($EngineRating, 1.5, 0);
		$GyroCrits = -2;
		$GyroCost = 400000;
		break;
	case 2: // Heavy-duty	
		$GyroTonnage = gyroTonnage($EngineRating, 2, 0);
		$GyroCost = 500000;
		break;
	case 3: // XL
		$GyroTonnage = gyroTonnage($EngineRating, 2, 1);
		$GyroCrits = 2;
		$GyroCost = 750000;
		break;
	default: // Standard
		$GyroTonnage = gyroTonnage($EngineRating, 1, 0);
		$GyroCost = 300000;
		break;
}

// Cockpit Type
switch ($_POST['Cockpit']) {
	case 1: // Small Cockpit
		$CockpitTonnage = 2;
		$CockpitCrits = 2;
		$CockpitCost = 175000;
		break;
	case 2: // Enhanced Imaging
		$CockpitCrits = 1;
		$CockpitTonnage = 3;
		$CockpitCost = 400000;
		break;
	case 3: // Command Console
		$CockpitCrits = 0;
		$CockpitTonnage = 6;
		$CockpitCost = 250000;
		break;
	case 4: // Torso Mounted
		$CockpitCrits = 3;
		$CockpitCost = 750000;
		break;
	default: // Standard
		$CockpitCrits = 1;
		$CockpitTonnage = 3;
		$CockpitCost = 200000;
		break;
}


// ---------------------------------
// Internal Structure
// ---------------------------------

// Internal Structure Type
switch ($_POST['ISType']) {
	case 1: // Endo Steel
		$ISCrits = $SpISCrits;
		$ISTonnage = roundNearHalf($_POST['Tonnage'] / 20);
		$ISCost = 1600;
		break;
	case 2: // Composite
		$ISTonnage = roundNearHalf($_POST['Tonnage'] / 20);
		$ISCost = 1600;
		break;
	case 3: // Reinforced
		$ISTonnage = ($_POST['Tonnage'] / 10) * 2;
		$ISCost = 6400;
		break;
	default: // Standard
		$ISTonnage = $_POST['Tonnage'] / 10;
		$ISCost = 400;
		break;
}

// IndustrialMech Internal Structure
if ($_POST['Mods'] == 3) $ISTonnage *= 2;

// Internal Structure Points
$ISC = internalstructPoints('ISC', $_POST['Tonnage'], $_POST['Legs']);
$IST = internalstructPoints('IST', $_POST['Tonnage'], $_POST['Legs']);
$ISL = internalstructPoints('ISL', $_POST['Tonnage'], $_POST['Legs']);
$ISA = internalstructPoints('ISA', $_POST['Tonnage'], $_POST['Legs']);


// ---------------------------------
// External Armor
// ---------------------------------

// Max armor values
$MaxHead = 9;
$MaxArms = $ISA * 2;
$MaxLegs = $ISL * 2;
$MaxTorso = $IST * 2;
$MaxCT = $ISC * 2;

// Max out all the armor locations on a Mech
if ($_POST['ArmorPercent']) {
	$MaxHead = (int)($MaxHead * $_POST['ArmorPercent'] + 0.99);
	$MaxArms = (int)($MaxArms * $_POST['ArmorPercent'] + 0.99);
	$MaxLegs = (int)($MaxLegs * $_POST['ArmorPercent'] + 0.99);
	$MaxTorso = (int)($MaxTorso * $_POST['ArmorPercent'] + 0.99);
	$MaxCT = (int)($MaxCT * $_POST['ArmorPercent'] + 0.99);
	
	$_POST['ArmorHead'] = $MaxHead;
	$_POST['ArmorCT'] = $MaxCT;
	$_POST['ArmorCTR'] = $MaxCT;
	$_POST['ArmorRT'] = $MaxTorso;
	$_POST['ArmorRTR'] = $MaxTorso;
	$_POST['ArmorLT'] = $MaxTorso;
	$_POST['ArmorLTR'] = $MaxTorso;
	$_POST['ArmorRA'] = $MaxArms;
	$_POST['ArmorLA'] = $MaxArms;
	$_POST['ArmorRL'] = $MaxLegs;
	$_POST['ArmorLL'] = $MaxLegs;
}

// Check if armor value is over maximum armor
$_POST['ArmorHead'] = maximumValue(lessThanZero($_POST['ArmorHead']), $MaxHead);
$_POST['ArmorRA'] = maximumValue(lessThanZero($_POST['ArmorRA']), $MaxArms);
$_POST['ArmorLA'] = maximumValue(lessThanZero($_POST['ArmorLA']), $MaxArms);
$_POST['ArmorRL'] = maximumValue(lessThanZero($_POST['ArmorRL']), $MaxLegs);
$_POST['ArmorLL'] = maximumValue(lessThanZero($_POST['ArmorLL']), $MaxLegs);

// Check front/rear balance
$CenterTorso = explode(",", rearArmor(lessThanZero($_POST['ArmorCT']), lessThanZero($_POST['ArmorCTR']), $MaxCT));
$LeftTorso = explode(",", rearArmor(lessThanZero($_POST['ArmorLT']), lessThanZero($_POST['ArmorLTR']), $MaxTorso));
$RightTorso = explode(",", rearArmor(lessThanZero($_POST['ArmorRT']), lessThanZero($_POST['ArmorRTR']), $MaxTorso));

$_POST['ArmorCT'] = $CenterTorso[0];
$_POST['ArmorCTR'] = $CenterTorso[1];
$_POST['ArmorLT'] = $LeftTorso[0];
$_POST['ArmorLTR'] = $LeftTorso[1];
$_POST['ArmorRT'] = $RightTorso[0];
$_POST['ArmorRTR'] = $RightTorso[1];

// Add up Armor
$ArmorTotal = $_POST['ArmorHead'] + $_POST['ArmorCT'] + $_POST['ArmorCTR'] + $_POST['ArmorRT'] + $_POST['ArmorRTR'] + $_POST['ArmorLT'] + $_POST['ArmorLTR'] + $_POST['ArmorRA'] + $_POST['ArmorLA'] + $_POST['ArmorRL'] + $_POST['ArmorLL'];
$ArmorMax = 9 + ($ISC + ($IST * 2) + ($ISA * 2) + ($ISL * 2)) * 2;

// Armor Type
switch ($_POST['Armor']) {
	case 1: // Ferro-Fibrous
		$ArmorCrits = $FerroCrits;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, ferroMultiplier($_POST['Tech']));
		$ArmorCost = 20000;
		break;
	case 2: // Hardened
		$ArmorTonnage = armorTonnage($ArmorTotal, 8, 0);
		$ArmorCost = 15000;
		$RunningMod = 1;
		break;
	case 3: // Laser-Reflective
		$ArmorCrits = $LaserRefCrits;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 30000;
		break;
	case 4: // Reactive
		$ArmorCrits = $FerroCrits;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 30000;
		break;
	case 5: // Light Ferro-Fibrous
		$ArmorCrits = 7;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 1.06);
		$ArmorCost = 15000;
		break;
	case 6: // Heavy Ferro-Fibrous
		$ArmorCrits = 21;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 1.24);
		$ArmorCost = 25000;
		break;
	case 7: // Stealth
		$ArmorCrits = 12;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 50000;
		break;
	default: // Standard
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 10000;
		break;
}

// Check for Armor errors
if ($ArmorTonnage < 0) $ArmorTonnage = 0;
if ($ArmorTotal < 1) $ArmorTonnage = 0;


// --------------------------------
// Melee Weapons and Arm Actuators
// --------------------------------

if ($_POST['Legs'] == 4) {
	// Quad Legged
	$LeftArmActCrits = 2;
	$RightArmActCrits = 2;
	$LeftMeleeWeapon = 0;
	$RightMeleeWeapon = 0;
	$LeftArmCost = $_POST['Tonnage'] * 350;
	$RightArmCost = $_POST['Tonnage'] * 350;
} else {
	$LeftArmCost = $_POST['Tonnage'] * 230;
	$RightArmCost = $_POST['Tonnage'] * 230;

	// Left Arm Actuators
	switch ($_POST['LAActuators']) {
		case 1: // No Hand
			$LeftMeleeWeapon = 0;
			$LeftArmActCrits = 1;
			$LeftArmCost = $_POST['Tonnage'] * 150;
			break;
		case 2: // No Hand and No Lower Arm
			$LeftMeleeWeapon = 0;
			$LeftArmActCrits = 0;
			$LeftArmCost = $_POST['Tonnage'] * 100;
			break;
		case 4: // Hatchet
			$LeftMeleeWeapon = meleeWeaponTons(4);
			$LeftMeleeWeaponCrits = meleeWeaponCrits(4);
			$LeftArmActCrits = 2;
			$MeleeBV = $LeftMeleeWeapon * 1.5;
			$LeftArmCost += ($LeftMeleeWeapon * 5000);
			break;
		case 5: // Sword
			$LeftMeleeWeapon = meleeWeaponTons(5);
			$LeftMeleeWeaponCrits = meleeWeaponCrits(5);
			$LeftArmActCrits = 2;
			$MeleeBV = $LeftMeleeWeapon * 1.725;
			$LeftArmCost += ($LeftMeleeWeapon * 10000);
			break;
		case 6: // Mace
			$LeftMeleeWeapon = meleeWeaponTons(6);
			$LeftMeleeWeaponCrits = meleeWeaponCrits(6);
			$LeftArmActCrits = 2;
			$MeleeBV = $LeftMeleeWeapon * 1.5;
			$LeftArmCost += ($LeftMeleeWeapon * 5000);
			break;
		case 7: // Claw
			$LeftMeleeWeapon = meleeWeaponTons(7);
			$LeftMeleeWeaponCrits = meleeWeaponCrits(7);
			$LeftArmActCrits = 2;
			$MeleeBV = $LeftMeleeWeapon * 1.5;
			$LeftArmCost += ($LeftMeleeWeapon * 5000);
			break;
		case 8: // Retractable Blade
			$LeftMeleeWeapon = meleeWeaponTons(8);
			$LeftMeleeWeaponCrits = meleeWeaponCrits(8) + 1;
			$LeftArmActCrits = 2;
			$MeleeBV = $LeftMeleeWeapon * 1.5;
			$LeftArmCost += ($LeftMeleeWeapon * 7000);
			break;
		default: // Hand and Lower Arm
			$LeftMeleeWeapon = 0;
			$LeftArmActCrits = 2;
			break;
	}
	
	// Right Arm Actuators
	switch ($_POST['RAActuators']) {
		case 1: // No Hand
			$RightMeleeWeapon = 0;
			$RightArmActCrits = 1;
			$RightArmCost = $_POST['Tonnage'] * 150;
			break;
		case 2: // No Hand and No Lower Arm
			$RightMeleeWeapon = 0;
			$RightArmActCrits = 0;
			$RightArmCost = $_POST['Tonnage'] * 100;
			break;
		case 4: // Hatchet
			$RightMeleeWeapon = meleeWeaponTons(4);
			$RightMeleeWeaponCrits = meleeWeaponCrits(4);
			$RightArmActCrits = 2;
			$MeleeBV += $RightMeleeWeapon * 1.5;
			$RightArmCost += ($RightMeleeWeapon * 5000);
			break;
		case 5: // Sword
			$RightMeleeWeapon = meleeWeaponTons(5);
			$RightMeleeWeaponCrits = meleeWeaponCrits(5);
			$RightArmActCrits = 2;
			$MeleeBV += $RightMeleeWeapon * 1.725;
			$RightArmCost += ($RightMeleeWeapon * 10000);
			break;
		case 6: // Mace
			$RightMeleeWeapon = meleeWeaponTons(6);
			$RightMeleeWeaponCrits = meleeWeaponCrits(6);
			$RightArmActCrits = 2;
			$MeleeBV += $RightMeleeWeapon * 1.5;
			$RightArmCost += ($RightMeleeWeapon * 5000);
			break;
		case 7: // Claw
			$RightMeleeWeapon = meleeWeaponTons(7);
			$RightMeleeWeaponCrits = meleeWeaponCrits(7);
			$RightArmActCrits = 2;
			$MeleeBV += $RightMeleeWeapon * 1.5;
			$RightArmCost += ($RightMeleeWeapon * 5000);
			break;
		case 8: // Retractable Blade
			$RightMeleeWeapon = meleeWeaponTons(8);
			$RightMeleeWeaponCrits = meleeWeaponCrits(8) + 1;
			$RightArmActCrits = 2;
			$MeleeBV += $RightMeleeWeapon * 1.5;
			$RightArmCost += ($RightMeleeWeapon * 7000);
			break;
		default: // Hand and Lower Arm
			$RightMeleeWeapon = 0;
			$RightArmActCrits = 2;
			break;
	}
}

// General Critical Locations
$CritsHead_Max = $CockpitCrits;
$CritsCT_Max = 2 - $GyroCrits - $CTEngineCrits;
$CritsLL_Max = 2;
$CritsRL_Max = 2;
$CritsLT_Max = 12 - $EngineCrits;
$CritsRT_Max = 12 - $EngineCrits;

// Number of Legs Crits
if ($_POST['Legs'] == 4) {
	$CritsLA_Max = 2;
	$CritsRA_Max = 2;
	$Crits = 35;
} else {
	$CritsLA_Max = 10 - $LeftArmActCrits - $LeftMeleeWeapon;
	$CritsRA_Max = 10 - $RightArmActCrits - $RightMeleeWeapon;
	$Crits = 50 + $CockpitCrits - $RightArmActCrits - $LeftArmActCrits;
}


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
			if ($WeaponsOnly[$w]['crits'] > 11) {
				// Split locations
				$ListWeapons .= $LocationsSP;
			} else {
				// Select the locations list by the weapons's crits
				if ($WeaponsOnly[$w]['crits'] > 2 && $_POST['Legs'] == 4) $ListWeapons .= $LocationsT;
				if ($WeaponsOnly[$w]['crits'] > 2 && $_POST['Legs'] == 2) $ListWeapons .= $LocationsC3;
				if ($WeaponsOnly[$w]['crits'] == 2) $ListWeapons .= $LocationsC2;
				if ($WeaponsOnly[$w]['crits'] == 1) $ListWeapons .= $LocationsC1;
				if ($WeaponsOnly[$w]['special'] == 1) $ListWeapons .= "<option value=\"1\" disabled=\"disabled\">---</option>" . $LocationsSP;
			}
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsOnly[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsOnly[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsOnly[$w]['crits'] . "\" /> ";
			$ListWeapons .= $WeaponsOnly[$w]['name'] . " [" . $WeaponsOnly[$w]['crits'] . "]</li>";

			// Get totals for laser and ballistic weapons
			if ($WeaponsOnly[$w]['type'] == 1 || $WeaponsOnly[$w]['type'] == 2 && $WeaponsOnly[$w]['name'] == 'Flamer' && $WeaponsOnly[$w]['name'] == 'Machine Gun' && $WeaponsOnly[$w]['name'] == 'Flamer (Vehicle)') {
				$DirectFireWeapons += $WeaponsOnly[$w]['tons'];
				$DirectFireWeaponsBV += $WeaponsOnly[$w]['bv'];
			}
			
			// Check for ICE engine and energy weapons
			if ($_POST['Engine'] == 8 && $WeaponsOnly[$w]['type'] == 1) $Amplifier += $WeaponsOnly[$w]['tons'];

			// Add to the totals
			$TotalWeaponsTonnage += $WeaponsOnly[$w]['tons'];
			$TotalWeaponsCrits += $WeaponsOnly[$w]['crits'];
			$MaxDamage += $WeaponsOnly[$w]['damage'];
			$MaxHeat += $WeaponsOnly[$w]['heat'];
			$WeaponsCost += $WeaponsOnly[$w]['cost'];
			$WeaponsBV += $WeaponsOnly[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Weapons[$w]);
	$w++;
} while (count($WeaponsOnly) > $w);


// Power Amplifier for ICE engines
if ($_POST['Engine'] == 8) $Amplifier = roundNearHalf($Amplifier * 0.1);


// Display Selected Ammo
$Ammunition = preg_split("/,/", $_POST['Ammunition']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Ammunition[$w]) {
			$ListWeapons .= startSelect($id);
			$ListWeapons .= $LocationsHS;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsAmmo[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsAmmo[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsAmmo[$w]['crits'] . "\" /> ";			
			$ListWeapons .= $WeaponsAmmo[$w]['name'] . " [" . $WeaponsAmmo[$w]['crits'] . "]</li>";
			
			$TotalWeaponsTonnage += $WeaponsAmmo[$w]['tons'];
			$TotalWeaponsCrits += $WeaponsAmmo[$w]['crits'];
			$WeaponsCost += $WeaponsAmmo[$w]['cost'];
			$AmmoBV += $WeaponsAmmo[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Ammunition[$w]);
	$w++;
} while (count($WeaponsAmmo) > $w);


// Display Selected Equipment
$Equipment = preg_split("/,/", $_POST['Equipment']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Equipment[$w]) {
			$ListEquipment .= startSelect($id);

			if ($WeaponsEquip[$w]['special'] == 3) {
				$ListEquipment .= $LocationsTA;
			} else if ($WeaponsEquip[$w]['special'] == 4) {
				$ListEquipment .= $LocationsHS;
			} else {
				if ($WeaponsEquip[$w]['crits'] > 2) $ListEquipment .= $LocationsHS3;
				if ($WeaponsEquip[$w]['crits'] == 2) $ListEquipment .= $LocationsHS2;
				if ($WeaponsEquip[$w]['crits'] == 1) $ListEquipment .= $LocationsHS;
				if ($WeaponsEquip[$w]['special'] == 3) $ListEquipment .= $LocationsTA;
			}

			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsEquip[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsEquip[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsEquip[$w]['crits'] . "\" /> ";
			$ListEquipment .= $WeaponsEquip[$w]['name'] . " [" . $WeaponsEquip[$w]['crits'] . "]</li>";
			
			$TotalWeaponsTonnage += $WeaponsEquip[$w]['tons'];
			$TotalWeaponsCrits += $WeaponsEquip[$w]['crits'];
			$WeaponsCost += $WeaponsEquip[$w]['cost'];
			$WeaponsBV += $WeaponsEquip[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Equipment[$w]);
	$w++;
} while (count($WeaponsEquip) > $w);


// Display Selected Industrial Equipment
$Industrial = preg_split("/,/", $_POST['Industrial']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Industrial[$w]) {
			$ListEquipment .= startSelect($id);

			if ($WeaponsIndust[$w]['crits'] > 2) $ListEquipment .= $LocationsHS3;
			if ($WeaponsIndust[$w]['crits'] == 2) $ListEquipment .= $LocationsHS2;
			if ($WeaponsIndust[$w]['crits'] == 1) $ListEquipment .= $LocationsHS;
			if ($WeaponsIndust[$w]['special'] == 3) $ListEquipment .= $LocationsTA;

			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsIndust[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsIndust[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $WeaponsIndust[$w]['crits'] . "\" /> ";
			$ListEquipment .= $WeaponsIndust[$w]['name'] . " [" . $WeaponsIndust[$w]['crits'] . "]</li>";
			
			$TotalWeaponsTonnage += $WeaponsIndust[$w]['tons'];
			$TotalWeaponsCrits += $WeaponsIndust[$w]['crits'];
			$WeaponsCost += $WeaponsIndust[$w]['cost'];
			//$WeaponsBV += $Weapons_IS_Industrial[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Industrial[$w]);
	$w++;
} while (count($WeaponsIndust) > $w);


// Display MASC
if ($_POST['AdvanceMP'] == 1) {
	$ListEquipment .= startSelect($id);
	if ($SpecialCrits > 2) $ListEquipment .= $LocationsHS3;
	if ($SpecialCrits == 2) $ListEquipment .= $LocationsHS2;
	if ($SpecialCrits == 1) $ListEquipment .= $LocationsHS;
	$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"MASC\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"MASC\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $SpecialCrits . "\" /> MASC <small>[" . $SpecialCrits . "]</li>";
	$id++;
}


// Display Supercharger
if ($_POST['AdvanceMP'] == 3) {
	$ListEquipment .= startSelect($id);
	if ($_POST['Engine'] == 1 OR $_POST['Engine'] == 2) {
		$ListEquipment .= $LocationsTA;
	} else {
		$ListEquipment .= $LocationCT;
	}
	$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"Supercharger\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"SCharge\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $SpecialCrits . "\" /> Supercharger [" . $SpecialCrits . "]</li>";
	$id++;
}


// Targeting System Type
switch ($_POST['Targeting']) {
	case 1: // Targeting Computer
		if ($DirectFireWeapons > 0) {
			if ($_POST['Tech'] == 2) {
				$TargetingTonnage = round($DirectFireWeapons / 5);
				$TargetingCrits = intval(($TargetingTonnage) + 0.5);
			} else {
				$TargetingTonnage = round($DirectFireWeapons / 4);
				$TargetingCrits = intval(($TargetingTonnage) + 0.5);
			}
			if ($TargetingTonnage < 1) $TargetingTonnage = 1;
			if ($TargetingCrits < 1) $TargetingCrits = 1;

			// Display Targeting Computer
			$ListEquipment .= startSelect($id);
			if ($TargetingCrits > 2) $ListEquipment .= $LocationsHS3;
			if ($TargetingCrits == 2) $ListEquipment .= $LocationsHS2;
			if ($TargetingCrits == 1) $ListEquipment .= $LocationsHS;
			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"Targeting Computer\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"TComp\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $TargetingCrits . "\" /> Targeting Computer [" . $TargetingCrits . "]</li>";
			$id++;
			$WeaponsBV += ($DirectFireWeaponsBV * 0.2);
		}
		$SensorsCost = (10000 * $TargetingTonnage) + 5000;
		break;
	case 2: // Long-Range
		$SensorsCost = 2000;
		break;
	case 3: // Short-Range
		$SensorsCost = 2000;
		break;
	case 4: // Variable-Range
		$SensorsCost = 10000;
		$TargetingTonnage = 0.5;
		$TargetingCrits = 1;
		$ListEquipment .= startSelect($id);
		$ListEquipment .= $LocationHead;
		$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"Variable-Range System\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"1\" /> Variable-Range System [1]</li>";
		$id++;
		break;
	case 5: // Anit-Aircraft
		$SensorsCost = 2000;
		break;
	case 6: // Multi-Trac
		$SensorsCost = 2000;
		break;
	case 7: // Multi-Trac II
		$SensorsCost = 5000;
		$TargetingTonnage = 0.5;
		$TargetingCrits = 1;
		$ListEquipment .= startSelect($id);
		$ListEquipment .= $LocationHead;
		$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"Multi-Trac II System\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"1\" /> Multi-Trac II System [1]</li>";
		$id++;
		break;
	case 8: // Enhanced Satellite Uplink
		$SensorsCost = 3000;
		break;
	case 9: // Null-Signature System
		$SensorsCost = 2000000;
		$MaxHeat += 10;
		$TargetingCrits = 7;
		break;
	default: // Standard
		$SensorsCost = 2000;
		break;
}


// Display Selected Jump Jets
for ($j = 0; $j < $_POST['Jumping']; $j++) {
	$ListEquipment .= startSelect($id);
	$ListEquipment .= $LocationsJJ;
	$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $JJTitle . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $JumpJetSN . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $JJCrit . "\" /> " . $JJTitle . " [" . $JJCrit . "]</li>";
	$id++;
}


// Display Selected Heat Sinks
for ($h = 0; $h < $HSCrits; $h++) {
	$ListHeatSinks .= startSelect($id);
	if ($_POST['HSType'] == 1) {
		if ($_POST['Tech'] == 1) {
			// Inner Sphere
			$ListHeatSinks .= $LocationsHS3;
		} else {
			// Clan
			$ListHeatSinks .= $LocationsHS2;	
		}
	} else {
		$ListHeatSinks .= $LocationsHS;
	}
	$ListHeatSinks .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $Weapons_HeatSinks[$HSType]['name'] . "\" /><input type=\"hidden\" name=\"ItemCrits" . $id . "\" value=\"" . $Weapons_HeatSinks[$HSType]['crits'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $Weapons_HeatSinks[$HSType]['sn'] . "\" />";
	$ListHeatSinks .= " " . $Weapons_HeatSinks[$HSType]['name'];
	$ListHeatSinks .= " [" . $Weapons_HeatSinks[$HSType]['crits'] . "]</li>";
	$id++;
}

// Add melee weapon damage to total
$MaxDamage += meleeWeaponDamage($_POST['LAActuators']) + meleeWeaponDamage($_POST['RAActuators']);


// ---------------------------------
// Final Totals
// ---------------------------------

// Tonnage Remaining
$TonnageRemaining = $_POST['Tonnage'] - $CockpitTonnage - $_POST['HeatSinks'] - $EngineTonnage - $GyroTonnage - $ISTonnage - $JumpJetsTonnage - $ArmorTonnage - $SpecialTonnage - $TotalWeaponsTonnage - $LeftMeleeWeapon - $RightMeleeWeapon - $LAMTonnage - $TargetingTonnage - $Amplifier;

// Crits Remaining
$CritsRemaining = $Crits - $HSTotalCrits - $JJCrits - $ISCrits - $ArmorCrits - ($EngineCrits * 2) - $CTEngineCrits - $LeftMeleeWeaponCrits - $RightMeleeWeaponCrits - $TotalWeaponsCrits - $SpecialCrits - $GyroCrits - $TargetingCrits;

// Total Cost
$TotalCost = 50000 + $CockpitCost + ($_POST['Tonnage'] * $SensorsCost) + ($_POST['Tonnage'] * 2000) + ($_POST['Tonnage'] * $ISCost) + $LeftArmCost + $RightArmCost + (($EngineCost * $EngineRating * $_POST['Tonnage']) / 75) + ($GyroTonnage * $GyroCost) + ($_POST['Tonnage'] * ($_POST['Jumping'] * $_POST['Jumping']) * $JJCost) + (($_POST['HeatSinks'] + 10) * $HSCost) + ($ArmorTonnage * $ArmorCost) + $AdvancedCost + $WeaponsCost;

// Cost for CASE on Clan mechs (generic rough value)
if ($_POST['Tech'] == 2 && $AmmoBV > 0) $TotalCost += 100000;

switch ($_POST['Mods']) {
	case 1: // OmniMech
		$TotalCost *= 1.25 * (1 + ($_POST['Tonnage'] / 100));
		break;
	case 2: // LAM
		$TotalCost *= 1.75 * (1 + ($_POST['Tonnage'] / 100));
		break;
	case 3: // IndustrialMech
		$TotalCost *= (1 + ($_POST['Tonnage'] / 400));	
		break;
	default: // Battlemech
		$TotalCost *= (1 + ($_POST['Tonnage'] / 100));
		break;
}


// Battle Value
if ($HeatDissapated < $MaxHeat) {
	$HeatDis = ($MaxHeat - $HeatDissapated) * 5;
} else {
	$HeatDis = $MaxHeat;
}

// BV Defense
$DefenceBV = $_POST['Tonnage'] + ($ArmorTotal * 2) + ((3 + $ISC + ($ISA * 2) + ($ISL * 2) + ($IST * 2)) * $EngineBV) - $HeatDis;

if ($_POST['Jumping'] > 4) {
	$Walk = $_POST['Walking'];
	$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Walk] + 1];
} else {
	$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Running]];
}

// BV Offense
$WeaponsBV += $MeleeBV - $AmmoBV;
if ($MaxHeat) {
	$X = ($HeatDissapated * $WeaponsBV) / $MaxHeat;
} else {
	$X = 0;
}
$Y = ($WeaponsBV - $X) / 2;
$SpeedBV = $_POST['Jumping'] + $Running + $MascBV;

if ($SpeedBV > 26) {
	$OffenceBV = ($X + $Y) * 4.12;
} else {
	$OffenceBV = ($X + $Y) * $arrSpeedFac[$SpeedBV];
}

$TotalBV = $DefenceBV + $OffenceBV;

if ($_POST['Mods'] == 2) $TotalBV *= 0.75;


// ---------------------------------
// Final Output
// ---------------------------------

// Split value
define('SPLIT', '||');

// Return data to the client
echo engineMake($EngineRating) . " " . ($EngineRating); // Engine Rating
echo SPLIT . $EngineTonnage; // Engine Tonnage
echo SPLIT . decimalPlaces($TonnageRemaining, 2); // Tonnage Remaining
echo SPLIT . decimalPlaces($_POST['Tonnage'], 1); // Tonnage
echo SPLIT . ($Running - $RunningMod); // Running
echo SPLIT . weightClass($_POST['Tonnage']); // Weight Class
echo SPLIT . decimalPlaces($JumpJetsTonnage, 1); // JumpJets Tonnage
echo SPLIT . decimalPlaces($GyroTonnage, 1); // Gyro Tonnage
echo SPLIT . decimalPlaces($ISTonnage, 1); // IS Tonnage
echo SPLIT . decimalPlaces($ArmorTonnage, 1); // Armor Tonnage
echo SPLIT . ($_POST['Walking'] * 2); // Sprinting
echo SPLIT . $CritsRemaining; // Crits Remaining
echo SPLIT . $Crits; // Total Crits
echo SPLIT . decimalPlaces($SpecialTonnage, 1); // Special Movement Tonnage
echo SPLIT . $ISC * 2; // IS Center Torso
echo SPLIT . $IST * 2; // IS Torsos
echo SPLIT . $ISA * 2; // IS Arms
echo SPLIT . $ISL * 2; // IS Legs
echo SPLIT . $ListWeapons; // All Weapons
echo SPLIT . $MaxDamage; // Total Weapon Damage
echo SPLIT . ($MaxHeat + 2); // Total Weapon Heat
echo SPLIT . largeNumber($TotalCost); // Total Cost
echo SPLIT . largeNumber($TotalBV); // Total Battle Value
echo SPLIT . $ArmorTotal; // Total Armor Points
echo SPLIT . $ArmorMax; // Max Armor Points
echo SPLIT . decimalPlaces($_POST['HeatSinks'], 1); // Heat Sinks Tonnage
echo SPLIT . $HeatDissapated; // Heat Disapated
echo SPLIT . $_POST['ArmorHead']; // H Armor
echo SPLIT . $_POST['ArmorCT']; // CT Armor
echo SPLIT . $_POST['ArmorCTR']; // CTR Armor
echo SPLIT . $_POST['ArmorLT']; // LT Armor
echo SPLIT . $_POST['ArmorLTR']; // LTR Armor
echo SPLIT . $_POST['ArmorRT']; // RT Armor
echo SPLIT . $_POST['ArmorRTR']; // RTR Armor
echo SPLIT . $_POST['ArmorLA']; // LA Armor
echo SPLIT . $_POST['ArmorRA']; // RA Armor
echo SPLIT . $_POST['ArmorLL']; // LL Armor
echo SPLIT . $_POST['ArmorRL']; // RL Armor
echo SPLIT . $ListEquipment; // All Equipment and Jumpjets
echo SPLIT . $ListHeatSinks; // All HeatSinks
echo SPLIT . decimalPlaces($MaxDamage / $_POST['Tonnage'], 2); // Damage Per Ton
echo SPLIT . $CritsHead_Max; // Head Crits
echo SPLIT . $CritsCT_Max; // CT Crits
echo SPLIT . $CritsLT_Max; // LT Crits
echo SPLIT . $CritsRT_Max; // RT Crits
echo SPLIT . $CritsLA_Max; // LA Crits
echo SPLIT . $CritsRA_Max; // RA Crits
echo SPLIT . $CritsLL_Max; // LL Crits
echo SPLIT . $CritsRL_Max; // RL Crits
echo SPLIT . $id; // Number of Weapons
echo SPLIT . decimalPlaces($LeftMeleeWeapon, 1); // Right Melee Weapon Tons
echo SPLIT . decimalPlaces($RightMeleeWeapon, 1); // Left Melee Weapon Tons
echo SPLIT . decimalPlaces($CockpitTonnage, 1); // Cockpit Tons
echo SPLIT . decimalPlaces($TargetingTonnage, 1); // Targeting Tons


?>