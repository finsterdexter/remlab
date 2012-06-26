<?php // Structure and Installation Calculations

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


// Number of crew members
$BaseCrewNum = roundNearWhole($_POST['Tonnage'] / 15, 0.5);
if ($BaseCrewNum < 1) $BaseCrewNum = 1;

// Max weapons and equipment allowed
$MaxWeaponTons = $_POST['Tonnage'] / 10;
$MaxWeaponTurretTons = $_POST['Tonnage'] / 10;
$MaxAmmoTons = $_POST['Tonnage'] / 2;

switch ($_POST['Mods']) {
	case 1: // Building
		$CostMult = 150;
		break;
	case 2: // Hangar
		$CostMult = 175;
		break;
	case 3: // Bridge
		$CostMult = 150;
		break;
	case 4: // Wall
		$CostMult = 200;
		break;
	default: // Fortress
		$CostMult = 75;
		break;
}


// Fortress only
if ($_POST['Mods'] == 0) {
	$ArmorMax = $_POST['Tonnage'];
	
	if ($_POST['ArmorPercent']) {
		$_POST['ArmorB'] = (int)($ArmorMax * $_POST['ArmorPercent'] + 0.99);
	}
	
	// Add up Armor
	$_POST['ArmorB'] = intval($_POST['ArmorB']);
	
	// Armor Type
	$ArmorTonnage = armorTonnage($_POST['ArmorB'], 16, 0);
	
	// Check for Armor errors
	if ($ArmorTonnage < 0) $ArmorTonnage = 0;
	if ($_POST['ArmorB'] < 1) $ArmorTonnage = 0;
} else {
	$_POST['ArmorB'] = 0;
	$ArmorMax = 0;
	$MaxWeaponTons = 0;
	$MaxAmmoTons = 0;
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
$Totalheat = 0;

// Display Selected Weapons
$Weapons = preg_split("/,/", $_POST['Weapons']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Weapons[$w]) {
			// Create the entry in the Allocate box
			$ListWeapons .= startSelect($id);
			if ($_POST['Turret']) {
				$ListWeapons .= $LocationsIT;
			} else {
				$ListWeapons .= $LocationsI;			
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
				$Totalheat += $WeaponsOnly[$w]['heat'];
				$Amplifier += $WeaponsOnly[$w]['tons'];
			}

			// Add to the totals
			$TotalWeaponsTonnage += $WeaponsOnly[$w]['tons'];
			//$TotalWeaponsCrits += 1;
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
$Amplifier = roundNearHalf($Amplifier * 0.1);

// Display Selected Ammo
$Ammunition = preg_split("/,/", $_POST['Ammunition']);

$w = 0;

do {
	$i = 0;
	do {
		if ($Ammunition[$w]) {
			$ListWeapons .= startSelect($id);
			$ListWeapons .= $LocationsI;
			$ListWeapons .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsAmmo[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsAmmo[$w]['sn'] . "\" /> ";			
			$ListWeapons .= $WeaponsAmmo[$w]['name'] . "</li>";
			
			$TotalAmmoTonnage += $WeaponsAmmo[$w]['tons'];
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
				$ListEquipment .= $LocationsIT;
			} else {
				$ListEquipment .= $LocationsI;			
			}
			$ListEquipment .= "</select><input type=\"hidden\" name=\"Item" . $id . "\" value=\"" . $WeaponsEquip[$w]['name'] . "\" /><input type=\"hidden\" name=\"SN" . $id . "\" value=\"" . $WeaponsEquip[$w]['sn'] . "\" /> ";
			$ListEquipment .= $WeaponsEquip[$w]['name'] . "</li>";
			
			$TotalWeaponsTonnage += $WeaponsEquip[$w]['tons'];
			$WeaponsCost += $WeaponsEquip[$w]['cost'];
			$WeaponsBV += $WeaponsEquip[$w]['bv'];

			$id++;
			$i++;
		}
	} while ($i < $Equipment[$w]);
	$w++;
} while (count($WeaponsEquip) > $w);


// ---------------------------------
// Final Totals
// ---------------------------------

// Tonnage Remaining
$TonnageRemaining = $MaxWeaponTons - $TotalWeaponsTonnage;

// Total Cost
$TotalCost = ($_POST['Tonnage'] * 10000) + (($_POST['DoorLevels'] * 10000) * $_POST['Door']) + ($Totalheat * 2000) + ($ArmorTonnage * 60000) + $WeaponsCost + ($MaxWeaponTurretTons * 5000) + ($Amplifier * 20000);

$TotalCost *= (1 + ($_POST['Tonnage'] / $CostMult)) * $_POST['Hexes'];


// Battle Value
if ($_POST['Mods'] == 0) {
	// BV Defense
	$DefenceBV = $ArmorTotal;
	$DefenceBV *= $arrDefenceFac[0];
	
	// BV Offense
	//$WeaponsBV -= $AmmoBV;
	
	$X = 0;
	$Y = ($WeaponsBV - $X) / 2;
	
	$OffenceBV = $X + $Y;
	
	$TotalBV = $DefenceBV + $OffenceBV;
} else {
	$TotalBV = 0;
}

// ---------------------------------
// Final Output
// ---------------------------------

// Split value
define('SPLIT', '||');

// Return data to the client
echo decimalPlaces($TonnageRemaining, 1); // Tonnage Remaining
echo SPLIT . decimalPlaces($_POST['Tonnage'], 1); // Tonnage
echo SPLIT . weightClassInstallation($_POST['Tonnage']); // Weight Class
echo SPLIT . decimalPlaces($ArmorTonnage, 1); // Armor Tonnage
echo SPLIT . decimalPlaces($MaxWeaponTons, 1); // Tonnage Available
echo SPLIT . $ListWeapons; // All Weapons
echo SPLIT . $MaxDamage; // Total Weapon Damage
echo SPLIT . largeNumber($TotalCost); // Total Cost
echo SPLIT . largeNumber($TotalBV); // Total Battle Value
echo SPLIT . $_POST['ArmorB']; // Total Armor Points
echo SPLIT . $_POST['ArmorB']; // Base Armor
echo SPLIT . $ArmorMax; // Base Armor Max
echo SPLIT . decimalPlaces($MaxDamage / $_POST['Tonnage'], 2); // Damage Per Ton
echo SPLIT . $id; // Number of Weapons
echo SPLIT . $BaseCrewNum; // Base Crew Size
echo SPLIT . $ListEquipment; // All Equipment
echo SPLIT . decimalPlaces($MaxAmmoTons, 1); // Max Ammo Tons
echo SPLIT . decimalPlaces($MaxAmmoTons - $TotalAmmoTonnage, 1); // Ammo Tons Remaining
echo SPLIT . $Totalheat; // Heat sinks
echo SPLIT . $Amplifier; // Power Amp

?>