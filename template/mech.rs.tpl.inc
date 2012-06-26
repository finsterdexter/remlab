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

#ArmorDiagram h2 {
	border: 1px solid #000;
}

#ArmorDiagram td {
	padding: 1px 5px;
}

#ArmorDiagram p {
	padding: 1px 0;
}

#ArmorDiagram span {
	font-size: 5px;
	margin-left: 1px;
}

#CriticalSlots {
	border: 1px solid #000;
	margin: 4px 2px 4px 4px;
}

#CriticalSlots table {
	width: 100%;
	height: 100%;
}

#CriticalSlots td {
	width: 33%;
	padding: 2px 4px 6px 4px;
}

#CriticalSlots table span {
	font-size: 4px;
	color: #999;
}

#CriticalSlots strong {
	font-weight: normal;
}

#CriticalSlots ol {
	margin-bottom: 2px;
}

#BaseStats, #Pilot, #HeatTable {
	border: 1px solid #000;
	margin: 4px 2px 0 0;
}

#Footer {
	border: 1px solid #000;
	margin: 2px 5px;
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

/* IE6 Hack */
* html ol {
	margin: 0 0 10px 26px;	
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

td.LeftBorder {
	border-left: 1px solid #000;
	text-align: center;
}

td.HitsBorder {
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

#CriticalChart {
	border: 1px solid #000;
	width: 135px;
	padding: 0;
}

#CriticalChart td{
	padding: 1px;
}

#Overflow {
	border: 1px solid #000;
	width:18px;
	height:14px;
	margin: 2px 0;
}

.LineAbove {
	margin: 2px 0;
	border-top: 1px solid #000;
	padding-top: 4px;
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

.FontBG, #CriticalSlots td p, #Options a, #CriticalSlots td strong {
	font-size: 8px;
}

.FontST, td, th, #Footer th, #HeatTable td, div {
	font-size: 6px;
}

.FontSM, td p span, p.BVCost {
	font-size: 5px !important;
}

.Lborder {
	border-left: 1px solid #000;
}
</style>
</head>

<body>

<div id="Options">
	<form name="form" action=""><input type="button" value="Print" onclick="window.print()" /></form>
</div>

