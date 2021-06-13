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
	$animals = getAllData("animals");
    $horses = getData("animals", 147.5, "height", ">=");
    $ponys = getData("animals", 147.5, "height", "<");
    render('animals/index', ['animals' => $animals, 'horses' => $horses, 'ponys' => $ponys]);
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

//formulier data controleren en sturen naar de database om iets te maken 
function store_visitor() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = [];
        $data = formcontrole($_POST, ['name' => CST_VALIDATE_NAME, 'address' => CST_VALIDATE_ADRESS, 'telephone_number' => CST_VALIDATE_PHONE], $errors);
        if (empty($errors) && !empty($data)) {
            create($data, "visitors");
            index();
        } else {
            render('visitor/create', $data);
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
            print_r($errors);
            render('animals/create', $data);
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
            create($data, "visitors");
            index();
        } else {
            render('visitor/create', $data);
        }
    } 
}