<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão - Funcionário do Mês</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script>
    async function excluirRegistro(id) {
        if (confirm("Tem certeza que deseja excluir este registro?")) {
            try {
                const response = await fetch("excluir.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id: id
                    })
                });
                const result = await response.json();
                if (result.success) {
                    alert("Registro excluído com sucesso!");
                    location.reload();
                } else {
                    alert("Erro ao excluir registro: " + result.message);
                }
            } catch (error) {
                alert("Erro de conexão com o servidor.");
            }
        }
    }
    </script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Exclusão de Registros</h1>
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
            echo "<td><button class='btn btn-danger btn-sm' onclick='excluirRegistro({$row['id']})'>Excluir</button></td>";
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