<table width="100%" cellspacing="0">
	<tr>
	<td width="75%">
	<div id="Title">
		<table width="100%" cellspacing="0">
			<tr>
				<td width="69%"><h1>{GAME_SYSTEM}</h1><h3>{CLASS} {LEGS} {CHASSIS} Record Sheet</h3></td>
				<td class="FontBG">Player: {PLAYER}<br /><br />Miniature: {MINIATURE}</td>
			</tr>
		</table>
	</div>
	<div id="ArmorDiagram" style="min-height:184px">
		<table width="100%" cellspacing="0">
			<tr>
				<td colspan="3" width="55%" style="padding:0 0 0 2px"><h2>Armor Diagram</h2></td>
				<td colspan="3" width="45%" style="padding:0 2px 0 1px"><h2>Internal Structure</h2></td>
			</tr>
			<tr>
				<td width="15%"><p>{LA_TITLE} <span>(10,11)</span></p>{ARMOR_LA}</td>
				<td width="15%"><p>Head <span>(12)</span></p>{ARMOR_H}</td>
				<td width="15%"><p>{RA_TITLE} <span>(3,4)</span></p>{ARMOR_RA}</td>
				<td width="15%" class="Lborder"><p>{LA_TITLE}</p>{IS_LA}</td>
				<td width="15%"><p>Head</p>{IS_H}</td>
				<td width="15%"><p>{RA_TITLE}</p>{IS_RA}</td>
			</tr>
			<tr>
				<td><p>Left Torso <span>(8)</span></p>{ARMOR_LT}<p>Rear</p>{ARMOR_LTR}</td>
				<td><p>Center Torso <span>(2,7)</span></p>{ARMOR_CT}<p>Rear</p>{ARMOR_CTR}</td>
				<td><p>Right Torso <span>(6)</span></p>{ARMOR_RT}<p>Rear</p>{ARMOR_RTR}</td>
				<td class="Lborder"><p>Left Torso</p>{IS_LT}</td>
				<td><p>Center Torso</p>{IS_CT}</td>
				<td><p>Right Torso</p>{IS_RT}</td>
			</tr>
			<tr>
				<td rowspan="2"><p>{LL_TITLE} <span>(9)</span></p>{ARMOR_LL}</td>
				<td rowspan="2" style="padding:10px 0 0 5px">Armor<br /><strong>{ARMOR}</strong></td>
				<td rowspan="2"><p>{RL_TITLE} <span>(5)</span></p>{ARMOR_RL}</td>
				<td class="Lborder"><p>{LL_TITLE}</p>{IS_LL}</td>
				<td style="padding-left:5px">Internal Structure<br /><strong>{INTERNALSTRUCT}</strong><br /><br />Gyro<br /><strong>{GYRO}</strong></td>
				<td><p>{RL_TITLE}</p>{IS_RL}</td>
			</tr>
		</table>
   </div>

	<div id="CriticalSlots">
		<h2>Critical Hit Table</h2>
		<table width="99%" cellspacing="0">
			<tr>
				<td><strong>{LA_TITLE}</strong><br />{HIGH_LOW}
				<ol>
{CRITS_LA}
				</ol></td>
				<td><strong>Head</strong><br />&nbsp;
					<ol>
					<li>Life Support</li>
					<li>Sensors</li>
					<li>Cockpit</li>
{CRITS_H}
					</ol></td>
				<td><strong>{RA_TITLE}</strong><br />{HIGH_LOW}
					<ol>
{CRITS_RA}
					</ol></td>
			</tr>
			<tr>
				<td><strong>Left Torso</strong><br />{HIGH_LOW}
				<ol>
{CRITS_LT}
				</ol></td>
				<td><strong>Center Torso</strong><br />{HIGH_LOW}
				<ol>
				<li>Engine</li>
				<li>Engine</li>
				<li>Engine</li>
				<li>Gyro</li>
				<li>Gyro</li>
{CRITS_CT}				</ol></td>
				<td><strong>Right Torso</strong><br />{HIGH_LOW}
				<ol>
{CRITS_RT}
				</ol></td>
			</tr>
			<tr>
				<td><strong>{LL_TITLE}</strong><br />&nbsp;
				<ol>
				<li>Hip</li>
				<li>Upper Leg Actuator</li>
				<li>Lower Leg Actuator</li>
				<li>Foot Actuator</li>
{CRITS_LL}
				</ol></td>
				<td><div id="CriticalChart">
					<table width="100%" cellspacing="2">
						<tr>
							<td width="65%">Engine Hits:</td>
							<td>O O O</td>
						</tr><tr>
							<td>Gyro Hits:</td>
							<td>O O {HD_GYRO}</td>
						</tr><tr>
							<td>Sensor Hits:</td>
							<td>O O</td>
						</tr><tr>
							<td>Life Support:</td>
							<td>O</td>
						</tr>
					</table>
				</div>
				<p class="BVCost">Battle Value: {BATTLE_VALUE}<br />Cost: {TOTAL_COST} C-bills<br />Damage: {MAX_DAMAGE} &nbsp;&nbsp; Heat: {MAX_HEAT}</p>
		   	</td>
				<td><strong>{RL_TITLE}</strong><br />&nbsp;
				<ol>
				<li>Hip</li>
				<li>Upper Leg Actuator</li>
				<li>Lower Leg Actuator</li>
				<li>Foot Actuator</li>
{CRITS_RL}
				</ol></td>
			</tr>
		</table>
		</div>
		</td>
		
		<td width="25%">
		<div id="BaseStats">
			<h2>Mech Data</h2>
			<p style="margin-top:4px">Type: <strong>{TYPE}</strong></p>
			<p>Tonnage: <strong>{TONS}</strong></p>
			<p>Technology: <strong>{TECHNOLOGY}</strong> / {ERA}</p>
			<p>Ruleset: <strong>{LEVEL}</strong> ({EDITION} edition)</p>
			<p style="margin-top:5px">Movement Points:</p>
			<blockquote>
				<p>Walking: <strong>{WALKING}</strong></p>
				<p>Running: <strong>{RUNNING}</strong></p>{SPRINTING}
				<p>Jumping: <strong>{JUMPING}</strong></p>
		 	</blockquote>
			<p class="LineAbove">Heat Sinks: <strong>{HEATSINKS} [{HEAT_DISIPATE}] | {HEATSINK_TYPE}</strong></p>
			<p style="letter-spacing:1px">{HEATSINK_TICKS}</p>
			<p class="LineAbove">Targeting: <strong>{TARGETING}</strong> {TARGETING_MOD}</p>
			<p class="LineAbove">Auto Eject: <strong>{AUTO_EJECT}</strong></p>
		</div>
	  	<div id="Pilot">
  			<h2>Warrior Data</h2>
  			<p style="margin-top:4px">Name: {PILOT}</p>  	
  			<p>Affiliation: {FACTION}</p>
    		<p>Experience: {EXPERIENCE} <span class="FontSM">{ABILITIES}</span></p>
  			<p>Gunnery Skill: <strong>{GUNNERY}</strong> &nbsp; Piloting Skill: <strong>{PILOTING}</strong></p>
  			<p>Kills: OOOO OOOO OOOO OOOO OOOO</p>
  			<table width="96%" cellspacing="0" style="border:1px solid #000; margin:0 0 3px 4px">
				<tr>
					<td width="40%" style="border-bottom:1px solid #000">Hits Taken:</td>
					<td width="10%" class="HitsBorder">1</td>
					<td width="10%" class="HitsBorder">2</td>
					<td width="10%" class="HitsBorder">3</td>
					<td width="10%" class="HitsBorder">4</td>
					<td width="10%" class="HitsBorder">5</td>
					<td width="10%" class="HitsBorder">6</td>
				</tr>
				<tr>
					<td>Consciousness:</td>
					<td class="LeftBorder">3</td>
					<td class="LeftBorder">5</td>
					<td class="LeftBorder">7</td>
					<td class="LeftBorder">10</td>
					<td class="LeftBorder">11</td>
					<td class="LeftBorder">X</td>
				</tr>
			</table>
		</div>
		<div id="HeatTable">
		<h2>Heat Scale</h2>
		<table width="100%" cellspacing="0" style="margin:0 0 3px 5px">
			<tr>
				<td width="15%"><div id="Overflow"></div></td>
				<td style="padding-top:4px">&nbsp;Heat Overflow</td>
			</tr>
{HEAT_SCALE}
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
{ALLOCATED_MELEE}
		</table>	
		</td><td width="41%" class="Lborder">
			<p><strong>Ammunition</strong></p>
{ALLOCATED_AMMO}
		</td></tr>
	</table>
</div>

<div id="Bottom">Created with {TITLE} {VERSION} available at <a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a>. Created on {DATE_CREATED}.</div>

</body>
</html>