<?php

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

function getEmployee($value, $colum = "id"){
	try {
		$conn=openDatabaseConnection();

		$stmt = $conn->prepare("SELECT * FROM employees WHERE $colum = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();

		$result = $stmt->fetch();
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	$conn = null;
	return $result;
}

function createEmployee($data){
	// Maak hier de code om een medewerker toe te voegen
	$allPassed = check_array_exist($data);
	$exists = getEmployee($data["input_name"], "name");
	
	if (isset($exists) && empty($exists)) { //check of de employee niet al in de database staat.
		if ($allPassed && isset($data) && !empty($data)) { //check of alle data bestaat
			try {
				$conn=openDatabaseConnection();
		
				$stmt = $conn->prepare("INSERT INTO employees(name, age) VALUES (:name, :age)");

				$stmt->bindParam(':name', $data["input_name"]);
				$stmt->bindParam(':age', $data["input_age"]);
			
				$stmt->execute(); 
			}
			catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage();
			} 
		} else {
			echo "Er missen gegevens bij het aanmaken van de employee.";
		}     
	} else { //als de game al is ingepland op dezelfde tijd
		echo "De werknemer met de naam ". $data["input_name"] . " bestaat al.";
	}
}


function updateEmployee($data){
	// Maak hier de code om een medewerker te bewerken
	$allPassed = check_array_exist($data, array("input_name", "input_age", "id_employee"));
	$exists = getEmployee($data["input_name"], "name");
	
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
		echo "De werknemer met de naam ".$data["input_name"]." bestaat al.";
	}
}

function deleteEmployee($id){
	// Maak hier de code om een medewerker te verwijderen
	settype($id, "int");
	$exists = getEmployee($id);
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
$errors = [];

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
		if(array_key_exists($key, $validation)){
			if ($validation[$key] == "CST_VALIDATE_NAME") {
				$value = strtolower($value);
				$value = ucwords($value);
				if (preg_match("/^[a-zA-Z- ]*$/", $value)) {
					$newData[$key] = $value;
				} else {
					$errors[$key] = 'Alleen letters en spaties zijn toegestaan bij de input.';
				}
			} else {
				if(filter_var($newData[$key], $validation[$key])){
					$errors[$key] = 'Veld is incorrect';
				} elseif (filter_var($newData[$key], $validation[$key]) === 0 && $validation[$key] === FILTER_VALIDATE_INT) {
					# code...
				}
			}
		}
	}
 	return $newData;
}

// function formcontrole(){
// 	$data = [];
// 	$errors = [];
// 	$error_empty = "Het is verplicht om dit veld in te vullen.";
	
// 	if(!empty($_POST['id_employee']) && isset($_POST['submit_change'])) {
// 		$id_employee = trim_data($_POST['id_employee']);
// 		settype($id_employee, "int");
// 		$employee = getEmployee($id_employee);
	
// 		if (!is_numeric($id_employee) && isset($employee) && !empty($employee)) {
// 			$errors["id_employee"] = 'een employee met dit id bestaat niet.';
// 		} else {
// 			$data["id_employee"] = $id_employee;
// 		}
// 	} else {
// 		$errors["id_employee"] = 'geen id van de employee die hij aan moet passen meegestuurd.';
// 	}

// 	if (!empty($_POST['input_name'])) {
// 		$input_name = trim_data($_POST['input_name']);
// 		$input_name = strtolower($input_name);
// 		$input_name = ucwords($input_name);
// 		if (!preg_match("/^[a-zA-Z- ]*$/", $input_name)) {
// 			$errors["input_name"] = 'Alleen letters en spaties zijn toegestaan bij de input.';
// 		} else {
// 			$data["input_name"] = $input_name;
// 		}
// 	} else {
// 		$errors["input_name"] = $error_empty;
// 	}
	
// 	if(!empty($_POST['input_age'])) {
// 		$input_age = trim_data($_POST['input_age']);
// 		settype($input_age, "int");
// 		if (!is_numeric($input_age)) {
// 		$errors["input_age"] = 'De leeftijd moet een nummer zijn tussen de 1 en 120 jaar.';
// 		} else {
// 		$data["input_age"] = $input_age;
// 		}
// 	} else {
// 		$errors["input_age"] = $error_empty;
// 	}  
	
// 	$data["errors"] = $errors;
// 	return $data;
// } 

//trim data van formulier
function trim_data($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
	
// -------------------- andere/speciale functies ----------------
	
//checkt of alle key's in de array bestaan
function check_array_exist($array_check, $keys = array("input_name", "input_age")) {
	$allPassed = true;
	foreach($keys as $entry) {
		if(!isset($array_check[$entry]) || empty($array_check[$entry])) {
			$allPassed = false;
			break;
		}
	}
	return $allPassed;
}



