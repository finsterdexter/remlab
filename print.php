<?php

ini_set('max_input_time', '60');
ini_set('max_execution_time', '30');
ini_set('output_buffering', '4096');

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// Includes
require_once('include/functions.inc.php');
require_once('include/template.class.php');
require_once('include/structure.db.php');

// Set p to default and check for errors
if (!$_GET['p']) $_GET['p'] = 'mech';

// Define each HTML template
switch ($_GET['t']) {
	case 'tr':
		$template = 'template/' . cleanInput($_GET['p']) . '.tr.tpl.inc';
		break;
	case 'xml':
		header("Content-type: application/xml");
		$template = 'template/' . cleanInput($_GET['p']) . '.tpl.xml';
		break;
	case 'mft':
		header("Content-type: text/plain");
		$template = 'template/' . cleanInput($_GET['p']) . '.tpl.mft';
		break;
	default:
		$template = 'template/' . cleanInput($_GET['p']) . '.rs.tpl.inc';
		break;
}

// Default time zone (CST)
$Timezone = date('U') - 3600;

// Define the HTML elements
define('CIRCLE_LG', "O");
define('CIRCLE_SM', "o");
define('REAR', "(R)");
define('EMPTY_SLOT', "\t\t\t<li><em>Roll Again</em></li>\n");
define('LOW', "Low &nbsp;(1-3)\n");
define('HIGH', "High &nbsp;(4-6)\n");
define('LOC_BREAK', "\t\t\t</ol>High &nbsp;(4-6)\n\t\t\t<ol>\n");
define('EMPTY_CELL', "\t\t\t<td>-</td>\n");
define('CELL_OPEN', "\t\t\t<td>");
define('CELL_OPEN_CTR', "\t\t\t<td class=\"Center\">");
define('CELL_CLOSE', "</td>\n");
define('LIST_OPEN', "\t\t\t<li>");
define('LIST_CLOSE', "</li>\n");

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate($template);

// Check for user entered tonnage
if ($_POST['TonnageInput']) {
	$Tonnage = $_POST['TonnageInput'];
} else {
	$Tonnage = $_POST['Tonnage'];
}

// Vehicle Advanced MP
if ($_POST['UnitType'] == 1) $CruisingMod = advancedVehMPMod($_POST['AdvanceMP']);

// Engine Rating
if ($_POST['UnitType'] == 4) {
	$EngineRating = intval($Tonnage * runningSpeed($_POST['Walking']));
} else {
	$EngineRating = intval(roundUpFive($Tonnage) * ($_POST['Walking'] + $CruisingMod)) - suspensionFactor($_POST['Mods'], $Tonnage);
	if ($EngineRating < 5) $EngineRating = 5;
}

// Heat sinks
if ($_POST['Engine'] < 7) {
	$HeatSinks = nullToZero($_POST['HeatSinks']) + 10;
} else {
	$HeatSinks = nullToZero($_POST['HeatSinks']);
}

// Variables
if ($_POST['Legs'] == 4) $MechLegs = 'Quad-Legged';
if ($_POST['Armor'] == 2) $RunningMod = 1;
if ($_POST['Gyro'] == 2) $HDGyro = CIRCLE_LG;
$ISMult = 1;

// Pilot/Player info, if no data then add lines
if ($_POST['PilotName']) { 
	$PilotName = cleanInput($_POST['PilotName']);
} else {
	$PilotName = "<span class=\"UL\">&nbsp;</span>";
}
if ($_POST['Player']) { 
	$Player = cleanInput($_POST['Player']);
} else {
	$Player = "<span class=\"UL\">&nbsp;</span>";
}
if ($_POST['Miniature']) {
	$Miniature = cleanInput($_POST['Miniature']);	
} else {
	$Miniature = "<span class=\"UL ULs\">&nbsp;</span>";
}

// Check for user entered era
if ($_POST['EraInput']) {
	$page->setParameter('ERA', $_POST['EraInput']);
} else {
	$page->setParameter('ERA', $_POST['Era']);
}

// Special Movement Types
switch ($_POST['AdvanceMP']) {
	case 1: // MASC
		$Masc = " (" . intval($_POST['Walking'] * 2) . ")";
		break;
	case 3: // SuperCharger
		$Masc = " (" . intval($_POST['Walking'] * 2.5) . ")";
		$MascSprint = " (" . intval($_POST['Walking'] * 3) . ")";
		break;
	default:
		break;
}

// VTOL Jet Boosters
if ($_POST['SpRear'] == 6) $Masc = " (" . intval($_POST['Walking'] * 2.5) . ")";


// Settings for the page
$page->setParameter('TITLE', TITLE);
$page->setParameter('SUB_TITLE', SUB_TITLE);
$page->setParameter('VERSION', VERSION);
$page->setParameter('AUTHOR', AUTHOR);
$page->setParameter('URL', AUTHOR);
$page->setParameter('DATE_CREATED', date("M j, Y", $Timezone));
$page->setParameter('GAME_SYSTEM', 'BATTLETECH');

