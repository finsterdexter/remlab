<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{TYPE} Record Sheet</title>
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

div, table, td {
	overflow: hidden;
	padding: 0;
	margin: 0;
	border: 0;
}

.CritBox {
	border: 1px solid #000;
	text-align: center;
}

.CritNum {
	border: 1px solid #000;
	padding: 1px 4px;
	margin-left: 4px;
}

#ArmorDiagram h2 {
	border: 1pt solid #000;
}

.Border {
	border: 1pt solid #000;
}

.Border td, .Border th {
	font-size: 6px;
}

#ArmorDiagram td {
	padding: 1px 5px;
}

#ArmorDiagram p {
	padding: 1px 0;
}
#BaseStats, #Pilot, #Criticals, #Track {
	border: 1px solid #000;
	margin: 4px 2px 0 0;
}

#Footer {
	border: 1px solid #000;
	margin: 2px;
}

#Bottom {
	color: #666;
	text-align: center;
	margin-top: 3px;
}

#Footer td {
	padding: 0;
}

#Options {
	position: absolute;
	top: 5px;
	left: 285px;
	width: 200px;
	z-index: 99;
}

input {
	width: 85px;
}

#Options a {
	color: #333;
}

p {
	margin: 0;
	padding: 1px 0 1px 3px;
}

ol {
	margin: 0 0 10px 20px;
	padding: 0;
}

ul, blockquote {
	margin: 0 12px;
	padding: 0;
}

td {
	margin: 0;
	padding: 1px;
	vertical-align: top;
}

.LeftBorder {
	border-left: 1px solid #000;
	text-align: center;
}

.HitsBorder {
	border-left: 1px solid #000;
	border-bottom: 1px solid #000;
	text-align: center;
}

th {
	margin: 0;
	padding: 1px;
}

#Footer th {
	margin: 0;
	padding: 0;
}

h1 {
	letter-spacing: -1px;
	font-size: 33px;
	font-style: italic;
	margin: 0;
	padding: 0;
}

h2 {
	font-size: 10px;
	text-align: center;
	font-weight: normal;
	border-bottom: 1px solid #000;
	display: block;
	margin: 0;
	padding: 1px 0;
	letter-spacing: 1px;
	background: #ddd;
}

h3 {
	font-size: 11px;
	letter-spacing: 1px;
	margin: -6px 0 3px 2px;
	padding: 0;
	font-weight: normal;
}

td li em, #ArmorDiagram td em  {
	color: #999;
}

#HeatTable td {
	padding: 0;
}

#Overflow {
	border: 1px solid #000;
	width:18px;
	height:14px;
	margin: 2px 0;
}

.Elevation td {
	border: 1px solid #000;
	text-align: center;
}

.LineAbove {
	margin: 2px 0;
	border-top: 1px solid #000;
	padding-top: 3px;
}

.UL {
	overflow: hidden;
	border-bottom: 1px solid #000;
	padding-right: 110px;
}

.ULs {
	padding-right: 100px;
}

a {
	color: #666;
	text-decoration: none;
}

.Center {
	text-align: center;
}

.Left {
	text-align: left;
}

.Right {
	text-align: right;
}

.FontBG, div#CriticalSlots td p, #Options a, #CriticalSlots td strong {
	font-size: 8px;
}

.FontST, div, td, th, #Footer th {
	font-size: 6px;
}

.FontSM, td p span, .BVCost {
	font-size: 5px !important;
}

.Internal {
	display: block;
	width: 70px;
	border: 1px solid #000;
	padding: 1px 2px;
	background: #EEE;
}
</style>
</head>

<body>

<div id="Options">
	<form name="form" action=""><input type="button" value="Print" onclick="window.print()" /></form>
</div>

