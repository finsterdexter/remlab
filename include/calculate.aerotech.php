<?php // Aerotech Fighter Calculations

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
	$EngineWeightFactor = 0.061;
} else {
	// Inner Sphere
	$EngineWeightFactor = 0.065;
}

// Max Thrust speed
$Running = intval(($_POST['Walking'] + 0.5) * 1.5);

// Structural Integrity
if ($_POST['StructuralIntegrity'] < $Running) $_POST['StructuralIntegrity'] = $Running;
if ($_POST['StructuralIntegrity'] > $Running * 30) $_POST['StructuralIntegrity'] = $Running * 30;

// Fighter additional crew is zero
if ($_POST['Mods'] < 2) $_POST['Crew'] = 0;

// Aerotech type
switch ($_POST['Mods']) {
	case 1: // Conventional fighter
		$EngineMod = 0;
		$FuelPoints = 160;
		$CockpitTonnage = roundNearHalf($_POST['Tonnage'] * 0.1);
		$BaseCrewNum = 1;
		$CrewMass = $_POST['Crew'];	
		$ArmorMax = $_POST['Tonnage'];
		$PassengerTons = 1;
		$ItemSpace = 5;
		$FoodWater = 0;
		$Hardpoints = roundNearWhole($_POST['Tonnage'] / 5, -0.5);
		$CockpitCost = $_POST['Tonnage'] * 4000;
		$StructIntegrity = structuralIntegrity($_POST['Walking'], $_POST['Tonnage']);
		$SIMass = 0;		
		$SICost = $StructIntegrity * 4000;
		break;
	case 2: // Small Craft (aero)
		$EngineMod = 0;
		$FuelPoints = 80;
		$CockpitTonnage = roundNearHalf($_POST['Tonnage'] * 0.0075);
		$BaseCrewNum = 3;
		$CrewMass = ($BaseCrewNum + $_POST['Crew']) * 2;
		$ItemSpace = 12;
		$Hardpoints = 0;
		$FoodWater = 1;
		$PassengerTons = 5;
		$CockpitCost = 500000 + ($_POST['Tonnage'] * 2000);
		$StructIntegrity = $_POST['StructuralIntegrity'];
		$SICost = $StructIntegrity * 50000;
		$SIMass = intval(($StructIntegrity * $_POST['Tonnage']) / 200);
		$ArmorMax = intval(($StructIntegrity * 4.5) * 16);
		break;
	case 3: // Small Craft (Sphere)
		$EngineMod = 0;
		$FuelPoints = 80;
		$CockpitTonnage = roundNearHalf($_POST['Tonnage'] * 0.0075);
		$BaseCrewNum = 3;
		$CrewMass = ($BaseCrewNum + $_POST['Crew']) * 2;
		$ItemSpace = 12;
		$Hardpoints = 0;
		$FoodWater = 1;
		$PassengerTons = 5;
		$CockpitCost = 500000 + ($_POST['Tonnage'] * 2000);
		$StructIntegrity = $_POST['StructuralIntegrity'];
		$SICost = $StructIntegrity * 50000;
		$SIMass = intval(($StructIntegrity * $_POST['Tonnage']) / 500);
		$ArmorMax = intval(($StructIntegrity * 3.6) * 16);
		break;
	default: // Aerospace fighter
		$EngineMod = 2;
		$FuelPoints = 80;
		$CockpitTonnage = (3);
		$BaseCrewNum = 1;
		$CrewMass = $_POST['Crew'];
		$ArmorMax = $_POST['Tonnage'] * 8;
		$PassengerTons = 1;
		$ItemSpace = 5;
		$FoodWater = 0;
		$Hardpoints = roundNearWhole($_POST['Tonnage'] / 5, -0.5);
		$CockpitCost = 250000 + ($_POST['Tonnage'] * 2000);
		$StructIntegrity = structuralIntegrity($_POST['Walking'], $_POST['Tonnage']);
		$SIMass = 0;
		$SICost = $StructIntegrity * 50000;
		break;
}


