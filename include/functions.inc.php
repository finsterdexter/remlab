<?php // REMLAB settings and functions

// Settings
define('TITLE', 'REMLAB');
define('SUB_TITLE', 'Web Mech Designer');
define('VERSION', '2.9.12 BETA');
define('AUTHOR', 'http://remlab.sourceforge.net/');


// Clean the user input
function cleanInput($var) {
	return addslashes(strip_tags(trim($var)));
}

// Clean the output
function cleanOutput($var) {
	return stripslashes(strip_tags(trim($var)));
}

// Clean the overview text
function cleanOverview($var) {
	return nl2br(stripslashes(strip_tags(trim($var))));
}

// Replace zeros and null characters with a dash
function nullToDash($var) {
	if (trim($var) == NULL) {
		return '-';
	} else {
		return $var;
	}
}

// Replace null characters with a zero
function nullToZero($var) {
	if (trim($var) == NULL) {
		return 0;
	} else {
		return $var;
	}
}

// Check if value is less than zero and return zero
function lessThanZero($var) {
	if ($var < 0 || trim($var) == NULL || !is_numeric($var)) {
		return 0;
	} else {
		return $var;
	}
}

// Check the maximum value
function maximumValue($var, $Max) {
	if ($var > $Max) {
		return $Max;
	} else {
		return $var;	
	}
}

// Round to the up or down to the nearest whole number
function roundNearWhole($var, $direction) {
	return intval($var + $direction);
}

// Round to the nearest half number (0.5)
function roundNearHalf($var) {
	return round(($var + 0.2) * 2) / 2;
}

// Round up to the nearest five
function roundUpFive($var) {
	return round(($var + 2) / 5) * 5;
}

// Get the running, flank, max speed value from the walking value
function runningSpeed($var) {
	return intval(($var + 0.5) * 1.5);
}

// Tons to kilograms
function tonsToKG($var) {
	return intval($var * 1000);
}

// Add the Solaris multipier (4x) to value
function solarisMult($var) {
	if ($_POST['Level'] == 4 && $var) {
		return $var * 4;
	} else {
		return $var;
	}
}

// Start the select tag when listing the item allocations
function startSelect($id) {
	return "<li><select name=\"Location" . $id . "\" id=\"Location" . $id . "\" onchange=\"checkCrits()\"><option value=\"1\">-</option>";
}

// Display the trailing decimal places
function decimalPlaces($var, $places) {
	$places = explode(".", $var);
	$places = strlen($places[1]);
	if ($places < 1) $places = 1;
	if ($places > 2) $places = 2;
	return number_format($var, $places, '.', '');
}

// Display a long value with commas
function largeNumber($var) {
	return number_format($var, 0, '.', ',');
}

// Strip down a long value with commas
function stripComma($var) {
	return str_replace(',', '', $var);
}

// Get the faction from the corresponding number
function getFaction($Faction) {
	require('factions.db.php');
	return stripslashes($arrFaction[$Faction]);
}

// Display factions by selected catagory
function DisplayFactions($startID, $endID) {
	require('factions.db.php');
	for ($f = $startID; $f < $endID; $f++) {
		$faction .= "<option value=\"" . $f . "\">" . $arrFaction[$f] . "</option>";
	}
	return $faction;
}

// Display the header for the weapons table
function displayWeaponsHeader($acronym, $title, $width) {
	if ($width) $widthTag = " width=\"" . $width . "\"";
	if (!$title) {
		return "<th" . $widthTag . ">" . $acronym . "</th>";	
	} else {
		return "<th" . $widthTag . "><acronym title=\"" . $title . "\">" . $acronym . "</acronym></th>";
	}
}


// Print for Javascript purposes
function jsWeapons() {
	require('include/master.db.php');
	$i = 0;	
	do {
		$weapon .= "\t\t\t\",\" + dF." . $WeaponsFull[$i]['sn'] . ".value +\n";
		$i++;
	} while ($i < count($WeaponsFull));
	return $weapon;
}


// Display weapons by catagory in a table
function DisplayWeapons($TableID) {
	require('include/master.db.php');
	
	define('CELL_OPEN', "<td>");
	define('CELL_CLOSE', "</td>");	

	switch ($TableID) {
		case 'WT1':
			$WeaponsList = $Weapons_IS_Energy;
			break;
		case 'WT2':
			$WeaponsList = $Weapons_IS_Ballistic;
			break;
		case 'WT3':
			$WeaponsList = $Weapons_IS_Missle;
			break;
		case 'WT4':
			$WeaponsList = $Weapons_IS_Artillery;
			break;
		case 'WT5':
			$WeaponsList = $Weapons_IS_Equip;
			break;
		case 'WT6':
			$WeaponsList = $Weapons_IS_Industrial;
			break;
		case 'WT1c':
			$WeaponsList = $Weapons_Clan_Energy;
			break;
		case 'WT2c':
			$WeaponsList = $Weapons_Clan_Ballistic;
			break;
		case 'WT3c':
			$WeaponsList = $Weapons_Clan_Missle;
			break;
		case 'WT4c':
			$WeaponsList = $Weapons_Clan_Artillery;
			break;
		case 'WT5c':
			$WeaponsList = $Weapons_Clan_Equip;
			break;
		case 'WT6c':
			$WeaponsList = $Weapons_Clan_Industrial;
			break;
		case 'WTP':
			$WeaponsList = $Weapons_Protomech;
			break;
	}
	
	$weapon .= "<table id=\"" . $TableID . "\" cellspacing=\"1\">\n";
	$weapon .= "\t<tr class=\"TH\">";
	$weapon .= displayWeaponsHeader('&nbsp;#', 0, 45);
	$weapon .= displayWeaponsHeader('Type', 0, 185);
	$weapon .= displayWeaponsHeader('Heat', 0, 0);
	$weapon .= displayWeaponsHeader('Damage', 0, 0);
	$weapon .= displayWeaponsHeader('Min', 'Minimum range', 0);
	$weapon .= displayWeaponsHeader('Short', 'Short range', 0);
	$weapon .= displayWeaponsHeader('Med', 'Medium range', 0);
	$weapon .= displayWeaponsHeader('Long', 'Long range', 0);
	$weapon .= displayWeaponsHeader('Tons', 0, 0);
	$weapon .= displayWeaponsHeader('Crits', 0, 0);
	$weapon .= displayWeaponsHeader('Ammo', 'Shots per ton', 0);
	$weapon .= displayWeaponsHeader('Cost', 'Cost in C-bills', 0);
	$weapon .= displayWeaponsHeader('BV', 'Battle Value', 0);
	$weapon .= "\t</tr>\n";
	
	$i = 0;	
	
	do {
		$weapon .= "\t<tr class=\"L" . $WeaponsList[$i]['level'] . $WeaponsList[$i]['ed'] . "\">";
		$weapon .= "<td><select name=\"" . $WeaponsList[$i]['sn'] . "\" onchange=\"Calc()\">";
		$weapon .= "<option value=\"0\">-</option>";
		
		// Set the base number of items a user may select
		if ($WeaponsList[$i]['crits'] > 11) {
			$CritsMax = 3;
		} elseif ($WeaponsList[$i]['crits'] > 6) {
			$CritsMax = 5;
		} elseif ($WeaponsList[$i]['crits'] > 5) {
			$CritsMax = 7;
		} elseif ($WeaponsList[$i]['crits'] > 3) {
			$CritsMax = 9;
		} elseif ($TableID == 'WTP') {
			$CritsMax = 6;
		} else {
			$CritsMax = 16;
		}
		
		// Add options to the select
		for ($o = 1; $o < $CritsMax; $o++) {
			$weapon .= "<option value=\"" . $o . "\">" . $o . "</option>";
		}

		$weapon .= "</select>" . CELL_CLOSE;
		$weapon .= CELL_OPEN . $WeaponsList[$i]['name'] . CELL_CLOSE;
		$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['heat']) . CELL_CLOSE;
		if ($WeaponsList[$i]['type'] == 4) {
			$weapon .= CELL_OPEN . $WeaponsList[$i]['damage'] . "/" . $WeaponsList[$i]['mdamage'] . CELL_CLOSE;
		} elseif ($WeaponsList[$i]['type'] == 3 && $WeaponsList[$i]['mdamage'] != NULL) {
			$weapon .= CELL_OPEN . $WeaponsList[$i]['mdamage'] . "-" . $WeaponsList[$i]['damage'] . CELL_CLOSE;
		} else {
			$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['damage']) . CELL_CLOSE;
		}
		$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['min']) . CELL_CLOSE;
		if ($WeaponsList[$i]['short'] == 1 || $WeaponsList[$i]['short'] == NULL) {
			$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['short']) . CELL_CLOSE;
			$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['medium']) . CELL_CLOSE;
			$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['long']) . CELL_CLOSE;
		} else {
			$weapon .= CELL_OPEN . "1-" . $WeaponsList[$i]['short'] . CELL_CLOSE;
			$weapon .= CELL_OPEN . ($WeaponsList[$i]['short'] + 1) . "-" . $WeaponsList[$i]['medium'] . CELL_CLOSE;
			if ($WeaponsList[$i]['long'] == ($WeaponsList[$i]['medium'] + 1)) {
				$weapon .= CELL_OPEN . $WeaponsList[$i]['long'] . CELL_CLOSE;			
			} else {
				$weapon .= CELL_OPEN . ($WeaponsList[$i]['medium'] + 1) . "-" . $WeaponsList[$i]['long'] . CELL_CLOSE;
			}
		}
		$weapon .= CELL_OPEN . decimalPlaces($WeaponsList[$i]['tons'], 1) . CELL_CLOSE;
		$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['crits']) . CELL_CLOSE;

		$weapon .= CELL_OPEN . nullToDash($WeaponsList[$i]['ammo']) . CELL_CLOSE;
		$weapon .= CELL_OPEN . largeNumber($WeaponsList[$i]['cost']) . CELL_CLOSE;
		$weapon .= CELL_OPEN . $WeaponsList[$i]['bv'] . CELL_CLOSE;
		$weapon .= "</tr>\n";
		$i++;
	} while ($i < count($WeaponsList));
	$weapon .= "</table>\n";
	
	return $weapon;
}


