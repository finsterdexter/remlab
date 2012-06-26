<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{TYPE} Technical Readout</title>
<meta name="authors" content="{AUTHOR}" />
<style type="text/css" media="print">#Options { display: none; }</style>
<style type="text/css" media="all">
body {
	font-family: Verdana, Helvetica, Arial, sans-serif;
	font-size: 100%;
	color: #000;
	background: #fff;
	margin: 0;
}

a {
	color: #666;
	text-decoration: none;
}

div, table {
	padding: 0;
	margin: 0;
	border: 0;
}

table {
	width: 99%;
	font-size: 55%;
	margin-bottom: 18px;
}

th {
	text-align: left;
}

#Options {
	position: absolute;
	top: 5px;
	left: 285px;
	width: 200px;
	z-index: 99;
}

#Version {
	font-size: 50%;
	color: #666666;
	position: absolute;
	top: 2px;
	left: 50%;
}

input {
	width: 85px;
}

p {
	font-size: 40%;
	margin: 0;
}

h1 {
	letter-spacing: -1px;
	font-size: 33px;
	font-style: italic;
	margin: 0;
	padding: 0;
}

h2 {
	font-size: 75%;
	margin: 10px 0 0 0;
}

h3 {
	font-size: 10px;
	letter-spacing: 1px;
	margin: -6px 0 8px 0;
	padding: 0;
	font-weight: normal;
}

h4 {
	font-size: 85%;
	margin: 0 0 2px 0;
	font-weight: bold;
}

#Right {
	position: absolute;
	width: 45%;
	margin-left: 50%;
	top: 62px;
}

#Left {
	width: 47%;
	margin: 0 3px;
}

.BF {
	margin-bottom: 0;
	text-align: center;
	width: 90%;
}

.BF th {
	text-align: center;
	vertical-align: bottom;
}

table em {
	font-size: 70%;
}

dl {
	font-size: 56%;
	margin: 0;
}

dd {
	margin: 1px 0;
}

dd strong {
	padding-right: 5px;
}

.center {
	text-align: center;
}

.indent {
	padding-left: 30px;
}
</style>
</head>

<body>

<div id="Options">
	<form name="form" action=""><input type="button" value="Print" onclick="window.print()" /></form>
</div>

<div id="Version">{TITLE} {VERSION}<br /><a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a><br />Created on {DATE_CREATED}</div>

<h1>AEROTECH</h1>
<h3>{CLASS} {CHASSIS} Technical Readout</h3>

