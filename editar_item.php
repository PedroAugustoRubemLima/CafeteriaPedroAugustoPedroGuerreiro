<?php
include "verifica_login.php";
include "conexao.php";

$id = $_GET['id'];

if (isset($_POST['nome_item'])) {
    $nome = $_POST['nome_item'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    if (isset($_POST['disponivel'])) {
        $disponivel = 1;
    } else {
        $disponivel = 0;
    }

    $stmt = mysqli_prepare($conn, "UPDATE cardapio SET nome_item = ?, categoria = ?, descricao = ?, preco = ?, disponivel = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssdii", $nome, $categoria, $descricao, $preco, $disponivel, $id);
    mysqli_stmt_execute($stmt);
    header("Location: painel.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM cardapio WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($res);
?>
<html>
<head>
<meta charset="UTF-8">
<title>Editar</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Editar item</h1>
<form method="post">
Nome: <input type="text" name="nome_item" value="<?php echo htmlspecialchars($item['nome_item']); ?>" required><br><br>
Categoria:
<select name="categoria">
<option <?php if ($item['categoria'] == "Café") echo "selected"; ?>>Café</option>
<option <?php if ($item['categoria'] == "Doce") echo "selected"; ?>>Doce</option>
<option <?php if ($item['categoria'] == "Salgado") echo "selected"; ?>>Salgado</option>
<option <?php if ($item['categoria'] == "Bebida Gelada") echo "selected"; ?>>Bebida Gelada</option>
</select><br><br>
Descrição: <input type="text" name="descricao" value="<?php echo htmlspecialchars($item['descricao']); ?>"><br><br>
Preço: <input type="number" step="0.01" name="preco" value="<?php echo $item['preco']; ?>" required><br><br>
<input type="checkbox" name="disponivel" <?php if ($item['disponivel']) echo "checked"; ?>> Disponivel<br><br>
<input type="submit" value="Salvar">
</form>
<br>
<a href="painel.php">Voltar</a>
</body>
</html>
