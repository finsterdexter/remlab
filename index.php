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

// Define the different HTML templates
define('MAIN_PAGE', 'template/default.tpl.inc');
define('MECH_PAGE', 'template/mech.tpl.inc');
define('VEHICLE_PAGE', 'template/vehicle.tpl.inc');
define('AEROTECH_PAGE', 'template/aerotech.tpl.inc');
define('PROTO_PAGE', 'template/protomech.tpl.inc');
define('INSTALL_PAGE', 'template/installation.tpl.inc');

// Set p to default and check for errors
if (!$_GET['p']) $_GET['p'] = 'build';

// Select the requested template
switch ($_GET['p']) {
	case 'mech':
		$template = MECH_PAGE;
		break;
	case 'vehicle':
		$template = VEHICLE_PAGE;
		break;
	case 'aerotech':
		$template = AEROTECH_PAGE;
		break;
	case 'protomech':
		$template = PROTO_PAGE;
		break;
	case 'installation':
		$template = INSTALL_PAGE;
		break;
	default:
		$template = MAIN_PAGE;
		break;	
}

// Define the class and get the HTML template
$page = new HtmlTemplate();

// HTML template
$page->getTemplate($template);

// Sub page content
$page->setParameter('PAGE_CONTENT', @file_get_contents('template/' .  cleanInput($_GET['p']) . '.pg.inc'));

// Settings for the page
$page->setParameter('TITLE', TITLE);
$page->setParameter('SUB_TITLE', SUB_TITLE);
$page->setParameter('VERSION', VERSION);
$page->setParameter('AUTHOR', AUTHOR);

// Weapon Tables
if ($_GET['p'] == 'protomech') {
	$page->setParameter('WEAPONS_PROTO', DisplayWeapons('WTP'));
	$page->setParameter('WEAPONS_PROTO_AMMO', DisplayAmmo('WT7cP'));
} else {
	$page->setParameter('WEAPONS_IS_ENERGY', DisplayWeapons('WT1'));
	$page->setParameter('WEAPONS_IS_BALLISTIC', DisplayWeapons('WT2'));
	$page->setParameter('WEAPONS_IS_MISSLE', DisplayWeapons('WT3'));
	$page->setParameter('WEAPONS_IS_ARTILLERY', DisplayWeapons('WT4'));
	$page->setParameter('WEAPONS_IS_EQUIPMENT', DisplayWeapons('WT5'));
	$page->setParameter('WEAPONS_IS_INDUSTRIAL', DisplayWeapons('WT6'));
	$page->setParameter('WEAPONS_IS_AMMO1', DisplayAmmo('WT7'));
	$page->setParameter('WEAPONS_IS_AMMO2', DisplayAmmo('WT8'));
	
	$page->setParameter('WEAPONS_CLAN_ENERGY', DisplayWeapons('WT1c'));
	$page->setParameter('WEAPONS_CLAN_BALLISTIC', DisplayWeapons('WT2c'));
	$page->setParameter('WEAPONS_CLAN_MISSLE', DisplayWeapons('WT3c'));
	$page->setParameter('WEAPONS_CLAN_ARTILLERY', DisplayWeapons('WT4c'));
	$page->setParameter('WEAPONS_CLAN_EQUIPMENT', DisplayWeapons('WT5c'));
	$page->setParameter('WEAPONS_CLAN_INDUSTRIAL', DisplayWeapons('WT6c'));
	$page->setParameter('WEAPONS_CLAN_AMMO1', DisplayAmmo('WT7c'));
	$page->setParameter('WEAPONS_CLAN_AMMO2', DisplayAmmo('WT8c'));
}

// Affiliation List
$page->setParameter('FACTION_IS', DisplayFactions(1,13));
$page->setParameter('FACTION_CLAN', DisplayFactions(13,38));
$page->setParameter('FACTION_PERIPHERY', DisplayFactions(38,58));
$page->setParameter('FACTION_DARKAGE', DisplayFactions(58,67));
$page->setParameter('FACTION_MERCS', DisplayFactions(67,86));
$page->setParameter('FACTION_GENERIC', DisplayFactions(86,97));

// Dispay the page
$page->createPage();
	
?>