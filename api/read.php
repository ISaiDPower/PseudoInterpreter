<?php
/*
 * @title API Handler
 * @description Acest fisier se ocupa cu tratarea cererilor catre api.
 */

header("Access-Control-Allow-Origin: *");
$request = json_decode(file_get_contents("php://input"), true);

$my = new mysqli("localhost", "pseudo", "3tOwptx9w@", "pseudo");
if ($my->connect_error) {
    http_response_code(501);
    die(json_encode([
        'status' => false,
        'response' => "Nu am putut efectua conectarea la baza de date."], JSON_PRETTY_PRINT));
}
if (!isset($request['apikey'])) {
    http_response_code(401);
    die(json_encode([
        'status' => false,
        'response' => "Nicio cheie api nu a fost prevazuta in cerere."], JSON_PRETTY_PRINT));
}
$sql = "SELECT * FROM `api_keys` WHERE `api_key` = '" . $request['apikey'] ."'";
if ($my->query($sql)->num_rows == 0) {
    http_response_code(404);
    die(json_encode([
        'status' => false,
        'response' => 'Niciun cont api nu a fost gasit cu aceasta cheie.'], JSON_PRETTY_PRINT));
}
$response1 = $my->query($sql)->fetch_assoc();
if ($response1['requests'] == $response1['total_requests']) {
    http_response_code(200);
    die(json_encode([
        'status' => false,
        'response' => 'Cererile tale au atins limita, te rog sa cumperi un nou pachet, sau daca ai unul gratuit, te rog sa astepti pana la inceputul urmatoarei luni.'
    ], JSON_PRETTY_PRINT));
}
$sql = "UPDATE `api_keys` SET `requests` = '" . $response1['requests'] + 1 . "' WHERE `api_keys`.`api_key` = ". $request['apikey'] . ";";
session_start();
if (!isset($request['variables'])) {
    die(json_encode([
        'status' => false,
        'response' => 'Variabilele nu au fost specificate.'
    ]));
}
foreach ($request['variables'] as $variable => $value) {
    $_SESSION['in']['vars'][$variable] = $value;
}
http_response_code(200);
die(json_encode([
    'status' => true,
    'response' => "Cererea ta a fost efectuata cu succes."
], JSON_PRETTY_PRINT));