<?php // Combat Vehicle Calculations

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
	$FerroCrits = 2;
	$LaserRefCrits = 1;
	$SpEngineCrits = 1;
} else {
	// Inner Sphere
	$FerroCrits = 2;
	$LaserRefCrits = 1;
	$SpEngineCrits = 2;
}

// Unit specific variables
switch ($_POST['Mods']) {
	case 1: // Wheeled
		$LiftDive = 0;
		$CostMult = 200;
		break;
	case 2: // Hovercraft
		$LiftDive = roundNearHalf($_POST['Tonnage'] * 0.1);
		$CostMult = 50;
		break;
	case 3: // WiGE
		$LiftDive = roundNearHalf($_POST['Tonnage'] * 0.1);
		$CostMult = 75;
		break;
	case 4 OR 5: // Submarine and Displacement Hull
		$LiftDive = roundNearHalf($_POST['Tonnage'] * 0.1);
		$CostMult = 200;
		break;
	case 6: // Hydrofoil
		$LiftDive = roundNearHalf($_POST['Tonnage'] * 0.1);
		$CostMult = 75;
		break;
	case 7: // VTOL
		$LiftDive = roundNearHalf($_POST['Tonnage'] * 0.1);
		$CostMult = 30;
		$RotorCost = $LiftDive * 40000;
		break;
	default: // Tracked
		$LiftDive = 0;
		$CostMult = 100;
		break;
}

// Suspension Factor
$Suspension = suspensionFactor($_POST['Mods'], $_POST['Tonnage']);

// Number of crew members
$BaseCrewNum = roundNearWhole($_POST['Tonnage'] / 15, 0.5);
if ($BaseCrewNum < 1) $BaseCrewNum = 1;
$ExtraCrew = $_POST['Crew'] / 2;

// Item slots
$ItemSlots = roundNearWhole($_POST['Tonnage'] / 5, 0.5) + 5;

// Cockpit/Controls weight
$CockpitTonnage = roundNearHalf($_POST['Tonnage'] * 0.05);


// ---------------------------------
// Engine and Movement
// ---------------------------------

// Cruising Modifier
$CruisingMod = advancedVehMPMod($_POST['AdvanceMP']);

// Engine Rating
$EngineRating = intval(roundUpFive($_POST['Tonnage']) * ($_POST['Walking'] + $CruisingMod)) - $Suspension;
if ($EngineRating < 5) $EngineRating = 5;

// Flanking speed
$Running = runningSpeed($_POST['Walking']);

// Engine Type
switch ($_POST['Engine']) {
	case 1: // Fusion XL
		$EngineCrits = $SpEngineCrits;
		$EngineTonnage = decimalPlaces(engineMass(2, 0, $EngineRating) * 1.5, 2);
		$EngineCost = 20000;
		$EngineBV = 0.75;
		break;
	case 2: // Fusion XXL
		$EngineCrits = $SpEngineCrits + 1;
		$EngineTonnage = decimalPlaces(engineMass(3, 0, $EngineRating) * 1.5, 2);
		$EngineCost = 100000;
		$EngineBV = 0.5;
		break;
	case 3: // Fusion Large
		$EngineCrits = $SpEngineCrits + 2;
		$EngineTonnage = decimalPlaces(engineMass(0, 0, $EngineRating) * 1.5, 1);
		$EngineCost = 10000;
		$EngineBV = 1.5;
		break;
	case 4: // Fusion XL Large
		$EngineCrits = ($SpEngineCrits * 2) + 2;
		$EngineTonnage = decimalPlaces(engineMass(2, 0, $EngineRating) * 1.5, 1);
		$EngineCost = 40000;
		$EngineBV = 0.75;
		break;
	case 5: // Fusion XXL Large
		$EngineCrits = (($SpEngineCrits + 1) * 2) + 2;
		$EngineTonnage = decimalPlaces(engineMass(3, 0, $EngineRating) * 1.5, 2);
		$EngineCost = 200000;
		$EngineBV = 0.5;
		break;
	case 6: // Light
		$EngineCrits = 1;
		$EngineTonnage = decimalPlaces(engineMass(1.5, 0, $EngineRating) * 1.5, 1);
		$EngineCost = 15000;
		$EngineBV = 1.5;
		break;
	case 7: // Compact
		$EngineCrits = 0;
		$CTEngineCrits = -3;
		$EngineTonnage = decimalPlaces(engineMass(1.5, 1, $EngineRating) * 1.5, 2);
		$EngineCost = 10000;
		$EngineBV = 1.5;
		break;
	case 8: // ICE
		$EngineCrits = 0;
		$EngineTonnage = engineMass(2, 1, $EngineRating);
		$EngineCost = 1250;
		$EngineBV = 1;
		break;
	case 9: // Fuel Cell
		$EngineCrits = 0;
		$EngineTonnage = engineMass(1.2, 1, $EngineRating);
		$EngineCost = 3500;
		$EngineBV = 1;
		break;
	case 10: // Fission
		$EngineCrits = 0;
		$EngineTonnage = engineMass(1.75, 1, $EngineRating);
		$EngineCost = 7500;
		$EngineBV = 1;
		break;
	default: // Fusion
		$EngineCrits = 0;
		$EngineTonnage = decimalPlaces(engineMass(0, 0, $EngineRating) * 1.5, 1);
		$EngineCost = 5000;
		$EngineBV = 1.5;
		break;
}

