<h1>bewerk een reservering</h1>
<form name="store" method="post" action="<?=URL?>Main/update_reservation">
	<fieldset>
		<input type="hidden" name="id" value="<?=$reservation["id"];?>">
		<label for="visitor">bezoeker *</label><br>
		<select name="visitor">
			<?php foreach ($data["visitors"] as $key => $value) { ?>
				<option <?php if ($value["id"] == $reservation["visitor"]) { echo "selected='selected'"; } ?> value="<?= $value["id"];?>"><?= $value["name"];?></option>
			<?php } ?>
		</select>

		<label for="animal">Het dier dat u wilt reserveren *</label><br>
		<select name="animal">
			<?php foreach ($data["animals"] as $key => $value) { ?>
				<option <?php if ($value["id"] == $reservation["animal"]) { echo "selected='selected'"; } ?> value="<?= $value["id"];?>"><?= $value["name"];?>, ras: <?= $value["race"];?>, leeftijd: <?= $value["age"];?>, hoogspringen: <?= $value["show_jumping"];?></option>
			<?php } ?>
		</select><br>

		<label for="date_reservation">Datum reservering *</label><br>
		<input type="datetime-local" name="date_reservation" value="<?= date('Y-m-d\TH:i', strtotime($reservation["date_reservation"]));?>" required><br>

		<label for="time_duration">aantal ritten *</label><br>
		<input type="number" onchange="kost_berekening(this.value)" name="time_duration" min="1" step="1" value="<?=$reservation["time_duration"];?>" required><br>
		<label id="default_kosten" for="time_duration">De duur van een rit is altijd precies 60 minuten en kost €55,-</label><br>

		<p id="totale_kosten">De totale kosten zijn nu: €0,-</p>

		<input type="submit" name="submit" value="Submit">
	</fieldset>
</form>