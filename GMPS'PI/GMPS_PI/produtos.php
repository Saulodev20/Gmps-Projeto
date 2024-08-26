<?php
include_once('conexao.php');

// Função para tratar a edição do produto
if (isset($_POST['editar'])) {
    $id = (int)$_POST['id'];
    $nome = $conexao->real_escape_string($_POST['nome']);
    $fornecedor = $conexao->real_escape_string($_POST['fornecedor']);
    $categoria = $conexao->real_escape_string($_POST['categoria']);
    $modelo = $conexao->real_escape_string($_POST['modelo']);
    $marca = $conexao->real_escape_string($_POST['marca']);
    $preco = (float)$_POST['preco'];
    $quantidade = (int)$_POST['quantidade'];

    $stmt = $conexao->prepare("UPDATE produtos SET nome=?, fornecedor=?, categoria=?, modelo=?, marca=?, preco=?, quantidade=? WHERE id=?");
    $stmt->bind_param("ssssddii", $nome, $fornecedor, $categoria, $modelo, $marca, $preco, $quantidade, $id);

    if ($stmt->execute()) {
        echo "Produto atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar produto: " . $conexao->error;
    }

    $stmt->close();
}

// Função para tratar a exclusão do produto
if (isset($_POST['excluir'])) {
    $id = (int)$_POST['id'];

    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Produto excluído com sucesso!";
    } else {
        echo "Erro ao excluir produto: " . $conexao->error;
    }

    $stmt->close();
}

// Preparação e execução da inserção no banco
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar']) && !isset($_POST['excluir'])) {
    $nome = $conexao->real_escape_string($_POST["nome"]);
    $fornecedor = $conexao->real_escape_string($_POST["fornecedor"]);
    $categoria = $conexao->real_escape_string($_POST["categoria"]);
    $modelo = $conexao->real_escape_string($_POST["modelo"]);
    $marca = $conexao->real_escape_string($_POST["marca"]);
    $preco = (float) $_POST["preco"];
    $quantidade = (int) $_POST["quantidade"];
    
    $linkImagem = null;
    if (isset($_FILES['imagem'])) {
        $uploadError = $_FILES['imagem']['error'];
        if ($uploadError === UPLOAD_ERR_OK) {
            $imagemTmpName = $_FILES['imagem']['tmp_name'];
            $imagemNome = basename($_FILES['imagem']['name']);
            $imagemDestino = 'uploads/' . $imagemNome;
            
            if (move_uploaded_file($imagemTmpName, $imagemDestino)) {
                $linkImagem = $imagemDestino;
            } else {
                die("Erro ao mover o arquivo de imagem.");
            }
        } else {
            echo "Erro no upload da imagem: " . $uploadError;
        }
    }

    $stmt = $conexao->prepare("INSERT INTO produtos (nome, fornecedor, categoria, modelo, marca, preco, quantidade, link_imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddis", $nome, $fornecedor, $categoria, $modelo, $marca, $preco, $quantidade, $linkImagem);

    if ($stmt->execute()) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . $conexao->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM produtos";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Produto</title>
    <link rel="icon" href="src\img\favIconGmps.png" type="image/png">
    <link rel="stylesheet" href="src\css\navbar.css">
    <link rel="stylesheet" href="src/css/cadastros1.css">
    <style>
        .indicador{
    margin-top: 110px;
    margin-left: 50px;
    text-align: left;
    color: #184487;
    font-size: 30px;
}

body {
    font-family: "Montserrat", sans-serif;
    background-color: #f0f0f0;
    padding: 20px;
}

.titulos {
    margin-top: 60px;
    color: #184487;
    margin-bottom: 20px;
    margin-left: 50px;
}