// Advanced Movement Types
switch ($_POST['AdvanceMP']) {
	case 1: // Amphibious
		$SpecialTonnage = roundNearHalf($_POST['Tonnage'] * 0.1);
		$SpecialCrits = 0;
		$AdvancedCost = 10000 * $SpecialTonnage;
		break;
	case 2: // Snowmobile
		$SpecialTonnage = 0;
		$SpecialCrits = 0;
		$AdvancedCost = $_POST['Tonnage'] * $_POST['Tonnage'] * 1;
		break;
	case 3: // Dune Buggy
		$SpecialTonnage = 0;
		$SpecialCrits = 0;
		$AdvancedCost = $_POST['Tonnage'] * $_POST['Tonnage'] * 10;
		break;
	case 4: // Supercharger
		$SpecialTonnage = roundNearHalf($EngineTonnage * 0.1);
		$SpecialCrits = 1;
		$AdvancedCost = $EngineRating * 10000;
		break;
	case 5: // Dual Rotors
		$SpecialTonnage = 0;
		$SpecialCrits = 0;
		$AdvancedCost = $LiftDive * 40000;
		break;
	case 6: // Co-Axial Rotors
		$SpecialTonnage = 0;
		$SpecialCrits = 0;
		$AdvancedCost = $LiftDive * 40000;
		break;
	default: // none
		$SpecialTonnage = 0;
		$SpecialCrits = 0;
		$AdvancedCost = 0;
		break;
}


// ---------------------------------
// Heat Sinks
// ---------------------------------

// Heat Sink Settings
if ($_POST['Engine'] > 7) {
	$HSEngine = 0;
} else {
	$HSEngine = 10;
}


// ---------------------------------
// Internal Structure
// ---------------------------------

// Internal Structure Type
$ISTonnage = roundNearHalf($_POST['Tonnage'] * 0.1);

// Internal Structure armor points
$InternalArmor = roundNearWhole($_POST['Tonnage'] * 0.1, 0.5);


// ---------------------------------
// External Armor
// ---------------------------------

if ($_POST['ArmorPercent']) {
	$_POST['ArmorF'] = $_POST['ArmorPercent'] * 12;
	$_POST['ArmorRS'] = $_POST['ArmorPercent'] * 10;
	$_POST['ArmorLS'] = $_POST['ArmorPercent'] * 10;
	$_POST['ArmorR'] = $_POST['ArmorPercent'] * 8;
	if ($_POST['Mods'] == 7) {
		$_POST['ArmorT'] = 2;
	} else {
		if ($_POST['SpTop'] == 1) $_POST['ArmorT'] = $_POST['ArmorPercent'] * 10;
	}
}

// VTOL rotor armor
if ($_POST['Mods'] == 7 && $_POST['ArmorT'] > 2) $_POST['ArmorT'] = 2; 

// Add up Armor
$ArmorTotal = $_POST['ArmorF'] + $_POST['ArmorRS'] + $_POST['ArmorLS'] + $_POST['ArmorR'] + $_POST['ArmorT'];
$ArmorMax = 600;

// Armor Type
switch ($_POST['Armor']) {
	case 1: // Ferro-Fibrous
		$ArmorCrits = $FerroCrits;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, ferroMultiplier($_POST['Tech']));
		$ArmorCost = 20000;
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
		$ArmorCrits = 1;
		$ArmorTonnage = armorTonnage($ArmorTotal, 16, 1.06);
		$ArmorCost = 15000;
		break;
	case 6: // Heavy Ferro-Fibrous
		$ArmorCrits = 3;
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
// Special Equipment
// ----------------------------------

