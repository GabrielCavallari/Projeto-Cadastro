<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && is_numeric($data['id'])) {
        $id = (int) $data['id'];

        // Conexão com o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'projeto_final');
        if ($conn->connect_error) {
            echo json_encode(["success" => false, "message" => "Erro de conexão com o banco."]);
            exit;
        }

        // Exclusão do registro
        $sql = "DELETE FROM funcionario_mes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao excluir o registro."]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID inválido."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método não suportado."]);
}