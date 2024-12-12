<?php
include './API/createGUID.php';



function fetchFact()
{
    // $url = "https://uselessfacts.jsph.pl/random.json?language=en";


    // $ch = curl_init($url);

    // Set options
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request pew pew pew
    // $response = curl_exec($ch);
    // echo $response;
    // Check for errors
    // if (curl_errno($ch)) {
    //     // Handle cURL error
    //     echo 'cURL Error: ' . curl_error($ch);
    //     curl_close($ch);
    //     return;
    // }

    // Close the cURL session
    // curl_close($ch);

    // Decode the JSON response
    // $data = json_decode($response, true);
    $data = json_decode(getTestJson(), true);
    // echo $data;
    // Check if the data is valid
    // if (json_last_error() !== JSON_ERROR_NONE) {
    //     // Handle JSON decoding error
    //     echo 'JSON Decode Error: ' . json_last_error_msg();
    //     return;
    // }

    // Display the fact
    // get a count of the number of facts in the response then generate a random number between 0 and the count
    $count = count($data);
    $randomIndex = rand(0, $count - 1);
    $data = $data[$randomIndex];
    if (isset($data['text'])) {
        $html = '<div id="8dd2ea8e-560b-48a9-9a5f-1f152cafaa9c" class="dash-card narrow square">
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

function getTestJson()
{
    $testData = [
        [
            "index" => 1,
            "text" => "Iron Man was originally named Bucket Man, and he had no superpowers or friends."
        ],
        [
            "index" => 2,
            "text" => "L.L. Bean stands for Live.Laugh.Bean"
        ],
        [
            "index" => 3,
            "text" => "Zooery Deschanel does not appear in six episides of New Girl becuase she was put on unpaid leave for showing up to work without bangs."
        ],
        [
            "index" => 4,
            "text" => "It is impossible to blink while breathing."
        ],
        [
            "index" => 5,
            "text" => "Lumberjacks always chop the west side of a tree bacause trees always fall to the east."
        ],
        [
            "index" => 6,
            "text" => "The Pythagorean theorem mathmatically proves that triangles are the ugliest shape."
        ],
        [
            "index" => 7,
            "text" => "If an identical twin commits a crime, then both twins are arrested just to make sure the police didn't catch the wrong one."
        ],
        [
            "index" => 8,
            "text" => "Penguins can fly, but choose not becuase they have a fear of heights."
        ],
        [
            "index" => 9,
            "text" => "The first person to ever say 'I'm not a doctor, but I play one on TV' was a doctor."
        ],
        [
            "index" => 10,
            "text" => "You can chnage the order of the components on your dashboard from the settings menu."
        ],
    ];
    return json_encode($testData);
}
