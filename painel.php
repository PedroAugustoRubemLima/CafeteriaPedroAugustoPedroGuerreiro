<?php
include "verifica_login.php";
include "conexao.php";

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

    $stmt = mysqli_prepare($conn, "INSERT INTO cardapio (nome_item, categoria, descricao, preco, disponivel) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssdi", $nome, $categoria, $descricao, $preco, $disponivel);
    mysqli_stmt_execute($stmt);
    header("Location: painel.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM cardapio");
mysqli_stmt_execute($stmt);
$itens = mysqli_stmt_get_result($stmt);
?>
<html>
<head>
<meta charset="UTF-8">
<title>Painel</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Cardapio da Cafeteria</h1>
<p>Bem vindo <?php echo htmlspecialchars($_SESSION['nome']); ?> | <a href="logout.php">Sair</a></p>

<h2>Cadastrar item</h2>
<form method="post">
Nome: <input type="text" name="nome_item" required><br><br>
Categoria:
<select name="categoria">
<option>Café</option>
<option>Doce</option>
<option>Salgado</option>
<option>Bebida Gelada</option>
</select><br><br>
Descrição: <input type="text" name="descricao"><br><br>
Preço: <input type="number" step="0.01" name="preco" required><br><br>
<input type="checkbox" name="disponivel" checked> Disponivel<br><br>
<input type="submit" value="Cadastrar">
</form>

<h2>Itens</h2>
<table border="1">
<tr>
<th>ID</th>
<th>Nome</th>
<th>Categoria</th>
<th>Descrição</th>
<th>Preço</th>
<th>Disponivel</th>
<th>Ações</th>
</tr>
<?php while ($item = mysqli_fetch_assoc($itens)) { ?>
<tr>
<td><?php echo $item['id']; ?></td>
<td><?php echo htmlspecialchars($item['nome_item']); ?></td>
<td><?php echo htmlspecialchars($item['categoria']); ?></td>
<td><?php echo htmlspecialchars($item['descricao']); ?></td>
<td>R$ <?php echo $item['preco']; ?></td>
<td><?php if ($item['disponivel']) { echo "Sim"; } else { echo "Não"; } ?></td>
<td>
<a href="editar_item.php?id=<?php echo $item['id']; ?>">Editar</a>
<a href="excluir_item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>
