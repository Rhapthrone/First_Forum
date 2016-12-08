<?php
include 'naglowek.php';
include 'laczenie.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<form method="post" action="">
				<fieldset style="width: 20%;">
					Nazwa użytkownika: <input type="text" name="user_name">
					Hasło: <input type="password" name="user_pass">
					<input type="submit" value="Zaloguj">
					<p>Nie masz jeszcze konta? <a href="rejestracja.php">zarejestruj się</a> teraz</p>
				</fieldset>
          </form>';
    }
else {
	$stm = $conn ->prepare("SELECT user_id, user_name, user_level FROM users WHERE user_name = ? AND user_pass = ?");
    $stm -> bind_param('ss', $login, $password);
	$login = mysql_real_escape_string($_POST['user_name']);                     
	$password = sha1($_POST['user_pass']);
	$stm -> execute();
    $_SESSION['login'] = true;   
	$res = $stm->get_result(); 
	while($dane = $res ->fetch_assoc()) {
		$_SESSION['user_id'] = $dane['user_id'];
		$_SESSION['user'] = $dane['user_name'];
		$_SESSION['user_level'] = $dane['user_level'];
	}
	$stm-> close();
	header('Location: http://localhost');
	exit();
}

include 'stopka.php';
?>