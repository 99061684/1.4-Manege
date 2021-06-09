<?php 	
	
?>
<h1>Overzicht van paarden</h1>
<table>	
	<tr>
		<th>naam</th>
		<th>ras</th>
		<th>leeftijd</th>
		<th>hoogspringen</th>
		<th>wijzigen</th>
		<th>verwijderen</th>
	</tr>
	<?php foreach ($data["horses"] as $key => $value) { ?>
		<tr>
			<td><?= $value["name"];?></td>
			<td><?= $value["race"];?></td>
			<td><?= $value["age"];?></td>
			<td><?= $value["show_jumping"];?></td>
			<td><a href="<?=URL?>/employee/edit/<?= $value["id"];?>">Wijzigen</a></td>
			<td><a href="<?=URL?>/employee/delete/<?= $value["id"];?>">Verwijderen</a></td>
		</tr>
	<?php } 
	// de opbouw van de link bepaald welke method in welke controller aangeroepen wordt.
	// het woordje "employee" in de url betekent dat het framework moet zoeken naar een controller genaamd "EmployeeController".
	// Hij maakt van de eerste letter een hoofdletter en plakt er zelf "Controller" achter.
	// Het woordje "update" of "delete" betekent dat hij in deze controller moet zoeken naar een method met deze naam.
	?>
</table>

<h1>Overzicht van pony's</h1>
<table>	
	<tr>
		<th>naam</th>
		<th>ras</th>
		<th>leeftijd</th>
		<th>schofthoogte</th>
		<th>wijzigen</th>
		<th>verwijderen</th>
	</tr>
	<?php foreach ($data["ponys"] as $key => $value) { ?>
		<tr>
		<td><?= $value["name"];?></td>
			<td><?= $value["race"];?></td>
			<td><?= $value["age"];?></td>
			<td><?= $value["height"];?></td>
			<td><a href="<?=URL?>/employee/edit/<?= $value["id"];?>">Wijzigen</a></td>
			<td><a href="<?=URL?>/employee/delete/<?= $value["id"];?>">Verwijderen</a></td>
		</tr>
	<?php } 
	// de opbouw van de link bepaald welke method in welke controller aangeroepen wordt.
	// het woordje "employee" in de url betekent dat het framework moet zoeken naar een controller genaamd "EmployeeController".
	// Hij maakt van de eerste letter een hoofdletter en plakt er zelf "Controller" achter.
	// Het woordje "update" of "delete" betekent dat hij in deze controller moet zoeken naar een method met deze naam.
	?>
</table>