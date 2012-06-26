<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{TITLE} {SUB_TITLE}</title>
<meta name="authors" content="{AUTHOR}" />
<link type="text/css" rel="stylesheet" href="resources/remlab.css" media="screen" />
<link type="text/css" rel="stylesheet" href="resources/print.css" media="print" />
<script type="text/javascript" src="include/remlab.js"></script>
<script type="text/javascript" src="include/mech.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>

<body onload="loadApp()">

<div id="Top">
	<div id="Header" onclick="location.href='build.lab'">
		<h1>{TITLE} <span>{SUB_TITLE}</span></h1>
		<div>{VERSION}</div>
	</div>
	<div id="Navigation">
		<dl>
			<dd><a href="build.lab">Build</a></dd>
			<dd><a href="about.lab">About</a></dd>
			<dd><a href="help.lab">Help</a></dd>
		</dl>
	</div>
</div>

<div id="Content">

<noscript>Javascript must be enabled for REMLAB to function.</noscript>

<form name="form" method="post" action="">

<div id="Totals">
	<table cellspacing="0">
		<tr>
			<th>Tonnage:</th>
			<td><span id="txtTonsRemaining">0.0</span>&nbsp;of <span id="txtTonnage">0.0</span></td>
			<th>Cost:</th>
			<td><span id="txtTotalCost">0</span> <small>C-bills</small></td>
			<th>Heat:</th>
			<td><span id="txtMaxHeat">2</span> / <span id="txtHeatDisapated">10</span></td>
			<th width="30%" rowspan="2"><input type="button" name="bRS" value="Record Sheet" onclick="submitForm('mech','rs')" /> <input type="button" name="bTR" value="Tech Readout" onclick="submitForm('mech','tr')" /><br /><input type="button" name="bXML" value="XML" onclick="submitForm('mech','xml')" /> <!--input type="button" name="bMM" value="MegaMek" onclick="submitForm('mech','mft')" /--></th>
		</tr>
		<tr>
			<th>Crits:</th>
			<td><span id="txtCritsRemaining">0</span>&nbsp;of <span id="txtCrits">0</span></td>
			<th><acronym title="Battle Value">BV</acronym>:</th>
			<td id="txtTotalBV">0</td>
			<th>Damage:</th>
			<td><span id="txtMaxDamage">0</span> <small>(<span id="txtDamagePerTon">0.00</span> per ton)</small></td>
		</tr>	
	</table>
</div>

<div id="Tabs">
	<dl>
		<dd><a id="L1btn" href="#" onclick="switchTab('L1');return false">Chassis</a></dd>
		<dd><a id="L2btn" href="#" onclick="switchTab('L2');return false">Armor</a></dd>
		<dd><a id="L3btn" href="#" onclick="switchTab('L3');return false">Armament</a></dd>
		<dd><a id="L4btn" href="#" onclick="switchTab('L4');return false">Warrior</a></dd>
		<dd><a id="L5btn" href="#" onclick="switchTab('L5');return false">History</a></dd>
	</dl>
</div>

<div id="Stats">
	Type <input type="text" name="Type" size="32" maxlength="50" value="" /> &nbsp;
	Class <select name="Mods" onchange="changeLevel()">
		<option value="0" selected="selected">BattleMech</option>
		<option value="1">OmniMech</option>
		<option value="3">IndustrialMech</option>
		<option value="2">Land-Air Mech</option>
	</select> &nbsp;
	Tonnage <select name="Tonnage" onchange="Calc()">
		<option value="10">10</option>
		<option value="15">15</option>
		<option value="20" selected="selected">20</option>
		<option value="25">25</option>
		<option value="30">30</option>
		<option value="35">35</option>
		<option value="40">40</option>
		<option value="45">45</option>
		<option value="50">50</option>
		<option value="55">55</option>
		<option value="60">60</option>
		<option value="65">65</option>
		<option value="70">70</option>
		<option value="75">75</option>
		<option value="80">80</option>
		<option value="85">85</option>
		<option value="90">90</option>
		<option value="95">95</option>
		<option value="100">100</option>
	</select> &nbsp;
