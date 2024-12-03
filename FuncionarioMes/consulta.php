<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta - Funcionário do Mês</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Consulta - Funcionário do Mês</h1>
        <form method="GET" action="" id="formConsulta" class="mt-4">
            <div class="mb-3">
                <label for="funcionario" class="form-label">Selecione o Funcionário:</label>
                <select class="form-control" id="funcionario" name="funcionario">
                    <option value="">Todos os Funcionários</option>
                    <?php
                // Conexão com o banco de dados
                $conn = new mysqli('localhost', 'root', '', 'projeto_final');
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // Buscar nomes de funcionários no banco
                $sql = "SELECT DISTINCT nome FROM funcionario_mes ORDER BY nome";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['nome']}'>{$row['nome']}</option>";
                    }
                }

                $conn->close();
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label">Selecione o Ano:</label>
                <select class="form-control" id="ano" name="ano">
                    <option value="">Todos os Anos</option>
                    <?php
                for ($i = 2020; $i <= 2030; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mes" class="form-label">Selecione o Mês:</label>
                <select class="form-control" id="mes" name="mes">
                    <option value="">Todos os Meses</option>
                    <?php
                $meses = [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ];
                foreach ($meses as $mes) {
                    echo "<option value='$mes'>$mes</option>";
                }
                ?>
                </select>
            </div>
            <button type="submit" formaction="consultanome.php" class="btn btn-primary">Consultar por Nome</button>
            <button type="submit" formaction="consultamesano.php" class="btn btn-secondary">Consultar por Mês e
                Ano</button>
        </form>
    </div>
    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>