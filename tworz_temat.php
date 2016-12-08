<?php
include 'naglowek.php';
include 'laczenie.php';

if (!(isset($_SESSION['login']))){
	echo ('Musisz być zalogowany, aby dodawać tematy. <a href="zaloguj.php">zaloguj się</a> teraz.');
}
else {
if ($_SERVER['REQUEST_METHOD'] != 'POST'){
	$sql = "SELECT cat_name, cat_id FROM categories";
	$result = $conn -> query($sql);
	if (!$result){
		echo 'Błąd bazy danych, skontaktuj się z administratorem na admin@example.com';
	}
	else {	
	echo '<form method="POST" action="">
				<fieldset>
					<legend>Twórz temat: </legend>
					<div style="float:right; margin-right: 50px;">
						<h4>Pamiętaj o tych zasadach tworząc post:</h4>
						<ul>
							<li>Nie obrażaj innych</li>
							<li>Nie olinkuj podejrzanych stron</li>
							<li>Cenzuruj przekleństwa</li>
							<li>Itd.</li>
							<li>Itd.</li>
							<li>Itd.</li>
							<li>Itd.</li>
							<li>Itd.</li>
						<ul>	
					</div>
					<label for="temat">Temat:</label>
					<input type="text" name="temat" style="width: 368px;"/>
					<label for="kategorie">Wybierz kategorie: </label>
					<select name ="kategoria" style="width: 372px;height:25px">';
						if ($result->num_rows > 0) {
							while ($option = $result->fetch_assoc()){
								echo '<option value="' . $option['cat_id'] . '">' . $option['cat_name'] . '</option>';
							}
						}	
						else {	
							echo 'Brak kategorii';
						}
					echo '</select>
					<label for="tresc">Treść:</label>
					<textarea cols="50" rows="20" style="resize:none;" name="tresc"></textarea>
					<input type="submit" value="Twórz" id="tworz"/>
				</fieldset>
		</form>';
	}	
}
else{
		$stm = $conn-> prepare("INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by)
								VALUES (?, ?, ?, ?)");
		$stm->bind_param('ssii', $temat, $datetime, $kategoria, $login) ;
		$temat = mysql_real_escape_string($_POST['temat']);
		$kategoria = mysql_real_escape_string($_POST['kategoria']);
		$login = $_SESSION['user_id'];
		$datetime = date("Y-m-d H:i:s");
		$stm->execute();
		$temat2 = $conn->insert_id;		
		$stm->close();
		
		$stmt = $conn-> prepare("INSERT INTO posts(post_content, post_date, post_topic, post_by)
								VALUES (?,?,?,?)"); 
		$stmt->bind_param('ssii', $tresc2, $datetime2, $temat2, $login2);	
		$tresc2 = mysql_real_escape_string($_POST['tresc']);
		$datetime2 = date("Y-m-d H:i:s");
		$login2 = $_SESSION['user_id'];
		$stmt->execute();
		$stmt->close();
		$conn->close();
		
		header('Location: http://localhost/posty.php?id=' . $temat2 .'');
		exit();	
	}
}
include 'stopka.php';
?>