// Display Ammo in a table
function DisplayAmmo($TableID) {
	require('include/master.db.php');

	define('CELL_OPEN', "<td>");
	define('CELL_CLOSE', "</td>");

	switch ($TableID) {
		case 'WT7':
			$WeaponsList = $Weapons_IS_Ammo1;
			break;
		case 'WT8':
			$WeaponsList = $Weapons_IS_Ammo2;
			break;
		case 'WT7c':
			$WeaponsList = $Weapons_Clan_Ammo1;
			break;
		case 'WT8c':
			$WeaponsList = $Weapons_Clan_Ammo2;
			break;
		case 'WT7cP':
			$WeaponsList = $Weapons_Protomech_Ammo;
			$TableID = 'WT7c';
			break;
	}

	$weapon .= "<table id=\"" . $TableID . "\" cellspacing=\"1\">\n";
	$weapon .= "\t<tr class=\"TH\">";
	$weapon .= displayWeaponsHeader('#', 0, 45);
	$weapon .= displayWeaponsHeader('Type', 0, 145);
	$weapon .= displayWeaponsHeader('Ammo', 'Shots per ton', 0);
	$weapon .= displayWeaponsHeader('Tons', 0, 0);
	$weapon .= displayWeaponsHeader('Cost', 'Cost in C-bills', 0);
	$weapon .= displayWeaponsHeader('BV', 'Battle Value', 0);	
	$weapon .= "\t</tr>\n";
	
	$i = 0;	
	
	do {
		$weapon .= "\t<tr class=\"L" . $WeaponsList[$i]['level'] . $WeaponsList[$i]['ed'] . "\">";
		$weapon .= "<td><select name=\"" . $WeaponsList[$i]['sn'] . "\" onchange=\"Calc()\">";
		$weapon .= "<option value=\"0\">-</option>";
		for ($o = 1; $o < 11; $o++) {
			$weapon .= "<option value=\"" . $o . "\">" . $o . "</option>";
		}
		$weapon .= "</select>" . CELL_CLOSE;
		$weapon .= CELL_OPEN . $WeaponsList[$i]['aname'] . CELL_CLOSE;
		$weapon .= CELL_OPEN . $WeaponsList[$i]['ammo'] . CELL_CLOSE;
		$weapon .= CELL_OPEN . decimalPlaces($WeaponsList[$i]['tons'], 1) . CELL_CLOSE;
		$weapon .= CELL_OPEN . largeNumber($WeaponsList[$i]['cost']) . CELL_CLOSE;
		$weapon .= CELL_OPEN . $WeaponsList[$i]['bv'] . CELL_CLOSE;
		$weapon .= "</tr>\n";
		$i++;
	} while ($i < count($WeaponsList));
	
	$weapon .= "</table>\n";
	
	return $weapon;
}


// ------------------------------------------
// Switch from numerical to text descriptions
// ------------------------------------------

// Check for Solaris VII and multiply values
function solarisMultiply($Level) {
	if ($Level == 4) {
		return 4;
	} else {
		return 1;
	}
}

// Get the technology type
function technology($Tech) {
	if ($Tech == 2) {
		return 'Clan';
	} else {
		return 'Inner Sphere';
	}
}

// Check if Mech has a name
function mechType($Type) {
	if ($Type == NULL) {
		return 'Untitled';
	} else {
		return $Type;
	}
}

// Get auto eject operation
function autoEject($Type) {
	if ($Type == 1) {
		 return 'Operational';
	} else {
		 return 'Disabled';
	}
}

// Get heat sink modifier
function heatsinkModifier($Type) {
	if ($Type) {
		return 2;
	} else {
		return 1;
	}
}

// Get the Heat Sinks type
function heatsinkType($Type) {
	switch ($Type) {
		case 1:
			return 'Double';
			break;
		case 2:
			return 'Compact';
			break;
		default:
			return 'Single';
			break;
	}
}

// Advanced movment type
function advancedMPType($Type) {
	switch ($Type) {
		case 1:
			return 'MASC';
			break;
		case 2:
			return 'Triple Strength';
			break;
		case 3:
			return 'Supercharger';
			break;
		default:
			return 'none';
			break;
	}
}

// Advanced vehicle movment type
function advancedVehMPType($Type) {
	switch ($Type) {
		case 1:
			return '| Amphibious';
			break;
		case 2:
			return '| Snowmobile';
			break;
		case 3:
			return '| Dune Buggy';
			break;
		case 4:
			return '| Supercharger';
			break;
		case 5:
			return '| Dual Rotors';
			break;
		case 6:
			return '| Co-Axial Rotors';
			break;
		default:
			return '';
			break;
	}
}

// Advanced vehicle movment type cruising modifier
function advancedVehMPMod($Type) {
	switch ($_POST['AdvanceMP']) {
		case 2: // Snowmobile
			return 1;
			break;
		case 3: // Dune Buggy
			return 1;
			break;
		default: // none
			return 0;
			break;
	}
}

// Advanced Aerotech movment type
function advancedAeroMPType($Type) {
	switch ($Type) {
		case 1:
			return 'VSTOL Capable';
			break;
		default:
			return '';
			break;
	}
}

// Calculate melee weapon damage
function meleeWeaponDamage($Type) {
	switch ($Type) {
		case 4: // Hatchet
			return $_POST['Tonnage'] / 5;
			break;
		case 5: // Sword
			return roundNearWhole($_POST['Tonnage'] * 0.1, 0.5) + 1;
			break;
		case 6: // Mace
			return ($_POST['Tonnage'] / 5) * 2;
			break;
		case 7: // Claw
			return $_POST['Tonnage'] / 5;
			break;
		case 8: // Retractable Blade
			return roundNearWhole($_POST['Tonnage'] * 0.1, 0.5);
			break;
		default: // None
			return 0;
			break;
	}
}

// Calculate melee weapon tonnage
function meleeWeaponTons($Type) {
	switch ($Type) {
		case 4: // Hatchet
			return roundNearWhole($_POST['Tonnage'] / 15, 0.5);
			break;
		case 5: // Sword
			return roundNearWhole($_POST['Tonnage'] / 20, 0.5);
			break;
		case 6: // Mace
			return roundNearWhole($_POST['Tonnage'] / 15, 0.5);
			break;
		case 7: // Claw
			return roundNearWhole($_POST['Tonnage'] / 15, 0.5);
			break;
		case 8: // Retractable Blade
			return roundNearWhole($_POST['Tonnage'] / 20, 0.5);
			break;
		default: // None
			return 0;
			break;
	}
}

// Calculate melee weapon crits
function meleeWeaponCrits($Type) {
	if ($Type > 3) {
		return roundNearWhole($_POST['Tonnage'] / 15, 0.5);
	} else {
		return 0;
	}
}

// Get the suspension factor for all vehicles
function suspensionFactor($Type, $Tonnage) {
	switch ($Type) {
		case 1: // Wheeled
			return 20;
			break;
		case 2: // Hovercraft
			switch ($Tonnage) {
				case $Tonnage > 10 AND $Tonnage < 21:
					return 85;
					break;
				case $Tonnage > 20 AND $Tonnage < 31:
					return 130;
					break;
				case $Tonnage > 30 AND $Tonnage < 41:
					return 175;
					break;
				case $Tonnage > 40 AND $Tonnage < 51:
					return 235;
					break;
				default:
					return 40;
					break;
			}
			break;
		case 3: // WiGE
			switch ($Tonnage) {
				case $Tonnage > 15 AND $Tonnage < 31:
					return 80;
					break;
				case $Tonnage > 30 AND $Tonnage < 46:
					return 115;
					break;
				case $Tonnage > 45 AND $Tonnage < 81:
					return 140;
					break;
				default:
					return 45;
					break;
			}
			break;
		case 4: // Displacement Hull
			return 30;
			break;
		case 5: // Submarine
			return 30;
			break;
		case 6: // Hydrofoil
			switch ($Tonnage) {
				case $Tonnage > 10 AND $Tonnage < 21:
					return 105;
					break;
				case $Tonnage > 20 AND $Tonnage < 31:
					return 150;
					break;
				case $Tonnage > 30 AND $Tonnage < 41:
					return 195;
					break;
				case $Tonnage > 40 AND $Tonnage < 51:
					return 255;
					break;
				case $Tonnage > 50 AND $Tonnage < 61:
					return 300;
					break;
				case $Tonnage > 60 AND $Tonnage < 71:
					return 345;
					break;
				case $Tonnage > 70 AND $Tonnage < 81:
					return 390;
					break;
				case $Tonnage > 80 AND $Tonnage < 91:
					return 435;
					break;
				case $Tonnage > 90 AND $Tonnage < 101:
					return 480;
					break;
				default:
					return 60;
					break;
			}
			break;
		case 7: // VTOL
			switch ($Tonnage) {
				case $Tonnage > 10 AND $Tonnage < 21:
					return 95;
					break;
				case $Tonnage > 20 AND $Tonnage < 31:
					return 140;
					break;
				default:
					return 50;
					break;
			}
			break;
		default: // Tracked
			return 0;
			break;
	}
}

