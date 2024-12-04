<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta por Mês e Ano - Funcionário do Mês</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Resultado da Consulta por Mês e Ano</h1>
        <?php
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'projeto_final');
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verificar se os parâmetros "mes" e "ano" foram enviados
    $mes = $_GET['mes'] ?? '';
    $ano = $_GET['ano'] ?? '';

    if (empty($mes) || empty($ano)) {
        echo "<p class='alert alert-warning'>Você deve selecionar o mês e o ano. <a href='consulta.php'>Voltar</a></p>";
        exit;
    }

    // Buscar dados no banco de dados
    $sql = "SELECT * FROM funcionario_mes WHERE mes = ? AND ano = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $mes, $ano);
    $stmt->execute();
    $result = $stmt->get_result();

    // Exibir resultados
    if ($result->num_rows > 0) {
        echo "<table class='table mt-4'>";
        echo "<thead>
                <tr>
                    <th>Nome</th>
                    <th>Vendas</th>
                    <th>Bônus</th>
                    <th>Mês</th>
                    <th>Ano</th>
                    <th>Imagem</th>
                </tr>
              </thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>R$ " . number_format($row['vendas'], 2, ',', '.') . "</td>";
            echo "<td>R$ " . number_format($row['bonus'], 2, ',', '.') . "</td>";
            echo "<td>{$row['mes']}</td>";
            echo "<td>{$row['ano']}</td>";
            echo "<td><img src='{$row['imagem']}' alt='Foto do Funcionário' width='100'></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p class='alert alert-info'>Nenhum registro encontrado para o mês <strong>$mes</strong> e o ano <strong>$ano</strong>. <a href='consulta.php'>Voltar</a></p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    </div>
    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>