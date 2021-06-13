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

function getData($table, $value, $colum = "id", $operators = "="){
	$data = getTables();
	foreach ($data as $key => $tables) {
		if ($table == $tables["Tables_in_manege"]) {
			try {
				$conn=openDatabaseConnection();

				switch($operators){
					case ">=": 
						$stmt = $conn->prepare("SELECT * FROM `$table` WHERE $colum >= :value");
					break;
					case "<=":
						$stmt = $conn->prepare("SELECT * FROM `$table` WHERE $colum <= :value");
					break;
					case ">":
						$stmt = $conn->prepare("SELECT * FROM `$table` WHERE $colum > :value");
					break;
					case "<":
						$stmt = $conn->prepare("SELECT * FROM `$table` WHERE $colum < :value");
					break;
					default:
					$stmt = $conn->prepare("SELECT * FROM `$table` WHERE $colum = :value");				  
				}
				$stmt->bindParam(":value", $value);
				$stmt->execute();
				
				if ($colum == "height") {
					$result = $stmt->fetchAll();
				} else {
					$result = $stmt->fetch();
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
	unset($data["submit"]);
	unset($columns["id"]);
	$allPassed = check_array_exist($data, $columns);
	$exists = getData($table, $data["name"], "name");
	
	if (isset($exists) && empty($exists)) { //check of hij niet al in de database staat.
		if ($allPassed && isset($data) && !empty($data)) { //checkt of alle data bestaat
			try {
				$conn=openDatabaseConnection();

				$key = array_keys($data);  //get key(column name)
				$value = array_values($data);  //get values (values to be inserted)		
				$stmt = $conn->prepare("INSERT INTO `$table` ( ". implode(',' , $key) .") VALUES('". implode("','" , $value) ."')");
			
				$stmt->execute(); 
			}
			catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage();
			} 
		} else {
			echo "Er missen gegevens bij het aanmaken.";
			print_r($data);
		}     
	} else { //als de game al is ingepland op dezelfde tijd
		echo "In de tabel ".$table." bestaat de naam: " . $data["name"] . " al.";
	}
}

function updateEmployee($data, $table){
	// Maak hier de code om een medewerker te bewerken
	$allPassed = check_array_exist($data);
	$exists = getData($table, $data["name"], "name");
	
	if (isset($exists) && (empty($exists) || $exists["id"] == $data["id_employee"])) { //check of de employee niet al in de database staat.
		if ($allPassed && isset($data) && !empty($data)) { //check of alle data bestaat
			try {
				$conn=openDatabaseConnection();
		
				$stmt = $conn->prepare("UPDATE employees SET name=:name, age=:age WHERE id=:id");
	
				$stmt->bindParam(':name', $data["input_name"]);
				$stmt->bindParam(':age', $data["input_age"]);
				$stmt->bindParam(':id', $data["id_employee"]);
			
				$stmt->execute(); 
			}
			catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage();
			} 
		} else {
			echo "Er missen gegevens bij het aanpassen van de employee.";
		}     
	} else { //als de game al is ingepland op dezelfde tijd
		echo "De werknemer met de naam ".$data["name"]." bestaat al.";
	}
}

function deleteEmployee($id){
	// Maak hier de code om een medewerker te verwijderen
	settype($id, "int");
	$exists = getData($table, $data["name"], "name");
	if (isset($id) && !empty($id) && is_numeric($id) && isset($exists) && !empty($exists)) { 
		try {
			$conn=openDatabaseConnection();
	
			$stmt = $conn->prepare("DELETE FROM employees WHERE id=:id");
			$stmt->bindParam(':id', $id);
			$stmt->execute(); 
		}
		catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		} 
	} else {
		echo "De employee kan niet worden verwijderd, omdat hij niet bestaat of het id incorrect is.";
	}

	$conn = null;
}

// -------------------- form controle functies ----------------
define('CST_VALIDATE_NAME', 'CST_VALIDATE_NAME');
define('CST_VALIDATE_ADRESS', 'CST_VALIDATE_ADRESS');
define('CST_VALIDATE_PHONE', 'CST_VALIDATE_PHONE');
// $errors = [];

// $array = ["name" => "bas VErdoorn"];
// $data = formcontrole($array, ['name' => CST_VALIDATE_NAME,'age' => FILTER_VALIDATE_INT, 'email' => FILTER_VALIDATE_EMAIL], $errors);

function formcontrole($data, $validation, &$errors){
	$newData = [];
	foreach($data as $key => $value){
		$newData[$key] = trim_data($value);
		if(!isset($data[$key]) || empty($data[$key])){
			$errors[$key] = 'Veld is verplicht';
		}
	}
 	foreach($newData as $key => $value){
		echo $key;
		echo $validation[$key];
		switch ($validation[$key]) {
			case 'CST_VALIDATE_ID':
				// if(filter_var($value, FILTER_SANITIZE_NUMBER_INT) && $value > 0){
				// 	$exists = getData($table, $data["name"], "name");
				// }
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
				if (validateDate($value, $format = 'd-m-Y H:i')) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen geldige datums zijn toegestaan bij de input.';
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
			default:
				if(!filter_var($newData[$key], $validation[$key]) || ((filter_var($newData[$key], $validation[$key]) === 0 && $validation[$key] != (FILTER_VALIDATE_INT || FILTER_SANITIZE_NUMBER_INT)))){
					$errors[$key] = 'Veld is incorrect';
				}
			break;
		}
		if(array_key_exists($key, $validation)){
			if ($validation[$key] == "CST_VALIDATE_NAME") {
				$value = strtolower($value);
				$value = ucwords($value);
				if (preg_match("/^[a-zA-Z- ]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen letters en spaties zijn toegestaan bij de input.';
				}
			} elseif ($validation[$key] == "CST_VALIDATE_ADRESS") {
				if (preg_match("/^[a-zA-Z0-9- ]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Het adress is niet goed ingevuld. Hij moet bestaan uit een straat en straatnummer.';
				}
			} elseif ($validation[$key] == "CST_VALIDATE_PHONE") {
				if (preg_match("/^[0-9- ()]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen telefoonnummers zijn toegestaan bij de input.';
				}
			} else {
				if(!filter_var($newData[$key], $validation[$key]) || ((filter_var($newData[$key], $validation[$key]) === 0 && $validation[$key] != (FILTER_VALIDATE_INT || FILTER_SANITIZE_NUMBER_INT)))){
					$errors[$key] = 'Veld is incorrect';
				}
			}
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

function validateDate($date, $format = 'd-m- H:i') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

var_dump(validateDate('2012-02-28 12:12'));
