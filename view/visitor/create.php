<h1>Voeg een bezoeker toe</h1>
<form name="store" method="post" action="<?=URL?>Main/store_visitor">
	<fieldset>
		<label for="name">Naam *</label><br>
		<input type="text" name="name" placeholder="bas verdoorn" value="<?=$name;?>" required><br>

		<label for="address">adres *</label><br>
		<input type="text" name="address" placeholder="straat en huisnummer" value="<?=$address;?>" required><br>

		<label for="telephone_number">telefoon nummer *</label><br>
		<input type="text" name="telephone_number" placeholder="06 38224482" value="<?=$telephone_number;?>" required><br>
		<!-- pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" -->
		
		<input type="submit" name="submit" value="Submit">
	</fieldset>
</form>