// Front Mount
switch ($_POST['SpFront']) {
	case 1: // Bulldozer Blade
		$SpFrontTons = 2;
		$SpFrontSlots = 1;
		$SpFrontCost = 50000;
		break;
	case 2: // Minesweeper
		$SpFrontTons = 3;
		$SpFrontSlots = 1;
		$SpFrontCost = 40000;
		break;
	case 3: // VTOL Sensors
		$SpFrontTons = 0.25;
		$SpFrontSlots = 1;
		$SpFrontCost = 75000;
		break;
	case 4: // VTOL Camera
		$SpFrontTons = 0.5;
		$SpFrontSlots = 1;
		$SpFrontCost = 90000;
		break;
	default: // none
		$SpFrontTons = 0;
		$SpFrontSlots = 0;
		$SpFrontCost = 0;
		break;
}

// Top Mount
switch ($_POST['SpTop']) {
	case 1: // Turret
		$SpTopTons = 0;
		$SpTopSlots = 0;
		$SpTopCost = 5000;
		break;
	case 2: // Bridge Layer Light
		$SpTopTons = 1;
		$SpTopSlots = 1;
		$SpTopCost = 40000;
		break;
	case 3: // Bridge Layer Med
		$SpTopTons = 2;
		$SpTopSlots = 1;
		$SpTopCost = 75000;
		break;
	case 4: // Bridge Layer Heavy
		$SpTopTons = 6;
		$SpTopSlots = 1;
		$SpTopCost = 100000;
		break;
	case 5: // Mast-mount
		$SpTopTons = 0.5;
		$SpTopSlots = 0;
		$SpTopCost = 50000;
		break;
	default: // none
		$SpTopTons = 0;
		$SpTopSlots = 0;
		$SpTopCost = 0;
		break;
}