<span id="txtClass">Light</span>
</div>

<div id="L1">
	<div class="ColLeft">
	<h3>Rules</h3>
	<div>
	<table>
		<tr>
			<th>Ruleset</th>
			<td><select name="Level" onchange="changeLevel()">
				<option value="2" selected="selected">Standard</option>
				<option value="3">Advanced</option>
				<option value="4">Solaris</option>
			</select></td>
		</tr>
		<tr>
			<th>Edition</th>
			<td><select name="Edition" onchange="changeLevel()">
				<option value="2">2nd</option>
				<option value="3">3rd</option>
				<option value="4">4th</option>
				<option value="5" selected="selected">5th</option>
			</select></td>
		</tr>
		<tr>
			<th>Technology</th>
			<td><select name="Tech" onchange="changeLevel();switchCatagory('T1')">
				<option value="1" selected="selected">Inner Sphere</option>
				<option value="2">Clan</option>
			</select></td>
		</tr>
		<tr>
			<th>Era</th>
			<td><select id="Era" name="Era">
				<option value="2439">2439</option>
				<option value="2570">2570</option>
				<option value="2750">2750</option>
				<option value="3025">3025</option>
				<option value="3039">3039</option>
				<option value="3050">3050</option>
				<option value="3055">3055</option>
				<option value="3058">3058</option>
				<option value="3060">3060</option>
				<option value="3067">3067</option>
				<option value="3075" selected="selected">3075</option>
				<option value="3132">3132</option>
			</select><input type="text" id="EraInput" name="EraInput" size="5" maxlength="4" value="" /><input type="button" value=" + " class="Plus" onclick="flipInput('EraInput','Era')" title="Switch between input and select" /></td>
		</tr>	
	</table>
	</div>

	<h3>Engine and Movement</h3>
	<div>
	<table>
		<tr>
			<th>Walking <acronym title="Movement Points">MP</acronym></th>
			<td><select name="Walking" onchange="Calc()">
				<option value="01" selected="selected">1</option>
				<option value="02">2</option>
				<option value="03">3</option>
				<option value="04">4</option>
				<option value="05">5</option>
				<option value="06">6</option>
				<option value="07">7</option>
				<option value="08">8</option>
				<option value="09">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
			</select>&nbsp; Running <acronym title="Movement Points">MP</acronym> <strong><span id="txtRunning">2</span></strong></td>			
		</tr>
		<tr>
			<th>Engine</th>
			<td><select name="Engine" onchange="Calc()">
				<option value="0" selected="selected">Fusion</option>
			</select>&nbsp; <span id="txtEngine">Pitban 20</span> <span class="Tons">[<span id="txtEngineTonnage">0.5</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Advanced</th>
			<td><select name="AdvanceMP" onchange="Calc()">
				<option value="0" selected="selected">None</option>
			</select> <span class="Tons">[<span id="txtSpecialMovement">0.0</span> tons]</span></td>			
		</tr>
	</table>
	</div>

	<h3>Jump Jets</h3>
	<div>
	<table>
		<tr>
			<th>Jumping <acronym title="Movement Points">MP</acronym></th>
			<td><select name="Jumping" onchange="Calc()">
				<option value="0" selected="selected">0</option>
				<option value="01">1</option>
				<option value="02">2</option>
				<option value="03">3</option>
				<option value="04">4</option>
				<option value="05">5</option>
				<option value="06">6</option>
				<option value="07">7</option>
				<option value="08">8</option>
				<option value="09">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select> <span class="Tons">[<span id="txtJumpJets">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Type</th>
			<td><select name="JJType" onchange="Calc()">
				<option value="0" selected="selected">Standard</option>			
			</select></td>
		</tr>
	</table>
	</div>
	</div>
	
	<div class="ColRight">
	<h3>Limbs</h3>
	<div>
	<table>
		<tr>
			<th>Legs</th>
			<td><select name="Legs" onchange="changeLegs()">
				<option value="2" selected="selected">Biped</option>
				<option value="4">Quadraped</option>
			</select></td>			
		</tr>
		<tr>
			<th>Left Arm</th>
			<td><select name="LAActuators" onchange="changeLegs()">
				<option value="3" selected="selected">Full Arm</option>
				<option value="1">No Hand</option>
				<option value="2">No Lower Arm</option>
			</select> <span class="Tons">[<span id="txtLATonnage">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Right Arm</th>
			<td><select name="RAActuators" onchange="changeLegs()">
				<option value="3" selected="selected">Full Arm</option>
				<option value="1">No Hand</option>
				<option value="2">No Lower Arm</option>
			</select> <span class="Tons">[<span id="txtRATonnage">0.0</span> tons]</span></td>			
		</tr>
	</table>
	</div>

	<h3>Internal Components</h3>
	<div>
	<table>
		<tr>
			<th>Internal Structure</th>
			<td><select name="ISType" onchange="Calc()">
				<option value="0" selected="selected">Standard</option>
			</select> <span class="Tons">[<span id="txtISTonnage">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Gyroscope</th>
			<td><select name="Gyro" onchange="Calc()">
				<option value="0" selected="selected">Standard</option>
			</select> <span class="Tons">[<span id="txtGyroTonnage">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Cockpit</th>
			<td><select name="Cockpit" onchange="Calc()">
				<option value="0" selected="selected">Standard</option>
			</select> <span class="Tons">[<span id="txtCockpitTonnage">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Targeting System</th>
			<td><select name="Targeting" onchange="Calc()">
				<option value="0" selected="selected">Standard</option>
			</select> <span class="Tons">[<span id="txtTargetingTonnage">0.0</span> tons]</span></td>			
		</tr>	
	</table>
	</div>
	
	<h3>Heat Sinks</h3>
	<div>
	<table>
		<tr>
			<th>Quantity</th>
			<td><select name="HeatSinks" onchange="Calc()">
				<option value="0" selected="selected">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
			</select><span id="PlusTen">+10</span> <span class="Tons">[<span id="txtHeatSinks">0.0</span> tons]</span></td>			
		</tr>
		<tr>
			<th>Type</th>
			<td><select name="HSType" onchange="Calc()">
				<option value="0" selected="selected">Single</option>
			</select></td>			
		</tr>
	</table>
	</div>
	</div>
</div>

<div id="L2">
	<h3 class="padding">Armor</h3>
	<div>Type <select name="Armor" onchange="Calc()">
			<option value="0" selected="selected">Standard</option>
		</select> &nbsp; Armor Points &nbsp;<strong><span id="txtArmorTotal">0</span>/<span id="txtArmorMax">0</span></strong>&nbsp; <span class="Tons">[<span id="txtArmorTonnage">0.0</span> tons]</span>
	</div>

	<h3>Allocate Armor Points</h3>
	<div>
	<table width="460" cellspacing="1">
		<tr>
			<td></td>
			<td></td>
			<td><acronym title="Head">H</acronym><br /><input type="text" name="ArmorHead" size="2" maxlength="1" value="0" onblur="Calc()" />/9</td>
			<td></td>
			<td></td>
			<th rowspan="4">
				<fieldset><legend>Amount</legend>
				<input type="button" value="Full" onclick="armorPercent(1)" /><br /><input type="button" value="75%" onclick="armorPercent(0.75)" /><br /><input type="button" value="50%" onclick="armorPercent(0.5)" /><br /><input type="button" value="25%" onclick="armorPercent(0.25)" /><br /><input type="button" value="None" onclick="clearArmor()" /><input type="hidden" name="ArmorPercent" value="0" /></fieldset>
			</th>
		</tr>
		<tr>
			<td><acronym title="Left Arm">LA</acronym><br /><input type="text" name="ArmorLA" size="2" maxlength="2" value="0" onchange="Calc()" onkeyup="armorBalance('ArmorLA','ArmorRA')" />/<span id="txtMaxLA"></span></td>
			<td><acronym title="Left Torso">LT</acronym><br /><input type="text" name="ArmorLT" size="2" maxlength="2" value="0" onchange="Calc()" onkeyup="armorBalance('ArmorLT','ArmorRT')" />/<span id="txtMaxLT"></span></td>
			<td><acronym title="Center Torso">CT</acronym><br /><input type="text" name="ArmorCT" size="2" maxlength="2" value="0" onchange="Calc()" />/<span id="txtMaxC"></span></td>
			<td><acronym title="Right Torso">RT</acronym><br /><input type="text" name="ArmorRT" size="2" maxlength="2" value="0" onchange="Calc()" />/<span id="txtMaxRT"></span></td>
			<td><acronym title="Right Arm">RA</acronym><br /><input type="text" name="ArmorRA" size="2" maxlength="2" value="0" onchange="Calc()" />/<span id="txtMaxRA"></span></td>
		</tr>
		<tr>
			<td></td>
			<td><acronym title="Left Torso Rear">LT(R)</acronym><br /><input type="text" name="ArmorLTR" size="2" maxlength="2" value="0" onchange="Calc()" onkeyup="armorBalance('ArmorLTR','ArmorRTR')" /></td>
			<td><acronym title="Center Torso Rear">CT(R)</acronym><br /><input type="text" name="ArmorCTR" size="2" maxlength="2" value="0" onchange="Calc()" /></td>
			<td><acronym title="Right Torso Rear">RT(R)</acronym><br /><input type="text" name="ArmorRTR" size="2" maxlength="2" value="0" onchange="Calc()" /></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><acronym title="Left Leg">LL</acronym><br /><input type="text" name="ArmorLL" size="2" maxlength="2" value="0" onchange="Calc()" onkeyup="armorBalance('ArmorLL','ArmorRL')" />/<span id="txtMaxLL"></span></td>
			<td></td>
			<td><acronym title="Right Leg">RL</acronym><br /><input type="text" name="ArmorRL" size="2" maxlength="2" value="0" onchange="Calc()" />/<span id="txtMaxRL"></span></td>
			<td></td>
		</tr>
	</table>
	</div>
</div>

<div id="L3">
	<h3 class="line">Weapons and Equipment</h3>
	<div id="weapTabs">
		<dl>
			<dd><a id="T1btn" href="#" onclick="switchCatagory('T1');return false">Energy</a></dd>
			<dd><a id="T2btn" href="#" onclick="switchCatagory('T2');return false">Ballistic</a></dd>
			<dd><a id="T3btn" href="#" onclick="switchCatagory('T3');return false">Missile</a></dd>
			<dd><a id="T4btn" href="#" onclick="switchCatagory('T4');return false">Artillery</a></dd>
			<dd><a id="T5btn" href="#" onclick="switchCatagory('T5');return false">Equipment</a></dd>
			<dd><a id="T6btn" href="#" onclick="switchCatagory('T6');return false">Industrial</a></dd>
			<dd><a id="T7btn" href="#" onclick="switchCatagory('T7');return false">Ammunition</a></dd>
			<dd><a id="T8btn" href="#" onclick="showAllocate();return false">Allocate Items</a></dd>
		</dl>
	</div>
	
	<div id="ISWeapons">
		<div id="T1">
{WEAPONS_IS_ENERGY}
		</div>
		
		<div id="T2">
{WEAPONS_IS_BALLISTIC}
		</div>
		
		<div id="T3">
{WEAPONS_IS_MISSLE}
		</div>
		
		<div id="T4">
{WEAPONS_IS_ARTILLERY}
		</div>
		
		<div id="T5">
{WEAPONS_IS_EQUIPMENT}
		</div>
		
		<div id="T6">
{WEAPONS_IS_INDUSTRIAL}
		</div>		
		
		<div id="T7">
			<div class="ammoRight">
{WEAPONS_IS_AMMO2}
			</div>
					
			<div class="ammoLeft">
{WEAPONS_IS_AMMO1}
			</div>
		</div>
	</div>
	
	<div id="ClanWeapons">
		<div id="T1c">
{WEAPONS_CLAN_ENERGY}
		</div>
		
		<div id="T2c">
{WEAPONS_CLAN_BALLISTIC}
		</div>
		
		<div id="T3c">
{WEAPONS_CLAN_MISSLE}
		</div>
		
		<div id="T4c">
{WEAPONS_CLAN_ARTILLERY}
		</div>
		
		<div id="T5c">
{WEAPONS_CLAN_EQUIPMENT}
		</div>
		
		<div id="T6c">
{WEAPONS_CLAN_INDUSTRIAL}
		</div>
		
		<div id="T7c">
			<div class="ammoRight">
{WEAPONS_CLAN_AMMO2}
			</div>
			<div class="ammoLeft">
{WEAPONS_CLAN_AMMO1}
			</div>
		</div>
	</div>
	
	<h3>Allocate</h3>
	<div id="allocate">
		<table cellspacing="1" cellpadding="1">
			<tr>
				<td width="25%">
					<p>Weapons &amp; Ammo</p>
					<ul id="txtListWeapons"><li></li></ul>
				</td>
				<td width="25%">
					<p>Equipment</p>
					<ul id="txtListEquipment"><li></li></ul>
				</td>
				<td width="25%">
					<p>Heat Sinks</p>
					<ul id="txtListHeatSinks"><li></li></ul>
				</td>
				<td width="25%">
					<p>Available Slots</p>
					<table id="CritSlots">
						<tr>
							<td><acronym title="Head">H</acronym></td>
							<th><input type="text" name="HCrits" value="1" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Center Torso">CT</acronym></td>
							<th><input type="text" name="CTCrits" value="2" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Left Torso">LT</acronym></td>
							<th><input type="text" name="LTCrits" value="12" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Right Torso">RT</acronym></td>
							<th><input type="text" name="RTCrits" value="12" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Left Arm">LA</acronym></td>
							<th><input type="text" name="LACrits" value="8" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Right Arm">RA</acronym></td>
							<th><input type="text" name="RACrits" value="8" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Left Leg">LL</acronym></td>
							<th><input type="text" name="LLCrits" value="2" readonly="readonly" /></th>
						</tr>
						<tr>
							<td><acronym title="Right Leg">RL</acronym></td>
							<th><input type="text" name="RLCrits" value="2" readonly="readonly" /></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>

<div id="L4">
	<div class="ColLeft">
		<h3>Warrior Info</h3>
		<div>
		<table>
			<tr>
				<th>Name</th>
				<td><input type="text" name="PilotName" size="34" maxlength="40" value="" /><!--input type="button" value="^" title="Random Name Generator (off-site)" onclick="OpenWindow('http://www.behindthename.com/random/')" /--></td>			
			</tr>
			<tr>
				<th>Affiliation</th>
				<td><select id="Faction" name="Faction">
					<option value="0" selected="selected">None (blank line)</option>
					<optgroup label="Inner Sphere">
						{FACTION_IS}
					</optgroup>
					<optgroup label="Clans">
						{FACTION_CLAN}
					</optgroup>
					<optgroup label="The Periphery Realms">
						{FACTION_PERIPHERY}
					</optgroup>
					<optgroup label="Dark Age (32nd Century)">
						{FACTION_DARKAGE}
					</optgroup>
					<optgroup label="Mercenaries">
						{FACTION_MERCS}
					</optgroup>
					<optgroup label="Generic">
						{FACTION_GENERIC}
					</optgroup>
				</select><input type="text" id="FactionInput" name="FactionInput" size="34" maxlength="40" value="" /><input type="button" value=" + " class="Plus" onclick="flipInput('FactionInput','Faction')" title="Switch between input and select" /></td>			
			</tr>
			<tr>
				<th>Abilities</th>
				<td><select name="Abilities">
					<option value="0" selected="selected">No Special Abilities</option>
				</select></td>			
			</tr>
			<tr>
				<th>Player</th>
				<td><input type="text" name="Player" size="25" maxlength="25" value="" /></td>			
			</tr>
			<tr>
				<th>Miniature</th>
				<td><input type="text" name="Miniature" size="25" maxlength="25" value="" /></td>			
			</tr>
		</table>
		</div>
	</div>
	
	<div class="ColRight">
		<h3>Warrior Stats</h3>
		<div>
		<table>
			<tr>
				<th>Race</th>
				<td><select name="Race" onchange="raceSkills()">
					<option value="0" selected="selected">Human</option>
					<option value="1">Clanner</option>
				</select></td>
			</tr>
			<tr>
				<th>Experience</th>
				<td><select name="Experience">
					<option value="1" selected="selected">Green</option>
					<option value="2">Regular</option>
					<option value="3">Veteran</option>
					<option value="4">Elite</option>
				</select></td>
			</tr>
			<tr>
				<th>Gunnery Skill</th>
				<td><select name="Gunnery">
					<option value="8">7</option>
					<option value="7">6</option>
					<option value="6">5</option>
					<option value="5" selected="selected">4</option>
					<option value="4">3</option>
					<option value="3">2</option>
					<option value="2">1</option>
					<option value="1">0</option>
				</select> <input type="button" value="Random" onclick="randStats()" title="Randomize the piloting and gunnery skills" /></td>
			</tr>
			<tr>
				<th>Piloting Skill</th>
				<td><select name="Piloting">
					<option value="8">7</option>
					<option value="7">6</option>
					<option value="6" selected="selected">5</option>
					<option value="5">4</option>
					<option value="4">3</option>
					<option value="3">2</option>
					<option value="2">1</option>
					<option value="1">0</option>
				</select></td>
			</tr>
			<tr>
				<th>Auto Eject</th>
				<td><select name="AutoEject">
					<option value="1" selected="selected">Operational</option>
					<option value="0">Disabled</option>
				</select></td>
			</tr>
		</table>
		</div>
	</div>
</div>

<div id="L5">
	<div class="ColLeft">
		<h3>Overview</h3>
		<div><textarea name="Overview" rows="4" cols="44"></textarea></div>
		<h3>Capabilities</h3>
		<div><textarea name="Capability" rows="4" cols="44"></textarea></div>
		<h3>Battle History</h3>
		<div><textarea name="History" rows="4" cols="44"></textarea></div>
	</div>
	<div class="ColRight">
		<h3>Deployment</h3>
		<div><textarea name="Deployment" rows="4" cols="44"></textarea></div>
		<h3>Variants</h3>
		<div><textarea name="Varients" rows="4" cols="44"></textarea></div>
		<h3>Notable Warriors</h3>
		<div><textarea name="Notable" rows="4" cols="44"></textarea></div>
	</div>
</div>

<input type="hidden" name="UnitType" value="1" />
<input type="hidden" name="Tons" value="0" />
<input type="hidden" name="Crits" value="0" />
<input type="hidden" name="EngineRating" value="0" />
<input type="hidden" name="TotalCost" value="0" />
<input type="hidden" name="TotalBV" value="0" />
<input type="hidden" name="MaxDamage" value="0" />
<input type="hidden" name="MaxHeat" value="0" />
<input type="hidden" name="ArmorTotal" value="0" />
<input type="hidden" name="HCritsMax" value="1" />
<input type="hidden" name="CTCritsMax" value="2" />
<input type="hidden" name="LTCritsMax" value="12" />
<input type="hidden" name="RTCritsMax" value="12" />
<input type="hidden" name="LACritsMax" value="8" />
<input type="hidden" name="RACritsMax" value="8" />
<input type="hidden" name="LLCritsMax" value="2" />
<input type="hidden" name="RLCritsMax" value="2" />
<input type="hidden" name="NumWeapons" value="" />
<input type="hidden" name="1Crits" value="" />

</form>

<div id="Processing"></div>

</div>

<div id="Bottom">
	<div>Developed by <a href="http://www.marchtwenty.com/">March Twenty Productions</a> and distributed on <a href="http://remlab.sourceforge.net/">SourceForge.net</a>.</div>
</div>

</body>
</html>