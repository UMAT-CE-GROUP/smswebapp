<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CUSTOM SMS</title>
  <!-- Add Bootstrap CSS link -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Custom CSS to center the title and buttons */
    .container {
      text-align: center;
    }
    /* Custom CSS for mobile view */
    @media (max-width: 576px) {
      .form-group {
        margin-bottom: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4">SEND CUSTOM SMS</h1>
    <h5 class="mb-4">Do you need API & Sender ID, Call us on +233546124691</h5>
    <?php
    // Function to send an SMS using the provided API
    function sendSMS($api_key, $message, $sender_id, $recipients) {
      // Construct the API URL for sending SMS
      $url = "https://api.smsonlinegh.com/v4/message/sms/send";

      // Prepare the data for the API request
      $data = array(
        "key" => $api_key,
        "text" => $message,
        "type" => 0,
        "sender" => $sender_id,
        "to" => $recipients
      );

      // Set the content type
      $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json"
      );

      // Initialize cURL session for sending SMS
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);

      // Check for cURL errors for sending SMS
      if (curl_errno($ch)) {
        echo "<div class='alert alert-danger mt-4'>Error sending SMS: " . curl_error($ch) . "</div>";
      } else {
        // Close cURL session for sending SMS
        curl_close($ch);

        // Process the API response for sending SMS
        $json_response = json_decode($response, true);

        // Check if SMS sent successfully
        if (isset($json_response['handshake']['id']) && $json_response['handshake']['id'] === 0) {
          echo "<div class='alert alert-success mt-4'>SMS sent successfully!</div>";
        } else {
          echo "<div class='alert alert-danger mt-4'>Failed to send SMS.</div>";
        }
      }
    }

    // Function to check SMS balance using the provided API
    function checkBalance($api_key) {
      // Construct the API URL for balance retrieval
      $balance_url = "https://api.smsonlinegh.com/v4/report/balance";

      // Set the content type and authorization header
      $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json",
        "Authorization: key " . $api_key
      );

      // Initialize cURL session for balance retrieval
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $balance_url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $balance_response = curl_exec($ch);

      // Check for cURL errors for balance retrieval
      if (curl_errno($ch)) {
        echo "<div class='alert alert-danger mt-4'>Error retrieving balance: " . curl_error($ch) . "</div>";
      } else {
        // Close cURL session for balance retrieval
        curl_close($ch);

        // Process the API response for balance retrieval
        $json_response = json_decode($balance_response, true);

        // Check if balance retrieval was successful
        if (isset($json_response['handshake']['id']) && $json_response['handshake']['id'] === 0) {
          $balance_data = $json_response['data']['balance'];
          $amount = $balance_data['amount'];
          $currencyName = $balance_data['currencyName'];
          $currencyCode = $balance_data['currencyCode'];

          echo "<div class='alert alert-info mt-4'>Your SMS balance is: $amount $currencyCode ($currencyName)</div>";
        } else {
          echo "<div class='alert alert-danger mt-4'>Failed to retrieve SMS balance.</div>";
        }
      }
    }

    // Function to save the balance API key to local storage
    function saveBalanceAPI($api_key) {
      // Save the balance API key to local storage
      if ($api_key) {
        echo "<script>localStorage.setItem('balanceAPI', '$api_key');</script>";
      }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      // Send SMS logic
      $api_key = $_POST["key"];
      $message = $_POST["text"];
      $sender_id = $_POST["sender"];
      $recipients = $_POST["to"];

      sendSMS($api_key, $message, $sender_id, $recipients);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["key"])) {
      // Check SMS balance logic
      $api_key = $_GET["key"];
      checkBalance($api_key);
    } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["balance_key"])) {
      // Save balance API key
      $balance_api_key = $_POST["balance_key"];
      saveBalanceAPI($balance_api_key);
    }
    ?>

    <form action="" method="post">
      <div class="form-group">
        <label for="apiKey">API Key:</label>
        <input type="text" class="form-control" id="apiKey" name="key" required>
      </div>

      <div class="form-group">
        <label for="message">Message:</label>
        <input type="text" class="form-control" id="message" name="text" required>
      </div>

      <div class="form-group">
        <label for="senderId">Sender ID:</label>
        <input type="text" class="form-control" id="senderId" name="sender" required>
      </div>

      <div class="form-group">
        <label for="recipients">Recipients (comma-separated):</label>
        <input type="text" class="form-control" id="recipients" name="to" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Send SMS</button>
    </form>

    <br>

    <form action="" method="get">
      <div class="form-group">
        <label for="apiKey">API Key:</label>
        <input type="text" class="form-control" id="apiKey" name="key" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Check Balance</button>
    </form>

    <!-- Save settings to local storage -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get the API key and Sender ID inputs
        var apiKeyInput = document.getElementById("apiKey");
        var senderIdInput = document.getElementById("senderId");

        // Check if API key and Sender ID are saved in local storage
        if (localStorage.getItem("apiKey")) {
          apiKeyInput.value = localStorage.getItem("apiKey");
        }

        if (localStorage.getItem("senderId")) {
          senderIdInput.value = localStorage.getItem("senderId");
        }

        // Save API key and Sender ID to local storage on form submission
        document.querySelector("form").addEventListener("submit", function () {
          localStorage.setItem("apiKey", apiKeyInput.value);
          localStorage.setItem("senderId", senderIdInput.value);
        });

        // Check if balance API key is saved in local storage
        var balanceAPIInput = document.getElementById("balanceAPI");
        if (localStorage.getItem("balanceAPI")) {
          balanceAPIInput.value = localStorage.getItem("balanceAPI");
        }

        // Save balance API key to local storage on form submission
        document.getElementById("saveBalanceAPIForm").addEventListener("submit", function () {
          localStorage.setItem("balanceAPI", balanceAPIInput.value);
        });
      });
    </script>

    <!-- Add a button to link back to the index page -->
    <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
  </div>

  <!-- Bootstrap JS and jQuery (Optional, but required for some Bootstrap features) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