<table width="100%" cellspacing="0">
	<tr>
	<td width="72%">
	<div id="Title">
		<table width="100%" cellspacing="0">
			<tr>
				<td width="69%"><h1>{GAME_SYSTEM}</h1><h3>{CLASS} {CHASSIS_TYPE} Record Sheet</h3></td>
				<td class="FontBG">Player: {PLAYER}<br /><br />Miniature: {MINIATURE}</td>
			</tr>
		</table>
	</div>
	<div id="ArmorDiagram">
		<table width="100%" cellspacing="0">
			<tr>
				<td colspan="3" style="padding:0 1px"><h2>Armor Diagram</h2></td>
			</tr>
			<tr>
				<td width="33%"><strong>Terrain Restrictions</strong><br />{TERRAIN_RESTRICT}</td>
				<td><p>Front</p>{ARMOR_F}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td width="33%"></td>
			</tr>
			<tr>
				<td><p>Left Side</p>{ARMOR_LS}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="padding:10px 5px"><span{STYLE_DISPLAY}><p>{TURRET_ROTOR}</p>{ARMOR_T}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td><p>Right Side</p>{ARMOR_RS}<span class="Internal">{ARMOR_INTERNAL}</span></td>
			</tr>
			<tr>
				<td style="padding:12px 0 0 10px">Special Equipment<br /><strong>{SP_FRONT}{SP_TOP}{SP_REAR}</strong><br /><br />Heat Sinks: <strong>{HEATSINKS}</strong><br /><br />Cargo Space: <strong>{CARGO_SPACE} tons</strong></td>
				<td><p>Rear</p>{ARMOR_R}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="padding:12px 0 0 10px">Armor<br /><strong>{ARMOR}</strong><br /><br />Targeting<br /><strong>{TARGETING}</strong> {TARGETING_MOD}</td>
			</tr>
			<tr>
				<td></td>
				<td style="padding:8px 0 0 0"><p class="BVCost">Battle Value: {BATTLE_VALUE}<br />Cost: {TOTAL_COST} C-bills<br />Damage: {MAX_DAMAGE}</p></td>
				<td></td>
			</tr>
		</table>
   </div>
   
	<div id="Track" {HIDE_TRACK}>
	<h2>{ELEVATION_DEPTH} Track</h2>
	<table class="Elevation" width="100%" cellspacing="1">
		<tr>
			<td style="border:0"><strong>Turn</strong></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td>
		</tr>
		<tr>
			<td style="border:0"><strong>{ELEVATION_DEPTH}</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
		</tr>
	</table>
	</div>
	</td>
	<td width="28%">
		<div id="BaseStats">
			<h2>Vehicle Data</h2>
			<p style="margin-top:4px">Type: <strong>{TYPE}</strong></p>
			<p>Tonnage: <strong>{TONS}</strong></p>
			<p>Technology: <strong>{TECHNOLOGY}</strong> / {ERA}</p>
			<p>Ruleset: <strong>{LEVEL}</strong> ({EDITION} edition)</p>
			<p style="margin-top:5px">Movement Points:</p>
			<blockquote style="margin-bottom:5px">
				<p>Cruising: <strong>{WALKING}</strong></p>
				<p>Flank: <strong>{RUNNING}</strong></p>
		 	</blockquote>
			<p>Motive: <strong>{CHASSIS}</strong> {ADVANCED_VEH_MP}</p>
		</div>
	  	<div id="Pilot">
  			<h2>Crew Data</h2>
			<p style="margin-top:4px">Crew Size: <strong>{CREW_NUM}</strong></p>
  			<p>Name: {PILOT}</p>
  			<p>Affiliation: {FACTION}</p>
    		<p>Experience: {EXPERIENCE} {ABILITIES}</p>
  			<p>Gunnery Skill: <strong>{GUNNERY}</strong> &nbsp; Driving Skill: <strong>{PILOTING}</strong></p>
  			<p>Kills: OOOO OOOO OOOO OOOO OOOO</p>
			<p class="LineAbove">{CREW_DATA_STATS}</p>
		</div>
	  	<div id="Criticals" style="padding-bottom:3px">
  			<h2 style="margin-bottom:3px">Critical Damage</h2>
			<table width="100%" cellspacing="1" cellpadding="0">
				<tr>
					<td width="20%">Sensor Hits</td>
					<td class="CritBox" width="5%">+1</td>
					<td class="CritBox" width="5%">+2</td>
					<td class="CritBox" width="5%">+3</td>
					<td class="CritBox" width="6%">X</td>
				</tr>
				<tr>{CRITICAL_DAMAGE}</tr>
			</table>
			<table width="100%" cellspacing="1" cellpadding="0">
				<tr>
					<td class="CritBox" width="50%">Engine Hit</td>
					<td class="CritBox">Turret Locked</td>
				</tr>
			</table>
			<table width="100%" cellspacing="1" cellpadding="0">
				<tr>
					<td class="CritBox" width="20%">Front</td>
					<td class="CritBox" width="20%">Left<td>
					<td class="CritBox" width="20%">Right</td>
					<td class="CritBox" width="20%">Rear</td>
					<td class="CritBox" width="20%">Turret</td>
				</tr>
			</table>
		</div>
	</td>
  </tr>
</table>

<div id="Footer">
	<h2>Weapons and Equipment</h2>
	<table width="100%" cellspacing="0">
		<tr><td>
		<table width="100%" cellspacing="1">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}
		</table>	
		</td><td width="41%" style="border-left: 1px solid #000">
			<p><strong>Ammunition</strong></p>
{ALLOCATED_AMMO}
		</td></tr>
	</table>
</div>

