<?php
// maak een bevestig pagina voor het verwijderen van een mededwerker
    
?>
<h1>Weet u zeker dat u de employee <?=$name;?> wilt verwijderen?</h1>
<form name="destroy" method="post" action="<?=URL?>employee/destroy/<?=$id;?>">
	<fieldset>
        <p>Wilt u de employee verwijderen?</p>
        <input type="radio" id="radio_delete_yes" name="radio_delete" value="true">
        <label for="radio_delete_yes">Ja</label><br>

        <input type="radio" id="radio_delete_no" name="radio_delete" value="false">
        <label for="radio_delete_no">Nee</label><br>
		
		<input type="submit" name="submit_change" value="Submit">
	</fieldset>
</form>