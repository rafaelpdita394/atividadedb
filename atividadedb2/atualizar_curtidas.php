<?php
// Verifica se a solicitação é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o parâmetro foto_id foi enviado na solicitação POST
    if (isset($_POST['foto_id'])) {
        // Obtém o ID da foto enviado na solicitação
        $foto_id = $_POST['foto_id'];

        // Conexão com o banco de dados (substitua pelos seus dados)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "atividadedb";

        // Cria a conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se a conexão foi bem sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Verifica se o ID da foto existe na tabela fotos
        $check_sql = "SELECT id FROM fotos WHERE id = $foto_id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows == 1) {
            // Atualiza o número de curtidas na tabela 'fotos' para a foto com o ID fornecido
            $sql = "UPDATE fotos SET curtidas = curtidas + 1 WHERE id = $foto_id";
            if ($conn->query($sql) === TRUE) {
                // Retorna o novo número de curtidas após a atualização
                $sql = "SELECT curtidas FROM fotos WHERE id = $foto_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row["curtidas"];
                } else {
                    echo "0";
                }
            } else {
                echo "Erro ao atualizar o número de curtidas: " . $conn->error;
            }
        } else {
            echo "ID da foto não encontrado na tabela fotos.";
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "ID da foto não fornecido na solicitação.";
    }
} else {
    echo "Solicitação inválida.";
}
?>