// Unit specific values
switch ($_POST['UnitType']) {
	case 2: // Vehicle
		$page->setParameter('CLASS', weightClass($Tonnage));
		$page->setParameter('ADVANCED_VEH_MP', advancedVehMPType($_POST['AdvanceMP']));
		$page->setParameter('CHASSIS', vehicleChassis($_POST['Mods']));
		$page->setParameter('CHASSIS_TYPE', vehicleClass($_POST['Mods']));
		$page->setParameter('TERRAIN_RESTRICT', vehicleTerrain($_POST['Mods']));
		$page->setParameter('TURRET_TONS', decimalPlaces($_POST['TurretTons'], 1));
		$page->setParameter('POWER_AMP', decimalPlaces($_POST['PowerAmp'], 1));
		$page->setParameter('CONTROL_EQUIP', decimalPlaces($_POST['ControlEquip'], 1));
		$page->setParameter('LIFT_EQUIP', decimalPlaces($_POST['LiftEquip'], 1));
		$page->setParameter('CARGO_SPACE', decimalPlaces($_POST['CargoSpace'], 1));
		$page->setParameter('ARMOR', armorType($_POST['Armor']));
		$page->setParameter('ALLOCATED_HEADER', allocatedWeaponsHeaderVehicle());
		if ($_POST['SpFront']) {
			$page->setParameter('SP_FRONT', vehFrontType($_POST['SpFront']) . "\n");
		} else {
			$page->setParameter('SP_FRONT', '');
		}
		if ($_POST['SpTop']) {
			$page->setParameter('SP_TOP', vehTopType($_POST['SpTop']) . "\n");
		} else {
			$page->setParameter('SP_TOP', '');
		}
		if ($_POST['SpRear']) {
			$page->setParameter('SP_REAR', vehRearType($_POST['SpRear']) . "\n");
		} else {
			$page->setParameter('SP_REAR', '');
		}
		if ($_POST['SpSides']) {
			$page->setParameter('SP_SIDES', vehRearType($_POST['SpSides']) . "\n");
		} else {
			$page->setParameter('SP_SIDES', '');
		}
		if (!$_POST['SpFront'] && $_POST['SpTop'] < 2 && !$_POST['SpRear'] && $_GET['t'] == 'rs') $page->setParameter('SP_FRONT', 'None');
		switch ($_POST['Mods']) {
			case 5:
				$page->setParameter('TURRET_ROTOR', 'Turret');
				$page->setParameter('ELEVATION_DEPTH', 'Depth');
				if ($_POST['SpTop'] != 1) $page->setParameter('STYLE_DISPLAY', ' style="visibility:hidden"');
				$page->setParameter('CREW_DATA_STATS', 'Commander Hit <span class="CritNum">+1</span> &nbsp;&nbsp;&nbsp; Driver Hit <span class="CritNum">+2</span></p><p class="FontSM">Mod to all skill rolls &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mod to Driving skill rolls');
				$page->setParameter('CRITICAL_DAMAGE', '<td>Motive System Hits</td><th class="CritBox">+1</th><th class="CritBox">+2</th><th class="CritBox">+3</th><td></td>');
				break;
			case 7:
				$page->setParameter('TURRET_ROTOR', 'Rotor');
				$page->setParameter('ELEVATION_DEPTH', 'Elevation');
				$page->setParameter('CREW_DATA_STATS', 'Co-Pilot Hit <span class="CritNum">+1</span> &nbsp;&nbsp;&nbsp;&nbsp; Pilot Hit <span class="CritNum">+2</span></p><p class="FontSM">Mod to all to-hit rolls &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mod to Driving skill rolls');
				$page->setParameter('CRITICAL_DAMAGE', '<td>Flight Stabilizer</td><th class="CritBox">+3</th><th></th><th></th><td></td>');
				break;
			default:
				$page->setParameter('TURRET_ROTOR', 'Turret');
				if ($_POST['SpTop'] != 1) $page->setParameter('STYLE_DISPLAY', ' style="visibility:hidden"');
				$page->setParameter('HIDE_TRACK', ' style="display:none"');
				$page->setParameter('CREW_DATA_STATS', 'Commander Hit <span class="CritNum">+1</span> &nbsp;&nbsp;&nbsp; Driver Hit <span class="CritNum">+2</span></p><p class="FontSM">Mod to all skill rolls &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mod to Driving skill rolls');
				$page->setParameter('CRITICAL_DAMAGE', '<td>Motive System Hits</td><th class="CritBox">+1</th><th class="CritBox">+2</th><th class="CritBox">+3</th><td></td>');
				break;
		}

		// Vehicle Armor ticks
		$page->setParameter('ARMOR_F', Display_Armor($_POST['ArmorF'], 10));
		$page->setParameter('ARMOR_R', Display_Armor($_POST['ArmorR'], 10));
		$page->setParameter('ARMOR_RS', Display_Armor($_POST['ArmorRS'], 10));
		$page->setParameter('ARMOR_LS', Display_Armor($_POST['ArmorLS'], 10));
		$page->setParameter('ARMOR_T', Display_Armor($_POST['ArmorT'], 10));
		$page->setParameter('ARMOR_INTERNAL', Display_Armor(roundNearWhole($Tonnage * 0.1, 0.5), 10));
		// Vehicle Armor value
		$page->setParameter('ARMOR_F_NUM', $_POST['ArmorF']);
		$page->setParameter('ARMOR_R_NUM', $_POST['ArmorR']);
		$page->setParameter('ARMOR_RS_NUM', $_POST['ArmorRS']);
		$page->setParameter('ARMOR_LS_NUM', $_POST['ArmorLS']);
		$page->setParameter('ARMOR_T_NUM', $_POST['ArmorLT']);
		break;
	case 3: // Aerotech
		if ($_POST['Mods'] < 2) {
			$page->setParameter('CLASS', weightClassAero($Tonnage));
		} else {
			$page->setParameter('CLASS', '');		
		}
		$page->setParameter('CHASSIS', aerotechChassis($_POST['Mods']));
		$page->setParameter('STRUCTURAL_INTEGRITY', $_POST['StructuralIntegrity']);
		$page->setParameter('SAFETHRUST_SPEED', mp2KphAir(intval($_POST['Walking'])));
		$page->setParameter('MAXTHRUST_SPEED', mp2KphAir(runningSpeed($_POST['Walking'])));
		$page->setParameter('FUEL', decimalPlaces($_POST['Fuel'], 1));
		$page->setParameter('FUEL_USE', fuelConsumptionDS($Tonnage) . ' tons/day');
		$page->setParameter('ARMOR', armorTypeAero($_POST['Armor']));
		$page->setParameter('GUNNERS_NUM', nullToZero($_POST['Gunners']));
		$page->setParameter('PASS_NUM', nullToZero($_POST['Passengers']));
		$page->setParameter('ALLOCATED_HEADER', allocatedWeaponsHeaderAerotech());
		if ($_POST['Lifeboat']) {
			$page->setParameter('LIFEBOAT', 'Lifeboat');
		} else {
			$page->setParameter('LIFEBOAT', '');		
		}
		switch ($_POST['Mods']) {
			case 1: // Conventional fighter
				$page->setParameter('COCKPIT', roundNearHalf($Tonnage * 0.1));
				$page->setParameter('SI_MASS', '0.0');
				$page->setParameter('FOOD_WATER', '0.0 tons');
				break;
			case 2: // Small Craft (aero)
				$page->setParameter('COCKPIT', roundNearHalf($Tonnage * 0.0075));
				$page->setParameter('SI_MASS', decimalPlaces(intval(($_POST['StructuralIntegrity'] * $Tonnage) / 200), 1));
				$page->setParameter('FOOD_WATER', '1.0 tons (35 day supply)');
				break;
			case 3: // Small Craft (Sphere)
				$page->setParameter('COCKPIT', roundNearHalf($Tonnage * 0.0075));
				$page->setParameter('SI_MASS', decimalPlaces(intval(($_POST['StructuralIntegrity'] * $Tonnage) / 500), 1));
				$page->setParameter('FOOD_WATER', '1.0 tons (35 day supply)');
				break;
			default: // Aerospace fighter
				$page->setParameter('COCKPIT', '3.0');
				$page->setParameter('SI_MASS', '0.0');
				$page->setParameter('FOOD_WATER', '0.0 tons');
				break;
		}
		if ($_POST['Mods'] == 1) {
			$page->setParameter('FUEL_POINTS', $_POST['Fuel'] * 160);
		} else {
			$page->setParameter('FUEL_POINTS', $_POST['Fuel'] * 80);
		}
		$page->setParameter('FUEL_MASS', $_POST['Fuel']);
		$page->setParameter('POWER_AMP', decimalPlaces($_POST['PowerAmp'], 1));
		$page->setParameter('CARGO_SPACE', decimalPlaces($_POST['CargoSpace'], 1));
		$page->setParameter('VSTOL', advancedAeroMPType($_POST['AdvanceMP']));
		if ($_POST['AdvanceMP'] == 1) $VSTOLMass = roundNearHalf($Tonnage * 0.05);
		$page->setParameter('ADVANCEDMP_MASS', decimalPlaces($VSTOLMass, 1));
		$page->setParameter('HEAT_SCALE_AERO', heatScaleAero());
		$page->setParameter('CONTROL_EQUIP', decimalPlaces($_POST['ControlEquip'], 1));
		if ($_POST['Mods'] > 1) $page->setParameter('HP_VISIBLE', 'style="display:none"');
		$page->setParameter('HARDPOINT1', Hardpoints($_POST['Hardpoint1']));
		$page->setParameter('HARDPOINT2', Hardpoints($_POST['Hardpoint2']));
		$page->setParameter('HARDPOINT3', Hardpoints($_POST['Hardpoint3']));
		$page->setParameter('HARDPOINT4', Hardpoints($_POST['Hardpoint4']));
		$page->setParameter('HARDPOINT5', Hardpoints($_POST['Hardpoint5']));
		$page->setParameter('HARDPOINT6', Hardpoints($_POST['Hardpoint6']));
		$page->setParameter('HARDPOINT7', Hardpoints($_POST['Hardpoint7']));
		$page->setParameter('HARDPOINT8', Hardpoints($_POST['Hardpoint8']));
		$page->setParameter('HARDPOINT9', Hardpoints($_POST['Hardpoint9']));
		$page->setParameter('HARDPOINT10', Hardpoints($_POST['Hardpoint10']));
		$page->setParameter('HARDPOINT11', Hardpoints($_POST['Hardpoint11']));
		$page->setParameter('HARDPOINT12', Hardpoints($_POST['Hardpoint12']));
		$page->setParameter('HARDPOINT13', Hardpoints($_POST['Hardpoint13']));
		$page->setParameter('HARDPOINT14', Hardpoints($_POST['Hardpoint14']));
		$page->setParameter('HARDPOINT15', Hardpoints($_POST['Hardpoint15']));
		$page->setParameter('HARDPOINT16', Hardpoints($_POST['Hardpoint16']));
		$page->setParameter('HARDPOINT17', Hardpoints($_POST['Hardpoint17']));
		$page->setParameter('HARDPOINT18', Hardpoints($_POST['Hardpoint18']));
		$page->setParameter('HARDPOINT19', Hardpoints($_POST['Hardpoint19']));
		$page->setParameter('HARDPOINT20', Hardpoints($_POST['Hardpoint20']));	
		// Aerotech Armor ticks
		$page->setParameter('ARMOR_N', Display_Armor($_POST['ArmorN'], 20));
		$page->setParameter('ARMOR_A', Display_Armor($_POST['ArmorA'], 20));
		$page->setParameter('ARMOR_RW', Display_Armor($_POST['ArmorRW'], 20));
		$page->setParameter('ARMOR_LW', Display_Armor($_POST['ArmorLW'], 20));
		$page->setParameter('SI_POINTS', Display_Armor($_POST['StructuralIntegrity'], 20));
		// Aerotech Armor value
		$page->setParameter('ARMOR_N_NUM', $_POST['ArmorN']);
		$page->setParameter('ARMOR_A_NUM', $_POST['ArmorA']);
		$page->setParameter('ARMOR_RW_NUM', $_POST['ArmorRW']);
		$page->setParameter('ARMOR_LW_NUM', $_POST['ArmorLW']);
		break;
	case 4: // ProtoMech
		$page->setParameter('JUMPING', intval($_POST['Jumping']));
		$page->setParameter('COCKPIT', '0.5');
		$page->setParameter('ALLOCATED_HEADER', allocatedWeaponsHeaderVehicle());
		$page->setParameter('POINT_COST', largeNumber(str_replace(',','',$_POST['TotalCost']) * 5));
		$page->setParameter('HEATSINKS_PROTO', ($_POST['HeatSinks'] * 4));
		$page->setParameter('HEATSINK_MASS_PROTO', $_POST['HeatSinks']);
		$page->setParameter('ENGINE_TONS', decimalPlaces(engineMassProto($EngineRating), 2));
		// Display Ammo
		if ($_POST['AMMOAC2']) $AmmoProto .= "AC/2: " . $_POST['AMMOAC2'] . " shots | ";
		if ($_POST['AMMOAC5']) $AmmoProto .= "AC/5: " . $_POST['AMMOAC5'] . " shots | ";
		if ($_POST['AMMOAMS']) $AmmoProto .= "AMS: " . $_POST['AMMOAMS'] . " shots | ";
		if ($_POST['AMMOHMG']) $AmmoProto .= "HMG: " . $_POST['AMMOHMG'] . " shots | ";
		if ($_POST['AMMOLMG']) $AmmoProto .= "LMG: " . $_POST['AMMOLMG'] . " shots | ";
		if ($_POST['AMMOMG']) $AmmoProto .= "MG: " . $_POST['AMMOMG'] . " shots | ";
		if ($_POST['AMMOLRM']) $AmmoProto .= "LRM: " . $_POST['AMMOLRM'] . " shots | ";
		if ($_POST['AMMOSRM']) $AmmoProto .= "SRM: " . $_POST['AMMOSRM'] . " shots | ";
		if ($_POST['AMMOSSRM']) $AmmoProto .= "sSRM: " . $_POST['AMMOSSRM'] . " shots | ";
		if ($_POST['AMMONarc']) $AmmoProto .= "Narc: " . $_POST['AMMONarc'] . " shots | ";
		$page->setParameter('ALLOCATED_AMMO_PROTO', $AmmoProto);
		// ProtoMech Armor ticks
		$page->setParameter('ARMOR_H', Display_Armor($_POST['ArmorH'], 10));
		$page->setParameter('ARMOR_T', Display_Armor($_POST['ArmorT'], 10));
		$page->setParameter('ARMOR_LA', Display_Armor($_POST['ArmorLA'], 10));
		$page->setParameter('ARMOR_RA', Display_Armor($_POST['ArmorRA'], 10));
		$page->setParameter('ARMOR_MG', Display_Armor($_POST['ArmorM'], 10));
		$page->setParameter('ARMOR_L', Display_Armor($_POST['ArmorL'], 10));
		// ProtoMech Armor value
		$page->setParameter('ARMOR_H_NUM', $_POST['ArmorH']);
		$page->setParameter('ARMOR_T_NUM', $_POST['ArmorT']);
		$page->setParameter('ARMOR_LA_NUM', $_POST['ArmorLA']);
		$page->setParameter('ARMOR_RA_NUM', $_POST['ArmorRA']);
		$page->setParameter('ARMOR_MG_NUM', $_POST['ArmorM']);
		$page->setParameter('ARMOR_L_NUM', $_POST['ArmorL']);
		// ProtoMech Internal Structure points
		$ISH = $arrInternalStructure[$Tonnage]['H'];
		$IST = $arrInternalStructure[$Tonnage]['T'];
		$ISL = $arrInternalStructure[$Tonnage]['L'];
		$ISA = $arrInternalStructure[$Tonnage]['A'];
		// ProtoMech Internal Structure ticks
		$page->setParameter('IS_H', Display_Armor($ISH, 10));
		$page->setParameter('IS_T', Display_Armor($ISH, 10));
		$page->setParameter('IS_LA', Display_Armor($ISA, 10));
		$page->setParameter('IS_RA', Display_Armor($ISA, 10));
		$page->setParameter('IS_MG', Display_Armor(1, 10));
		$page->setParameter('IS_L', Display_Armor($ISL, 10));
		// ProtoMech Internal Structure value
		$page->setParameter('IS_H_NUM', $ISH);
		$page->setParameter('IS_T_NUM', $IST);
		$page->setParameter('IS_LA_NUM', $ISA);
		$page->setParameter('IS_RA_NUM', $ISA);
		$page->setParameter('IS_MG_NUM', 1);
		$page->setParameter('IS_L_NUM', $ISL);
		break;
	case 5: // Structure - Installation
		$page->setParameter('CLASS', weightClassInstallation($Tonnage));
		$page->setParameter('ADVANCED_VEH_MP', advancedVehMPType($_POST['AdvanceMP']));
		$page->setParameter('CHASSIS', structureClass($_POST['Mods']));
		$page->setParameter('TURRET_TONS', decimalPlaces($_POST['TurretTons'], 1));
		$page->setParameter('STRUCT_HEIGHT', ($_POST['Levels'] * 6));
		$page->setParameter('STRUCT_SIZE', ($_POST['Hexes'] * 10));
		$page->setParameter('NUM_HEIGHT', $_POST['Levels']);
		$page->setParameter('NUM_SIZE', $_POST['Hexes']);
		$page->setParameter('ALLOCATED_HEADER', allocatedWeaponsHeaderVehicle());
		$page->setParameter('ARMOR_INTERNAL', Display_Armor($Tonnage, 25));
		$page->setParameter('TURRET_TONS', decimalPlaces($_POST['TurretTons'], 1));
		$page->setParameter('POWER_AMP', decimalPlaces($_POST['PowerAmp'], 1));
		$page->setParameter('HEATSINKS_STRUCT', nullToZero($_POST['HeatSinks']));
		$page->setParameter('HEATSINK_STRUCT_MASS', decimalPlaces($_POST['HeatSinks'], 1));
		$page->setParameter('ARMOR_B_NUM', $_POST['ArmorB']);
		if ($_POST['Basement']) {
			$page->setParameter('STRUCT_BASEMENT', ($_POST['Basement'] * 6) . " meters deep");
			$page->setParameter('NUM_BASEMENT', $_POST['Basement'] . " levels deep");
		} else {
			$page->setParameter('STRUCT_BASEMENT', "none");
			$page->setParameter('NUM_BASEMENT', "none");
		}
		if ($_POST['Door']) {
			$page->setParameter('STRUCT_DOORS', $_POST['Door'] . " door " . ($_POST['DoorLevels'] * 6) . " meters high");
			$page->setParameter('NUM_DOORS', $_POST['Door'] . " doors " . $_POST['DoorLevels'] . " levels high");
		} else {
			$page->setParameter('STRUCT_DOORS', "none");
			$page->setParameter('NUM_DOORS', "none");
		}
		if ($_POST['ArmorB']) {
			$page->setParameter('ARMOR', armorType($_POST['Armor']));
			$page->setParameter('ARMOR_B', Display_Armor($_POST['ArmorB'], 25));
		} else {
			$page->setParameter('ARMOR', "none");
			$page->setParameter('ARMOR_B', "none");
		}
		if ($_POST['TurretTons']) {
			$page->setParameter('TURRET_PRESENT', "Present");
		} else {
			$page->setParameter('TURRET_PRESENT', "none");
		}
		for ($i = ($_POST['Hexes'] + 1); $i < 13; $i++) {
			$page->setParameter('HEX_VISIBLE_' . $i, "visibility:hidden");
		}
		break;
	default: // Mech
		$page->setParameter('CLASS', weightClass($Tonnage));
		$page->setParameter('CHASSIS', mechChassis($_POST['Mods']));
		$page->setParameter('JUMPING', intval($_POST['Jumping']));
		$page->setParameter('LEGS', $MechLegs);
		$page->setParameter('LEGS_NUM', $_POST['Legs']);
		$page->setParameter('ADVANCED_MP', advancedMPType($_POST['AdvanceMP']));
		$page->setParameter('LEFTARM', armActuatorsType($_POST['LAActuators']));
		$page->setParameter('RIGHTARM', armActuatorsType($_POST['RAActuators']));
		$page->setParameter('ARMOR', armorType($_POST['Armor']));
		$page->setParameter('COCKPIT_TYPE', cockpitType($_POST['Cockpit']));
		$page->setParameter('GYRO', gyroType($_POST['Gyro']));
		$page->setParameter('HD_GYRO', $HDGyro);
		$page->setParameter('INTERNALSTRUCT', internalstructType($_POST['ISType']));
		$page->setParameter('ALLOCATED_HEADER', allocatedWeaponsHeader());
		// Cockpit Mass
		switch ($_POST['Cockpit']) {
			case 1: // Small Cockpipt
				$page->setParameter('COCKPIT', '2.0');
				break;
			case 3: // Command Console
				$page->setParameter('COCKPIT', '6.0');
				break;
			default: // Standard, Enhanced Imaging, Torso Mounted
				$page->setParameter('COCKPIT', '3.0');
				break;
		}
		// Gyro Mass
		switch ($_POST['Gyro']) {
			case 1: // Compact
				$page->setParameter('GYRO_MASS', decimalPlaces((int)(($EngineRating / 100) + 0.99) * 1.5, 1));
				break;
			case 2: // Heavy-duty
				$page->setParameter('GYRO_MASS', decimalPlaces((int)(($EngineRating / 100) + 0.99) * 2, 1));
				break;
			case 3: // XL
				$page->setParameter('GYRO_MASS', decimalPlaces((int)(($EngineRating / 100) + 0.99) / 2, 1));
				break;
			default: // Standard
				$page->setParameter('GYRO_MASS', decimalPlaces((int)(($EngineRating / 100) + 0.99), 1));
				break;
		}
		// Mech Armor ticks
		$page->setParameter('ARMOR_LA', Display_Armor($_POST['ArmorLA'], 10));
		$page->setParameter('ARMOR_H', Display_Armor($_POST['ArmorHead'], 10));
		$page->setParameter('ARMOR_RA', Display_Armor($_POST['ArmorRA'], 10));
		$page->setParameter('ARMOR_LT', Display_Armor($_POST['ArmorLT'], 10));
		$page->setParameter('ARMOR_LTR', Display_Armor($_POST['ArmorLTR'], 10));
		$page->setParameter('ARMOR_CT', Display_Armor($_POST['ArmorCT'], 10));
		$page->setParameter('ARMOR_CTR', Display_Armor($_POST['ArmorCTR'], 10));
		$page->setParameter('ARMOR_RT', Display_Armor($_POST['ArmorRT'], 10));
		$page->setParameter('ARMOR_RTR', Display_Armor($_POST['ArmorRTR'], 10));
		$page->setParameter('ARMOR_LL', Display_Armor($_POST['ArmorLL'], 10));
		$page->setParameter('ARMOR_RL', Display_Armor($_POST['ArmorRL'], 10));
		// Mech Armor value
		$page->setParameter('ARMOR_LA_NUM', $_POST['ArmorLA']);
		$page->setParameter('ARMOR_H_NUM', $_POST['ArmorHead']);
		$page->setParameter('ARMOR_RA_NUM', $_POST['ArmorRA']);
		$page->setParameter('ARMOR_LT_NUM', $_POST['ArmorLT']);
		$page->setParameter('ARMOR_LTR_NUM', $_POST['ArmorLTR']);
		$page->setParameter('ARMOR_CT_NUM', $_POST['ArmorCT']);
		$page->setParameter('ARMOR_CTR_NUM', $_POST['ArmorCTR']);
		$page->setParameter('ARMOR_RT_NUM', $_POST['ArmorRT']);
		$page->setParameter('ARMOR_RTR_NUM', $_POST['ArmorRTR']);
		$page->setParameter('ARMOR_LL_NUM', $_POST['ArmorLL']);
		$page->setParameter('ARMOR_RL_NUM', $_POST['ArmorRL']);
		// Mech Internal Structure points
		$ISC = internalstructPoints('ISC', $Tonnage, $_POST['Legs']);
		$IST = internalstructPoints('IST', $Tonnage, $_POST['Legs']);
		$ISL = internalstructPoints('ISL', $Tonnage, $_POST['Legs']);
		$ISA = internalstructPoints('ISA', $Tonnage, $_POST['Legs']);
		// Mech Internal Structure ticks
		$page->setParameter('IS_LA', Display_Armor($ISA, 10));
		$page->setParameter('IS_H', Display_Armor(3, 10));
		$page->setParameter('IS_RA', Display_Armor($ISA, 10));
		$page->setParameter('IS_LT', Display_Armor($IST, 10));
		$page->setParameter('IS_CT', Display_Armor($ISC, 10));
		$page->setParameter('IS_RT', Display_Armor($IST, 10));
		$page->setParameter('IS_LL', Display_Armor($ISL, 10));
		$page->setParameter('IS_RL', Display_Armor($ISL, 10));
		// Mech Internal Structure value
		$page->setParameter('IS_LA_NUM', $ISA);
		$page->setParameter('IS_RA_NUM', $ISA);
		$page->setParameter('IS_LT_NUM', $IST);
		$page->setParameter('IS_CT_NUM', $ISC);
		$page->setParameter('IS_RT_NUM', $IST);
		$page->setParameter('IS_LL_NUM', $ISL);
		$page->setParameter('IS_RL_NUM', $ISL);
		// Critical Hits Table
		$page->setParameter('CRITS_H', Display_Crits('H'));
		$page->setParameter('CRITS_LA', Display_Crits('LA'));
		$page->setParameter('CRITS_RA', Display_Crits('RA'));
		$page->setParameter('CRITS_LT', Display_Crits('LT'));
		$page->setParameter('CRITS_RT', Display_Crits('RT'));
		$page->setParameter('CRITS_CT', Display_Crits('CT'));
		$page->setParameter('CRITS_LL', Display_Crits('LL'));
		$page->setParameter('CRITS_RL', Display_Crits('RL'));
		// Change the limb titles based on the number of legs
		if ($_POST['Legs'] == 4) {
			$page->setParameter('ARMS_TITLE', 'Front Legs');
			$page->setParameter('LEGS_TITLE', 'Rear Legs');
			$page->setParameter('LA_TITLE', 'Front Left Leg');
			$page->setParameter('RA_TITLE', 'Front Right Leg');
			$page->setParameter('LL_TITLE', 'Rear Left Leg');
			$page->setParameter('RL_TITLE', 'Rear Right Leg');
			$page->setParameter('HIGH_LOW', '&nbsp;');
		} else {
			$page->setParameter('ARMS_TITLE', 'Arms');
			$page->setParameter('LEGS_TITLE', 'Legs');
			$page->setParameter('LA_TITLE', 'Left Arm');
			$page->setParameter('RA_TITLE', 'Right Arm');
			$page->setParameter('LL_TITLE', 'Left Leg');
			$page->setParameter('RL_TITLE', 'Right Leg');
			$page->setParameter('HIGH_LOW', LOW);
		}
		// Land-Air Mech
		if ($_POST['Mods'] == 2) {
			$page->setParameter('THRUST', "<tr>\n\t\t\t<td class=\"indent\">Safe Thrust:</td>\n\t\t\t<td>" . intval($_POST['Walking']) . "</td>\n\t\t\t<td></td>\n\t\t</tr>\n");
			$page->setParameter('OVERTHRUST', "<tr>\n\t\t\t<td class=\"indent\">Max Thrust:</td>\n\t\t\t<td>" . intval($_POST['Walking'] + 0.5) * 1.5 . "</td>\n\t\t\t<td></td>\n\t\t</tr>\n");
			$page->setParameter('STRUCT_INTEGRITY', "<tr>\n\t\t\t<td class=\"indent\">Structural Integrity:</td>\n\t\t\t<td>" . structuralIntegrity($_POST['Walking'], $Tonnage) . "</td>\n\t\t\t<td></td>\n\t\t</tr>\n");
			$page->setParameter('THRUST_SPEED', "<dd><strong>Safe Thrust Speed:</strong> " . mp2KphAir(intval($_POST['Walking'])) . " kph</dd>");
			$page->setParameter('OVERTHRUST_SPEED', "<dd><strong>Maximum Thrust Speed:</strong> " . mp2KphAir(runningSpeed($_POST['Walking'])) . " kph</dd>");
			$page->setParameter('LAM_CONV', "<tr>\n\t\t\t<td>Conversion Equipment:</td>\n\t\t\t<td></td>\n\t\t\t<td>" . decimalPlaces(intval($Tonnage) / 10, 1) . "</td>\n\t\t</tr>\n");
		} else {
			$page->setParameter('THRUST', '');
			$page->setParameter('OVERTHRUST', '');
			$page->setParameter('STRUCT_INTEGRITY', '');
			$page->setParameter('THRUST_SPEED', '');
			$page->setParameter('OVERTHRUST_SPEED', '');
			$page->setParameter('LAM_CONV', '');
		}
		// Sprinting
		if ($_POST['Level'] > 3) {
			$page->setParameter('SPRINTING', "<p>Sprinting: <strong>" . intval($_POST['Walking'] * 2) . $MascSprint . "</strong></p>");
		} else {
			$page->setParameter('SPRINTING', "");
		}
		break;
}


