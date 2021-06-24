<?php 
	
?>
<a href="<?=URL?>Main/create_reservations">maak een reservering.</a>
<h1>Overzicht van reserveringen</h1>
<table>	
	<tr>
		<th>naam bezoeker</th>
		<th>dier</th>
		<th>datum reservering</th>
		<th>duur reservering</th>
		<th>kosten</th>
		<th>wijzigen</th>
		<th>verwijderen</th>
	</tr>
	<?php foreach ($data as $key => $value) {
		$visitor = getData("visitors", ["id" => ["operator" => "=", "value"=> $value["visitor"]]]);
		$animal = getData("animals", ["id" => ["operator" => "=", "value"=> $value["animal"]]]);
		?>
		<tr>
			<td><?= $visitor["name"];?></td>
			<td><?= $animal["name"];?></td>
			<td><?= $value["date_reservation"];?></td>
			<td><?= $value["time_duration"];?> ritten en <?= $value["time_duration"];?> uren</td>
			<td>€<?= $value["costs"];?>,-</td>
			<td><a href="<?=URL?>Main/edit_reservation/<?= $value["id"];?>">Wijzigen</a></td>
			<td><a href="<?=URL?>Main/delete_reservation/<?= $value["id"];?>">Verwijderen</a></td>
		</tr>
	<?php } 
	// de opbouw van de link bepaald welke method in welke controller aangeroepen wordt.
	// het woordje "employee" in de url betekent dat het framework moet zoeken naar een controller genaamd "EmployeeController".
	// Hij maakt van de eerste letter een hoofdletter en plakt er zelf "Controller" achter.
	// Het woordje "update" of "delete" betekent dat hij in deze controller moet zoeken naar een method met deze naam.
	?>
</table>

