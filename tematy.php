<?php
include 'naglowek.php';
include 'laczenie.php';

$sql = "SELECT topics.topic_id, topics.topic_by, topics.topic_cat, topics.topic_date, topics.topic_subject, users.user_name, users.user_id FROM topics
		LEFT JOIN users ON topics.topic_by = users.user_id
		WHERE topics.topic_cat =" . mysql_real_escape_string($_GET['id']) . "";
		
$result = $conn -> query($sql);

echo '<table>
		<thead>
			<tr>
				<th>Temat: </th>
				<th>Informacje: </th>
			</tr>
		</thead>	
		<tbody>';
			while($dane = $result ->fetch_assoc()) {
				echo '<tr><td><a href="posty.php?id= ' . $dane['topic_id'] . '">' . $dane['topic_subject'] . '</a></td>
					  <td>' . $dane['user_name'] . '<br/> ' . $dane['topic_date'] . '</td>';  
			}
echo'</tbody>
</table>';	


include 'stopka.php';
?>