// General values
$page->setParameter('TYPE', mechType($_POST['Type']));
$page->setParameter('TONS', $Tonnage);
$page->setParameter('TECHNOLOGY', technology($_POST['Tech']));
$page->setParameter('LEVEL', levelType($_POST['Level']));
$page->setParameter('LEVEL_NUM', $_POST['Level']);
$page->setParameter('EDITION', numberSub($_POST['Edition']));
$page->setParameter('EDITION_NUM', $_POST['Edition']);
$page->setParameter('WALKING', intval($_POST['Walking']));
$page->setParameter('RUNNING', runningSpeed($_POST['Walking']) - $RunningMod . $Masc);


// Engine
switch ($_POST['Engine']) {
	case 1: // Fusion XL
		$page->setParameter('ENGINE_TONS', engineMass(2, 0, $EngineRating));
		break;
	case 2: // Fusion XXL
		$page->setParameter('ENGINE_TONS', engineMass(3, 0, $EngineRating));
		break;
	case 3: // Fusion Large
		$page->setParameter('ENGINE_TONS', engineMass(0, 0, $EngineRating));
		break;
	case 4: // Fusion XL Large
		$page->setParameter('ENGINE_TONS', engineMass(2, 0, $EngineRating));
		break;
	case 5: // Fusion XXL Large
		$page->setParameter('ENGINE_TONS', engineMass(3, 0, $EngineRating));
		break;
	case 6: // Light
		$page->setParameter('ENGINE_TONS', engineMass(1.5, 0, $EngineRating));
		break;
	case 7: // Compact
		$page->setParameter('ENGINE_TONS', engineMass(1.5, 1, $EngineRating));
		break;
	case 8: // ICE
		$page->setParameter('ENGINE_TONS', engineMass(2, 1, $EngineRating));
		$ISMult = 2;
		break;
	default: // Standard
		$page->setParameter('ENGINE_TONS', engineMass(0, 0, $EngineRating));
		break;
}
$page->setParameter('ENGINE_TYPE', engineType($_POST['Engine']));
$page->setParameter('ENGINERATING', $EngineRating);
$page->setParameter('ENGINEMAKE', engineMake($EngineRating));


