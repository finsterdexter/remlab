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
	padding: 1px 6px;
	margin-left: 4px;
}

.CritNum {
	border: 1px solid #000;
	padding: 1px 2px;
	margin-left: 4px;
}

.Border {
	border: 1px solid #000;
	margin-top: 3px;
}

.Border td, .Border th {
	font-size: 6px;
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
	padding: 3px 0 0 2px;
}

ol {
	margin: 0 0 10px 20px;
	padding: 0;
}

ul {
	margin: 0 12px;
	padding: 0;
}

td {
	margin: 0;
	padding: 0 1px;
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
	border: 1px solid #000;
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

#Warrior {
	border: 1px solid #000;
	margin: 0 0 1px 1px;
}

#Warrior td {
	padding: 1px 2px;
}

.LineAbove {
	margin: 2px 0;
	border-top: 1px solid #000;
	padding-top: 2px;
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
	margin-right: 4px;
}

.FontBG, #Options a {
	font-size: 8px;
}

.FontST, td, th, #Footer th, div {
	font-size: 6px;
}

.FontSM, td p span {
	font-size: 5px;
}

.Internal {
	display: block;
	width: 50px;
	border: 1px solid #000;
	padding: 1px 2px;
	background: #eee;
}
</style>
<script type="text/javascript">
function hideSlot() {
	if (document.form.Slots.value == 1) {
		document.getElementById('P1').style.visibility = 'hidden';
	} else if (document.form.Slots.value == 2) {
		document.getElementById('P2').style.visibility = 'hidden';
	} else if (document.form.Slots.value == 3) {
		document.getElementById('P3').style.visibility = 'hidden';
	} else if (document.form.Slots.value == 4) {
		document.getElementById('P4').style.visibility = 'hidden';
	} else if (document.form.Slots.value == 5) {
		document.getElementById('P5').style.visibility = 'hidden';
	} else if (document.form.Slots.value == 6) {
		document.getElementById('Title').style.visibility = 'hidden';
		document.getElementById('Bottom').style.visibility = 'hidden';
	} else {
		document.getElementById('P1').style.visibility = 'visible';
		document.getElementById('P2').style.visibility = 'visible';
		document.getElementById('P3').style.visibility = 'visible';
		document.getElementById('P4').style.visibility = 'visible';
		document.getElementById('P5').style.visibility = 'visible';
		document.getElementById('Title').style.visibility = 'visible';
		document.getElementById('Bottom').style.visibility = 'visible';
	}
}
</script>
</head>

<body>

<div id="Options">
	<form name="form" action="">
		<input type="button" value="Print" onclick="window.print()" />
		<select name="Slots" onchange="hideSlot()">
			<option value="0" selected="selected">All</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">Top</option>
		</select>
	</form>
</div>

<table width="100%" cellspacing="0">
	<tr>
	<td width="72%">
	<div id="Title">
		<table width="100%" cellspacing="0">
			<tr>
				<td width="70%"><h1>{GAME_SYSTEM}</h1><h3>ProtoMech Point Record Sheet</h3></td>
				<td class="FontBG">Player: {PLAYER}<br /><br />Miniature: {MINIATURE}</td>
			</tr>
		</table>
	</div>
</table>

