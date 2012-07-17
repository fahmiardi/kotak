<?php
function html($text) {

	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text, $escape=TRUE) {
	if($escape) {
		echo html($text);
	}
	else {
		echo $text;
	}
}

function valid_email($address)
	{
		if($address != "") {
			return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
		}
		else {
			return TRUE;
		}
	}

function send_email($recipient, $subject = 'Test email', $message = 'Hello World')
	{
		return mail($recipient, $subject, $message);
	}

function changeDate($datetime) {
	$explode = explode(" ", $datetime);
	$date = explode("-", $explode[0]);
	echo $date[2]."/".$date[1]."/".$date[0]." ".$explode[1];
}
?>