// Heat Sinks
$page->setParameter('HEATSINK_TICKS', heatsinkTicks($HeatSinks));
$page->setParameter('HEATSINKS', $HeatSinks);
$page->setParameter('HEATSINK_TYPE', heatsinkType($_POST['HSType']));
$page->setParameter('HEAT_DISIPATE', ($HeatSinks * heatsinkModifier($_POST['HSType'])) * solarisMultiply($_POST['Level']));
$page->setParameter('HEAT_SCALE', heatScale());
if ($_POST['Engine'] == 8) {
	$page->setParameter('HEATSINK_MASS', decimalPlaces(($HeatSinks), 1));
} else {
	$page->setParameter('HEATSINK_MASS', decimalPlaces(($HeatSinks - 10), 1));
}


// Armament List
if ($_POST['UnitType'] == 4) {
	$page->setParameter('ALLOCATED_WEAPONS', listAllocatedWeaponsProto());
	$page->setParameter('LISTWEAPONS_TR', listWeaponsTRProto());
	$page->setParameter('TR_ARMAMENT', listArmamentTRProto());
} else {
	$page->setParameter('ALLOCATED_WEAPONS', listAllocatedWeapons($_POST['UnitType']));
	$page->setParameter('ALLOCATED_MELEE', listAllocatedMeleeWeapons());
	$page->setParameter('ALLOCATED_AMMO', listAllocatedAmmo());
	$page->setParameter('LISTWEAPONS_TR', listWeaponsTR($_POST['UnitType']));
	$page->setParameter('TR_ARMAMENT', listArmamentTR());
}
$page->setParameter('LISTWEAPONS_XML', listWeaponsXML());