<div class="Border" id="P1">
	<p style="float:left"><strong style="color:#666">#1</strong> &nbsp; Type: <strong>{TYPE}</strong> &nbsp;&nbsp; Tonnage: <strong>{TONS}</strong> &nbsp;&nbsp; Movement Points: <strong style="letter-spacing:2px">{WALKING}/{RUNNING}/{JUMPING}</strong></p>
	<p class="Right">Battle Value: {BATTLE_VALUE} &nbsp;&nbsp; Cost: {TOTAL_COST} C-bills &nbsp;&nbsp; Ruleset: {LEVEL} ({EDITION} edition)</p>
	<table width="100%" cellspacing="0">
		<tr>
			<td width="19%"><h2>Armor Diagram</h2>
			<table width="100%" cellspacing="0">
				<tr>
					<td width="33%"><p>Main Gun</p>{ARMOR_MG}<span class="Internal">{IS_MG}</span></td>
					<td><p>Head</p>{ARMOR_H}<span class="Internal">{IS_H}</span></td>
					<td width="33%"></td>
				</tr>
				<tr>
					<td><p>Left Arm</p>{ARMOR_LA}<span class="Internal">{IS_LA}</span></td>
					<td><p>Torso</p>{ARMOR_T}<span class="Internal">{IS_T}</span></td>
					<td><p>Right Arm</p>{ARMOR_RA}<span class="Internal">{IS_RA}</span></td>
				</tr>
				<tr>
					<td></td>
					<td><p>Legs</p>{ARMOR_L}<span class="Internal">{IS_L}</span></td>
					<td></td>
				</tr>
			</table>	
			</td>
			<td width="36%" style="border-left:1px solid #000"><h2>Hit Locations and Critical Hits</h2>
			<table width="100%" cellspacing="0" id="CritLocations">
				<tr>
					<th>2d6</th>
					<th class="Left">Location</th>
					<th class="Left">1st Hit</th>
					<th class="Left">2nd Hit</th>
					<th class="Left">3rd Hit</th>
				</tr>
				<tr>
					<th>2</th>
					<td>Main Gun</td>
					<td>+1 to hit</td>
					<td>Main Gun destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>4</th>
					<td>Right Arm</td>
					<td>+1 to hit</td>
					<td>Right Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>5,9</th>
					<td>Legs</td>
					<td>-1 walk</td>
					<td>Half walk</td>
					<td>No move</td>
				</tr>
				<tr>
					<th>6,7,8</th>
					<td>Torso</td>
					<td>-1 jump*</td>
					<td>Half jump*</td>
					<td>Proto destroyed</td>
				</tr>
				<tr>
					<th>10</th>
					<td>Left Arm</td>
					<td>+1 to hit</td>
					<td>Left Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>12</th>
					<td>Head</td>
					<td>+1 to hit</td>
					<td>+2 to hit; no long range</td>
					<td></td>
				</tr>
			</table>
			<p class="FontSM"><strong>* Roll 1d6:</strong><br />1-2 - First Torso weapon destroyed | 3-4 - Second Torso weapon destroyed</p>
			</td>
			<td style="border-left:1px solid #000"><h2>Weapons and Equipment</h2>
			<table width="100%" cellspacing="0">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}

			</table>	
			<p><strong>Ammunition:</strong> {ALLOCATED_AMMO_PROTO}</p>
			<p class="LineAbove">Name: {PILOT} &nbsp; Gunnery Skill: <strong>{GUNNERY}</strong> ({EXPERIENCE})</p>
  			<table id="Warrior" width="210" cellspacing="0">
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
			</td>
		</tr>
	</table>
</div>

<div class="Border" id="P2">
	<p style="float:left"><strong style="color:#666">#2</strong> &nbsp; Type: <strong>{TYPE}</strong> &nbsp;&nbsp; Tonnage: <strong>{TONS}</strong> &nbsp;&nbsp; Movement Points: <strong style="letter-spacing:2px">{WALKING}/{RUNNING}/{JUMPING}</strong></p>
	<p class="Right">Battle Value: {BATTLE_VALUE} &nbsp;&nbsp; Cost: {TOTAL_COST} C-bills &nbsp;&nbsp; Ruleset: {LEVEL} ({EDITION} edition)</p>
	<table width="100%" cellspacing="0">
		<tr>
			<td width="19%"><h2>Armor Diagram</h2>
			<table width="100%" cellspacing="0">
				<tr>
					<td width="33%"><p>Main Gun</p>{ARMOR_MG}<span class="Internal">{IS_MG}</span></td>
					<td><p>Head</p>{ARMOR_H}<span class="Internal">{IS_H}</span></td>
					<td width="33%"></td>
				</tr>
				<tr>
					<td><p>Left Arm</p>{ARMOR_LA}<span class="Internal">{IS_LA}</span></td>
					<td><p>Torso</p>{ARMOR_T}<span class="Internal">{IS_T}</span></td>
					<td><p>Right Arm</p>{ARMOR_RA}<span class="Internal">{IS_RA}</span></td>
				</tr>
				<tr>
					<td></td>
					<td><p>Legs</p>{ARMOR_L}<span class="Internal">{IS_L}</span></td>
					<td></td>
				</tr>
			</table>	
			</td>
			<td width="36%" style="border-left:1px solid #000"><h2>Hit Locations and Critical Hits</h2>
			<table width="100%" cellspacing="0" id="CritLocations">
				<tr>
					<th>2d6</th>
					<th class="Left">Location</th>
					<th class="Left">1st Hit</th>
					<th class="Left">2nd Hit</th>
					<th class="Left">3rd Hit</th>
				</tr>
				<tr>
					<th>2</th>
					<td>Main Gun</td>
					<td>+1 to hit</td>
					<td>Main Gun destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>4</th>
					<td>Right Arm</td>
					<td>+1 to hit</td>
					<td>Right Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>5,9</th>
					<td>Legs</td>
					<td>-1 walk</td>
					<td>Half walk</td>
					<td>No move</td>
				</tr>
				<tr>
					<th>6,7,8</th>
					<td>Torso</td>
					<td>-1 jump*</td>
					<td>Half jump*</td>
					<td>Proto destroyed</td>
				</tr>
				<tr>
					<th>10</th>
					<td>Left Arm</td>
					<td>+1 to hit</td>
					<td>Left Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>12</th>
					<td>Head</td>
					<td>+1 to hit</td>
					<td>+2 to hit; no long range</td>
					<td></td>
				</tr>
			</table>
			<p class="FontSM"><strong>* Roll 1d6:</strong><br />1-2 - First Torso weapon destroyed | 3-4 - Second Torso weapon destroyed</p>
			</td>
			<td style="border-left:1px solid #000"><h2>Weapons and Equipment</h2>
			<table width="100%" cellspacing="0">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}

			</table>	
			<p><strong>Ammunition:</strong> {ALLOCATED_AMMO_PROTO}</p>
			<p class="LineAbove">Name: {PILOT} &nbsp; Gunnery Skill: <strong>{GUNNERY}</strong> ({EXPERIENCE})</p>
  			<table id="Warrior" width="210" cellspacing="0">
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
			</td>
		</tr>
	</table>
