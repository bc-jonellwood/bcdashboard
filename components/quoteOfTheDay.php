<?php
include './API/createGUID.php';
function fetchFact()
{
    // $url = "https://uselessfacts.jsph.pl/random.json?language=en";
    $url = "https://uselessfacts.jsph.pl/api/v2/facts/random?language=en";

    $ch = curl_init($url);

    // Set options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request pew pew pew
    $response = curl_exec($ch);
    // echo $response;
    // Check for errors
    if (curl_errno($ch)) {
        // Handle cURL error
        echo 'cURL Error: ' . curl_error($ch);
        curl_close($ch);
        return;
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);
    // echo $data;
    // Check if the data is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle JSON decoding error
        echo 'JSON Decode Error: ' . json_last_error_msg();
        return;
    }

    // Display the fact
    if (isset($data['text'])) {
        $html = '<div id="8dd2ea8e-560b-48a9-9a5f-1f152cafaa9c" class="dash-card narrow short">
                        <div class="card-content">
                            <div class="component-header">Did you know? <button class="not-btn" onclick="minimizeCard(\'8dd2ea8e-560b-48a9-9a5f-1f152cafaa9c\')"><img src="./icons/resize.svg" alt="resize" width="24" height="24" /></button></div>';
        $html .= "<p class='daily-quote'>Fact: " . htmlspecialchars($data['text']);
        $html .= '</p></div>
                    </div>';
        echo $html;
    } else {
        echo "Fact not found in the response.";
    }
}

// Call the function to fetch and display the fact
fetchFact();