// ---------------------------------
// Engine and Movement
// ---------------------------------

// Advanced Movement Types
switch ($_POST['AdvanceMP']) {
	case 1: // VSTOL
		$SpecialTonnage = roundNearHalf($_POST['Tonnage'] * 0.05);
		$AdvancedCost = 10000 * $SpecialTonnage;
		break;
	default: // none
		$SpecialTonnage = 0;
		$AdvancedCost = 0;
		$CruisingMod = 0;
		break;
}

if ($_POST['Mods'] > 1) {
	// Engine rating for Small Craft
	$EngineTonnage = ($_POST['Tonnage'] * $_POST['Walking']) * $EngineWeightFactor;
	$EngineCost = 5000;
	$EngineBV = 1.5;
	$EngineRating = '';
} else {
	// Engine Rating for Fighters
	$EngineRating = intval(roundUpFive($_POST['Tonnage']) * ($_POST['Walking'] - $EngineMod));
	if ($EngineRating < 10) $EngineRating = 10;
	
	// Engine Type
	switch ($_POST['Engine']) {
		case 1: // Fusion XL
			$EngineTonnage = engineMass(2, 0, $EngineRating);
			$EngineCost = 20000;
			$EngineBV = 0.75;
			break;
		case 2: // Fusion XXL
			$EngineTonnage = engineMass(3, 0, $EngineRating);
			$EngineCost = 100000;
			$EngineBV = 0.5;
			break;
		case 3: // Fusion Large
			$EngineTonnage = engineMass(0, 0, $EngineRating);
			$EngineCost = 10000;
			$EngineBV = 1.5;
			break;
		case 4: // Fusion XL Large
			$EngineTonnage = engineMass(2, 0, $EngineRating);
			$EngineCost = 40000;
			$EngineBV = 0.75;
			break;
		case 5: // Fusion XXL Large
			$EngineTonnage = engineMass(3, 0, $EngineRating);
			$EngineCost = 200000;
			$EngineBV = 0.5;
			break;
		case 6: // Light
			$EngineTonnage = engineMass(1.5, 0, $EngineRating);
			$EngineCost = 15000;
			$EngineBV = 1.5;
			break;
		case 7: // Compact
			$EngineCrits = 0;
			$CTEngineCrits = -3;
			$EngineTonnage = engineMass(1.5, 1, $EngineRating);
			$EngineCost = 10000;
			$EngineBV = 1.5;
			break;
		case 8: // ICE / Turbine
			$EngineTonnage = engineMass(2, 1, $EngineRating);
			$EngineCost = 1250;
			$EngineBV = 1;
			break;
		default: // Fusion
			$EngineTonnage = engineMass(0, 0, $EngineRating);
			$EngineCost = 5000;
			$EngineBV = 1.5;
			break;
	}
}

// Conventional fighter fusion engine shielding
if ($_POST['Engine'] != 8 && $_POST['Mods'] == 1) $EngineTonnage = decimalPlaces($EngineTonnage * 1.5, 1);

// ---------------------------------
// Heat Sinks
// ---------------------------------

// Heat Sink Settings
if ($_POST['Engine'] > 7) {
	$HSEngine = 0;
} else {
	$HSEngine = 10;
}

// Heat Sink Type
switch ($_POST['HSType']) {
	case 1: // Double
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
		$HeatDissapated = $_POST['HeatSinks'] + $HSEngine;
		$HSCost = 2000;
		$HSType = 0;
		break;
}



// ---------------------------------
// External Armor
// ---------------------------------

if ($_POST['ArmorPercent']) {
	$_POST['ArmorN'] = intval($_POST['ArmorPercent'] * ($ArmorMax / 4));
	$_POST['ArmorRW'] = intval($_POST['ArmorPercent'] * ($ArmorMax / 4));
	$_POST['ArmorLW'] = intval($_POST['ArmorPercent'] * ($ArmorMax / 4));
	$_POST['ArmorA'] = intval($_POST['ArmorPercent'] * ($ArmorMax / 4));
}