</div>

<div class="Border" id="P3">
	<p style="float:left"><strong style="color:#666">#3</strong> &nbsp; Type: <strong>{TYPE}</strong> &nbsp;&nbsp; Tonnage: <strong>{TONS}</strong> &nbsp;&nbsp; Movement Points: <strong style="letter-spacing:2px">{WALKING}/{RUNNING}/{JUMPING}</strong></p>
	<p class="Right">Battle Value: {BATTLE_VALUE} &nbsp;&nbsp; Cost: {TOTAL_COST} C-bills &nbsp;&nbsp; Ruleset: {LEVEL} ({EDITION} edition)</p>
	<table width="100%" cellspacing="0">
		<tr>
			<td width="19%"><h2>Armor Diagram</h2>
			<table width="100%" cellspacing="0">
				<tr>
					<td width="33%"><p>Main Gun</p>{ARMOR_MG}<span class="Internal">{IS_MG}</span></td>
					<td><p>Head</p>{ARMOR_H}<span class="Internal">{IS_H}</span></td>
					<td width="33%"></td>
				</tr>
				<tr>
					<td><p>Left Arm</p>{ARMOR_LA}<span class="Internal">{IS_LA}</span></td>
					<td><p>Torso</p>{ARMOR_T}<span class="Internal">{IS_T}</span></td>
					<td><p>Right Arm</p>{ARMOR_RA}<span class="Internal">{IS_RA}</span></td>
				</tr>
				<tr>
					<td></td>
					<td><p>Legs</p>{ARMOR_L}<span class="Internal">{IS_L}</span></td>
					<td></td>
				</tr>
			</table>	
			</td>
			<td width="36%" style="border-left:1px solid #000"><h2>Hit Locations and Critical Hits</h2>
			<table width="100%" cellspacing="0" id="CritLocations">
				<tr>
					<th>2d6</th>
					<th class="Left">Location</th>
					<th class="Left">1st Hit</th>
					<th class="Left">2nd Hit</th>
					<th class="Left">3rd Hit</th>
				</tr>
				<tr>
					<th>2</th>
					<td>Main Gun</td>
					<td>+1 to hit</td>
					<td>Main Gun destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>4</th>
					<td>Right Arm</td>
					<td>+1 to hit</td>
					<td>Right Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>5,9</th>
					<td>Legs</td>
					<td>-1 walk</td>
					<td>Half walk</td>
					<td>No move</td>
				</tr>
				<tr>
					<th>6,7,8</th>
					<td>Torso</td>
					<td>-1 jump*</td>
					<td>Half jump*</td>
					<td>Proto destroyed</td>
				</tr>
				<tr>
					<th>10</th>
					<td>Left Arm</td>
					<td>+1 to hit</td>
					<td>Left Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>12</th>
					<td>Head</td>
					<td>+1 to hit</td>
					<td>+2 to hit; no long range</td>
					<td></td>
				</tr>
			</table>
			<p class="FontSM"><strong>* Roll 1d6:</strong><br />1-2 - First Torso weapon destroyed | 3-4 - Second Torso weapon destroyed</p>
			</td>
			<td style="border-left:1px solid #000"><h2>Weapons and Equipment</h2>
			<table width="100%" cellspacing="0">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}

			</table>	
			<p><strong>Ammunition:</strong> {ALLOCATED_AMMO_PROTO}</p>
			<p class="LineAbove">Name: {PILOT} &nbsp; Gunnery Skill: <strong>{GUNNERY}</strong> ({EXPERIENCE})</p>
  			<table id="Warrior" width="210" cellspacing="0">
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
			</td>
		</tr>
	</table>
