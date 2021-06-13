<?php 
	// if($data['connection']){
	// 	echo '<h1>HET WERKT!</h1>';
	// }else{
	// 	echo '<h1>DB CONNECTION FAILED!</h1>';
	// }	
	
?>
<h1>Overzicht van bezoekers</h1>
<a href="<?=URL?>Main/create_visitor">maak een bezoeker</a>
<table>	
	<tr>
		<th>naam</th>
		<th>adress</th>
		<th>telefoonnummer</th>
		<th>wijzigen</th>
		<th>verwijderen</th>
	</tr>
	<?php foreach ($data as $key => $value) { ?>
		<tr>
			<td><?= $value["name"];?></td>
			<td><?= $value["address"];?></td>
			<td><?= $value["telephone_number"];?></td>
			<td><a href="<?=URL?>employee/edit/<?= $value["id"];?>">Wijzigen</a></td>
			<td><a href="<?=URL?>employee/delete/<?= $value["id"];?>">Verwijderen</a></td>
		</tr>
	<?php } 
	// de opbouw van de link bepaald welke method in welke controller aangeroepen wordt.
	// het woordje "employee" in de url betekent dat het framework moet zoeken naar een controller genaamd "EmployeeController".
	// Hij maakt van de eerste letter een hoofdletter en plakt er zelf "Controller" achter.
	// Het woordje "update" of "delete" betekent dat hij in deze controller moet zoeken naar een method met deze naam.
	?>
</table>