// Make sure armor points are greater than zero
$_POST['ArmorN'] = lessThanZero($_POST['ArmorN']);
$_POST['ArmorRW'] = lessThanZero($_POST['ArmorRW']);
$_POST['ArmorLW'] = lessThanZero($_POST['ArmorLW']);
$_POST['ArmorA'] = lessThanZero($_POST['ArmorA']);

// Add up Armor
$ArmorTotal = $_POST['ArmorN'] + $_POST['ArmorRW'] + $_POST['ArmorLW'] + $_POST['ArmorA'];

// Check to see if the total armor points are less than the max armor points
if ($ArmorTotal > $ArmorMax) {
	$_POST['ArmorN'] = intval($ArmorMax / 4);
	$_POST['ArmorRW'] = intval($ArmorMax / 4);
	$_POST['ArmorLW'] = intval($ArmorMax / 4);
	$_POST['ArmorA'] = intval($ArmorMax / 4);
}

// Armor Type
switch ($_POST['Armor']) {
	case 1: // Ferro-Aluminum
		$ArmorCritsWings = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, ferroMultiplier($_POST['Tech']));
		$ArmorCost = 20000;
		break;
	case 3: // Laser-Reflective
		$ArmorCritsWings = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 30000;
		break;
	case 4: // Reactive
		$ArmorCritsWings = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 30000;
		break;
	case 5: // Light Ferro-Aluminum
		$ArmorCritsAft = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 1.06);
		$ArmorCost = 15000;
		break;
	case 6: // Heavy Ferro-Aluminum
		$ArmorCritsWings = 1;
		$ArmorCritsAft = 1;
		$ArmorCritsNose = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 1.24);
		$ArmorCost = 25000;
		break;
	default: // Standard
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 0);
		$ArmorCost = 10000;
		break;
}

// Check for Armor errors
if ($ArmorTonnage < 0) $ArmorTonnage = 0;
if ($ArmorTotal < 1) $ArmorTonnage = 0;


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
			$ListWeapons .= $LocationsAF;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsOnly[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsOnly[$w]['sn'] . "\" /><input type=\"hidden\" name=\"ItemTons" . $id . "\" value=\"" . $WeaponsOnly[$w]['tons'] . "\" /> ";
			$ListWeapons .= $WeaponsOnly[$w]['name'] . " </li>";

			// Get totals for laser and ballistic weapons
			if ($WeaponsOnly[$w]['type'] == 1 || $WeaponsOnly[$w]['type'] == 2 && $WeaponsOnly[$w]['name'] == 'Flamer' && $WeaponsOnly[$w]['name'] == 'Machine Gun' && $WeaponsOnly[$w]['name'] == 'Flamer (Vehicle)') {
				$DirectFireWeapons += $WeaponsOnly[$w]['tons'];
				$DirectFireWeaponsBV += $WeaponsOnly[$w]['bv'];
			}
			
			// Add up heat from energy weapons
			if ($WeaponsOnly[$w]['type'] == 1) {
				$Totalheat += $WeaponsOnly[$w]['heat'] - $HSEngine;
				// Check for ICE engine
				if ($_POST['Engine'] == 8) $Amplifier += $WeaponsOnly[$w]['tons'];
			}
			// Add to the totals
			$TotalWeaponsTonnage += $WeaponsOnly[$w]['tons'];
			$TotalWeaponsCrits += 1;
			$MaxHeat += $WeaponsOnly[$w]['heat'];
			$MaxDamage += $WeaponsOnly[$w]['damage'];
			$WeaponsCost += $WeaponsOnly[$w]['cost'];
			$WeaponsBV += $WeaponsOnly[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Weapons[$w]);
	$w++;
} while (count($WeaponsOnly) > $w);

// Power Amplifier for Turbine engines
if ($_POST['Engine'] == 8) $Amplifier = roundNearHalf($Amplifier * 0.1);

