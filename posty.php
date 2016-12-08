<?php
include 'naglowek.php';
include 'laczenie.php';


if($_SERVER['REQUEST_METHOD'] != 'POST'){
	$sql = "SELECT posts.post_id, posts.post_by, posts.post_topic, posts.post_date, posts.post_content, users.user_name, users.user_id FROM posts
		LEFT JOIN users ON posts.post_by = users.user_id
		WHERE posts.post_topic =" . mysql_real_escape_string($_GET['id']) . "";
		
	$result = $conn -> query($sql);

	echo '<table>
		<thead>
			<tr>
				<th>Dane:</th>
				<th>Treść</th>
			</tr>
		</thead>	
		<tbody>';
			while($dane = $result ->fetch_assoc()) {
				echo '<tr><td>' . $dane['user_name'] . '<br/> ' . $dane['post_date'] . '</td>
					  <td>' . $dane['post_content'] . '</td></tr>';  
			}
	echo'</tbody>
	</table>';	
	echo '<form method="POST" action="">
				<fieldset>
					<legend>Dodaj odpowiedź: </legend>
					<label for="tresc">Treść:</label>
					<textarea cols="100" rows="5" style="resize:none;" name="tresc_postu"></textarea>
					<input type="submit" value="Odpowiedz" id="tworz"/>
				</fieldset>
		</form>';
}
else {
	if (!(isset($_SESSION['login']))){
	echo ('Musisz być zalogowany, aby dodawać odpowiedzi. <a href="zaloguj.php">zaloguj się</a> teraz.');
	}
	else {
	$stm = $conn -> prepare("INSERT INTO posts(post_by, post_content, post_date, post_topic)
							 VALUES (?,?,?,?)");
	if(!($stm -> bind_param('issi', $login, $content, $date, $topic))){
		echo $conn->error;
	}
	$login = $_SESSION['user_id'];
	$content = mysql_real_escape_string($_POST['tresc_postu']);
	$date = date("Y-m-d H:i:s");
	$topic = mysql_real_escape_string($_GET['id']);
	$stm -> execute();
	$stm -> close();	
	header("Refresh:0");
	exit();
	}
}
include 'stopka.php';
?>