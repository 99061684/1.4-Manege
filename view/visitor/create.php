<h1>Voeg een bezoeker toe</h1>
<form name="store" method="post" action="<?=URL?>Main/store_visitor">
	<fieldset>
		<label for="name">Naam *</label><br>
		<input type="text" name="name" placeholder="bas verdoorn" value="<?=$data["name"];?>" required><br>
		<?php if (isset($errors["name"]) && !empty($errors["name"])) { ?>
			<small class="error_texts"><?= $errors["name"];?></small><br>
		<?php } ?>

		<label for="address">adres *</label><br>
		<input type="text" name="address" placeholder="straat en huisnummer" value="<?=$data["address"];?>" required><br>
		<?php if (isset($errors["address"]) && !empty($errors["address"])) { ?>
			<small class="error_texts"><?= $errors["address"];?></small><br>
		<?php } ?>

		<label for="telephone_number">telefoon nummer *</label><br>
		<input type="text" name="telephone_number" placeholder="06 38224482" value="<?=$data["telephone_number"];?>" required><br>
		<?php if (isset($errors["telephone_number"]) && !empty($errors["telephone_number"])) { ?>
			<small class="error_texts"><?= $errors["telephone_number"];?></small><br>
		<?php } ?>
		
		<input type="submit" name="submit" value="Submit">
	</fieldset>
</form>