<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiUrl = 'http://sms.gonlinesites.com/app/sms/api';
    $apiKey = 'REVJbHJiT2ZGeEt4SUpsS2JyZGs=';

    $phoneNumber = $_POST['phone_number'];
    $senderId = $_POST['sender_id'];
    $message = $_POST['message'];

    // Construct the API URL for sending a text/plain SMS
    $apiUrl .= '?action=send-sms';
    $apiUrl .= '&api_key=' . urlencode($apiKey);
    $apiUrl .= '&to=' . urlencode($phoneNumber);
    $apiUrl .= '&from=' . urlencode($senderId);
    $apiUrl .= '&sms=' . urlencode($message);

    // Send the API request
    $response = file_get_contents($apiUrl);

    if ($response !== false) {
        $result = 'SMS sent successfully!';
    } else {
        $result = 'Failed to send SMS.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Sender</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        textarea {
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
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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
        <h1>Single SMS Sender</h1>
        <h4>Use Sender ID: CEgroup5B</h4>
        <h4>Add Country Code: +233...</h4>
        <form method="post" action="">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <label for="sender_id">Sender ID:</label>
            <input type="text" name="sender_id" id="sender_id" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>

            <input type="submit" value="Send SMS">
        </form>
        <div class="contain">
        <a href="index.php" class="go-home-button">Go Home</a>
    </div>

        <?php if(isset($result)) { ?>
            <div class="result">
                <?php echo $result; ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
