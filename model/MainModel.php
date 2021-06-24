<?php
//-------------------- connectie database checken ----------------
function checkConnection(){
	try{ 
		$conn = openDatabaseConnection(); 
		$stmt = $conn->prepare("SHOW TABLES");
		$stmt->execute();
		$result = $stmt->fetchAll();
		
	}catch(Exception $e){
		return false;
	}

	return true;
}

//-------------------- data ophalen uit de database functies ----------------
function getTables(){
	try{ 
		$conn = openDatabaseConnection(); 
		$stmt = $conn->prepare("SHOW TABLES");
		$stmt->execute();
		$result = $stmt->fetchAll();
		
	}catch(Exception $e){
		return false;
	}

	return $result;
}

function getColumns($table){
	$columns = [];
	$data = getTables();

	foreach ($data as $key => $value) {
		if ($table == $value["Tables_in_manege"]) {
			try {
				$conn = openDatabaseConnection(); 

				$stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME =:table");
				$stmt->bindParam(':table', $table);
				$stmt->execute();
				$result = $stmt->fetchAll();
				break;
			} catch(PDOException $e){ // Vang de foutmelding af
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}
	if ($result) {
		foreach($result as $key => $value) {
			foreach($value as $key => $value2) {
				$columns[$value2] = $value2;
			}
		}
	} 
	return $columns;
}

function getAllData($table){
	$data = getTables();
	foreach ($data as $key => $value) {
		if ($table == $value["Tables_in_manege"]) {
			try {
				$conn=openDatabaseConnection();
		
				$stmt = $conn->prepare("SELECT * FROM `$table`");
				$stmt->execute();
				$result = $stmt->fetchAll();
				break;
			} catch(PDOException $e){ // Vang de foutmelding af
				// Zet de foutmelding op het scherm
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}
	
	$conn = null;
	return $result;
}

function getData($table, $parameters, $multiple_rows = null){
	$data = getTables();
	foreach ($data as $key => $tables) {
		if ($table == $tables["Tables_in_manege"]) {
			try {
				$conn=openDatabaseConnection();

				$index = 0;
				$sql = "SELECT * FROM `$table` where";
				foreach ($parameters as $key => $value) {
					if($index == 0){
						$sql .= " `$key`".$value['operator'] .":$key";
					}
					else{
						$sql .= " AND `$key`".$value['operator'] .":$key";
					}
					$index++;
				}

				$stmt = $conn->prepare($sql);
				foreach ($parameters as $key => $value) {
					$stmt->bindParam(":$key", $value['value']);
				}
				$stmt->execute();
				$count = $stmt->rowCount();

				if($multiple_rows == null){
					if ($count == 1) {
						$result = $stmt->fetch();
					} else {
						$result = $stmt->fetchAll();
					}
				} else {
					if ($multiple_rows) {
						$result = $stmt->fetchAll();
					} else {
						$result = $stmt->fetch();
					}
				}
				break;
			} catch(PDOException $e){ // Vang de foutmelding af
				// Zet de foutmelding op het scherm
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}
	$conn = null;
	return $result;
} 
//-------------------- CRUD functies database ----------------
function create($data, $table){
	$columns = getColumns($table);
	$tables = getTables();
	unset($data["submit"]);
	unset($columns["id"]);
	$allPassed = check_array_exist($data, $columns);

	if ($table == "reservations") {
		$exists = getData($table, ["visitor" => ["operator" => "=", "value"=> $data["visitor"]], "animal" => ["operator" => "=", "value"=> $data["animal"]], "date_reservation" => ["operator" => "=", "value"=> $data["date_reservation"]]]);
	} else {
		$exists = getData($table, ["name" => ["operator" => "=", "value"=> $data["name"]]]);
	}
	
	foreach ($tables as $key => $tablenames) {
		if ($table == $tablenames["Tables_in_manege"]) {
			if (isset($exists) && empty($exists)) { //check of hij niet al in de database staat.
				if ($allPassed && isset($data) && !empty($data)) { //checkt of alle data bestaat
					try {
						$conn=openDatabaseConnection();

						$key = array_keys($data);  //get key(column name)
						
						$stmt = $conn->prepare("INSERT INTO `$table` (". implode(',' , $key) .") VALUES(:". implode(", :" , $key) .")");
						foreach ($data as $key => $value) {
							$stmt->bindParam(":$key", $data[$key]);
						}
						$stmt->execute(); 
					}
					catch(PDOException $e){
						echo "Connection failed: " . $e->getMessage();
					} 
				} else {
					echo "Er missen gegevens bij het aanmaken.";
				}     
			} else { //als de game al is ingepland op dezelfde tijd
				echo "In de tabel ".$table." bestaat de naam: " . $data["name"] . " al.";
			}
			break;
		}
	}

	
}


function update($data, $table){
	$columns = getColumns($table);
	$tables = getTables();
	unset($data["submit"]);
	$allPassed = check_array_exist($data, $columns);
	
	foreach ($tables as $key => $tablenames) {
		if ($table == $tablenames["Tables_in_manege"]) {
			if ($allPassed && isset($data) && !empty($data)) { //checkt of alle data bestaat
				try {
					$conn=openDatabaseConnection();
	
					$key_array = array_keys($data);  //get key(column name)
					unset($key_array[array_search("id",$key_array)]);
	
					$sql = "UPDATE `$table` SET ";
					foreach ($key_array as $key => $value) {
						if (array_key_last($key_array) == $key) {
							$sql .= $value . "=:" . $value . " ";
						} else {
							$sql .= $value . "=:" . $value . ", ";
						}
					}
					$sql .= "WHERE id=:id";
					$stmt = $conn->prepare($sql);
					foreach ($data as $key => $value) {
						$stmt->bindParam(":$key", $data[$key]);
					}
					$stmt->bindParam(":id", $data["id"]);
					$stmt->execute(); 
				}
				catch(PDOException $e){
					echo "Connection failed: " . $e->getMessage();
				} 
			} else {
				echo "Er missen gegevens bij het aanmaken.";
				print_r($data);
			}
			break;
		}
	}
}

function delete($data, $table){
	// Maak hier de code om een medewerker te verwijderen
	$tables = getTables();
	$id = $data["id"];
	$id = intval($id);
	$exists = getData($table, ["id" => ["operator" => "=", "value"=> $data["id"]]]);
	$column = substr($table, 0, -1);
	$reserveringen = getData("reservations", [$column => ["operator" => "=", "value"=> $id]]);

	foreach ($tables as $key => $tablenames) {
		if ($table == $tablenames["Tables_in_manege"]) {
			if (isset($id) && !empty($id) && is_numeric($id) && isset($exists) && !empty($exists)) { 
				if(empty($reserveringen)){
					try {
						$conn=openDatabaseConnection();
				
						$stmt = $conn->prepare("DELETE FROM `$table` WHERE id=:id");
						$stmt->bindParam(':id', $id);
						$stmt->execute(); 
					}
					catch(PDOException $e){
						echo "Connection failed: " . $e->getMessage();
					}
				} else {
					echo "Hij kan niet worden verwijderd, omdat hij reserveringen heeft.";
				} 
			} else {
				echo "Hij kan niet worden verwijderd, omdat hij niet bestaat of het id incorrect is.";
			}
		
			$conn = null;
			break;
		}
	}
}

// -------------------- form controle functies ----------------
define('CST_VALIDATE_NAME', 'CST_VALIDATE_NAME');
define('CST_VALIDATE_ADRESS', 'CST_VALIDATE_ADRESS');
define('CST_VALIDATE_PHONE', 'CST_VALIDATE_PHONE');
define('CST_VALIDATE_DATE', 'CST_VALIDATE_DATE'); 
$errors = [];

function formcontrole($data, $validation, &$errors){
	$newData = [];
	foreach($data as $key => $value){
		$newData[$key] = trim_data($value);
		if(!isset($data[$key]) || empty($data[$key])){
			$errors[$key] = 'Veld is verplicht';
		}
	}
 	foreach($newData as $key => $value){
		switch ($validation[$key]) {
			case $validation[$key][0] == 'CST_VALIDATE_ID':
				if(filter_var($value, FILTER_SANITIZE_NUMBER_INT)){
					$exists = getData($validation[$key][1], ["id" => ["operator" => "=", "value"=> $value]]);
					if (isset($exists) && !empty($exists)) {
						$newData[$key] = $value;
					} else {
						$errors[$key] = 'hij bestaat niet in de database';
					}
				}
			break;
			case 'CST_VALIDATE_NAME':
				$value = strtolower($value);
				$value = ucwords($value);
				if (preg_match("/^[a-zA-Z- ]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen letters en spaties zijn toegestaan bij de input.';
				}
			break;
			case 'CST_VALIDATE_ADRESS':
				if (preg_match("/^[a-zA-Z0-9- ]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Het adress is niet goed ingevuld. Hij moet bestaan uit een straat en straatnummer.';
				}
			break;
			case 'CST_VALIDATE_PHONE':
				if (preg_match("/^[0-9- ()]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen telefoonnummers zijn toegestaan bij de input.';
				}
			break;
			case 'CST_VALIDATE_DATE':
				// echo "value datetime: ";
				// var_dump($value);
				// // echo "<br>";
				// // echo "format: YYYY-MM-DDThh:mm <br> na checken if value datetime dezelfde format heeft als de format: ";
				// var_dump(validateDate($value, 'Y-m-d H:i'));
				// // echo "<br> error: ";
				// if (validateDate($value, 'Y-m-d H:i')) {
				// 	$newData[$key] = $value;
				// } else {
				// 	$errors[$key] = 'Alleen geldige datums zijn toegestaan bij de input.';
				// }
			break;
			case FILTER_VALIDATE_BOOLEAN:
				$filtered = filter_var($newData[$key], $validation[$key], FILTER_NULL_ON_FAILURE);
				if($filtered === null) {
					$errors[$key] = 'Veld is geen boolean, ' . $newData[$key];
				} 
			break;
			default:
				if(!filter_var($newData[$key], $validation[$key]) || ((filter_var($newData[$key], $validation[$key]) === 0 && $validation[$key] != (FILTER_VALIDATE_INT || FILTER_SANITIZE_NUMBER_INT)))){
					$errors[$key] = 'Veld is incorrect, ' . $newData[$key];
				}
			break;
		}
	}
 	return $newData;
}

//trim data van formulier
function trim_data($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
	
// -------------------- andere/speciale functies ----------------

//checkt of alle key's in de array bestaan
function check_array_exist($array_check, $keys = array("name", "address", "telephone_number")) {
	$allPassed = true;
	foreach($keys as $entry) {
		if(!isset($array_check[$entry]) || empty($array_check[$entry])) {
			$allPassed = false;
			break;
		}
	}
	return $allPassed;
}

function kost_berekening($aantal_uren) {
	settype($aantal_uren, "int");
	$kosten_uur = 55;
	if(filter_var($aantal_uren, FILTER_SANITIZE_NUMBER_INT) && filter_var($kosten_uur, FILTER_SANITIZE_NUMBER_INT) && $aantal_uren > 0 && $kosten_uur > 0){
		$kosten = $kosten_uur * $aantal_uren;
	}
	
	return $kosten;
}

function validateDate($date, $format = 'Y-m-dTH:i') {
    $d = DateTime::createFromFormat($format, $date);
	// echo ' {hoi' . $d . '} ';
	// echo $date .' '. $format.'<br>';
    return $d && $d->format($format) == $date;

	// $date = new DateTime($date);
	// echo '<br>{'. $date->format($format). '}<br>';
	// return $date->format($format) == $date;
}

// 'YYYY-MM-DDThh:mm'