// Arm Actuators type
function armActuatorsType($Type) {
	switch ($Type) {
		case 2:
			return 'No Lower Arm';
			break;
		case 3:
			return 'Full Arm';
			break;
		case 4:
			return 'Hatchet';
			break;
		case 5:
			return 'Sword';
			break;
		case 6:
			return 'Mace';
			break;
		case 7:
			return 'Claw';
			break;
		case 8:
			return 'Retractable Blade';
			break;
		default:
			return 'No Hand';
			break;
	}
}

// Get the weight class from the tonnage
function weightClass($Tons) {	switch ($Tons) {
		case $Tons < 20: // 10 to 15
			return 'Ultra-Light';
			break;
		case $Tons > 36 && $Tons < 60: // 40 to 55
			return 'Medium';
			break;
		case $Tons > 59 && $Tons < 80: // 60 to 75
			return 'Heavy';
			break;
		case $Tons > 79 && $Tons < 101: // 80 to 100
			return 'Assault';
			break;
		case $Tons > 101 && $Tons < 136: // 105 to 135
			return 'Colossal';
			break;
		default:
			return 'Light'; // 1 to 35
			break;
	}
}

// Get the weight class for Aerotech fighters from the tonnage
function weightClassAero($Tons) {	switch ($Tons) {
		case $Tons > 45 && $Tons < 75: // 46 to 70
			return 'Medium';
			break;
		case $Tons > 74 && $Tons < 101: // 71 to 100
			return 'Heavy';
			break;
		case $Tons > 100: // 101 to 200
			return 'Assault';
			break;
		default:
			return 'Light'; // 1 to 45
			break;
	}
}

// Get the weight class for buildings and installations
function weightClassInstallation($Tons) {	switch ($Tons) {
		case $Tons > 15 && $Tons < 41: // 16 to 40
			return 'Medium';
			break;
		case $Tons > 40 && $Tons < 91: // 41 to 90
			return 'Heavy';
			break;
		case $Tons > 90: // 91 to 150
			return 'Hardened';
			break;
		default:
			return 'Light'; // 1 to 15
			break;
	}
}

// Calculate the engine tonnage from the engine rating 
function engineMass($Var, $Multiply, $EngineRating) {
	require('engine.db.php');
	
	if ($Var) {
		if ($Multiply) {
			return decimalPlaces(round(((($arrEngineRating[$EngineRating]['mass'] * $Var) + 0.2) * 2), 0) / 2, 1);
		} else {
			return decimalPlaces(round(((($arrEngineRating[$EngineRating]['mass'] / $Var) + 0.2) * 2), 0) / 2, 1);
		}
	} else {
		return decimalPlaces($arrEngineRating[$EngineRating]['mass'], 1);	
	}
}

// Calculate the engine tonnage from the engine rating for ProtoMechs
function engineMassProto($EngineRating) {
	if ($EngineRating < 40) {
		return $EngineRating * 0.025;
	} else {
		return engineMass(0, 0, roundUpFive($EngineRating));
	}
}

// Get the engine make
function engineMake($EngineRating) {
	require('engine.db.php');
	return $arrEngineRating[$EngineRating]['type'];
}

// Get the engine type
function engineType($Class) {
	switch ($Class) {
		case 1:
			return 'Fusion XL';
			break;
		case 2:
			return 'Fusion XXL';
			break;
		case 6:
			return 'Light';
			break;
		case 7:
			return 'Compact';
			break;
		case 8:
			return 'ICE';
			break;
		case 9:
			return 'Fuel Cell';
			break;
		case 10:
			return 'Fission';
			break;
		default:
			return 'Fusion';
			break;
	}
}

// Get the Mech chassis
function mechChassis($Class) {
	switch ($Class) {
		case 1:
			return 'OmniMech';
			break;
		case 2:
			return 'Land-Air Mech';
			break;
		case 3:
			return 'IndustrialMech';
			break;
		default:
			return 'BattleMech';
			break;
	}
}

// Get the Vehicle chassis
function vehicleChassis($Class) {
	switch ($Class) {
		case 1:
			return 'Wheeled';
			break;
		case 2:
			return 'Hovercraft';
			break;
		case 3:
			return 'WiGE';
			break;
		case 4:
			return 'Displacement Hull';
			break;
		case 5:
			return 'Submarine';
			break;
		case 6:
			return 'Hydrofoil';
			break;
		case 7:
			return 'VTOL';
			break;
		default:
			return 'Tracked';
			break;
	}
}

// Get the Vehicle chassis for Battleforce
function BFVehicleChassis($Class) {
	$arrChassis = array(t,w,h,i,n,s,f,v);
	return $arrChassis[$Class];
}

// Get the Vehicle class
function vehicleClass($Class) {
	switch ($Class) {
		case 1:
			return 'Ground Vehicle';
			break;
		case 2:
			return 'Ground Vehicle';
			break;
		case 3:
			return 'Ground Vehicle';
			break;
		case 4:
			return 'Naval Vessel';
			break;
		case 5:
			return 'Submarine';
			break;
		case 6:
			return 'Hydrofoil';
			break;
		case 7:
			return 'VTOL';
			break;
		default:
			return 'Ground Vehicle';
			break;
	}
}

// Get the Aerotech chassis
function aerotechChassis($Class) {
	switch ($Class) {
		case 1:
			return 'Conventional Fighter';
			break;
		case 2:
			return 'Aerodyne Small Craft';
			break;
		case 3:
			return 'Spheroid Small Craft';
			break;
		default:
			return 'AeroSpace Figher';
			break;
	}
}

// Get the Vehicle terrain restrictions
function vehicleTerrain($Class) {
	switch ($Class) {
		case 1:
			return 'Rough, Rubble, Woods (Light and Heavy), Water (Depth 1+)';
			break;
		case 2:
			return 'Woods (Light and Heavy)';
			break;
		case 3:
			return 'Any Woods, Hills, or Structures at same altitude';
			break;
		case 4:
			return 'All except Water (Depth 1+)';
			break;
		case 5:
			return 'All except Water (Depth 1+)';
			break;
		case 6:
			return 'All except Water (Depth 1+)';
			break;
		case 7:
			return 'Any Woods, Hills, or Structures at same altitude';
			break;
		default:
			return 'Woods (Heavy), Water (Depth 1+)';
			break;
	}
}

// Get the Structure class
function structureClass($Class) {
	switch ($Class) {
		case 1:
			return 'Building';
			break;
		case 2:
			return 'Hangar';
			break;
		case 3:
			return 'Bridge';
			break;
		default:
			return 'Fortress';
			break;
	}
}

