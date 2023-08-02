<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiUrl = 'http://sms.gonlinesites.com/app/sms/api';
    $apiKey = 'REVJbHJiT2ZGeEt4SUpsS2JyZGs=';

    $phoneNumbers = $_POST['phone_numbers'];
    $senderId = $_POST['sender_id'];
    $message = $_POST['message'];

    // Convert phone numbers to an array
    $phoneNumbersArray = explode(',', $phoneNumbers);

    // Loop through each phone number and send SMS
    $results = [];
    foreach ($phoneNumbersArray as $phoneNumber) {
        $phoneNumber = trim($phoneNumber);
        if (!empty($phoneNumber)) {
            // Construct the API URL for sending a text/plain SMS
            $apiUrl .= '?action=send-sms';
            $apiUrl .= '&api_key=' . urlencode($apiKey);
            $apiUrl .= '&to=' . urlencode($phoneNumber);
            $apiUrl .= '&from=' . urlencode($senderId);
            $apiUrl .= '&sms=' . urlencode($message);

            // Send the API request
            $response = file_get_contents($apiUrl);

            if ($response !== false) {
                $results[$phoneNumber] = 'SMS sent successfully!';
            } else {
                $results[$phoneNumber] = 'Failed to send SMS.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk SMS Sender</title>
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        label {
            display: block;
            margin-top: 20px;
        }

        textarea,
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            display: block;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Mobile styles */
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 24px;
            }

            label {
                margin-top: 10px;
            }

            textarea,
            input[type="text"],
            input[type="submit"] {
                padding: 8px;
                font-size: 14px;
            }

            .go-home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .go-home-button:hover {
            background-color: #0056b3;
        }
        .contain {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 12vh;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bulk SMS Sender</h1>
        <h4>Use Sender ID: CEgroup5B</h4>
        <h4>Add Country Code: +233...</h4>
        <form method="post" action="">
            <label for="phone_numbers">Phone Numbers (separated by commas):</label>
            <textarea name="phone_numbers" id="phone_numbers" rows="4" cols="50" required></textarea>

            <label for="sender_id">Sender ID:</label>
            <input type="text" name="sender_id" id="sender_id" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" cols="50" required></textarea>

            <input type="submit" value="Send SMS">
        </form>
         <div class="contain">
        <a href="index.php" class="go-home-button">Go Home</a>
    </div>

        <?php if(isset($results)) { ?>
            <div class="result">
                <h2>Result:</h2>
                <?php foreach ($results as $phoneNumber => $result) { ?>
                    <p><?php echo $phoneNumber . ': ' . $result; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