</div>

<div class="Border" id="P4">
	<p style="float:left"><strong style="color:#666">#4</strong> &nbsp; Type: <strong>{TYPE}</strong> &nbsp;&nbsp; Tonnage: <strong>{TONS}</strong> &nbsp;&nbsp; Movement Points: <strong style="letter-spacing:2px">{WALKING}/{RUNNING}/{JUMPING}</strong></p>
	<p class="Right">Battle Value: {BATTLE_VALUE} &nbsp;&nbsp; Cost: {TOTAL_COST} C-bills &nbsp;&nbsp; Ruleset: {LEVEL} ({EDITION} edition)</p>
	<table width="100%" cellspacing="0">
		<tr>
			<td width="19%"><h2>Armor Diagram</h2>
			<table width="100%" cellspacing="0">
				<tr>
					<td width="33%"><p>Main Gun</p>{ARMOR_MG}<span class="Internal">{IS_MG}</span></td>
					<td><p>Head</p>{ARMOR_H}<span class="Internal">{IS_H}</span></td>
					<td width="33%"></td>
				</tr>
				<tr>
					<td><p>Left Arm</p>{ARMOR_LA}<span class="Internal">{IS_LA}</span></td>
					<td><p>Torso</p>{ARMOR_T}<span class="Internal">{IS_T}</span></td>
					<td><p>Right Arm</p>{ARMOR_RA}<span class="Internal">{IS_RA}</span></td>
				</tr>
				<tr>
					<td></td>
					<td><p>Legs</p>{ARMOR_L}<span class="Internal">{IS_L}</span></td>
					<td></td>
				</tr>
			</table>	
			</td>
			<td width="36%" style="border-left:1px solid #000"><h2>Hit Locations and Critical Hits</h2>
			<table width="100%" cellspacing="0" id="CritLocations">
				<tr>
					<th>2d6</th>
					<th class="Left">Location</th>
					<th class="Left">1st Hit</th>
					<th class="Left">2nd Hit</th>
					<th class="Left">3rd Hit</th>
				</tr>
				<tr>
					<th>2</th>
					<td>Main Gun</td>
					<td>+1 to hit</td>
					<td>Main Gun destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>4</th>
					<td>Right Arm</td>
					<td>+1 to hit</td>
					<td>Right Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>5,9</th>
					<td>Legs</td>
					<td>-1 walk</td>
					<td>Half walk</td>
					<td>No move</td>
				</tr>
				<tr>
					<th>6,7,8</th>
					<td>Torso</td>
					<td>-1 jump*</td>
					<td>Half jump*</td>
					<td>Proto destroyed</td>
				</tr>
				<tr>
					<th>10</th>
					<td>Left Arm</td>
					<td>+1 to hit</td>
					<td>Left Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>12</th>
					<td>Head</td>
					<td>+1 to hit</td>
					<td>+2 to hit; no long range</td>
					<td></td>
				</tr>
			</table>
			<p class="FontSM"><strong>* Roll 1d6:</strong><br />1-2 - First Torso weapon destroyed | 3-4 - Second Torso weapon destroyed</p>
			</td>
			<td style="border-left:1px solid #000"><h2>Weapons and Equipment</h2>
			<table width="100%" cellspacing="0">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}

			</table>	
			<p><strong>Ammunition:</strong> {ALLOCATED_AMMO_PROTO}</p>
			<p class="LineAbove">Name: {PILOT} &nbsp; Gunnery Skill: <strong>{GUNNERY}</strong> ({EXPERIENCE})</p>
  			<table id="Warrior" width="210" cellspacing="0">
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
			</td>
		</tr>
	</table>
