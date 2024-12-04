<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'projeto_final');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter o ID do registro
$id = $_GET['id'] ?? '';
if (!is_numeric($id)) {
    die("ID inválido.");
}

// Buscar os dados do registro
$sql = "SELECT * FROM funcionario_mes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$registro = $result->fetch_assoc();

if (!$registro) {
    die("Registro não encontrado.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Editar Registro</h1>
        <form method="POST" action="alterar.php">
            <input type="hidden" name="id" value="<?= $registro['id'] ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= $registro['nome'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="mes" class="form-label">Mês:</label>
                <select class="form-control" id="mes" name="mes" required>
                    <?php
        $meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        foreach ($meses as $mes) {
            // Marca o mês atual como selecionado
            $selected = ($registro['mes'] === $mes) ? "selected" : "";
            echo "<option value='$mes' $selected>$mes</option>";
        }
        ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label">Ano:</label>
                <input type="number" class="form-control" id="ano" name="ano" value="<?= $registro['ano'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="alteracao.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>