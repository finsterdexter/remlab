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

.CritNum {
	border: 1px solid #000;
	text-align: center;
}

#ArmorDiagram h2 {
	border: 1px solid #000;
}

.Border {
	border: 1px solid #000;
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
#BaseStats, #Pilot, #HeatTable, #Criticals, #Velocity, #Hardpoints {
	border: 1px solid #000;
	margin: 4px 2px 0 0;
}

#HeatTable td {
	padding: 0;
}

#Hardpoints td {
	border: 1px solid #000;
	text-align: center;
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

div#Footer th {
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
	margin: -6px 0 3px 0;
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

#Velocity th {
	border: 1px solid #000;
}

#Velocity td {
	text-align: right;
}

.LineAbove {.FontSM, 
	margin: 1px 0;
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

.FontBG, #CriticalSlots td p, #Options a, #CriticalSlots td strong {
	font-size: 8px;
}

.FontST, div, td, th, #Footer th {
	font-size: 6px;
}

td p span, #HeatTable td, .BVCost {
	font-size: 5px !important;
}

.FontSM {
	font-size: 60%;
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
				<td width="69%"><h1>AEROTECH</h1><h3>{CLASS} {CHASSIS} Record Sheet</h3></td>
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
				<td width="33%"><strong>{VSTOL}</strong></td>
				<td><p>Nose</p>{ARMOR_N}</td>
				<td width="33%"></td>
			</tr>
			<tr>
				<td><p>Left Wing</p>{ARMOR_LW}</td>
				<td style="padding:10px 5px"><p>Structural Integrity ({STRUCTURAL_INTEGRITY})</p>{SI_POINTS}</td>
				<td><p>Right Wing</p>{ARMOR_RW}</td>
			</tr>
			<tr>
				<td style="padding:12px 0 0 10px">Cargo Space: <strong>{CARGO_SPACE} tons</strong><br /><br />Passengers: <strong>{PASS_NUM}</strong><br /><br />{LIFEBOAT}</td>
				<td><p>Aft</p>{ARMOR_A}</td>
				<td style="padding:12px 0 0 10px">Armor<br /><strong>{ARMOR}</strong><br /><br />Targeting<br /><strong>{TARGETING}</strong> {TARGETING_MOD}</td>
			</tr>
			<tr>
				<td></td>
				<td style="padding:6px 0 0 0"><p class="BVCost">Battle Value: {BATTLE_VALUE}<br />Cost: {TOTAL_COST} C-bills<br />Damage: {MAX_DAMAGE}</p></td>
				<td></td>
			</tr>
		</table>
   </div>
   
  	<div id="Criticals" style="float:left">
  		<h2 style="margin-bottom:3px">Critical Damage</h2>
		<table width="120" cellspacing="1">
			<tr>
				<td class="Right" width="20%">Avionics</td>
				<td class="CritNum" width="4%">+1</td>
				<td class="CritNum" width="4%">+2</td>
				<td class="CritNum" width="4%">+5</td>

			</tr>
			<tr>
				<td class="Right">FCS</td>
				<td class="CritNum">+2</td>
				<td class="CritNum">+4</td>
				<td class="CritNum">X </td>
			</tr>
			<tr>
				<td class="Right">Sensors</td>
				<td class="CritNum">+1</td>
				<td class="CritNum">+2</td>
				<td class="CritNum">+5</td>
			</tr>
			<tr>
				<td class="Right" width="20%">Engine</td>
				<td class="CritNum" width="4%">2</td>
				<td class="CritNum" width="4%">4 </td>
				<td class="CritNum" width="4%">X </td>			
			</tr>
			<tr>
				<td class="Right">Gear</td>
				<td class="CritNum">+5</td>
				<td></td>
				<td></td>			
			</tr>
			<tr>
				<td class="Right">Life Support</td>
				<td class="CritNum">+2</td>
				<td></td>
				<td></td>			
			</tr>
		</table>
  		<h2 style="border-top:1px solid #000;margin:3px 0">Fuel</h2>
  		<p>Fuel Points: <strong>{FUEL_POINTS}</strong></p>
	</div>

  	<div id="Velocity" style="margin-bottom:3px">
  		<h2 style="margin-bottom:3px">Velocity Record</h2>
		<table width="100%" cellspacing="1">
			<tr>
				<td width="19%">Turn #</td><th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th><th>07</th><th>08</th><th>09</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th>
			</tr>
			<tr>
				<td>Thrust</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Velocity</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Effective Vel.</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Altitude</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
		</table>
		<table width="100%" cellspacing="1">
			<tr>
				<td width="19%">Turn #</td><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th>
			</tr>
			<tr>
				<td>Thrust</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Velocity</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Effective Vel.</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			<tr>
				<td>Altitude</td><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
		</table>
	</div>
	
  	<div id="Hardpoints" {HP_VISIBLE}>
  		<h2>External Stores and Bombs</h2>
		<table width="100%" cellspacing="2">
			<tr>
				<td width="20%">&nbsp;{HARDPOINT1}</td>
				<td width="20%">&nbsp;{HARDPOINT2}</td>
				<td width="20%">&nbsp;{HARDPOINT3}</td>
				<td width="20%">&nbsp;{HARDPOINT4}</td>
				<td width="20%">&nbsp;{HARDPOINT5}</td>
			</tr>
			<tr>
				<td>&nbsp;{HARDPOINT6}</td>
				<td>&nbsp;{HARDPOINT7}</td>
				<td>&nbsp;{HARDPOINT8}</td>
				<td>&nbsp;{HARDPOINT9}</td>
				<td>&nbsp;{HARDPOINT10}</td>
			</tr>
			<tr>
				<td>&nbsp;{HARDPOINT11}</td>
				<td>&nbsp;{HARDPOINT12}</td>
				<td>&nbsp;{HARDPOINT13}</td>
				<td>&nbsp;{HARDPOINT14}</td>
				<td>&nbsp;{HARDPOINT15}</td>
			</tr>
			<tr>
				<td>&nbsp;{HARDPOINT16}</td>
				<td>&nbsp;{HARDPOINT17}</td>
				<td>&nbsp;{HARDPOINT18}</td>
				<td>&nbsp;{HARDPOINT19}</td>
				<td>&nbsp;{HARDPOINT20}</td>
			</tr>
		</table>
	</div>
	</td>
	<td width="28%">
		<div id="BaseStats">
			<h2>Fighter Data</h2>
			<p style="margin-top:4px">Type: <strong>{TYPE}</strong></p>
			<p>Tonnage: <strong>{TONS}</strong></p>
			<p>Technology: <strong>{TECHNOLOGY}</strong> / {ERA}</p>
			<p>Ruleset: <strong>{LEVEL}</strong> ({EDITION} edition)</p>
			<p style="margin-top:5px">Thrust Points:</p>
			<blockquote style="margin-bottom:5px">
				<p>Safe Thrust: <strong>{WALKING}</strong></p>
				<p>Max Thrust: <strong>{RUNNING}</strong></p>
		 	</blockquote>
			<p class="LineAbove">Heat Sinks: <strong>{HEATSINKS} [{HEAT_DISIPATE}] | {HEATSINK_TYPE}</strong></p>
			<p style="letter-spacing:1px">{HEATSINK_TICKS}</p>
		</div>
	  	<div id="Pilot">
  			<h2>Pilot Data</h2>
			<p style="margin-top:4px">Crew Size: <strong>{CREW_NUM}</strong> &nbsp; Gunners: <strong>{GUNNERS_NUM}</strong></p>
  			<p>Name: {PILOT}</p>
  			<p>Affiliation: {FACTION}</p>
    		<p>Experience: {EXPERIENCE} {ABILITIES}</p>
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
					<td style="border-bottom:1px solid #000">Consciousness:</td>
					<td class="HitsBorder">3</td>
					<td class="HitsBorder">5</td>
					<td class="HitsBorder">7</td>
					<td class="HitsBorder">10</td>
					<td class="HitsBorder">11</td>
					<td class="HitsBorder">X</td>
				</tr>
				<tr>
					<td>Modifier:</td>
					<td class="LeftBorder">+1</td>
					<td class="LeftBorder">+2</td>
					<td class="LeftBorder">+3</td>
					<td class="LeftBorder">+4</td>
					<td class="LeftBorder">+5</td>
					<td class="LeftBorder"></td>
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
{HEAT_SCALE_AERO}
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

<div id="Bottom">Created with {TITLE} {VERSION} available at <a href="http://remlab.sourceforge.net/">remlab.sourceforge.net</a>. Created on {DATE_CREATED}.</div>

</body>
</html>