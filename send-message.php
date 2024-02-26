<?php
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
    require_once 'vendor/autoload.php';
    use Twilio\Rest\Client;

    $sid    = "AC7bd274bd36d13dc3b46485f42381b8c1";
    $token  = "91e4445b631cec218b8a82b5c3ef0409";
    $twilio = new Client($sid, $token);
    $otp = rand(1000, 9999);

    $message = $twilio->messages
      ->create("+917972666011", // to
        array(
          "from" => "+14159699135",
          "body" => "Your OTP is " .$otp
        )
      );

print($message->sid);