<?php

if(isset($_GET['email']) && !empty($_GET['email'])){
    $email = mysql_escape_string($_GET['email']); // Set email variable            
    $search = mysql_query("SELECT user_email, aktywacja FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error()); 
    $match  = mysql_num_rows($search);
                 
    if($match > 0){
        mysql_query("UPDATE users SET aktywacja='0' WHERE email='".$email."' AND aktywacja='0'") or die(mysql_error());
    }else{
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
    }
                 
}else{
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}
?>