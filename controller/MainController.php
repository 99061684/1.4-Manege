<?php
require(ROOT . "model/MainModel.php");


// function index()
// {
// 	$connection = checkConnection();
//     render('visitor/index', ['connection' => $connection]);
// }

//overzichten weergeven 
function index() {
	$visitors = getAllData("visitors");
    render('visitor/index', $visitors);
}

function overzicht_animals() {
    $horses = getData("animals", ["height" => ["operator" => ">=", "value"=> 147.5]]);
    $ponys = getData("animals", ["height" => ["operator" => "<", "value"=> 147.5]], true);
    render('animals/index', ['horses' => $horses, 'ponys' => $ponys]);
}

function overzicht_reservations() {
	$reservations = getAllData("reservations");
    render('reservations/index', $reservations);
}

//het formulier weergeven om te iets te maken. 
function create_visitor() {
	render('visitor/create');
}

function create_animals() {
	render('animals/create');
}

function create_reservations() {
    $visitors = getAllData("visitors");
    $animals = getAllData("animals");
	render('reservations/create', ['animals' => $animals, 'visitors' => $visitors, 'kosten_rit' => $kosten_rit]);
}

//het formulier weergeven om te iets te updaten. 
function edit_visitor($id) {
    $visitor = getData("visitors", ["id" => ["operator" => "=", "value"=> $id]]);
	render('visitor/update', $visitor);
}

function edit_animal($id) {
    $animal = getData("animals", ["id" => ["operator" => "=", "value"=> $id]]);
	render('animals/update', $animal);
}

function edit_reservation($id) {
    $reservation = getData("reservations", ["id" => ["operator" => "=", "value"=> $id]]);
    $visitors = getAllData("visitors");
    $animals = getAllData("animals");
	render('reservations/update', ['animals' => $animals, 'visitors' => $visitors, 'reservation' => $reservation]);
}

//het formulier weergeven om te iets te verwijderen. 
function delete_visitor($id) {
    $visitor = getData("visitors", ["id" => ["operator" => "=", "value"=> $id]]);
	render('visitor/delete', $visitor);
}

function delete_animal($id) {
    $animal = getData("animals", ["id" => ["operator" => "=", "value"=> $id]]);
	render('animals/delete', $animal);
}

function delete_reservation($id) {
    $reservation = getData("reservations", ["id" => ["operator" => "=", "value"=> $id]]);
	render('reservations/delete', $reservation);
}

//formulier data controleren en sturen naar de database om iets te maken 
function store_visitor() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $data = formcontrole($_POST, ['name' => CST_VALIDATE_NAME, 'address' => CST_VALIDATE_ADRESS, 'telephone_number' => CST_VALIDATE_PHONE], $errors);
        if (empty($errors) && !empty($data)) {
            create($data, "visitors");
            index();
        } else {
            render('visitor/create', ["data" => $data, "errors" => $errors]);
        }
    } 
}

function store_animals() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $data = formcontrole($_POST, ['name' => CST_VALIDATE_NAME, 'race' => CST_VALIDATE_NAME, 'age' => FILTER_SANITIZE_NUMBER_INT, 'height' => FILTER_SANITIZE_NUMBER_INT, 'show_jumping' => FILTER_VALIDATE_BOOLEAN], $errors);
        if (empty($errors) && !empty($data)) {
            create($data, "animals");
            index();
        } else {
            render('animals/create', ["data" => $data, "errors" => $errors]);
        }
    } 
}

function store_reservations() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'visitors'];
        $CST_VALIDATE_ID2 = ['CST_VALIDATE_ID', 'animals'];
        $data = formcontrole($_POST, ['visitor' => $CST_VALIDATE_ID1, 'animal' => $CST_VALIDATE_ID2, 'date_reservation' => CST_VALIDATE_DATE, 'time_duration' => FILTER_SANITIZE_NUMBER_INT], $errors);
        if (empty($errors) && !empty($data)) {
            $data["costs"] = kost_berekening($data["time_duration"]);
            create($data, "reservations");
            index();
        } else {
            print_r($errors);
            render('reservations/create', $data);
        }
    } 
}

//formulier data controleren en sturen naar de database om iets te updaten 
function update_visitor() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'visitors'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID1, 'name' => CST_VALIDATE_NAME, 'address' => CST_VALIDATE_ADRESS, 'telephone_number' => CST_VALIDATE_PHONE], $errors);
        
        if (empty($errors) && !empty($data)) {
            update($data, "visitors");
            index();
        } else {
            render('visitor/update', ["data" => $data, "errors" => $errors]);
        }
    } 
}

function update_animal() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'animals'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID1, 'name' => CST_VALIDATE_NAME, 'race' => CST_VALIDATE_NAME, 'age' => FILTER_SANITIZE_NUMBER_INT, 'height' => FILTER_SANITIZE_NUMBER_INT, 'show_jumping' => FILTER_VALIDATE_BOOLEAN], $errors);
        
        if (empty($errors) && !empty($data)) {
            update($data, "animals");
            index();
        } else {
            render('animals/update', ["data" => $data, "errors" => $errors]);
        }
    } 
}

function update_reservation() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'visitors'];
        $CST_VALIDATE_ID2 = ['CST_VALIDATE_ID', 'animals'];
        $CST_VALIDATE_ID3 = ['CST_VALIDATE_ID', 'reservations'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID3, 'visitor' => $CST_VALIDATE_ID1, 'animal' => $CST_VALIDATE_ID2, 'date_reservation' => CST_VALIDATE_DATE, 'time_duration' => FILTER_SANITIZE_NUMBER_INT], $errors);
        
        if (empty($errors) && !empty($data)) {
            $data["costs"] = kost_berekening($data["time_duration"]);
            update($data, "reservations");
            index();
        } else {
            print_r($errors);
            render('reservations/update', $data);
        }
    } 
}

//formulier data controleren en sturen naar de database om iets te updaten 
function destroy_visitor() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'visitors'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID1, 'radio_delete' => FILTER_VALIDATE_BOOLEAN], $errors);
        
        $filtered = filter_var($data["radio_delete"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (empty($errors) && !empty($data) && $filtered == true) {
            delete($data, "visitors");
            index();
        } elseif (empty($errors) && !empty($data) && $filtered == false){
            index();
        } else {
            print_r($errors);
            delete_animal($data["id"]);
        }
    } 
}

function destroy_animal() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'animals'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID1, 'radio_delete' => FILTER_VALIDATE_BOOLEAN], $errors);
        
        $filtered = filter_var($data["radio_delete"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (empty($errors) && !empty($data) && $filtered == true) {
            delete($data, "animals");
            index();
        } elseif (empty($errors) && !empty($data) && $filtered == false){
            index();
        } else {
            print_r($errors);
            delete_animal($data["id"]);
        }
    } 
}

function destroy_reservation() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $CST_VALIDATE_ID1 = ['CST_VALIDATE_ID', 'reservations'];
        $data = formcontrole($_POST, ['id' => $CST_VALIDATE_ID1, 'radio_delete' => FILTER_VALIDATE_BOOLEAN], $errors);
        
        $filtered = filter_var($data["radio_delete"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (empty($errors) && !empty($data) && $filtered == true) {
            delete($data, "reservations");
            index();
        } elseif (empty($errors) && !empty($data) && $filtered == false){
            index();
        } else {
            print_r($errors);
            delete_animal($data["id"]);
        }
    } 
}