// Get the targeting type
function targetingType($Type) {
	switch ($Type) {
		case 1:
			return 'Targeting Computer';
			break;
		case 2:
			return 'Long-Range';
			break;
		case 3:
			return 'Short-Range';
			break;
		case 4:
			return 'Variable-Range';
			break;
		case 5:
			return 'Anit-Aircraft';
			break;
		case 6:
			return 'Multi-Trac';
			break;
		case 7:
			return 'Multi-Trac II';
			break;
		case 8:
			return 'Satellite Uplink';
			break;
		case 9:
			return 'Null-Signature';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the targeting modifier
function targetingMod($Type) {
	switch ($Type) {
		case 1:
			return '<br/>Modifier: -1/+3';
			break;
		case 2:
			return '<br/>Modifier: +1/+2/+3';
			break;
		case 3:
			return '<br/>Modifier: -1/+2/+5';
			break;
		case 4:
			return '';
			break;
		case 5:
			return '<br/>Modifier: +1/-2';
			break;
		case 6:
			return '<br/>Modifier: +1';
			break;
		case 7:
			return '';
			break;
		case 8:
			return '<br/>Modifier: +1 (int +3)';
			break;
		case 9:
			return '';
			break;
		default:
			return '';
			break;
	}
}

// Get the Cockpit type
function cockpitType($Type) {
	switch ($Type) {
		case 1:
			return 'Small Cockpit';
			break;
		case 2:
			return 'Enhanced Imaging';
			break;
		case 3:
			return 'Command Console';
			break;
		case 4:
			return 'Torso Mounted';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the special equipment Front type
function vehFrontType($Type) {
	switch ($Type) {
		case 1:
			return 'Bulldozer <br />';
			break;
		case 2:
			return 'Minesweeper <br />';
			break;
		case 3:
			return 'Sensors <br />';
			break;
		case 4:
			return 'Recon Camera <br />';
			break;
		default:
			return '';
			break;
	}
}

// Get the special equipment Top type
function vehTopType($Type) {
	switch ($Type) {
		case 2:
			return 'Bridge Layer [7 CF] <br />';
			break;
		case 3:
			return 'Bridge Layer [20 CF] <br />';
			break;
		case 4:
			return 'Bridge Layer [45 CF] <br />';
			break;
		case 5:
			return 'Mast-Mount <br />';
			break;
		case 6:
			return 'Dual Rotors <br />';
			break;
		case 7:
			return 'Co-Axial Rotors <br />';
			break;
		default:
			return '';
			break;
	}
}

// Get the special equipment Rear type
function vehRearType($Type) {
	switch ($Type) {
		case 1:
			return 'Coolant System <br />';
			break;
		case 2:
			return 'MASH Unit (small) <br />';
			break;
		case 3:
			return 'MASH Unit (large) <br />';
			break;
		case 4:
			return 'Mobile HQ (small) <br />';
			break;
		case 5:
			return 'Mobile HQ (large) <br />';
			break;
		case 6:
			return 'Jet Booster <br />';
			break;
		default:
			return '';
			break;
	}
}

// Warrior special ablilities
function specialAbilities($Type) {
	switch ($Type) {
		case 1:
			return '| Bulls-Eye Marksman';
			break;
		case 2:
			return '| Dodge Maneuver';
			break;
		case 3:
			return '| Edge';
			break;
		case 4:
			return '| Maneuvering Ace';
			break;
		case 5:
			return '| Melee Specialist';
			break;
		case 6:
			return '| Pain Resistance';
			break;
		case 7:
			return '| Sixth Sense';
			break;
		case 8:
			return '| Speed Demon';
			break;
		case 9:
			return '| Tactical Genius';
			break;
		case 10:
			return '| Weapon Specialist';
			break;
		default:
			return '';
			break;
	}
}

// Get Ferro-Fibrous armor multiplier
function ferroMultiplier($Tech) {
	if ($Tech == 2) {
		return 1.2;
	} else {
		return 1.12;
	}
}

// Check the balance between front and rear armor
function rearArmor($Front, $Rear, $Total) {
	if (($Front + $Rear) > $Total) {
		$Rear = round($Total / 4);
		$Front = $Total - $Rear;
	}
	return $Front . "," . $Rear;
}

// Get the total armor tonnage
function armorTonnage($ArmorTotal, $Points, $Mult) {
	if ($Mult) {
		return round((((($ArmorTotal / 16) / $Mult) + 0.2) * 2), 0) / 2;
	} else {
		return round(((($ArmorTotal / $Points) + 0.2) * 2), 0) / 2;
	}
}

// Get the Armor type
function armorType($Type) {
	switch ($Type) {
		case 1:
			return 'Ferro-Fiberous';
			break;
		case 2:
			return 'Hardened';
			break;
		case 3:
			return 'Laser-Reflective';
			break;
		case 4:
			return 'Reactive';
			break;
		case 5:
			return 'Light Ferro-Fibrous';
			break;
		case 6:
			return 'Heavy Ferro-Fibrous';
			break;
		case 7:
			return 'Stealth';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the Armor type for Aerotech fighters
function armorTypeAero($Type) {
	switch ($Type) {
		case 1:
			return 'Ferro-Aluminum';
			break;
		case 3:
			return 'Laser-Reflective';
			break;
		case 4:
			return 'Reactive';
			break;
		case 5:
			return 'Light Ferro-Aluminum';
			break;
		case 6:
			return 'Heavy Ferro-Aluminum';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the Gyro tonnage
function gyroTonnage($EngineRating, $Mult, $Operator) {
	if ($Operator) {
		return (int)(($EngineRating / 100) + 0.99) / $Mult;
	} else {
		return (int)(($EngineRating / 100) + 0.99) * $Mult;
	}
}

// Get the Gyro type
function gyroType($Type) {
	switch ($Type) {
		case 1:
			return 'Compact';
			break;
		case 2:
			return 'Heavy-duty';
			break;
		case 3:
			return 'Extra-Light';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the Internal Structure armor points
function internalstructPoints($Loc, $Tonnage, $Legs) {
	require('structure.db.php');
	if ($Legs == 4 && $Loc == 'ISA') {
		return $arrInternalStructure[roundUpFive($Tonnage)]['ISL'];
	} else {
		return $arrInternalStructure[roundUpFive($Tonnage)][$Loc];
	}
}

// Get the Internal Structure type
function internalstructType($Type) {
	switch ($Type) {
		case 1:
			return 'Endo Steel';
			break;
		case 2:
			return 'Composite';
			break;
		case 3: 
			return 'Reinforced';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the jump jets type
function jumpJetsType($Type) {
	switch ($Type) {
		case 1:
			return 'Improved';
			break;
		default:
			return 'Standard';
			break;
	}
}

// Get the Internal Structure type
function levelType($Level) {
	if ($Level == 4) {
		return 'Solaris VII';
	} else {
		if ($Level == 3) {
			return 'Advanced';
		} else {
			return 'Standard';			
		}
	}
}

// Get the Internal Structure type
function experienceLevel($Level) {
	switch ($Level) {
		case 2:
			return 'Regular';
			break;
		case 3: 
			return 'Veteran';
			break;
		case 4:
			return 'Elite';
			break;
		default:
			return 'Green';
			break;
	}
}

// Add the number sub to the edition
function numberSub($num) {
	switch ($num) {
		case 1:
			$sub = 'st';
			break;
		case 2:
			$sub = 'nd';
			break;
		case 3:
			$sub = 'rd';
			break;
		default:
			$sub = 'th';
			break;	
	}
	return $num . $sub;
}


// --------------
// Print-out Page 
// --------------

// Draw Armor Diagram per location
function Display_Armor($Loc, $Divisor) {
	if ($Loc == 0) {
		$Armor = "<em>None</em>";
	} else {
		for ($l = 0; $l < $Loc; $l++) {
			if ($l % $Divisor == 0 && $l != 0) $Armor .= "<br />";
			$Armor .= CIRCLE_LG;
		}
	}
	return $Armor;
}

// Display crits table per location
function Display_Crits($location) {
	switch ($location) {
		case $location == 'LL' OR $location == 'RL':
			$TotalCrits = 2;
			$StartNextList = 6;
			break;
		case $location == 'LA' OR $location == 'RA':
			if ($_POST['Legs'] == 4) {
				$TotalCrits = 2;
				$StartNextList = 6;
				$LocationList .= "\t\t\t<li>Hip</li>\n";
				$LocationList .= "\t\t\t<li>Upper Leg Actuator</li>\n";
				$LocationList .= "\t\t\t<li>Lower Leg Actuator</li>\n";
				$LocationList .= "\t\t\t<li>Foot Actuator</li>\n";
			} else {			
				$LocationList .= "\t\t\t<li>Shoulder</li>\n";
				$LocationList .= "\t\t\t<li>Upper Arm Actuator</li>\n";
				switch ($_POST[$location.'Actuators']) {
					case 1:
						$LocationList .= "\t\t\t<li>Lower Arm Actuator</li>\n";
						$TotalCrits = 9;
						$StartNextList = 3;
						break;
					case 2:
						$TotalCrits = 10;
						$StartNextList = 4;
						break;
					case 3:
						$LocationList .= "\t\t\t<li>Lower Arm Actuator</li>\n\t\t\t<li>Hand Actuator</li>\n";
						$TotalCrits = 8;
						$StartNextList = 2;
						break;
					case 4 OR 5 OR 6 OR 7 OR 8: // Melee Weapon
						$LocationList .= "\t\t\t<li>Lower Arm Actuator</li>\n\t\t\t<li>Hand Actuator</li>\n";
						$a = 0;
						$StartNextList = 2;
						switch ($_POST[$location.'Actuators']) {
							case 5:
								$MeleeWeapon = 'Sword';
								$MeleeCrits = meleeWeaponCrits(5);
								break;
							case 6:
								$MeleeWeapon = 'Mace';
								$MeleeCrits = meleeWeaponCrits(6);
								break;
							case 7:
								$MeleeWeapon = 'Claw';
								$MeleeCrits = meleeWeaponCrits(7);
								break;
							case 8:
								$MeleeWeapon = 'Retractable Blade';
								$MeleeCrits = meleeWeaponCrits(8);
								break;
							default:
								$MeleeWeapon = 'Hatchet';
								$MeleeCrits = meleeWeaponCrits(4);
								break;
						}
						// Display Melee Weapon
						do {
							if ($a == $StartNextList) $LocationList .= LOC_BREAK;
							$LocationList .= LIST_OPEN . $MeleeWeapon . LIST_CLOSE;
							$a++;
						} while ($MeleeCrits > $a);
						$TotalCrits = 8 - $MeleeCrits;
						break;
					default: // No hand or lower arm
						$TotalCrits = 10;
						$StartNextList = 4;
						break;
				}
			}
			break;
		case 'H':
			if ($_POST['Cockpit'] == 1) {
				$TotalCrits = 2;
			} else {
				$TotalCrits = 1;
			}
			$StartNextList = 6;
			break;
		case $location == 'LT' OR $location == 'RT':
			switch ($_POST['Engine']) {
				case 1: // XL Engine
					if ($_POST['Tech'] == 2) { // Clan
						$TotalCrits = 10;
						$StartNextList = 4;
						$LocationList .= LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
					} else { // Inner Sphere
						$TotalCrits = 9;
						$StartNextList = 3;
						$LocationList .= LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
					}
					break;
				case 2: // XXL Engine
					if ($_POST['Tech'] == 2) { // Clan
						$TotalCrits = 8;
						$StartNextList = 2;
						$LocationList .= LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
					} else { // Inner Sphere
						$TotalCrits = 6;
						$StartNextList = 0;
						$LocationList .=  LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
					}
					break;
				default: // Standard
					$TotalCrits = 12;
					$StartNextList = 6;
					break;
			}
			break;
		case 'CT':			
			if ($_POST['Engine'] == 7 AND $_POST['Gyro'] == 1) {
				$StartNextList = 1;
				$TotalCrits = 7;
			} elseif ($_POST['Gyro'] == 1) {
				$LocationList .= LIST_OPEN . "Engine" . LIST_CLOSE . "</ol>\n" . HIGH . LIST_CLOSE . "\t\t\t<ol>\n" . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
				$StartNextList = 0;
				$TotalCrits = 4;
			} elseif ($_POST['Engine'] == 7) {
				$LocationList .= LIST_OPEN . "Gyro" . LIST_CLOSE . "</ol>\n" . HIGH . LIST_CLOSE . "\t\t\t<ol>\n" . LIST_OPEN . "Gyro" . LIST_CLOSE;
				$StartNextList = 0;
				$TotalCrits = 5;
			} else {
				$LocationList .= LIST_OPEN . "Gyro" . LIST_CLOSE . "</ol>\n" . HIGH . "\t\t\t<ol>\n" . LIST_OPEN . "Gyro" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE . LIST_OPEN . "Engine" . LIST_CLOSE;
				$StartNextList = 2;
				$TotalCrits = 2;
			}
			if ($_POST['Gyro'] == 3) {
				$LocationList .= LIST_OPEN . "Gyro" . LIST_CLOSE . LIST_OPEN . "Gyro" . LIST_CLOSE;
				$TotalCrits = 0;
			}
			break;
	}
	
	$x = 0;
	$y = 0;
	$j = 0;
	$Crits = 0;
	
	do {
		// List Weapons and Equipment per location
		if ($_POST['Location'.$x] == $location || $_POST['Location'.$x] == $location . 'R') {
			$Crits += $_POST['ItemCrits'.$x];
			if ($Crits <= $TotalCrits) {
				for ($i = 0; $i < $_POST['ItemCrits'.$x]; $i++) {
					if ($y == $StartNextList) $LocationList .= LOC_BREAK;
					if ($_POST['Location'.$x] == $location . 'R') {
						// if weapon is rear firing
						$LocationList .= LIST_OPEN . $_POST['Item'.$x] . " " . REAR . " <span>[" . ($x + 1) . "]</span>" . LIST_CLOSE;
					} else {
						$LocationList .= LIST_OPEN . $_POST['Item'.$x] . " <span>[" . ($x + 1) . "]</span>" . LIST_CLOSE;
					}
					$y++;
				}
			}
		}

		// List Weapons and Equipment that use location spliting
		if ($_POST['Location'.$x] == 'LT' . $location || $_POST['Location'.$x] == 'RT' . $location) {
			$SplitLoc = preg_split("/,/", $_POST['ItemCrits'.$x]);
			$Crits += $SplitLoc[1];
			if ($Crits < $TotalCrits) {
				for ($i = 0; $i < $SplitLoc[1]; $i++) {
					if ($y == $StartNextList) $LocationList .= LOC_BREAK;
					$LocationList .= LIST_OPEN . $_POST['Item'.$x] . " <span>[" . ($x + 1) . "]</span>" . LIST_CLOSE;
					$y++;
				}
			}
		}
		$x++;
	} while ($_POST['Location'.$x] != NULL);
	
	// Display Blank 'roll again' slots if needed
	if ($Crits < $TotalCrits) {
		do {
			$CritDiff = $TotalCrits - $Crits;
			if ($j == ($CritDiff - 6)) $LocationList .= LOC_BREAK;
			$LocationList .= EMPTY_SLOT;
			$j++;
		} while ($j < $CritDiff);
	}
	
	// Display bottom slot in the head
	if ($location == 'H' && $_POST['Cockpit'] == 1) {
		$LocationList .= LIST_OPEN . "Sensors" . LIST_CLOSE;
	} elseif ($location == 'H') {
		$LocationList .= LIST_OPEN . "Sensors" . LIST_CLOSE . LIST_OPEN . "Life Support" . LIST_CLOSE;
	}

	return $LocationList;
}

// Weapons and equipment loadout table header for mechs
function allocatedWeaponsHeader() {
	$weapons .= "\t\t<tr class=\"Left\">\n";
	$weapons .= "\t\t\t<th width=\"15\" class=\"Center\">Loc</th>\n";
	$weapons .= "\t\t\t<th width=\"31%\">Type</th>\n";
	$weapons .= "\t\t\t<th width=\"20\">Heat</th>\n";
	$weapons .= "\t\t\t<th width=\"10\">Dmg</th>\n";
	if ($_POST['Level'] == 4) {
		$weapons .= "\t\t\t<th width=\"10\">Delay</th>\n";
		$weapons .= "\t\t\t<th width=\"15\">Min</th>\n";
		$weapons .= "\t\t\t<th width=\"15\">[+0]</th>\n";
		$weapons .= "\t\t\t<th width=\"15\">[+1]</th>\n";
		$weapons .= "\t\t\t<th width=\"15\">[+2]</th>\n";
		$weapons .= "\t\t\t<th width=\"20\">[+3]</th>\n";
		$weapons .= "\t\t\t<th width=\"20\">[+4]</th>\n";
		$weapons .= "\t\t\t<th width=\"25\">[+5]</th>\n";
	} else {
		$weapons .= "\t\t\t<th width=\"15\">Min</th>\n";
		$weapons .= "\t\t\t<th width=\"25\">Short</th>\n";
		$weapons .= "\t\t\t<th width=\"25\">Med</th>\n";
		$weapons .= "\t\t\t<th width=\"25\">Long</th>\n";
		if ($_POST['Level'] > 2) $weapons .= "\t\t\t<th width=\"20\">Extreme</th>\n";
	}
	$weapons .= "\t\t\t<th width=\"15\">Mod</th>\n";	
	$weapons .= "\t\t</tr>\n";
	return $weapons;
}

// Weapons and equipment loadout table header for vehicles
function allocatedWeaponsHeaderVehicle() {
	$weapons .= "\t\t<tr class=\"Left\">\n";
	$weapons .= "\t\t\t<th width=\"15\" class=\"Center\">Loc</th>\n";
	$weapons .= "\t\t\t<th width=\"32%\">Type</th>\n";
	$weapons .= "\t\t\t<th width=\"10\">Dmg</th>\n";
	$weapons .= "\t\t\t<th width=\"15\">Min</th>\n";
	$weapons .= "\t\t\t<th width=\"25\">Short</th>\n";
	$weapons .= "\t\t\t<th width=\"25\">Med</th>\n";
	$weapons .= "\t\t\t<th width=\"25\">Long</th>\n";
	if ($_POST['Level'] > 2) $weapons .= "\t\t\t<th width=\"20\">Extreme</th>\n";
	$weapons .= "\t\t\t<th width=\"12\">Mod</th>\n";	
	$weapons .= "\t\t</tr>\n";
	return $weapons;
}

// Weapons and equipment loadout table header for Aerotech
function allocatedWeaponsHeaderAerotech() {
	$weapons .= "\t\t<tr class=\"Left\">\n";
	$weapons .= "\t\t\t<th width=\"15\" class=\"Center\">Loc</th>\n";
	$weapons .= "\t\t\t<th width=\"32%\">Type</th>\n";
	$weapons .= "\t\t\t<th width=\"20\">Heat</th>\n";
	$weapons .= "\t\t\t<th width=\"30\">SRV <span class=\"FontSM\">(0-6)</span></th>\n";
	$weapons .= "\t\t\t<th width=\"30\">MRV <span class=\"FontSM\">(7-12)</span></th>\n";
	$weapons .= "\t\t\t<th width=\"30\">LRV <span class=\"FontSM\">(13-20)</span></th>\n";
	$weapons .= "\t\t\t<th width=\"30\">ERV <span class=\"FontSM\">(21-25)</span></th>\n";
	$weapons .= "\t\t\t<th width=\"15\">Mod</th>\n";	
	$weapons .= "\t\t</tr>\n";
	return $weapons;
}


// List the allocated weapons
function listAllocatedWeapons($UnitType) {
	require('master.db.php');
	
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsAndEquip); $y++) {
			if ($WeaponsAndEquip[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "\t\t<tr>\n";
					$weapons .= "\t\t\t<td class=\"Center\"><strong>" . $_POST['Location'.$x] . "</strong></td>\n";
					$weapons .= CELL_OPEN . $WeaponsAndEquip[$y]['name'] . CELL_CLOSE;
					if ($UnitType == 1 || $UnitType == 3) $weapons .= CELL_OPEN . nullToDash(solarisMult($WeaponsAndEquip[$y]['heat'])) . CELL_CLOSE; 
					if ($UnitType != 3) {
						if ($WeaponsAndEquip[$y]['type'] == 4) {
							$weapons .= CELL_OPEN . $WeaponsAndEquip[$y]['damage'] . "/" . $WeaponsAndEquip[$y]['mdamage'] . CELL_CLOSE;
						} elseif ($WeaponsAndEquip[$y]['type'] == 3 && $WeaponsAndEquip[$y]['mdamage'] != NULL) {
							$weapons .= CELL_OPEN . $WeaponsAndEquip[$y]['mdamage'] . "-" . $WeaponsAndEquip[$y]['damage'] . CELL_CLOSE;
						} else {
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['damage']) . CELL_CLOSE;
						}
						if ($_POST['Level'] == 4) $weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['delay']) . CELL_CLOSE;
						$weapons .= CELL_OPEN . nullToDash(solarisMult($WeaponsAndEquip[$y]['min'])) . CELL_CLOSE;
					}
					if ($_POST['Level'] == 4) {
						if ($WeaponsAndEquip[$y]['short'] != NULL) {
							$weapons .= CELL_OPEN . "1-" . ($WeaponsAndEquip[$y]['short'] * 2) . CELL_CLOSE;
							$weapons .= CELL_OPEN . (($WeaponsAndEquip[$y]['short'] * 2) + 1) . "-" . ($WeaponsAndEquip[$y]['short'] * 4) . CELL_CLOSE;
							$weapons .= CELL_OPEN . (($WeaponsAndEquip[$y]['short'] * 4) + 1) . "-" . ($WeaponsAndEquip[$y]['short'] * 6) . CELL_CLOSE;
							$weapons .= CELL_OPEN . (($WeaponsAndEquip[$y]['short'] * 6) + 1) . "-" . ($WeaponsAndEquip[$y]['short'] * 8) . CELL_CLOSE;
							$weapons .= CELL_OPEN . (($WeaponsAndEquip[$y]['short'] * 8) + 1) . "-" . ($WeaponsAndEquip[$y]['short'] * 10) . CELL_CLOSE;
							$weapons .= CELL_OPEN . (($WeaponsAndEquip[$y]['short'] * 10) + 1) . "-" . ($WeaponsAndEquip[$y]['short'] * 12) . CELL_CLOSE;
						} else {
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash() . CELL_CLOSE;
						}
					} else {
						if ($UnitType == 3) {
							$weapons .= CELL_OPEN . aerotechRanges($WeaponsAndEquip[$y]['long'],$WeaponsAndEquip[$y]['damage'],0) . CELL_CLOSE;
							$weapons .= CELL_OPEN . aerotechRanges($WeaponsAndEquip[$y]['long'],$WeaponsAndEquip[$y]['damage'],7) . CELL_CLOSE;
							$weapons .= CELL_OPEN . aerotechRanges($WeaponsAndEquip[$y]['long'],$WeaponsAndEquip[$y]['damage'],13) . CELL_CLOSE;
							$weapons .= CELL_OPEN . aerotechRanges($WeaponsAndEquip[$y]['long'],$WeaponsAndEquip[$y]['damage'],21) . CELL_CLOSE;
						} elseif ($WeaponsAndEquip[$y]['short'] == 1 || $WeaponsAndEquip[$y]['short'] == NULL) {
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['short']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['medium']) . CELL_CLOSE;
							$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['long']) . CELL_CLOSE;
							if ($_POST['Level'] > 2) $weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['extreme']) . CELL_CLOSE;
						} else {
							$weapons .= CELL_OPEN . "1-" . $WeaponsAndEquip[$y]['short'] . CELL_CLOSE;
							$weapons .= CELL_OPEN . ($WeaponsAndEquip[$y]['short'] + 1) . "-" . $WeaponsAndEquip[$y]['medium'] . CELL_CLOSE;
							$weapons .= CELL_OPEN . ($WeaponsAndEquip[$y]['medium'] + 1) . "-" . $WeaponsAndEquip[$y]['long'] . CELL_CLOSE;
							if ($_POST['Level'] > 2) $weapons .= CELL_OPEN . ($WeaponsAndEquip[$y]['long'] + 1) . "-" . $WeaponsAndEquip[$y]['extreme'] . CELL_CLOSE;
						}
					}
					$weapons .= CELL_OPEN . nullToDash($WeaponsAndEquip[$y]['thm']) . CELL_CLOSE;
					$weapons .= "\t\t</tr>\n";
				}
			}
		}
	}
	return $weapons;
}


// List the allocated weapons for ProtoMechs
function listAllocatedWeaponsProto() {
	require('master.db.php');
	
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsProto); $y++) {
			if ($WeaponsProto[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "\t\t<tr>\n";
					$weapons .= "\t\t\t<td class=\"Center\"><strong>" . $_POST['Location'.$x] . "</strong></td>\n";
					$weapons .= CELL_OPEN . $WeaponsProto[$y]['name'] . CELL_CLOSE;
					if ($WeaponsProto[$y]['type'] == 4) {
						$weapons .= CELL_OPEN . $WeaponsProto[$y]['damage'] . "/" . $WeaponsProto[$y]['mdamage'] . CELL_CLOSE;
					} elseif ($WeaponsProto[$y]['type'] == 3 && $WeaponsProto[$y]['mdamage'] != NULL) {
						$weapons .= CELL_OPEN . $WeaponsProto[$y]['mdamage'] . "-" . $WeaponsProto[$y]['damage'] . CELL_CLOSE;
					} else {
						$weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['damage']) . CELL_CLOSE;
					}
					if ($_POST['Level'] == 4) $weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['delay']) . CELL_CLOSE;
					$weapons .= CELL_OPEN . nullToDash(solarisMult($WeaponsProto[$y]['min'])) . CELL_CLOSE;
					if ($WeaponsAndEquip[$y]['short'] == 1 || $WeaponsProto[$y]['short'] == NULL) {
						$weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['short']) . CELL_CLOSE;
						$weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['medium']) . CELL_CLOSE;
						$weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['long']) . CELL_CLOSE;
						if ($_POST['Level'] > 2) $weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['extreme']) . CELL_CLOSE;
					} else {
						$weapons .= CELL_OPEN . "1-" . $WeaponsProto[$y]['short'] . CELL_CLOSE;
						$weapons .= CELL_OPEN . ($WeaponsProto[$y]['short'] + 1) . "-" . $WeaponsProto[$y]['medium'] . CELL_CLOSE;
						$weapons .= CELL_OPEN . ($WeaponsProto[$y]['medium'] + 1) . "-" . $WeaponsProto[$y]['long'] . CELL_CLOSE;
						if ($_POST['Level'] > 2) $weapons .= CELL_OPEN . ($WeaponsProto[$y]['long'] + 1) . "-" . $WeaponsProto[$y]['extreme'] . CELL_CLOSE;
					}
					$weapons .= CELL_OPEN . nullToDash($WeaponsProto[$y]['thm']) . CELL_CLOSE;
					$weapons .= "\t\t</tr>\n";
				}
			}
		}
	}
	return $weapons;
}


