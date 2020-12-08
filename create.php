<?php

function sanitize_input($value) {
	return trim(htmlspecialchars($value));
}

function postParameter($name) {
	return isset($_POST, $name) ? sanitize_input($_POST[$name]) : "";
}

$name = postParameter("name");
$email = postParameter("email");
$city = postParameter("city");
$phone = postParameter("phone");

$errors = [];

if (empty($name)) {
	$errors["name"] = "Please enter a name.";
}

if (empty($city)) {
	$errors["city"] = "Please enter a city.";
}

if (empty($phone)) {
	$errors["phone"] = "Please enter a phone number.";
}

if (empty($email)) {
	$errors["email"] = "Please enter an email address.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors["email"] = "Please enter a valid email address.";
}

$data = [
	'name' => $name,
	'email' => $email,
	'city' => $city,
	'phone' => $phone
];

if (empty($errors)) {
	$app = require "./core/app.php";	
	$user = new User($app->db);
	$user->insert($data);

	header('Location: index.php?result=success');
} else {
	$query = http_build_query([
		"result" => "error",
		"error" => $errors,
		"values" => $data
	]);

	header("Location: index.php?$query");
}
