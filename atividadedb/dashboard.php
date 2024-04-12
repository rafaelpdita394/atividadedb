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
        <!-- Aqui você pode adicionar elementos para visualizar e manipular os dados -->
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
