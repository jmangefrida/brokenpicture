<?php

//$to      = 'nobody@example.com';
//$subject = 'the subject';
//$message = 'hello';
$headers = 'From: gamemaster@brokenpicture.com' . "\r\n" .
    'Reply-To: gamemaster@brokenpicture.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

//mail($to, $subject, $message, $headers);

if(mail($nextplayer,"Your turn",$url,$headers))
print "Email successfully sent";
else
print "An error occured";
?>