// List the allocated melee weapons
function listAllocatedMeleeWeapons() {
	// Left arm melee weapons
	if ($_POST['LAActuators'] > 3) {
		$weapons .= "\t\t<tr>\n";
		$weapons .= "\t\t\t<th>LA</th>\n";
	
		switch ($_POST['LAActuators']) {
			case 4: // Hatchet
				$weaponName = "Hatchet";				
				$weaponDamage = meleeWeaponDamage(4);
				$weaponMod = '-1';
				break;
			case 5: // Sword
				$weaponName = "Sword";
				$weaponDamage = meleeWeaponDamage(5);
				$weaponMod = '-2';
				break;
			case 6: // Mace
				$weaponName = "Mace";
				$weaponDamage = meleeWeaponDamage(6);
				$weaponMod = '+2';
				break;
			case 7: // Claw
				$weaponName = "Claw";
				$weaponDamage = meleeWeaponDamage(7);
				$weaponMod = '0/-2';
				break;
			case 8: // Retractable Blade
				$weaponName = "Retractable Blade";
				$weaponDamage = meleeWeaponDamage(8);
				$weaponMod = '-2';
				break;
			default: // None
				break;
		}
		
		$weapons .= CELL_OPEN . $weaponName . CELL_CLOSE;
		$weapons .= CELL_OPEN . "0" . CELL_CLOSE;
		$weapons .= CELL_OPEN . $weaponDamage . CELL_CLOSE;
		$weapons .= EMPTY_CELL . EMPTY_CELL . EMPTY_CELL . EMPTY_CELL;
		$weapons .= CELL_OPEN . $weaponMod . CELL_CLOSE;
		
		if ($_POST['Level'] == 4) {
			$weapons .= EMPTY_CELL . EMPTY_CELL . EMPTY_CELL . EMPTY_CELL;
		}
		
		if ($_POST['Level'] == 3) $weapons .= EMPTY_CELL;
		
		$weapons .= "\t\t</tr>\n";
	}
	
	// Right arm melee weapons
	if ($_POST['RAActuators'] > 3) {
		$weapons .= "\t\t<tr>\n";
		$weapons .= "\t\t\t<th>RA</th>\n";
	
		switch ($_POST['RAActuators']) {
			case 4: // Hatchet
				$weaponName = "Hatchet";				
				$weaponDamage = meleeWeaponDamage(4);
				$weaponMod = '-1';
				break;
			case 5: // Sword
				$weaponName = "Sword";
				$weaponDamage = meleeWeaponDamage(5);
				$weaponMod = '-2';
				break;
			case 6: // Mace
				$weaponName = "Mace";
				$weaponDamage = meleeWeaponDamage(6);
				$weaponMod = '+2';
				break;
			case 7: // Claw
				$weaponName = "Claw";
				$weaponDamage = meleeWeaponDamage(7);
				$weaponMod = '0/-2';
				break;
			case 8: // Retractable Blade
				$weaponName = "Retractable Blade";
				$weaponDamage = meleeWeaponDamage(8);
				$weaponMod = '-2';
				break;
			default: // None
				break;
		}
		
		$weapons .= CELL_OPEN . $weaponName . CELL_CLOSE;
		$weapons .= CELL_OPEN . "0" . CELL_CLOSE;
		$weapons .= CELL_OPEN . $weaponDamage . CELL_CLOSE;
		$weapons .= EMPTY_CELL . EMPTY_CELL . EMPTY_CELL . EMPTY_CELL;
		$weapons .= CELL_OPEN . $weaponMod . CELL_CLOSE;
		
		if ($_POST['Level'] == 4) {
			$weapons .= EMPTY_CELL . EMPTY_CELL . EMPTY_CELL . EMPTY_CELL;
		}
		
		if ($_POST['Level'] == 3) $weapons .= EMPTY_CELL;
		
		$weapons .= "\t\t</tr>\n";
	}
	
	return $weapons;}

