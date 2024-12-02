<?php 

$uploadDir = 'img/'; // Onde as imgs serão armazenadas
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Tipos de arquivos permitidos para upload

// Verfica o envio do método
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados enviados pelo formulário
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $venda = $_POST['venda'] ?? '';
    $foto = $_POST['foto'] ?? null;
    
    // Verifica campos preenchidos
    if(empty($nome) || empty($email) || empty($venda) || empty($foto['name'])) {
        // Mensagem de erro
        echo "<script>alert('Todos os campos são obrigatórios!'); window.history.back();</script>";
        exit;
    }
    
    // Verifica tipo da foto
    if (!in_array($foto['type'], $allowedTypes)) {
        // Mensagem de erro
        echo "<script>alert('Formato de imagem inválido! Apenas JPEG, PNG e GIF são aceitos.'); window.history.back();</script>";
        exit;
    }

    // Lógica do cálculo de bônus
    $venda = (float) $venda;
    if ($venda < 500) {
        $bonus = $venda * 0.01;
    } elseif ($venda <= 3000) {
        $bonus = $venda * 0.05;
    } elseif ($venda <= 10000) {
        $bonus = $venda * 0.10;
    } else {
        $bonus = $venda * 0.15;
    }
    
    // Obter mês e ano
    $mes = date('F');
    $ano = date('Y');

    // Fazer upload da imagem
    $fotoNome = $uploadDir . basename($foto['name']);
    if (!move_uploaded_file($foto['tmp_name'], $fotoNome)) {
        echo "<script>alert('Erro ao fazer o upload da imagem!'); window.history.back();</script>";
        exit;
    }
}

?>