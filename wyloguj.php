<?php
include 'laczenie.php';

session_start();
session_destroy();

$conn->close();

header('Location: http://localhost');

?>