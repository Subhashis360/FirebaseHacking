<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function generateRandomEmail() {
        $domains = ['example.com', 'test.com', 'demo.com'];
        $randomUser = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10);
        $randomDomain = $domains[array_rand($domains)];
        return $randomUser . '@' . $randomDomain;
    }

    function generateRandomIP() {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }

    $key = $_POST['api_key'];

    $urx0 = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=" . $key;
    $randomEmail = generateRandomEmail();
    $ip = generateRandomIP();

    $datax0 = json_encode([
        "email" => $randomEmail,
        "password" => "123456qwerty",
        "returnSecureToken" => true
    ]);

    $headers0 = [
        "content-type: application/json",
        "X-Forwarded-For: $ip"
    ];

    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, $urx0);
    curl_setopt($ch1, CURLOPT_HEADER, 0);
    curl_setopt($ch1, CURLOPT_POST, 1);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, $datax0);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers0);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch1);
    curl_close($ch1);

    $jsonResponse = json_decode($response, true);

    if (isset($jsonResponse["idToken"]) && isset($jsonResponse["localId"])) {
        $tok = $jsonResponse["idToken"];
        $uid = $jsonResponse["localId"];
        echo "<p>Token: $tok</p><p>User ID: $uid</p>";
    } else {
        echo "<p>The provided API key does not work or the request failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firebase Signup</title>
</head>
<body>
    <h1>Firebase Signup</h1>
    <form method="POST" action="">
        <label for="api_key">Enter API Key:</label>
        <input type="text" id="api_key" name="api_key" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
