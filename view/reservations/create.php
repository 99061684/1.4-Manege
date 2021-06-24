<h1>Maak een reservering</h1>
<form name="store" method="post" action="<?=URL?>Main/store_reservations">
	<fieldset>
		<label for="visitor">bezoeker *</label><br>
		<select name="visitor">
			<?php foreach ($data["visitors"] as $key => $value) { ?>
				<option value="<?= $value["id"];?>"><?= $value["name"];?></option>
			<?php } ?>
		</select><br>

		<label for="animal">Het dier dat u wilt reserveren *</label><br>
		<select name="animal">
			<?php foreach ($data["animals"] as $key => $value) { ?>
				<option value="<?= $value["id"];?>"><?= $value["name"];?>, ras: <?= $value["race"];?>, leeftijd: <?= $value["age"];?>, hoogspringen: <?= $value["show_jumping"];?></option>
			<?php } ?>
		</select><br>

		<label for="date_reservation">Datum reservering *</label><br>
		<input type="datetime-local" datetime="Y-m-d H:i" name="date_reservation" value="<?=$date_reservation;?>" required><br>

		<label for="time_duration">aantal ritten *</label><br>
		<input type="number" onchange="kost_berekening(this.value)" id="time_duration" name="time_duration" min="1" step="1" value="<?=$time_duration;?>" required><br>
		<label id="default_kosten" for="time_duration">De duur van een rit is altijd precies 60 minuten en kost €55,-</label><br>

		<p id="totale_kosten">De totale kosten zijn nu: €0,-</p>

		<input type="submit" name="submit" value="Submit">
		<script src="<?=URL?>js/script.js"></script>
	</fieldset>
</form>

<script>
	const time_duration = document.getElementById("time_duration");
	kost_berekening(time_duration.value);
</script>