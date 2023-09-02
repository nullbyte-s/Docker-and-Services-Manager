<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'];

    exec($command, $output, $returnVar);

    $response = array(
        'success' => ($returnVar === 0),
        'message' => ($returnVar === 0) ? 'Comando executado com sucesso!' : 'Falha ao executar o comando.'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>