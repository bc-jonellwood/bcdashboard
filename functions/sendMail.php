<?php
function sendmail($to, $subject, $jsonData)
{

    // decode the json and make sure its good
    $data = json_decode($jsonData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON decode error: ' . json_last_error());
    }

    // somehow figure out how to send the data we want and not the data we dont want
    $body = "An account request has been submitted:\n\n";
    foreach ($data as $key => $value) {
        $body .= ucfirst($key) . ": " . htmlspecialchars($value) . "\n";
    }

    $headers = "From: dashboard@berkekeleycountysc.gov\r\n" .
        "Reply-To: no-reply@berkeleycountysc.gov\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // Attempt to send the mail
    if (!mail($to, $subject, $body, $headers)) {
        throw new Exception('Email could be sent');
    }
    echo "Email was sent to $to with subject: $subject";
}