// Display allocated ammo
function listAllocatedAmmo() {
	require('master.db.php');
	
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsAmmo); $y++) {
			if ($WeaponsAmmo[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['UnitType'] == 2 || $_POST['UnitType'] == 3) { 
					$ammo .= "\t\t\t<p>" . $WeaponsAmmo[$y]['aname'] . " &nbsp;[" . $WeaponsAmmo[$y]['ammo'] . "] ";
				} else {
					$ammo .= "\t\t\t<p><strong>" . $_POST['Location'.$x] . "</strong>&nbsp; " . $WeaponsAmmo[$y]['aname'] . " &nbsp;[" . $WeaponsAmmo[$y]['ammo'] . "] ";				
				}
				if ($WeaponsAmmo[$y]['ammo'] < 51) {
					// Display Ticks
					for ($a = 0; $a < $WeaponsAmmo[$y]['ammo']; $a++) {
						$ammo .= CIRCLE_SM;
					}
				}
				$ammo .= " _________</p>\n";
			}
		}
	}
	return $ammo;
}

// Display Heat Sink Ticks
function heatsinkTicks($heatSinks) {
	for ($h = 0; $h < $heatSinks; $h++) {
		if ($h == 20 OR $h == 40 OR $h == 60) $hs .= "<br />";
		$hs .= CIRCLE_LG;
	}
	return $hs;
}