</div>

<div class="Border" id="P5">
	<p style="float:left"><strong style="color:#666">#5</strong> &nbsp; Type: <strong>{TYPE}</strong> &nbsp;&nbsp; Tonnage: <strong>{TONS}</strong> &nbsp;&nbsp; Movement Points: <strong style="letter-spacing:2px">{WALKING}/{RUNNING}/{JUMPING}</strong></p>
	<p class="Right">Battle Value: {BATTLE_VALUE} &nbsp;&nbsp; Cost: {TOTAL_COST} C-bills &nbsp;&nbsp; Ruleset: {LEVEL} ({EDITION} edition)</p>
	<table width="100%" cellspacing="0">
		<tr>
			<td width="19%"><h2>Armor Diagram</h2>
			<table width="100%" cellspacing="0">
				<tr>
					<td width="33%"><p>Main Gun</p>{ARMOR_MG}<span class="Internal">{IS_MG}</span></td>
					<td><p>Head</p>{ARMOR_H}<span class="Internal">{IS_H}</span></td>
					<td width="33%"></td>
				</tr>
				<tr>
					<td><p>Left Arm</p>{ARMOR_LA}<span class="Internal">{IS_LA}</span></td>
					<td><p>Torso</p>{ARMOR_T}<span class="Internal">{IS_T}</span></td>
					<td><p>Right Arm</p>{ARMOR_RA}<span class="Internal">{IS_RA}</span></td>
				</tr>
				<tr>
					<td></td>
					<td><p>Legs</p>{ARMOR_L}<span class="Internal">{IS_L}</span></td>
					<td></td>
				</tr>
			</table>	
			</td>
			<td width="36%" style="border-left:1px solid #000"><h2>Hit Locations and Critical Hits</h2>
			<table width="100%" cellspacing="0" id="CritLocations">
				<tr>
					<th>2d6</th>
					<th class="Left">Location</th>
					<th class="Left">1st Hit</th>
					<th class="Left">2nd Hit</th>
					<th class="Left">3rd Hit</th>
				</tr>
				<tr>
					<th>2</th>
					<td>Main Gun</td>
					<td>+1 to hit</td>
					<td>Main Gun destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>4</th>
					<td>Right Arm</td>
					<td>+1 to hit</td>
					<td>Right Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>5,9</th>
					<td>Legs</td>
					<td>-1 walk</td>
					<td>Half walk</td>
					<td>No move</td>
				</tr>
				<tr>
					<th>6,7,8</th>
					<td>Torso</td>
					<td>-1 jump*</td>
					<td>Half jump*</td>
					<td>Proto destroyed</td>
				</tr>
				<tr>
					<th>10</th>
					<td>Left Arm</td>
					<td>+1 to hit</td>
					<td>Left Arm destroyed</td>
					<td></td>
				</tr>
				<tr>
					<th>12</th>
					<td>Head</td>
					<td>+1 to hit</td>
					<td>+2 to hit; no long range</td>
					<td></td>
				</tr>
			</table>
			<p class="FontSM"><strong>* Roll 1d6:</strong><br />1-2 - First Torso weapon destroyed | 3-4 - Second Torso weapon destroyed</p>
			</td>
			<td style="border-left:1px solid #000"><h2>Weapons and Equipment</h2>
			<table width="100%" cellspacing="0">
{ALLOCATED_HEADER}
{ALLOCATED_WEAPONS}

			</table>	
			<p><strong>Ammunition:</strong> {ALLOCATED_AMMO_PROTO}</p>
			<p class="LineAbove">Name: {PILOT} &nbsp; Gunnery Skill: <strong>{GUNNERY}</strong> ({EXPERIENCE})</p>
  			<table id="Warrior" width="210" cellspacing="0">
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
			</td>
		</tr>
	</table>
</div>

<div id="Bottom">Created with {TITLE} {VERSION} available at <a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a>. Created on {DATE_CREATED}.</div>

</body>
</html>