// Targeting System
$page->setParameter('TARGETING', targetingType($_POST['Targeting']));
$page->setParameter('TARGETING_MOD', targetingMod($_POST['Targeting']));


// Total Armor tonnage
switch ($_POST['Armor']) {
	case 1: // Ferro-Fibrous
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, ferroMultiplier($_POST['Tech'])), 1));
		break;
	case 2: // Hardened
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 8, 0), 1));
		break;
	case 3: // Laser-Reflective
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, 0), 1));
		break;
	case 4: // Reactive
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, 0), 1));
		break;
	case 5: // Light Ferro-Fibrous
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, 1.06), 1));
		break;
	case 6: // Heavy Ferro-Fibrous
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, 1.24), 1));
		break;
	default: // Standard
		$page->setParameter('ARMOR_MASS', decimalPlaces(armorTonnage($_POST['ArmorTotal'], 16, 0), 1));
		break;
}
$page->setParameter('ARMOR_TOTAL', $_POST['ArmorTotal']);


// Internal Structure Mass
switch ($_POST['ISType']) {
	case 1: // Endo Steel
		$page->setParameter('INTERNALSTRUCTURE', decimalPlaces((round(((($Tonnage / 20) + 0.2) * 2), 0) / 2) * $ISMult, 1));
		break;
	case 2: // Composite
		$page->setParameter('INTERNALSTRUCTURE', decimalPlaces((round(((($Tonnage / 20) + 0.2) * 2), 0) / 2) * $ISMult, 1));
		break;
	case 3: // Reinforced
		$page->setParameter('INTERNALSTRUCTURE', decimalPlaces((($Tonnage / 10) * 2) * $ISMult, 1));
		break;
	default: // Standard
		$page->setParameter('INTERNALSTRUCTURE', decimalPlaces(($Tonnage / 10) * $ISMult, 1));
		break;
}


