<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'projeto_final';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


$uploadDir = 'img/'; // Diretório onde as imagens serão armazenadas
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Tipos de arquivos permitidos para upload

// Verifica o método de envio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados enviados pelo formulário
    $funcionario = $_POST['func'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $foto = $_FILES['foto'] ?? null;

    // Verifica se todos os campos estão preenchidos
    if (empty($funcionario)) {
        echo "<script>alert('O campo Funcionário é obrigatório!'); window.history.back();</script>";
        exit;
    }

    if (empty($valor)) {
        echo "<script>alert('O campo Valor é obrigatório!'); window.history.back();</script>";
        exit;
    }

    if (empty($foto) || $foto['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('É obrigatório anexar uma imagem válida!'); window.history.back();</script>";
        exit;
    }
    
    echo "<script>alert('Todos os campos foram preenchidos corretamente!');</script>";

    // Verifica se o tipo do arquivo é permitido
    if (!in_array($foto['type'], $allowedTypes)) {
        echo "<script>alert('Formato de imagem inválido! Apenas JPEG, PNG e GIF são aceitos.'); window.history.back();</script>";
        exit;
    }

    // Converte o valor da venda para número
    $valor = (float) $valor;

    // Calcula o bônus com base no valor da venda
    if ($valor < 500) {
        $bonus = $valor * 0.01;
    } elseif ($valor <= 3000) {
        $bonus = $valor * 0.05;
    } elseif ($valor <= 10000) {
        $bonus = $valor * 0.10;
    } else {
        $bonus = $valor * 0.15;
    }

    // Obtém o mês e o ano atual em português
    setlocale(LC_TIME, 'portuguese');
    $mes = strftime('%B');
    $ano = date('Y');

    // Realiza o upload da imagem
    $fotoNome = $uploadDir . uniqid() . '-' . basename($foto['name']);
    if (!move_uploaded_file($foto['tmp_name'], $fotoNome)) {
        echo "<script>alert('Erro ao fazer o upload da imagem!'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO funcionario_mes (nome, vendas, bonus, mes, ano, imagem)
        VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddsss", $funcionario, $valor, $bonus, $mes, $ano, $fotoNome);

    if ($stmt->execute()) {
        echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href = 'cadastro.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar funcionário: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

}

?>