// Create a row for the heat scale
function heatScaleRow($num, $effect) {
	if ($_POST['Level'] == 4) {
		$mult = 4;
	} else {
		$mult = 1;
	}
	if ($num < 10) $num = '0' . $num;
	return "\t\t\t<tr><td>_ " . $num * $mult . "</td><td>" . $effect . "</td></tr>\n";
}

// Display the heat scale
function heatScale() {
	$heatscale .= heatScaleRow(30, 'Shutdown');
	$heatscale .= heatScaleRow(29, '');
	$heatscale .= heatScaleRow(28, 'Ammo Explosion, avoid on 8+');
	$heatscale .= heatScaleRow(27, '');
	$heatscale .= heatScaleRow(26, 'Shutdown, avoid on 10+');
	$heatscale .= heatScaleRow(25, '-5 Movement Points');
	$heatscale .= heatScaleRow(24, '+4 Modifier to Fire');
	$heatscale .= heatScaleRow(23, 'Ammo Explosion, avoid on 6+');
	$heatscale .= heatScaleRow(22, 'Shutdown, avoid on 8+');
	$heatscale .= heatScaleRow(21, '');
	$heatscale .= heatScaleRow(20, '-4 Movement Points');
	$heatscale .= heatScaleRow(19, 'Ammo Explosion, avoid on 4+');
	$heatscale .= heatScaleRow(18, 'Shutdown, avoid on 6+');
	$heatscale .= heatScaleRow(17, '+3 Modifier to Fire');
	$heatscale .= heatScaleRow(16, '');
	$heatscale .= heatScaleRow(15, '-3 Movement Points');
	$heatscale .= heatScaleRow(14, 'Shutdown, avoid on 4+');
	$heatscale .= heatScaleRow(13, '+2 Modifier to Fire');
	$heatscale .= heatScaleRow(12, '');
	$heatscale .= heatScaleRow(11, '');
	$heatscale .= heatScaleRow(10, '-2 Movement Points');
	$heatscale .= heatScaleRow(9, '');
	$heatscale .= heatScaleRow(8, '+1 Modifier to Fire');
	$heatscale .= heatScaleRow(7, '');
	$heatscale .= heatScaleRow(6, '');
	$heatscale .= heatScaleRow(5, '-1 Movement Points');
	$heatscale .= heatScaleRow(4, '');
	$heatscale .= heatScaleRow(3, '');
	$heatscale .= heatScaleRow(2, '');
	$heatscale .= heatScaleRow(1, '');
	$heatscale .= heatScaleRow(0, '');
	return $heatscale;
}

// Display the heat scale for Aerotech fighters
function heatScaleAero() {
	$heatscale .= heatScaleRow(30, 'Shutdown');
	$heatscale .= heatScaleRow(29, '');
	$heatscale .= heatScaleRow(28, 'Ammo Explosion, avoid on 8+');
	$heatscale .= heatScaleRow(27, 'Pilot Damage, avoid on 9+');
	$heatscale .= heatScaleRow(26, 'Shutdown, avoid on 10+');
	$heatscale .= heatScaleRow(25, 'Random Movement, avoid on 10+');
	$heatscale .= heatScaleRow(24, '+4 Modifier to Fire');
	$heatscale .= heatScaleRow(23, 'Ammo Explosion, avoid on 6+');
	$heatscale .= heatScaleRow(22, 'Shutdown, avoid on 8+');
	$heatscale .= heatScaleRow(21, 'Pilot Damage, avoid on 6+');
	$heatscale .= heatScaleRow(20, 'Random Movement, avoid on 8+');
	$heatscale .= heatScaleRow(19, 'Ammo Explosion, avoid on 4+');
	$heatscale .= heatScaleRow(18, 'Shutdown, avoid on 6+');
	$heatscale .= heatScaleRow(17, '+3 Modifier to Fire');
	$heatscale .= heatScaleRow(16, '');
	$heatscale .= heatScaleRow(15, 'Random Movement, avoid on 7+');
	$heatscale .= heatScaleRow(14, 'Shutdown, avoid on 4+');
	$heatscale .= heatScaleRow(13, '+2 Modifier to Fire');
	$heatscale .= heatScaleRow(12, '');
	$heatscale .= heatScaleRow(11, '');
	$heatscale .= heatScaleRow(10, 'Random Movement, avoid on 6+');
	$heatscale .= heatScaleRow(9, '');
	$heatscale .= heatScaleRow(8, '+1 Modifier to Fire');
	$heatscale .= heatScaleRow(7, '');
	$heatscale .= heatScaleRow(6, '');
	$heatscale .= heatScaleRow(5, 'Random Movement, avoid on 5+');
	$heatscale .= heatScaleRow(4, '');
	$heatscale .= heatScaleRow(3, '');
	$heatscale .= heatScaleRow(2, '');
	$heatscale .= heatScaleRow(1, '');
	$heatscale .= heatScaleRow(0, '');
	return $heatscale;
}

// List weapons and equipment in the Technical Readout
function listWeaponsTR($type) {
	require('master.db.php');
	
	// List selected weapons
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsAndEquip); $y++) {
			if ($WeaponsAndEquip[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "\t\t<tr>\n";
					$weapons .= CELL_OPEN . $WeaponsAndEquip[$y]['name'] . CELL_CLOSE;					
					$weapons .= CELL_OPEN . $_POST['Location'.$x] . CELL_CLOSE;					if ($type == 1) $weapons .= CELL_OPEN . $WeaponsAndEquip[$y]['crits'] . CELL_CLOSE;
					$weapons .= CELL_OPEN . decimalPlaces($WeaponsAndEquip[$y]['tons'], 1) . CELL_CLOSE;
					$weapons .= "\t\t</tr>\n";
				}
			}
		}
	}
	
	// Select Ammo
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsAmmo); $y++) {
			if ($WeaponsAmmo[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "\t\t<tr>\n";
					$weapons .= CELL_OPEN . $WeaponsAmmo[$y]['name'] . CELL_CLOSE;					
					$weapons .= CELL_OPEN . $_POST['Location'.$x] . CELL_CLOSE;					if ($type == 1) $weapons .= CELL_OPEN . $WeaponsAmmo[$y]['crits'] . CELL_CLOSE;
					$weapons .= CELL_OPEN . decimalPlaces($WeaponsAmmo[$y]['tons'], 1) . CELL_CLOSE;
					$weapons .= "\t\t</tr>\n";
				}
			}
		}
	}
	
	// List melee Weapons
	if ($type == 1 && $_POST['LAActuators'] > 3) {
		$weapons .= "\t\t<tr>\n";
		$weapons .= CELL_OPEN . armActuatorsType($_POST['LAActuators']) . CELL_CLOSE;					
		$weapons .= CELL_OPEN . "LA" . CELL_CLOSE;		$weapons .= CELL_OPEN . meleeWeaponCrits($_POST['LAActuators']) . CELL_CLOSE;
		$weapons .= CELL_OPEN . decimalPlaces(meleeWeaponTons($_POST['LAActuators']), 1) . CELL_CLOSE;
		$weapons .= "\t\t</tr>\n";
	}
	if ($type == 1 && $_POST['RAActuators'] > 3) {
		$weapons .= "\t\t<tr>\n";
		$weapons .= CELL_OPEN . armActuatorsType($_POST['RAActuators']) . CELL_CLOSE;					
		$weapons .= CELL_OPEN . "RA" . CELL_CLOSE;		$weapons .= CELL_OPEN . meleeWeaponCrits($_POST['RAActuators']) . CELL_CLOSE;
		$weapons .= CELL_OPEN . decimalPlaces(meleeWeaponTons($_POST['RAActuators']), 1) . CELL_CLOSE;
		$weapons .= "\t\t</tr>\n";
	}
	return $weapons;
}