// Totals
$page->setParameter('BATTLE_VALUE', $_POST['TotalBV']);
$page->setParameter('TOTAL_COST', $_POST['TotalCost']);
$page->setParameter('MAX_DAMAGE', $_POST['MaxDamage']);
$page->setParameter('MAX_HEAT', $_POST['MaxHeat'] * solarisMultiply($_POST['Level']));
$page->setParameter('DAMAGE_PER_TON', decimalPlaces($_POST['MaxDamage'] / $Tonnage, 2));


// Technical Readout real-world values
$page->setParameter('CRUISING_SPEED', mp2Kph(intval($_POST['Walking'])));
$page->setParameter('MAX_SPEED', mp2Kph(runningSpeed($_POST['Walking']) - $RunningMod) . $Masc);
$page->setParameter('JUMPING_DISTANCE', mp2Meters(intval($_POST['Jumping'])));

// Technical Readout Jump Jets
if ($_POST['Jumping']) {
	$page->setParameter('JUMPJETS', jumpJetsType($_POST['JJType']));
} else {
	$page->setParameter('JUMPJETS', 'none');
}


// Warrior data
$page->setParameter('AUTO_EJECT', autoEject($_POST['AutoEject']));
$page->setParameter('PILOT', $PilotName);
$page->setParameter('GUNNERY', $_POST['Gunnery'] - 1);
$page->setParameter('PILOTING', $_POST['Piloting'] - 1);
$page->setParameter('CREW_NUM', $_POST['BaseCrew'] + $_POST['Crew']);
$page->setParameter('MINIATURE', $Miniature);
$page->setParameter('PLAYER', $Player);
$page->setParameter('EXPERIENCE', experienceLevel($_POST['Experience']));
$page->setParameter('ABILITIES', specialAbilities($_POST['Abilities']));

