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
$response = $my->query($sql)->fetch_assoc();
http_response_code(200);
die(json_encode([
    'status' => true,
    'response' => [
        'id' => $response['id'],
        'api_key' => $response['api_key'],
        'domain' => $response['domain'],
        'used_requests' => $response['requests'],
        'total_requests' => $response['total_requests']]], JSON_PRETTY_PRINT));