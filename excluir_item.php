<?php
include "verifica_login.php";
include "conexao.php";

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM cardapio WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: painel.php");
