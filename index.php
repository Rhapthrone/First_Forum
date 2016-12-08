<?php
include 'naglowek.php';
include 'laczenie.php';

$cat = "SELECT * FROM categories";		//Wybór kategorii
$result_cat = $conn -> query($cat);	

echo '<table>
		<thead>
			<tr>
				<th>Kategoria: </th>
				<th>Ostatni temat: </th>
				<th>Liczba tematów: </th>
				<th>Liczba odpowiedzi: </th>
			</tr>
		</thead>	
		<tbody>';
			while($dane_cat = $result_cat->fetch_assoc()){
				echo '<tr><td><a href="tematy.php?id= ' . $dane_cat["cat_id"] . '">' . $dane_cat["cat_name"] . '</a></td>'; //kategoria
						
						//Wybór najnowszego tematu
						$top = "SELECT topic_id, topic_cat, topic_date, topic_subject, topic_by FROM topics WHERE topic_cat=" . $dane_cat['cat_id'] . "
								ORDER BY topic_id DESC LIMIT 1"; 													
						$result_top = $conn -> query($top);
						$dane_top = $result_top->fetch_assoc();
						$user = "SELECT user_name FROM users WHERE user_id=" . $dane_top['topic_by'] . "";
						$res_use = $conn ->query($user);
						$user = $res_use->fetch_assoc();
				echo '<td>' . $dane_top['topic_subject'] . '<br/>' . $dane_top['topic_date'] . '<br/>' . $user['user_name'] . '</td>'; 
						
						//Wybór ilosci tematów					
						$liczba_top = "SELECT COUNT(DISTINCT topic_id) AS LT FROM topics WHERE topic_cat=" . $dane_cat['cat_id'] . "";
						$result_lt = $conn -> query($liczba_top);
						$lt = $result_lt->fetch_assoc();
				echo '<td>' . $lt['LT'] . '</td>'; 
						
						//Wybór ilości odpowiedzi
						$LP2 = 0;
						$pomoc = "SELECT topic_id FROM topics WHERE topic_cat=" . $dane_cat['cat_id'] . "";		
						$result_pomoc = $conn -> query($pomoc);
							while($pomoc2 = $result_pomoc->fetch_assoc()){	
								$liczba_post = "SELECT COUNT(post_id) AS LP FROM posts WHERE post_topic=" . $pomoc2['topic_id'] . "";
								$result_lp = $conn -> query($liczba_post);
								$lp = $result_lp->fetch_assoc();
								$LP2 = $LP2 + $lp['LP']; 
						}
				echo '<td>' . $LP2 . '</td>'; 
			}
   echo'</tbody>
	</table>';	
	
include 'stopka.php';
?>