// Display Selected Ammo
$Ammunition = preg_split("/,/", $_POST['Ammunition']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Ammunition[$w]) {
			$ListWeapons .= startSelect($id);
			$ListWeapons .= $LocationsAFA;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsAmmo[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsAmmo[$w]['sn'] . "\" /> ";			
			$ListWeapons .= $WeaponsAmmo[$w]['name'] . "</li>";
			
			$TotalWeaponsTonnage += $WeaponsAmmo[$w]['tons'];
			$TotalWeaponsCrits += 0;
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
			$ListEquipment .= $LocationsAF;
			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsEquip[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsEquip[$w]['sn'] . "\" /> ";
			$ListEquipment .= $WeaponsEquip[$w]['name'] . "</li>";
			
			$TotalWeaponsTonnage += $WeaponsEquip[$w]['tons'];
			$TotalWeaponsCrits += 1;
			$WeaponsCost += $WeaponsEquip[$w]['cost'];
			$WeaponsBV += $WeaponsEquip[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Equipment[$w]);
	$w++;
} while (count($WeaponsEquip) > $w);


// Targeting System Type
switch ($_POST['Targeting']) {
	case 1: // Targeting Computer
		if ($DirectFireWeapons > 0) {
			if ($_POST['Tech'] == 2) {
				$TargetingTonnage = round($DirectFireWeapons / 5);
				$TargetingCrits = 1;
			} else {
				$TargetingTonnage = round($DirectFireWeapons / 4);
				$TargetingCrits = 1;
			}
			if ($TargetingTonnage < 1) $TargetingTonnage = 1;

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
		break;
	case 8: // Enhanced Satellite Uplink
		$SensorsCost = 3000;
		break;
	default: // Standard
		$SensorsCost = 2000;
		break;
}

// Number of Gunners
if ($id && $_POST['Mods'] > 1) {
	$_POST['Gunners'] = intval($id / 6);
} else {
	$_POST['Gunners'] = 0;
}



// ---------------------------------
// Final Totals
// ---------------------------------

// Tonnage Remaining
$TonnageRemaining = $_POST['Tonnage'] - $CrewMass - ($_POST['Gunners'] * 2) - ($_POST['Passengers'] * $PassengerTons) - $FoodWater - ($_POST['Lifeboat'] * 7) - $_POST['HeatSinks'] - $_POST['Fuel'] - $CockpitTonnage - $EngineTonnage - $ArmorTonnage - $SpecialTonnage - $TotalWeaponsTonnage - $TargetingTonnage - $Amplifier - $_POST['CargoSpace'];

// Crits Remaining
$ItemSlotsRemaining = ($ItemSpace * 4) - ($ArmorCritsWings * 2) - $ArmorCritsAft - $ArmorCritsNose - $TotalWeaponsCrits - $TargetingCrits;

// Total Cost
$TotalCost = $CockpitCost + $SICost + (($EngineCost * $EngineRating * $_POST['Tonnage']) / 75) + ($_POST['HeatSinks'] * $HSCost) + ($ArmorTonnage * $ArmorCost) + ($Amplifier * 20000) + $AdvancedCost + $WeaponsCost + ($_POST['Crew'] * 5000);

$TotalCost *= (1 + ($_POST['Tonnage'] / 200));


// Battle Value
if ($HeatDissapated < $MaxHeat) {
	$HeatDis = ($MaxHeat - $HeatDissapated) * 5;
} else {
	$HeatDis = $MaxHeat;
}

// BV Defense
$DefenceBV = $_POST['Tonnage'] + ($ArmorTotal * 2) + $EngineBV;

$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Running]];

// BV Offense
$WeaponsBV -= $AmmoBV;
if ($MaxHeat) {
	$X = ($HeatDissapated * $WeaponsBV) / $MaxHeat;
} else {
	$X = 0;
}
$Y = ($WeaponsBV - $X) / 2;

if ($Running > 26) {
	$OffenceBV = ($X + $Y) * 4.12;
} else {
	$OffenceBV = ($X + $Y) * $arrSpeedFac[$Running];
}

$TotalBV = $DefenceBV + $OffenceBV;

//0.1 tons of food = 7 days for 3
//0.5 tons of food = 35 days for 3

// ---------------------------------
// Final Output
// ---------------------------------

// Split value		$CockpitCost = 250000;
define('SPLIT', '||');

// Return data to the client
echo engineMake($EngineRating) . " " . ($EngineRating); // Engine Rating
echo SPLIT . $EngineTonnage; // Engine Tonnage
echo SPLIT . decimalPlaces($TonnageRemaining, 2); // Tonnage Remaining
echo SPLIT . decimalPlaces($_POST['Tonnage'], 1); // Tonnage
echo SPLIT . $Running; // Max Thrust
echo SPLIT . weightClassAero($_POST['Tonnage']); // weight Class
echo SPLIT . decimalPlaces($ArmorTonnage, 1); // Armor Tonnage
echo SPLIT . $ItemSlotsRemaining; // Crits Remaining
echo SPLIT . ($ItemSpace * 4); // Total Item slots
echo SPLIT . decimalPlaces($SpecialTonnage, 1); // Special Movement Tonnage
echo SPLIT . $ListWeapons; // All Weapons
echo SPLIT . $MaxDamage; // Total Weapon Damage
echo SPLIT . largeNumber($TotalCost); // Total Cost
echo SPLIT . largeNumber($TotalBV); // Total Battle Value
echo SPLIT . $ArmorTotal; // Total Armor Points
echo SPLIT . decimalPlaces($_POST['HeatSinks'], 1); // Heat Sinks Tonnage
echo SPLIT . $HeatDissapated; // Heat Disapated
echo SPLIT . ($MaxHeat + 2); // Total Weapon Heat
echo SPLIT . $_POST['ArmorN']; // Nose Armor
echo SPLIT . $_POST['ArmorLW']; // Left Wing Armor
echo SPLIT . $_POST['ArmorRW']; // Right Wing Armor
echo SPLIT . $_POST['ArmorA']; // Aft Armor
echo SPLIT . decimalPlaces($MaxDamage / $_POST['Tonnage'], 2); // Damage Per Ton
echo SPLIT . $id; // Number of Weapons
echo SPLIT . decimalPlaces($TargetingTonnage, 1); // Targeting Tons
echo SPLIT . $BaseCrewNum; // Base Crew Size
echo SPLIT . $_POST['Crew']; // Additional Crew
echo SPLIT . decimalPlaces($_POST['Crew'] * 2, 1); // Additional Crew Tons
echo SPLIT . $ListEquipment; // All Equipment
echo SPLIT . decimalPlaces($_POST['CargoSpace'], 1); // Cargo Space
echo SPLIT . decimalPlaces($_POST['Fuel'], 1); // Fuel tonnage
echo SPLIT . ($ItemSpace - $ArmorCritsNose); // Nose space
echo SPLIT . ($ItemSpace - $ArmorCritsWings); // LW space
echo SPLIT . ($ItemSpace - $ArmorCritsWings); // RW space
echo SPLIT . ($ItemSpace - $ArmorCritsAft); // Aft space
echo SPLIT . $CockpitTonnage; // Cockpit mass
echo SPLIT . $StructIntegrity; // Structural Integrity
echo SPLIT . decimalPlaces($SIMass, 1); // SI Mass
echo SPLIT . decimalPlaces($_POST['Passengers'] * $PassengerTons, 1); // Passengers
echo SPLIT . decimalPlaces($_POST['Lifeboat'] * 7, 1); // Lifeboats
echo SPLIT . $ArmorMax; // Max armor points
echo SPLIT . $_POST['Gunners']; // Gunners
echo SPLIT . decimalPlaces($_POST['Gunners'] * 2, 1); // Gunner tons

?>