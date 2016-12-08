<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="description" content="Forum ogólnotematyczne" />
	<meta name="keywords" content="forum, muzyka, filmy, sztuka, gry" />
	<meta name="author" content="Mariusz Wisniewski" />
	<title>Świat sztuki</title>
	<link rel="stylesheet" href="glowna.css?ts=<?=time()?>&quot;" type="text/css" />
</head>
<body>
	<section class="oprawa">
		<header>
			<ul>
				<li><a href="index.php">Index</a></li>
				<li><a href="tworz_temat.php">Twórz temat</a></li>
				<li>
					<?php
						session_start();
						if (!(isset($_SESSION['login']))) {
							echo '<a href="zaloguj.php">Zaloguj się</a>';
						}	
						else {
							echo  '<a href="wyloguj.php">Witaj ' . $_SESSION["user"] . '! (Wyloguj)</a>';
						}
					?>
				</li>
			<ul>	
		</header>
		<section class="zawartosc">	