// List weapons and equipment in the Technical Readout for ProtoMechs
function listWeaponsTRProto($type) {
	require('master.db.php');
	
	// List selected weapons
	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsProto); $y++) {
			if ($WeaponsProto[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "\t\t<tr>\n";
					$weapons .= CELL_OPEN . $WeaponsProto[$y]['name'] . CELL_CLOSE;					
					$weapons .= CELL_OPEN . $_POST['Location'.$x] . CELL_CLOSE;					if ($type == 1) $weapons .= CELL_OPEN . $WeaponsProto[$y]['crits'] . CELL_CLOSE;
					$weapons .= CELL_OPEN . decimalPlaces($WeaponsProto[$y]['tons'], 1) . CELL_CLOSE;
					$weapons .= "\t\t</tr>\n";
				}
			}
		}
	}
	return $weapons;
}

// List weapons and equipment in the XML file
function listWeaponsXML() {
	require('master.db.php');

	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsFull); $y++) {
			if ($WeaponsFull[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "<item>";
					$weapons .= "<id>" . $x . "</id>";
					$weapons .= "<type>" . $WeaponsFull[$y]['name'] . "</type>";
					$weapons .= "<loc>" . $_POST['Location'.$x] . "</loc>";					$weapons .= "<crits>" . $WeaponsFull[$y]['crits'] . "</crits>";
					$weapons .= "</item>";
				}
			}
		}
	}
	return $weapons;
}

// List weapons on the Tech Readout page
function listArmamentTR() {
	require('master.db.php');

	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsAndEquip); $y++) {
			if ($WeaponsAndEquip[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "<dd class=\"indent\">" . $WeaponsAndEquip[$y]['name'] . "</dd>";
				}
			}
		}
	}
	// Melee Weapons
	if ($_POST['LAActuators'] > 3) $weapons .= "<dd class=\"indent\">" . armActuatorsType($_POST['LAActuators']) . "</dd>";
	if ($_POST['RAActuators'] > 3) $weapons .= "<dd class=\"indent\">" . armActuatorsType($_POST['RAActuators']) . "</dd>";
	if (!$weapons) {
		return "<dd class=\"indent\">none</dd>";
	} else {
		return $weapons;
	}
}

// List weapons on the Tech Readout page for ProtoMechs
function listArmamentTRProto() {
	require('master.db.php');

	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsProto); $y++) {
			if ($WeaponsProto[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					$weapons .= "<dd class=\"indent\">" . $WeaponsProto[$y]['name'] . "</dd>";
				}
			}
		}
	}
	if (!$weapons) {
		return "<dd class=\"indent\">none</dd>";
	} else {
		return $weapons;
	}
}


// Convert Movement Points to KPH
function mp2Kph($MP) {
	$arrMP2KPH = array(0,14,22,32,43,54,65,76,85,97,108,119,130,137,150,162,172,184,190,201,216,230,248,261,275,290,305,318,329,340,351);
	return $arrMP2KPH[$MP];
}

// Convert Movement Points to KPH (Air Speed) for AeroTech
function mp2KphAir($MP) {
	$arrMP2KPH = array(160,390,550,720,810,900,1080,1210,1440,1620,1890,2050,2310,2560,2830,3210,3570,3850,4100,4500,5000,5600,6100,7600,8100,8700,9200,9800,11000,11700,12500);
	return $arrMP2KPH[$MP];
}

// Convert Jumping Movement Points to meters
function mp2Meters($MP) {
	if ($MP) {
		return $MP * 30 . ' meters';
	} else {
		return 'none';
	}
}

// Hardpoint/bomb descriptions
function Hardpoints($type) {
	$arrHarpoint = array('','High Explosive','Inferno','Cluster','Laser Guided','Rocket Launcher','Mine','Arrow IV','TAG','Fuel Pod');
	return $arrHarpoint[$type];
}


//////////////////////
// Battleforce Stats
//////////////////////

// Battleforce structure conversion
function structureBF($Tons, $Engine, $Tech) {
	// XL Engines
	if ($Engine > 0 && $Engine < 7) {
		// Clan
		if ($Tech == 2) {
			switch ($Tons) {
				case $Tons > 24 && $Tons < 40:
					return 2;
					break;
				case $Tons > 39 && $Tons < 60:
					return 3;
					break;
				case $Tons > 59 && $Tons < 80:
					return 4;
					break;
				case $Tons > 79 && $Tons < 100:
					return 5;
					break;
				case $Tons > 99 && $Tons < 120:
					return 6;
					break;
				case $Tons > 119:
					return 7;
					break;
				default:
					return 1;
					break;
			}
		} else {
			// Inner Sphere
			switch ($Tons) {
				case $Tons > 39 && $Tons < 65:
					return 2;
					break;
				case $Tons > 64 && $Tons < 95:
					return 3;
					break;
				case $Tons > 94 && $Tons < 125:
					return 4;
					break;
				case $Tons > 124:
					return 5;
					break;
				default:
					return 1;
					break;
			}
		}
	} else {
		// Standard Engines
		switch ($Tons) {
			case $Tons > 19 && $Tons < 30:
				return 2;
				break;
			case $Tons > 29 && $Tons < 45:
				return 3;
				break;
			case $Tons > 44 && $Tons < 55:
				return 4;
				break;
			case $Tons > 54 && $Tons < 75:
				return 5;
				break;
			case $Tons > 74 && $Tons < 85:
				return 6;
				break;
			case $Tons > 84 && $Tons < 95:
				return 7;
				break;
			case $Tons > 94:
				return 8;
				break;
			default:
				return 1;
				break;
		}
	}
}

// Battleforce armor conversion
function armorBF($Armor) {
	if (!$Armor) return 0;
	switch ($Armor) {
		case $Armor > 19 && $Armor < 60:
			return 1;
			break;
		case $Armor > 59 && $Armor < 100:
			return 2;
			break;
		case $Armor > 99 && $Armor < 140:
			return 3;
			break;
		case $Armor > 139 && $Armor < 180:
			return 4;
			break;
		case $Armor > 179 && $Armor < 220:
			return 5;
			break;
		case $Armor > 219 && $Armor < 260:
			return 6;
			break;
		case $Armor > 259 && $Armor < 300:
			return 7;
			break;
		case $Armor > 299 && $Armor < 360:
			return 8;
			break;
		case $Armor > 359:
			return intval($Armor / 40);
			break;
		default:
			return 0;
			break;
	}
}

// Battleforce total weapon damage value by range
function damageByRangeBF($WeaponRange) {
	require('master.db.php');

	for ($x = 0; $x < $Max_Items; $x++) {
		for ($y = 0; $y < count($WeaponsFull); $y++) {
			if ($WeaponsFull[$y]['sn'] == $_POST['SN'.$x] && $_POST['SN'.$x] != NULL) {
				if ($_POST['Location'.$x] != '0' || $_POST['Location'.$x] == NULL) {
					if ($WeaponsFull[$y]['long'] > $WeaponRange) {
						if ($WeaponsFull[$y]['min']) {
							if ($WeaponsFull[$y]['min'] < 4) $Damage = $WeaponsFull[$y]['damage'] * 0.75;
							if ($WeaponsFull[$y]['min'] > 3) $Damage = $WeaponsFull[$y]['damage'] * 0.5;
							$weapons += $Damage;
						} else {
							$weapons += $WeaponsFull[$y]['damage'];						
						}
					}
				}
			}
		}
	}
	if ($WeaponRange == 0) $weapons += meleeWeaponDamage($_POST['LAActuators']) + meleeWeaponDamage($_POST['RAActuators']);
	if ($weapons) return roundNearWhole($weapons * 0.1, 0.5);
}

function specialBF($Mods) {
	$arrSpecial = array('','omni','lam','utility');
	return $arrSpecial[$Mods];
}



//////////////////////
// AeroTech
//////////////////////

// Get the Structural Integrity of an Aerotech fighter
function structuralIntegrity($Thrust, $Tons) {
	$StructIntegrity = roundNearWhole($Tons * 0.1, 0.5);
	if ($Thrust > $StructIntegrity) {
		return intval($Thrust);
	} else {
		return $StructIntegrity;
	}
}

// Dropship fuel consumption tons per day
function fuelConsumptionDS($Tons) {
	switch ($Tons) {
		case $Tons > 49 && $Tons < 100:
			return 0.75;
			break;
		case $Tons > 99 && $Tons < 1000:
			return 1.84;
			break;
		case $Tons > 999 && $Tons < 4000:
			return 2.82;
			break;
		case $Tons > 3999 && $Tons < 9000:
			return 3.37;
			break;
		case $Tons > 8999 && $Tons < 20000:
			return 4.22;
			break;
		case $Tons > 19999 && $Tons < 30000:
			return 5.19;
			break;
		case $Tons > 29999 && $Tons < 40000:
			return 6.52;
			break;
		case $Tons > 39999 && $Tons < 50000:
			return 7.71;
			break;
		case $Tons > 59999 && $Tons < 70000:
			return 8.37;
			break;
		case $Tons > 69999:
			return 8.83;
			break;
		default:
			return 0.45;
			break;
	}
}

// Aerotech and Battlespace ranges
function aerotechRanges($Range, $Damage, $Value) {
	if ($Range > $Value) {
		return $Damage;	
	} else {
		return '-';
	}
}

?>