// Check for user made affiliation
if ($_POST['FactionInput']) {
	$page->setParameter('FACTION', '<span class=\"FontSM\">' . cleanInput($_POST['FactionInput']) . '</span>');
} else {
	$page->setParameter('FACTION', '<span class=\"FontSM\">' . getFaction($_POST['Faction']) . '</span>');
}

// History Info
if ($_POST['Overview']) $HOverview = "<h2>Overview</h2>\n<p>" . cleanOverview($_POST['Overview']) . "</p>\n";
if ($_POST['Capability']) $HCapability = "<h2>Capabilities</h2>\n<p>" . cleanOverview($_POST['Capability']) . "</p>\n";
if ($_POST['Deployment']) $HDeployment = "<h2>Deployment</h2>\n<p>" . cleanOverview($_POST['Deployment']) . "</p>\n";
if ($_POST['Varients']) $HVarients = "<h2>Variants</h2>\n<p>" . cleanOverview($_POST['Varients']) . "</p>\n";
if ($_POST['History']) $HHistory = "<h2>Battle History</h2>\n<p>" . cleanOverview($_POST['History']) . "</p>\n";
if ($_POST['Notable']) $HNotable = "<h2>Notable Warriors</h2>\n<p>" . cleanOverview($_POST['Notable']) . "</p>\n";
$page->setParameter('OVERVIEW', $HOverview);
$page->setParameter('CAPABILITY', $HCapability);
$page->setParameter('DEPLOYMENT', $HDeployment);
$page->setParameter('VARIENTS', $HVarients);
$page->setParameter('HISTORY', $HHistory);
$page->setParameter('NOTABLE', $HNotable);


