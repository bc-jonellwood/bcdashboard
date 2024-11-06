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
                            <div class="component-header">Did you know? <button class="not-btn" onclick="minimizeCard(\'8dd2ea8e-560b-48a9-9a5f-1f152cafaa9c\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>';
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
