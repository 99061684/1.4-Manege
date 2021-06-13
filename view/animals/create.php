<h1>Voeg een paard of pony toe</h1>
<form name="store" method="post" action="<?=URL?>Main/store_animals">
	<fieldset>
		<label for="name">Naam *</label><br>
		<input type="text" name="name" placeholder="Henk" value="<?=$name;?>" required><br>

		<label for="race">Ras *</label><br>
		<input type="text" name="race" placeholder="vul hier het ras in." value="<?=$race;?>" required><br>

		<label for="age">Leeftijd *</label><br>
		<input type="number" name="age" placeholder="12" value="<?=$age;?>" required><br>

		<label for="height">shofthoogte *</label><br>
		<input type="number" onchange="updateInput(this.value)" id="shofthoogte" name="height" placeholder="schofthoogte in cm" min="0" step="0.1" value="<?=$height;?>" required><br>

		<label for="springsport">Mogelijkheid springsport *</label><br>
		<input type="hidden" id="hidden_springsport" name="show_jumping" required>
		
		<input type="radio" id="springsport_ja" name="show_jumping" value="YES" required>
		<label for="springsport_ja">Ja</label><br>

		<input type="radio" id="springsport_nee" name="show_jumping" value="NO" required>
		<label for="springsport_nee">Nee</label><br>

		<label for="animal">Tot 147,5 cm schofthoogte gaat het om een pony. <br> Ponys kunnen niet doen aan springsport.</label><br>

		<input type="submit" name="submit" value="Submit">
	</fieldset>
</form>