
<h1>Persoon wijzigen</h1>
<form name="update" method="post" action="<?=URL?>employee/update">
	<fieldset>
	<input type="hidden" name="id_employee" value="<?=$id;?>"/>

	<label for="input_name">Naam *</label><br>
	<input type="text" name="input_name" value="<?=$name;?>" placeholder="Vul hier de naam in..."><br>

	<label for="input_age">Leeftijd *</label><br>
	<input type="number" name="input_age" value="<?=$age;?>" min="1" max="120" placeholder="Vul hier de leeftijd in..."><br>
	
	<input type="submit" name="submit_change" value="Submit">
	</fieldset>
</form>