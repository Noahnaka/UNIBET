<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
$url = "https://api.api-futebol.com.br/v1/campeonatos";
$headers = [
    "Authorization: Bearer test_4bd5c038e402694fe26647bf0061d9",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$resp = json_decode($response);

$id_campeonatos = [];

for($i = 0; $i < count($resp); $i++){
    $id_campeonatos[$i] = $resp[0]->campeonato_id;
    echo $response.'<br>';
}

echo json_encode($id_campeonatos);