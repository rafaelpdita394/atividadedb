<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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

// Obtém o imagem_id do usuário logado
$username = $_SESSION['username'];
$sql = "SELECT imagem_id FROM usuarios WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagem_id = $row["imagem_id"];

    // Consulta SQL para recuperar a URL da imagem com base no imagem_id
    $sql = "SELECT url FROM fotos WHERE id='$imagem_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagem_url = $row["url"];

        // Exibe a imagem na página
        echo "<div class='dashboard-container'>";
        echo "<h2>Dashboard</h2>";
        echo "<p>Bem-vindo, " . $_SESSION['username'] . "!</p>";
        echo "<img src='$imagem_url' alt='Imagem do usuário'>";
        echo "<button onclick='curtirFoto($imagem_id)'>Curtir</button>";
        echo "<span id='curtidas'>0</span> Curtidas";
        echo "<a href='logout.php'>Logout</a>";
        echo "</div>";
    } else {
        echo "URL da imagem não encontrada para o usuário.";
    }
} else {
    echo "Usuário não encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Dashboard</h2>
        <p>Bem-vindo, <?php echo $_SESSION['username']; ?>!</p>
        <!-- Botão para curtir a foto -->
        <button onclick="curtirFoto(1)">Curtir</button>
        <!-- Contagem de curtidas -->
        <span id="curtidas">0</span> Curtidas
        <!-- Link para fazer logout -->
        <a href="logout.php">Logout</a>
    </div>
    <!-- Imagem a ser curtida -->
    <img src="CARS.png" alt="Carros" id="foto">
    
    <script>
        function curtirFoto(foto_id) {
            // Envia uma solicitação AJAX para atualizar as curtidas no servidor
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Atualiza a contagem de curtidas na página
                    document.getElementById("curtidas").innerText = this.responseText;
                }
            };
            xhttp.open("POST", "atualizar_curtidas.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("foto_id=" + foto_id);
        }
    </script>
</body>
</html>