<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="50%">
<div id="LocTable" class="Border">
	<h2>Hit Location Table</h2>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th>2D6 ROLL</th>
		<th class="Left">FRONT</th>
		<th class="Left">REAR</th>
		<th class="Left">SIDE</th>
	</tr>
	<tr>
		<th>2*</th>
		<td>Front (critical)</td>
		<td>Rear (critical)</td>
		<td>Side (critical)</td>
	</tr>
	<tr>
		<th>3</th>
		<td>Front#/Rotors#</td>
		<td>Rear/Rotors#</td>
		<td>Side#/Rotors#</td>
	</tr>
	<tr>
		<th>4</th>
		<td>Front#/Rotors#</td>
		<td>Rear#/Rotors#</td>
		<td>Side#/Rotors#</td>
	</tr>
	<tr>
		<th>5</th>
		<td>Right Side#</td>
		<td>Left Side#</td>
		<td>Front#</td>
	</tr>
	<tr>
		<th>6</th>
		<td>Front</td>
		<td>Rear</td>
		<td>Side</td>
	</tr>
	<tr>
		<th>7</th>
		<td>Front</td>
		<td>Rear</td>
		<td>Side</td>
	</tr>
	<tr>
		<th>8</th>
		<td>Front</td>
		<td>Rear</td>
		<td>Side (critical)*</td>
	</tr>
	<tr>
		<th>9</th>
		<td>Left Side#</td>
		<td>Right Side#</td>
		<td>Rear#</td>
	</tr>
	<tr>
		<th>10</th>
		<td>Turret/Rotors#</td>
		<td>Turret/Rotors#</td>
		<td>Turret/Rotors#</td>
	</tr>
	<tr>
		<th>11</th>
		<td>Turret/Rotors#</td>
		<td>Turret/Rotors#</td>
		<td>Turret/Rotors#</td>
	</tr>
	<tr>
		<th>12*</th>
		<td>Turret/Rotors# (critical)</td>
		<td>Turret/Rotors# (critical)</td>
		<td>Turret/Rotors# (critical)</td>
	</tr>
	</table>
</div>
</td><td>
<div id="MotiveTable" class="Border">
	<h2>Motive System Damage Table</h2>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th width="16%">2D6 ROLL</th>
		<th class="Left">EFFECT *</th>
	</tr>
	<tr>
		<th>2-5</th>
		<td>No effect.</td>
	</tr>
	<tr>
		<th>6-7</th>
		<td>Minor damage; +1 modifier to all Driving Skill Rolls.</td>
	</tr>
	<tr>
		<th>8-9</th>
		<td>Moderate damage; -1 Cruising MP +2 modifier to all Driving Skill Rolls.</td>
	</tr>
	<tr>
		<th>10-11</th>
		<td>Heavy damage; only half Cruising MP (round fractions up), +3 modifier to all Driving Skill Rolls.</td>
	</tr>
	<tr>
		<th>12+</th>
		<td>Major damage; no movement for the rest of the game. Vehicle is immobile.</td>
	</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0" style="margin-left:4px">
	<tr>
		<td width="40%"><strong>Attack Direction Mod:</strong></td>
		<td><strong>Vehicle Type Mod:</strong></td>
	</tr>
	<tr>
		<td>Hit from rear +1</td>
		<td>Tracked, Naval +0</td>
	</tr>
	<tr>
		<td>Hit from the sides +2</td>
		<td>Wheeled +2</td>
	</tr>
	<tr>
		<td></td>
		<td>Hovercraft, Hydrofoil +3</td>
	</tr>
	<tr>
		<td></td>
		<td>WiGE +4</td>
	</tr>
	</table>
</div>
</td></tr><tr><td colspan="2">
<div id="CritTable" class="Border">
	<h2>Critical Hits Table</h2>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th width="16%">2D6 ROLL</th>
		<th class="Left">FRONT</th>
		<th class="Left">SIDE</th>
		<th class="Left">REAR</th>
		<th class="Left">TURRET/ROTORS</th>
	</tr>
	<tr>
		<th>2-5</th>
		<td>No Critical Hit</td>
		<td>No Critical Hit</td>
		<td>No Critical Hit</td>
		<td>No Critical Hit</td>
	</tr>
	<tr>
		<th>6</th>
		<td>Driver Hit</td>
		<td>Cargo/Infantry Hit</td>
		<td>Weapon Malfunction</td>
		<td>Stabilizer/Rotors Damaged</td>
	</tr>
	<tr>
		<th>7</th>
		<td>Weapon Malfunction</td>
		<td>Weapon Malfunction</td>
		<td>Cargo/Infantry Hit</td>
		<td>Turret Jam/Rotors Damaged</td>
	</tr>
	<tr>
		<th>8</th>
		<td>Stabilizer</td>
		<td>Crew Stunned</td>
		<td>Stabilizer</td>
		<td>Weapon Malfunction/Rotors Damaged</td>
	</tr>
	<tr>
		<th>9</th>
		<td>Sensors</td>
		<td>Stabilizer</td>
		<td>Weapon Destroyed</td>
		<td>Turret Locks/Flight Stabilizer Hit</td>
	</tr>
	<tr>
		<th>10</th>
		<td>Commander/Pilot Hit</td>
		<td>Weapon Destroyed</td>
		<td>Engine Hit</td>
		<td>Weapon Destroyed/Flight Stabilizer Hit</td>
	</tr>
	<tr>
		<th>11</th>
		<td>Weapon Destroyed</td>
		<td>Engine Hit</td>
		<td>Ammunition**</td>
		<td>Ammunition**/Rotors Destroyed</td>
	</tr>
	<tr>
		<th>12</th>
		<td>Crew Killed</td>
		<td>Fuel Tank*</td>
		<td>Fuel Tank*</td>
		<td>Turret Blown Off/Rotors Destroyed</td>
	</tr>
	</table>
</div>
</td></tr></table>

<div id="Bottom">Created with {TITLE} {VERSION} available at <a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a>. Created on {DATE_CREATED}.</div>

</body>
</html>