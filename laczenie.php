<?php
$conn = new mysqli("localhost", "user", "user123", "forum");

if ($conn->connect_error) {
	die('Błąd połączenia z bazą: ' . $conn->connect_error);
}

?>
