<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Obtém os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query para verificar se o usuário existe e tem acesso ao banco de dados
    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password' AND access='true'";
    $result = $conn->query($sql);
    
    // Verifica se a consulta SQL foi bem sucedida
    if (!$result) {
        // Caso ocorra um erro na consulta SQL
        echo "Erro na consulta: " . $conn->error;
    } else {
        // Verifica se o usuário foi encontrado
        if ($result->num_rows == 1) {
            // Inicia a sessão e redireciona para a página de dashboard
            session_start();
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            // Caso contrário, exibe uma mensagem de erro
            echo "Usuário ou senha incorretos.";
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>