.container {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

.texto{
    margin-bottom: 20px;
    color: #184487;
}
.campo {
    color: #000;
    background-color: #fff;
    padding: 10px;
    margin: 2px 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

.formulario {
    color: #184487;
    margin-top: 50px;
    max-width: 10%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    margin-left: 50px;
}

.upload-container {
    position: relative;
    overflow: hidden;
    display: inline-block;
}

.upload-container input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.upload-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.upload-button:hover {
    background-color: #0056b3;
}

.file-name {
    margin-left: 10px;
}

button {
    background-color: #184487 !important;
    color: white !important; 
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #f8f8f8 !important;
    color: #184487 !important;
}

.table-container {
    max-width: 400px;
    overflow-x: auto;
}

table {
    align-items: center;
    width: 95%;
    margin-left: 50px;
    border-collapse: collapse;
    border-radius: 25px;
    overflow: hidden;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    text-align: left;
    align-items: center;
}

th {
    background-color: #184487;
    color: white;
    text-align: center;
}

td {
    background-color: white;
    text-align: center;
}

.actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.actions form {
    display: inline;
}

.actions button {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
}

td {
    border: 1px solid #ddd;
    text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
    text-align: center;
}
    </style>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <img src="src/img/navLogo.png" alt="Logo"> 
    </div>
    <div class="buttons">
        <a href="home.php" class="button">
            <i class="fas fa-address-card"></i> Cadastros
        </a>
        <a href="estoque.php" class="button">
            <i class="fas fa-shopping-cart"></i> Estoque
        </a>
    </div>
    <div>
        <a href="index.php" id="logoutBtn" class="buttonL">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </div>
</nav>
<main>
    <div>
        <p class="indicador">
            <i class="fas fa-box-open"></i> <b>Produtos</b>
        </p>
    </div>
    <br> <br>
    <form action="produtos.php" method="post" enctype="multipart/form-data">
        <div class="formulario">
            <label class="texto" for="nome">Nome:</label>
            <input class="campo" type="text" id="nome" name="nome" required>
            <label class="texto" for="fornecedor">Fornecedor:</label>
            <input class="campo" type="text" id="fornecedor" name="fornecedor" required>
            <label class="texto" for="categoria">Categoria:</label>
            <input class="campo" type="text" id="categoria" name="categoria" required>
            <label class="texto" for="modelo">Modelo:</label>
            <input class="campo" type="text" id="modelo" name="modelo">
        </div>
        <div class="formulario">
            <label class="texto" for="marca">Marca:</label>
            <input class="campo" type="text" id="marca" name="marca">
            <label class="texto" for="preco">Preço:</label>
            <input class="campo" type="number" step="0.01" id="preco" name="preco" required>
            <label class="texto" for="quantidade">Quantidade:</label>
            <input class="campo" type="number" id="quantidade" name="quantidade" required>
            <div class="formulario">
                <label class="texto" for="imagem">Imagem:</label>
                <div class="upload-container">
                    <input class="campo" type="file" id="imagem" name="imagem" accept="image/*">
                    <label for="imagem" class="upload-button">Escolher Arquivo</label>
                    <span class="file-name"></span> 
                </div>
            </div>
        </div>
        <div style="display: flex;align-items: center;justify-content: center;"class="formulario">
            <button style="padding: 1rem" class="button" type="submit">Cadastrar</button>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <h2 class="titulos">Produtos Cadastrados</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Fornecedor</th>
                <th>Categoria</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["nome"]; ?></td>
                    <td><?php echo $row["fornecedor"]; ?></td>
                    <td><?php echo $row["categoria"]; ?></td>
                    <td><?php echo $row["modelo"]; ?></td>
                    <td><?php echo $row["marca"]; ?></td>
                    <td><?php echo $row["preco"]; ?></td>
                    <td><?php echo $row["quantidade"]; ?></td>
                    <td>
                        <?php if ($row['link_imagem']): ?>
                            <img src="<?php echo $row['link_imagem']; ?>" width="100">
                        <?php else: ?>
                            Sem imagem
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="produtos.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum produto cadastrado.</p>
    <?php endif; ?>

    <?php $conexao->close(); ?>
</main>
<script>
const fileInput = document.getElementById('imagem');
const fileNameSpan = document.querySelector('.file-name');

fileInput.addEventListener('change', () => {
    fileNameSpan.textContent = fileInput.files[0].name;
});
</script>
</body>
</html>
