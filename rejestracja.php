<?php	
include 'naglowek.php';
include 'laczenie.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') { //Formularz rejestracji
	echo '<form name="mojFormularz" onsubmit="return validateForm()" method="post" action="">
			<fieldset style="width:15%;">
				Nazwa użytkownika: <input type="text" name="user_name">
				Hasło: <input type="password" name="user_pass">
				Powtórz hasło: <input type="password" name="user_pass_check">
				E-mail: <input type="email" name="user_email">
				<input type="submit" value="Rejestruj!" />
			</fieldset>	
		</form>'; 
	 }
else {
	$errors = array();  //tablica błędów
	
	if(isset($_POST['user_name']) && $_POST['user_name'] !== "") { 			//sprawdź czy puste
        if(!ctype_alnum($_POST['user_name'])) { 		//jeśli nie puste, sprawdź czy afanumeryczne
			$errors[] = 'Nazwa uzytkownika może zawierać tylko litery i cyfry';
		}
        if(strlen($_POST['user_name']) > 30) { 		//jeśli nie puste, sprawdź długość
            $errors[] = 'Nazwa użytkownika nie może być dłuższa niż 30 znaków.';
        }
    }
    else {
        $errors[] = 'Pole nazwa użytkownka nie może być puste'; 
    }
     
    if(isset($_POST['user_pass']) && $_POST['user_pass'] !=="" && 
	   isset($_POST['user_pass_check']) && $_POST['user_pass_check'] !=="") {   //sprawdź czy puste
        if($_POST['user_pass'] != $_POST['user_pass_check']) {  //jeśli nie puste, sprawdź czy się zgadzają
            $errors[] = 'Hasła nie zgadzają się';
        }
    }
    else {
        $errors[] = 'Pole hasło i powtórz hasło nie może być puste';
    }
     
    if(!empty($errors)) { //jeśli są błędy, to wyświetl
        echo 'Podano nie prawidłowe wartości';
        echo '<ul>';
        foreach($errors as $key => $value) //wyświetl wszystkie błędy
        {
            echo '<li>' . $value . '</li>'; //lista
        }
        echo '</ul>';
		echo '<a href="">Powrót</a><br/><br/>';
    }
    else{
	$stm = $conn->prepare("INSERT INTO users(user_name, user_pass, user_email ,user_date, user_level) VALUES(?, ?, ?, ?, ?)");
	$stm ->bind_param('ssssi',$login, $pass, $email, $date, $lvl, $akt);
	$login = mysql_real_escape_string($_POST['user_name']);
	$pass = sha1($_POST['user_pass']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$date = date("Y-m-d H:i:s");
	$lvl = 0;
    $stm->execute();
	$stm->close();	
	header('Location: http://localhost');
	exit();	
	}
}
include 'stopka.php';
?>