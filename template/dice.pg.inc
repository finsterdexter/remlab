<noscript>Javascript must be enabled for REMLAB to function.</noscript>
<form name="form">
<div class="ColLeft">
	<h3>Dice Roller</h3>
	<div class="diceRoller">
		<select name="diceNum" onchange="diceButtonName()">
			<option value="1">1</option>
			<option value="2" selected="selected">2</option>
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
		</select> d
		<select name="diceSides" onchange="diceButtonName()">
			<option value="2">2</option>
			<option value="4">4</option>
			<option value="6" selected="selected">6</option>
			<option value="8">8</option>
			<option value="10">10</option>
			<option value="12">12</option>
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
		<input type="button" name="diceBtn" value="Roll 2d6" onclick="diceButtonName();diceRoller(document.form.diceSides.value,document.form.diceNum.value)" />
		<input type="text" name="diceResults" class="txtBoxClean" size="4" value="0" readonly="readonly" /><br />
		<textarea name="diceResultsList" rows="8" cols="4" readonly="readonly" style="width:130px;height:150px;"></textarea>
	</div>
</div>

<div class="ColRight">
	<h3>2d6 Dice Roller</h3>
	<div class="diceRoller">
		<input type="button" value="Roll 2d6" onclick="roll2d6()" /> <input type="text" name="diceResults2d6" class="txtBoxClean" size="3" value="0" readonly="readonly" />
		<div class="diRoll"><div id="die1" style="float:right;"></div><div id="die2"></div></div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
	</div>
</div>
</form>