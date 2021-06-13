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
	<?php foreach ($data as $key => $value) { ?>
		<tr>
			<td><?= $value["name"];?></td>
			<td><?= $value["address"];?></td>
			<td><?= $value["telephone_number"];?></td>
			<td><?= $value["address"];?></td>
			<td>€500,-</td>
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

