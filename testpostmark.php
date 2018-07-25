<?php

// Import the Postmark Client Class:
require_once('/vendor/autoload.php');
use Postmark\PostmarkClient;

$client = new PostmarkClient("f1d91cb7-b9b9-417f-8b9c-a687f5df9356");

// Send an email:
$sendResult = $client->sendEmail(
  "webmaster@moneyfinancetracking.com",
  "webmaster@moneyfinancetracking.com",
  "Hello from Postmark!",
  "This is just a friendly 'hello' from your friends at Postmark."
);

?>