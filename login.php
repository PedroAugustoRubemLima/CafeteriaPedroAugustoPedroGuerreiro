<?php
session_start();
include "conexao.php";

$erro = "";

if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);

    if ($user && (password_verify($senha, $user['senha']) || $senha == $user['senha'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        header("Location: painel.php");
        exit;
    } else {
        $erro = "usuario ou senha errado";
    }
}
?>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Cafeteria - Login</h1>
<p style="color:red"><?php echo $erro; ?></p>
<form method="post">
Usuario: <input type="text" name="usuario"><br><br>
Senha: <input type="password" name="senha"><br><br>
<input type="submit" value="Entrar">
</form>
</body>
</html>
