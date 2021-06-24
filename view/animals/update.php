<h1>bewerk een paard of pony</h1>
<form name="store" method="post" action="<?=URL?>Main/update_animal">
	<fieldset>
		<input type="hidden" name="id" value="<?=$id;?>">
		<label for="name">Naam *</label><br>
		<input type="text" name="name" placeholder="Henk" value="<?=$data["name"];?>" required><br>
		<?php if (isset($errors["name"]) && !empty($errors["name"])) { ?>
			<small class="error_texts"><?= $errors["name"];?></small><br>
		<?php } ?>

		<label for="race">Ras *</label><br>
		<input type="text" name="race" placeholder="vul hier het ras in." value="<?=$data["race"];?>" required><br>
		<?php if (isset($errors["race"]) && !empty($errors["race"])) { ?>
			<small class="error_texts"><?= $errors["race"];?></small><br>
		<?php } ?>

		<label for="age">Leeftijd *</label><br>
		<input type="number" name="age" placeholder="12" value="<?=$data["age"];?>" required><br>
		<?php if (isset($errors["age"]) && !empty($errors["age"])) { ?>
			<small class="error_texts"><?= $errors["age"];?></small><br>
		<?php } ?>

		<label for="height">shofthoogte *</label><br>
		<input type="number" onchange="updateInput(this.value)" id="shofthoogte" name="height" placeholder="schofthoogte in cm" min="1" step="0.1" value="<?=$data["height"];?>" required><br>
		<?php if (isset($errors["height"]) && !empty($errors["height"])) { ?>
			<small class="error_texts"><?= $errors["height"];?></small><br>
		<?php } ?>

		<label for="springsport">Mogelijkheid springsport *</label><br>
		<input type="hidden" id="hidden_springsport" name="show_jumping" required>
		
		<input type="radio" id="springsport_ja" name="show_jumping" value="YES" required>
		<label for="springsport_ja">Ja</label><br>

		<input type="radio" id="springsport_nee" name="show_jumping" value="NO" required>
		<label for="springsport_nee">Nee</label><br>
		<?php if (isset($errors["show_jumping"]) && !empty($errors["show_jumping"])) { ?>
			<small class="error_texts"><?= $errors["show_jumping"];?></small><br>
		<?php } ?>

		<label for="animal">Tot 147,5 cm schofthoogte gaat het om een pony. <br> Ponys kunnen niet doen aan springsport.</label><br>

		<input type="submit" name="submit" value="Submit">
	</fieldset>
	<script src="<?=URL?>js/script.js"></script>
</form>

<script>
	const shofthoogte = document.getElementById("shofthoogte");
	updateInput(shofthoogte.value);
</script>