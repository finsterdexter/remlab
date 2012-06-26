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

#Overflow {
	border: 1px solid #000;
	width:18px;
	height:14px;
	margin: 2px 0;
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
	width: 155px;
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
				<td width="69%"><h1>{GAME_SYSTEM}</h1><h3>{CLASS} {CHASSIS} Record Sheet</h3></td>
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
				<td><p>HEX #1</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_2}"><p>HEX #2</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_3}"><p>HEX #3</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
			</tr>
			<tr>
				<td style="{HEX_VISIBLE_4}"><p>HEX #4</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_5}"><p>HEX #5</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_6}"><p>HEX #6</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
			</tr>
			<tr>
				<td style="{HEX_VISIBLE_7}"><p>HEX #7</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_8}"><p>HEX #8</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_9}"><p>HEX #9</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
			</tr>
			<tr>
				<td style="{HEX_VISIBLE_10}"><p>HEX #10</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_11}"><p>HEX #11</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
				<td style="{HEX_VISIBLE_12}"><p>HEX #12</p>{ARMOR_B}<span class="Internal">{ARMOR_INTERNAL}</span></td>
			</tr>
			<tr>
				<td></td>
				<td style="padding:8px 0 0 0"><p class="BVCost">Battle Value: {BATTLE_VALUE}<br />Cost: {TOTAL_COST} C-bills<br />Damage: {MAX_DAMAGE}</p></td>
				<td></td>
			</tr>
		</table>
   </div>
   
	</td>
	<td width="28%">
		<div id="BaseStats">
			<h2>Structure Data</h2>
			<p style="margin-top:4px">Type: <strong>{TYPE}</strong></p>
			<p>Construction Factor: <strong>{TONS}</strong></p>
			<p>Technology: <strong>{TECHNOLOGY}</strong> / {ERA}</p>
			<p>Ruleset: <strong>{LEVEL}</strong> ({EDITION} edition)</p>
			<p class="LineAbove">Height: <strong>{NUM_HEIGHT} levels</strong></p>
			<p>Base Area: <strong>{NUM_SIZE} hexes</strong></p>
			<p>Basement: <strong>{NUM_BASEMENT}</strong></p>
			<p>Large Doors: <strong>{NUM_DOORS}</strong></p>
			<p>Turret: <strong>{TURRET_PRESENT}</strong></p>
		</div>
	  	<div id="Pilot">
  			<h2>Crew Data</h2>
			<p style="margin-top:4px">Crew Size: <strong>{CREW_NUM}</strong></p>
  			<p>Name: {PILOT}</p>
  			<p>Affiliation: {FACTION}</p>
    		<p>Experience: {EXPERIENCE} {ABILITIES}</p>
  			<p>Gunnery Skill: <strong>{GUNNERY}</strong></p>
  			<p>Kills: OOOO OOOO OOOO OOOO OOOO</p>
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

<div id="Bottom">Created with {TITLE} {VERSION} available at <a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a>. Created on {DATE_CREATED}.</div>

</body>
</html>