<div id="Right">
	<table cellspacing="1">
		<tr>
			<td width="40%">Type:</td>
			<td><strong>{TYPE}</strong></td>
		</tr>
		<tr>
			<td>Technology Base:</td>
			<td>{TECHNOLOGY} / {ERA}</td>
		</tr>
		<tr>
			<td>Ruleset:</td>
			<td>{LEVEL} ({EDITION} edition)</td>	
		</tr>
		<tr>
			<td>Tonnage:</td>
			<td>{TONS}</td>	
		</tr>
		<tr>
			<td>Cost:</td>
			<td>{TOTAL_COST} <small>C-bills</small></td>	
		</tr>
		<tr>
			<td>Battle Value:</td>
			<td>{BATTLE_VALUE}</td>	
		</tr>
	</table>

	<table cellspacing="1">
		<tr>
			<th width="40%">Equipment</th>
			<th width="20%"></th>
			<th>Mass</th>
		</tr>
		<tr>
			<td>Structural Integrity:</td>
			<td>{STRUCTURAL_INTEGRITY}</td>
			<td>{SI_MASS}</td>
		</tr>
		<tr>
			<td>Engine:</td>
			<td>{ENGINERATING}</td>
			<td>{ENGINE_TONS}</td>
		</tr>
		<tr>
			<td class="indent">Type:</td>
			<td>{ENGINE_TYPE}</td>
			<td></td>
		</tr>
		<tr>
			<td class="indent">Safe Thrust:</td>
			<td>{WALKING}</td>
			<td></td>
		</tr>
		<tr>
			<td class="indent">Maximum Thrust:</td>
			<td>{RUNNING}</td>
			<td></td>
		</tr>
		<tr>
			<td>Fuel:</td>
			<td>{FUEL_POINTS}</td>
			<td>{FUEL}</td>
		</tr>
		<tr>
			<td>Cockpit:</td>
			<td></td>
			<td>{CONTROL_EQUIP}</td>
		</tr>
		<tr>
			<td>Power Amplifier:</td>
			<td></td>
			<td>{POWER_AMP}</td>
		</tr>
		<tr>
			<td>VSTOL:</td>
			<td></td>
			<td>{ADVANCEDMP_MASS}</td>
		</tr>
		<tr>
			<td>Heat Sinks:</td>
			<td>{HEATSINKS} [{HEAT_DISIPATE}]</td>
			<td>{HEATSINK_MASS}</td>
		</tr>
		<tr>
			<td>Armor Factor:</td>
			<td>{ARMOR_TOTAL}</td>
			<td>{ARMOR_MASS}</td>
		</tr>
		<tr>
			<td></td>
			<td><em>Armor<br />Value</em></td>
		</tr>
		<tr>
			<td class="indent">Nose</td>
			<td>{ARMOR_N_NUM}</td>
		</tr>
		<tr>
			<td class="indent">L/R Wing</td>
			<td>{ARMOR_LW_NUM}/{ARMOR_RW_NUM}</td>
		</tr>
		<tr>
			<td class="indent">Aft</td>
			<td>{ARMOR_A_NUM}</td>
		</tr>
	</table>
	
	<table cellspacing="1">
		<tr>
			<th width="50%">Weapons and Ammo</th>
			<th width="20%">Location</th>
			<th>Tons</th>
		</tr>
	{LISTWEAPONS_TR}
	</table>
	
	<p>{LIFEBOAT}</p>
	
	<table cellspacing="1">
		<tr>
			<th width="30%">Crew:</th>
			<td>{CREW_NUM}</td>
		</tr>
		<tr>
			<th>Passengers:</th>
			<td>{PASS_NUM}</td>
		</tr>
		<tr>
			<th>Cargo:</th>
			<td>{CARGO_SPACE} tons</td>
		</tr>
		<tr>
			<th>Fuel Use:</th>
			<td>{FUEL_USE}</td>
		</tr>
		<tr>
			<th>Food &amp; Water:</th>
			<td>{FOOD_WATER}</td>
		</tr>
	</table>
	
	<p>&nbsp;</p>
	
	<h4>BattleForce 2</h4>
	<table cellspacing="0" cellpadding="0" class="BF">
		<tr>
			<th width="10%">MP</th>
			<th width="30%">Damage PB/M/L</th>
			<th width="30%">Overheat</th>
			<th>Class</th>		
		</tr>
		<tr>
			<td>{WALKING}N</td>
			<td>{BF_DAMAGE_S}/{BF_DAMAGE_M}/{BF_DAMAGE_L}</td>
			<td>{BF_OVERHEAT}</td>
			<td>{BF_CLASS}</td>		
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="BF">
		<tr>
			<th width="30%">Armor/Structure</th>
			<th width="35%">Point Value</th>
			<th>Specials</th>
		</tr>
		<tr>
			<td>{BF_ARMOR}/-</td>
			<td>{BF_POINTVALUE}</td>
			<td>{BF_SPECIAL}</td>
		</tr>		
	</table>
	
	<!--p>&nbsp;</p>
	
	<h4>BattleSpace</h4>
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td><strong>Type:</strong> {CHASSIS}</td>
			<td><strong>Tech:</strong> {TECHNOLOGY}</td>
			<td><strong>Mass:</strong> {TONS} tons</td>
		</tr>
		<tr>
			<td><strong>Safe Thrust:</strong> {WALKING}</td>
			<td><strong>Max Thrust:</strong> {RUNNING}</td>
			<td><strong>Fuel:</strong> {FUEL_POINTS}</td>
		</tr>
		<tr>
			<td><strong>Armor Value:</strong> {BS_ARMOR}</td>
			<td><strong>Heat Sinks:</strong> {HEATSINKS}</td>
			<td></td>
		</tr>
	</table>
	<table width="100%" cellspacing="1">
		<tr>
			<td>Arc</td>
			<td>Type</td>
			<td>Heat</td>
			<td>S</td>
			<td>M</td>
			<td>L</td>
			<td>E</td>
			<td>Mounts</td>		
		</tr>
	</table-->
</div>

<div id="Left">
	<h4>{TYPE}</h4>
	<dl>
		<dd><strong>Mass:</strong> {TONS} tons</dd>
		<dd><strong>Chassis:</strong> Standard</dd>
		<dd><strong>Movement Type:</strong> {CHASSIS}</dd>
		<dd><strong>Power Plant:</strong> {ENGINEMAKE} {ENGINERATING} {ENGINE_TYPE}</dd>
		<dd><strong>Safe Thrust Speed:</strong> {SAFETHRUST_SPEED} kph</dd>
		<dd><strong>Maximum Thrust Speed:</strong> {MAXTHRUST_SPEED} kph</dd>
		<dd><strong>Armor:</strong> {ARMOR}</dd>
		<dd><strong>Armament:</strong></dd>
		{TR_ARMAMENT}
		<dd><strong>Manufacturer:</strong> {TECHNOLOGY}</dd>
		<dd><strong>Communications System:</strong> Standard</dd>
		<dd><strong>Targeting &amp; Tracking System:</strong> {TARGETING}</dd>
	</dl>
	
{OVERVIEW}
{CAPABILITY}
{HISTORY}
{DEPLOYMENT}
{VARIENTS}
{NOTABLE}

</div>

</body>
</html>