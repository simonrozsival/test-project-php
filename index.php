<?php

include "./views/input.php";

// Init app instance
$app = require "./core/app.php";

// Get all users from DB, eager load all fields using '*'
$users = User::find($app->db,'*');

$result = $_GET["result"];
$errors = $_GET["error"] ?? [];
$values = $_GET["values"] ?? [];

// Render view 'views/index.php' and pass users variable there
$app->renderView('index', array(
	'users' => $users,
	'result' => $result,
	'errors' => $errors,
	'values' => $values
));
