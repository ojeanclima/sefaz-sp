<?php
// consultar.php - Executa a consulta usando o certificado enviado
session_start();

if (!isset($_SESSION['certificado']) || !file_exists($_SESSION['certificado'])) {
    die('Certificado não enviado. Volte e faça o upload.');
}

require_once __DIR__ . '/vendor/autoload.php';
use MatheusHack\SefazSP\SefazSP;

$certPath = $_SESSION['certificado'];
$senha = $_SESSION['senha'] ?? '';

// Exemplo de configuração do SoapClient com certificado
$options = [
    'local_cert' => $certPath,
    'passphrase' => $senha,
    'trace' => 1,
    'exceptions' => 1,
];

try {
    $sefaz = new SefazSP($options); // Supondo que a classe aceite options, senão adapte aqui
    $status = $sefaz->status();
    echo '<pre>Status Sefaz:<br>';
    var_dump($status);
    echo '</pre>';
} catch (Exception $e) {
    echo '<pre>Erro ao consultar Sefaz:<br>' . htmlspecialchars($e->getMessage()) . '</pre>';
}

// Link para voltar
echo '<p><a href="index.php">Voltar</a></p>';