// Rear Mount
switch ($_POST['SpRear']) {
	case 1: // Coolant
		$SpRearTons = 9;
		$SpRearSlots = 1;
		$SpRearCost = 90000;
		break;
	case 2: // MASH (small)
		$SpRearTons = 3.5;
		$SpRearSlots = 1;
		$SpRearCost = 35000;
		break;
	case 3: // MASH (large)
		$SpRearTons = 6.5;
		$SpRearSlots = 1;
		$SpRearCost = 65000;
		break;
	case 4: // Mobile HQ (small)
		$SpRearTons = 3;
		$SpRearSlots = 1;
		$SpRearCost = 30000;
		break;
	case 5: // Mobile HQ (large)
		$SpRearTons = 7;
		$SpRearSlots = 1;
		$SpRearCost = 70000;
		break;
	case 6: // Jet boosters
		$SpRearTons = (int)(($EngineTonnage * 0.1) + 0.9);;
		$SpRearSlots = 0;
		$SpRearCost = $EngineRating * 10000;
		break;
	default: // none
		$SpRearTons = 0;
		$SpRearSlots = 0;
		$SpRearCost = 0;
		break;
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
			if ($_POST['SpTop'] == 1) {
				$ListWeapons .= $LocationsGVT;
			} else {
				$ListWeapons .= $LocationsGV;			
			}
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
			$MaxDamage += $WeaponsOnly[$w]['damage'];
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
			$ListWeapons .= $LocationsGVI;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsAmmo[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsAmmo[$w]['sn'] . "\" /> ";			
			$ListWeapons .= $WeaponsAmmo[$w]['name'] . "</li>";
			
			$TotalWeaponsTonnage += $WeaponsAmmo[$w]['tons'];
			$TotalWeaponsCrits += 1;
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
			if ($_POST['SpTop'] == 1) {
				$ListEquipment .= $LocationsGVT;
			} else {
				$ListEquipment .= $LocationsGV;			
			}
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


// Display Selected Industrial Equipment
$Industrial = preg_split("/,/", $_POST['Industrial']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Industrial[$w]) {
			$ListEquipment .= startSelect($id);
			if ($_POST['SpTop'] == 1) {
				$ListEquipment .= $LocationsGVT;
			} else {
				$ListEquipment .= $LocationsGV;			
			}
			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsIndust[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsIndust[$w]['sn'] . "\" /> ";
			$ListEquipment .= $WeaponsIndust[$w]['name'] . "</li>";
			
			$TotalWeaponsTonnage += $WeaponsIndust[$w]['tons'];
			$TotalWeaponsCrits += 1;
			$WeaponsCost += $WeaponsIndust[$w]['cost'];
			//$WeaponsBV += $Weapons_IS_Industrial[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Industrial[$w]);
	$w++;
} while (count($WeaponsIndust) > $w);


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


// ---------------------------------
// Final Totals
// ---------------------------------

// Tonnage Remaining
$TonnageRemaining = $_POST['Tonnage'] - $Totalheat - $ExtraCrew - $CockpitTonnage - $EngineTonnage - $ISTonnage - $ArmorTonnage - $SpecialTonnage - $TotalWeaponsTonnage - $TargetingTonnage - $Amplifier - $LiftDive - $_POST['CargoSpace'] - $SpFrontTons - $SpTopTons - $SpRearTons - $SpSideTons;

// Crits Remaining
$ItemSlotsRemaining = $ItemSlots - $ArmorCrits - $EngineCrits - $TotalWeaponsCrits - $SpecialCrits - $TargetingCrits - $SpFrontSlots - $SpTopSlots - $SpRearSlots - $SpSideSlots;

// Total Cost
$TotalCost = ($CockpitTonnage * 10000) + ($_POST['Tonnage'] * $SensorsCost) + ($_POST['Tonnage'] * 2000) + ($_POST['Tonnage'] * 10000) + (($EngineCost * $EngineRating * $_POST['Tonnage']) / 75) + ($_POST['HeatSinks'] * 2000) + ($ArmorTonnage * $ArmorCost) + ($LiftDive * 20000) + $RotorCost + ($Amplifier * 20000) + $AdvancedCost + $WeaponsCost + $SpFrontCost + $SpTopCost + $SpRearCost + $SpSideCost + ($_POST['Crew'] * 5000);


$TotalCost *= (1 + ($_POST['Tonnage'] / $CostMult));


// Battle Value

// BV Defense
$DefenceBV = $_POST['Tonnage'] + ($ArmorTotal * 2) + (($InternalArmor * 4) * $EngineBV);
$DefenceBV *= $arrDefenceFac[$arrTargetMod[$Running]];

// BV Offense
$WeaponsBV -= $AmmoBV;

$Y = $WeaponsBV / 2;

if ($Running > 26) {
	$OffenceBV = $Y * 4.12;
} else {
	$OffenceBV = $Y * $arrSpeedFac[$Running];
}

$TotalBV = $DefenceBV + $OffenceBV;


// ---------------------------------
// Final Output
// ---------------------------------

// Split value
define('SPLIT', '||');

// Return data to the client
echo engineMake($EngineRating) . " " . $EngineRating; // Engine Rating
echo SPLIT . $EngineTonnage; // Engine Tonnage
echo SPLIT . decimalPlaces($TonnageRemaining, 2); // Tonnage Remaining
echo SPLIT . decimalPlaces($_POST['Tonnage'], 1); // Tonnage
echo SPLIT . $Running; // Running
echo SPLIT . weightClass($_POST['Tonnage']); // Weight Class
echo SPLIT . decimalPlaces($ArmorTonnage, 1); // Armor Tonnage
echo SPLIT . $ItemSlotsRemaining; // Crits Remaining
echo SPLIT . $ItemSlots; // Total Item slots
echo SPLIT . decimalPlaces($SpecialTonnage, 1); // Special Movement Tonnage
echo SPLIT . $ListWeapons; // All Weapons
echo SPLIT . $MaxDamage; // Total Weapon Damage
echo SPLIT . $Totalheat; // Total Weapon Heat
echo SPLIT . largeNumber($TotalCost); // Total Cost
echo SPLIT . largeNumber($TotalBV); // Total Battle Value
echo SPLIT . $ArmorTotal; // Total Armor Points
echo SPLIT . decimalPlaces($Totalheat, 1); // Heat Sinks Tonnage
echo SPLIT . $_POST['ArmorF']; // Front Armor
echo SPLIT . $_POST['ArmorLS']; // Left side Armor
echo SPLIT . $_POST['ArmorRS']; // Right side Armor
echo SPLIT . $_POST['ArmorR']; // Rear Armor
echo SPLIT . $_POST['ArmorT']; // Turret/Rotor Armor
echo SPLIT . decimalPlaces($MaxDamage / $_POST['Tonnage'], 2); // Damage Per Ton
echo SPLIT . $id; // Number of Weapons
echo SPLIT . decimalPlaces($TargetingTonnage, 1); // Targeting Tons
echo SPLIT . $BaseCrewNum; // Base Crew Size
echo SPLIT . $_POST['Crew']; // Additional Crew and Tons
echo SPLIT . decimalPlaces($ExtraCrew, 1); // Additional Crew and Tons
echo SPLIT . decimalPlaces($Amplifier, 1); // Power Amplifier
echo SPLIT . $ListEquipment; // All Equipment
echo SPLIT . decimalPlaces($_POST['CargoSpace'], 1); // Cargo Space
echo SPLIT . $LiftDive; // Lift/Drive Equipment
echo SPLIT . $CockpitTonnage; // Control Equipment
echo SPLIT . decimalPlaces($SpFrontTons, 1); // Front Tons
echo SPLIT . decimalPlaces($SpTopTons, 1); // Top tons
echo SPLIT . decimalPlaces($SpRearTons, 1); // Rear tons
echo SPLIT . decimalPlaces($SpSideTons, 1); // Side tons

?>