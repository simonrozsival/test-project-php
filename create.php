<?php

$app = require "./core/app.php";

// Create new instance of user
$user = new User($app->db);

function sanitize_input($value) {
	return trim(htmlspecialchars($value));
}

$name = sanitize_input($_POST['name']);
$email = sanitize_input($_POST['email']);
$city = sanitize_input($_POST['city']);

$errors = [];

if (empty($name)) {
	$errors["name"] = "Please enter a name.";
}

if (empty($city)) {
	$errors["city"] = "Please enter a city.";
}

if (empty($email)) {
	$errors["email"] = "Please enter an email address.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors["email"] = "Please enter a valid email address.";
}

if (empty($errors)) {
	// Insert it to database with POST data
	$user->insert(array(
		'name' => $name,
		'email' => $email,
		'city' => $city
	));

	// Redirect back to index
	header('Location: index.php?result=success');
} else {
	$query = http_build_query([
		"result" => "error",
		"error" => $errors,
		"values" => [
			"name" => $name,
			"email" => $email,
			"city" => $city
		]
	]);

	header("Location: index.php?$query");
}
