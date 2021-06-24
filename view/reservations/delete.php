<h1>Weet u zeker dat u de reservering wilt verwijderen?</h1>
<form name="destroy" method="post" action="<?=URL?>Main/destroy_reservation/">
	<fieldset>
        <input type="hidden" name="id" value="<?=$id;?>">
        <p>Wilt u de reservering verwijderen?</p>
        <input type="radio" id="radio_delete_yes" name="radio_delete" value="true">
        <label for="radio_delete_yes">Ja</label><br>

        <input type="radio" id="radio_delete_no" name="radio_delete" value="false">
        <label for="radio_delete_no">Nee</label><br>
		
		<input type="submit" name="submit" value="submit">
	</fieldset>
</form>