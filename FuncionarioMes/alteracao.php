<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração - Funcionário do Mês</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Alteração de Registros</h1>
        <?php
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'projeto_final');
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Buscar registros do banco de dados
    $sql = "SELECT * FROM funcionario_mes ORDER BY ano DESC, mes DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table class='table mt-4'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Mês</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
              </thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['mes']}</td>";
            echo "<td>{$row['ano']}</td>";
            echo "<td><a href='editar.php?id={$row['id']}' class='btn btn-warning btn-sm'>Alterar</a></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p class='alert alert-info'>Nenhum registro encontrado.</p>";
    }

    $conn->close();
    ?>
    </div>
    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>