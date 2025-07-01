<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Load API Key from a separate file
$apiKey = trim(file_get_contents('chatgpt-api-key.txt'));

// Get the user message from the request
$request = json_decode(file_get_contents('php://input'), true);
$userMessage = $request['message'] ?? '';

// Prepare data for API request
$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => $userMessage]
    ]
];

// Make API request to OpenAI
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

// Error handling for cURL
if (curl_errno($ch)) {
    $botMessage = 'Request Error: ' . curl_error($ch);
} else {
    $responseData = json_decode($response, true);
    if (isset($responseData['choices'][0]['message']['content'])) {
        $botMessage = $responseData['choices'][0]['message']['content'];
    } else {
        $botMessage = 'API Error: ' . json_encode($responseData);
    }
}

curl_close($ch);

// Return response to the frontend
echo json_encode(['response' => $botMessage]);
?> 