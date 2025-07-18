<?php
// index.php - Interface web simples para upload do certificado e dados da consulta
session_start();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['certificado']) && $_FILES['certificado']['error'] === UPLOAD_ERR_OK) {
        $certPath = __DIR__ . '/certificado.pfx';
        move_uploaded_file($_FILES['certificado']['tmp_name'], $certPath);
        $_SESSION['certificado'] = $certPath;
        $_SESSION['senha'] = $_POST['senha'] ?? '';
        $sucesso = 'Certificado enviado com sucesso!';
    } else {
        $erro = 'Erro ao enviar o certificado.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de Certificado - Sefaz SP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        h2 { text-align: center; }
        .msg { color: green; text-align: center; }
        .erro { color: red; text-align: center; }
        label { display: block; margin-top: 15px; }
        input[type="file"], input[type="password"] { width: 100%; }
        button { margin-top: 20px; width: 100%; padding: 10px; background: #1976d2; color: #fff; border: none; border-radius: 4px; font-size: 16px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Upload do Certificado Digital</h2>
    <?php if ($erro): ?><div class="erro"><?= $erro ?></div><?php endif; ?>
    <?php if ($sucesso): ?><div class="msg"><?= $sucesso ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label for="certificado">Certificado (.pfx):</label>
        <input type="file" name="certificado" id="certificado" accept=".pfx" required>
        <label for="senha">Senha do certificado:</label>
        <input type="password" name="senha" id="senha" required>
        <button type="submit">Enviar</button>
    </form>
    <?php if (isset($_SESSION['certificado'])): ?>
        <form method="post" action="consultar.php">
            <button type="submit" style="background:#388e3c;">Consultar Status Sefaz</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