// BattleForce 2 Info
$page->setParameter('BF_CVMOVE', BFVehicleChassis($_POST['Mods']));
if ($_POST['UnitType'] == 1) {
	$page->setParameter('BF_SPECIAL', nullToDash(specialBF($_POST['Mods'])));
} else {
	$page->setParameter('BF_SPECIAL', '-');
}
if ($_POST['UnitType'] == 2) {
	$page->setParameter('BF_STRUCTURE', intval(($_POST['ArmorTotal'] + (roundNearWhole($Tonnage * 0.1, 0.5) * 4)) / 30));
} else {
	$page->setParameter('BF_STRUCTURE', structureBF($Tonnage, $_POST['Engine'], $_POST['Tech']));
}
if ($_POST['UnitType'] == 3) {
	if ($_POST['Mods'] > 1) {
		$page->setParameter('BF_CLASS', 'SC');
	} else {
		$page->setParameter('BF_CLASS', 'F' . substr(weightClassAero($Tonnage), 0, 1));
	}
} else {
	$page->setParameter('BF_CLASS', substr(weightClass($Tonnage), 0, 1));
}
if ($_POST['UnitType'] == 5) {
	if ($Tonnage > 90) {
		$page->setParameter('BF_CLASS', 'HD');
	} else {
		$page->setParameter('BF_CLASS', substr(weightClassInstallation($Tonnage), 0, 1));	
	}
}
if (($_POST['MaxHeat'] - 4) > ($HeatSinks * heatsinkModifier($_POST['HSType']))) $BFHeat = round((($_POST['MaxDamage'] * ($HeatSinks * heatsinkModifier($_POST['HSType']))) / ($_POST['MaxHeat'] - 4)) / 10);
$page->setParameter('BF_ARMOR', armorBF($_POST['ArmorTotal']));
$page->setParameter('BF_DAMAGE_S', nullToDash(damageByRangeBF(1)));
$page->setParameter('BF_DAMAGE_M', nullToDash(damageByRangeBF(3)));
$page->setParameter('BF_DAMAGE_L', nullToDash(damageByRangeBF(16)));
$page->setParameter('BF_OVERHEAT', nullToDash($BFHeat));
$page->setParameter('BF_POINTVALUE', round((stripComma($_POST['TotalBV']) / 100) + 0.5));
if ($_POST['Jumping']) $BF_Jumping = 'J';
$page->setParameter('BF_JUMPING', $BF_Jumping);
if ($_POST['UnitType'] == 2) $page->setParameter('BF_JUMPING', substr(vehicleChassis($_POST['Mods']), 0, 1));
//$page->setParameter('BS_ARMOR', $_POST['ArmorTotal'] / 40);


// Dispay the page
$page->createPage();
	
?>