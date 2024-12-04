<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'projeto_final');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Receber os dados do formulário
$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$mes = $_POST['mes'] ?? '';
$ano = $_POST['ano'] ?? '';

if (!is_numeric($id) || empty($nome) || empty($mes) || !is_numeric($ano)) {
    echo "<script>alert('Dados inválidos.'); window.history.back();</script>";
    exit;
}

// Atualizar o registro no banco
$sql = "UPDATE funcionario_mes SET nome = ?, mes = ?, ano = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nome, $mes, $ano, $id);

if ($stmt->execute()) {
    echo "<script>alert('Registro atualizado com sucesso!'); window.location.href = 'alteracao.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar o registro.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();

$meses_validos = [
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];

if (!in_array($mes, $meses_validos)) {
    echo "<script>alert('Mês inválido.'); window.history.back();</script>";
    exit;
}
?>