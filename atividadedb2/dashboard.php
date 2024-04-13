<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Aqui você pode adicionar o código para visualizar e manipular os dados do banco de dados
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

