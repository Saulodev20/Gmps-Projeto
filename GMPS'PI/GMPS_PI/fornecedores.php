<?php
include_once('conexao.php');

// Função para tratar a exclusão do fornecedor
if (isset($_POST['excluir'])) {
    $id = (int)$_POST['id'];

    $stmt = $conexao->prepare("DELETE FROM fornecedores WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Fornecedor excluído com sucesso!";
    } else {
        echo "Erro ao excluir fornecedor: " . $conexao->error;
    }

    $stmt->close();
}

// Função para tratar a inserção no banco
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['excluir'])) {
    $nome = $conexao->real_escape_string($_POST["nome"]);
    $email = $conexao->real_escape_string($_POST["email"]);
    $telefone = $conexao->real_escape_string($_POST["telefone"]);
    $endereco = $conexao->real_escape_string($_POST["endereco"]);
    $cnpj = $conexao->real_escape_string($_POST["cnpj"]);
    $data_cadastro = date('Y-m-d');
    $descricao = $conexao->real_escape_string($_POST["descricao"]);
    $website = $conexao->real_escape_string($_POST["website"]);

    $stmt = $conexao->prepare("INSERT INTO fornecedores (nome, email, telefone, endereco, cnpj, data_cadastro, descricao, website) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nome, $email, $telefone, $endereco, $cnpj, $data_cadastro, $descricao, $website);

    if ($stmt->execute()) {
        echo "Fornecedor cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar fornecedor: " . $conexao->error;
    }

    $stmt->close();
}

// Selecionar todos os fornecedores cadastrados
$sql = "SELECT * FROM fornecedores";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="src\img\favIconGmps.png" type="image/png">
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="src/css/navbar.css">
    <link rel="stylesheet" href="src\css\cadastros1.css">
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
            <i class="fas fa-truck"></i> <b>Fornecedores</b>
        </p>
    </div>
    <br> <br>
    <form action="fornecedores.php" method="post">
    <div class="formulario">
        <label class="texto" for="nome">Nome:</label>
        <input class="campo" type="text" id="nome" name="nome"> 
        <label class="texto" for="email">Email:</label>
        <input class="campo" type="email" id="email" name="email">
        <label class="texto" for="telefone">Telefone:</label>
        <input class="campo" type="text" id="telefone" name="telefone" >
        <label class="texto" for="endereco">Endereço:</label>
        <input class="campo" type="text" id="endereco" name="endereco">
    </div>
    
    <div class="formulario">
        
        <label class="texto" for="cnpj">CNPJ:</label>
        <input class="campo" type="text" id="cnpj" name="cnpj">
        <label class="texto" for="descricao">Descrição:</label>
        <textarea class="campo" id="descricao" name="descricao"></textarea>
        <label class="texto" for="website">Website:</label>
        <input class="campo" type="url" id="website" name="website" value="https://example.com"> 
        <button type="submit">Cadastrar Fornecedor</button>
</div>
</form>


    <?php if ($result->num_rows > 0): ?>
        <h2 class="titulos">Fornecedores Cadastrados</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>CNPJ</th>
                <th>Data de Cadastro</th>
                <th>Descrição</th>
                <th>Website</th>
                <th>Ações</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["nome"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["telefone"]; ?></td>
                <td><?php echo $row["endereco"]; ?></td>
                <td><?php echo $row["cnpj"]; ?></td>
                <td><?php echo $row["data_cadastro"]; ?></td>
                <td><?php echo $row["descricao"]; ?></td>
                <td><?php echo $row["website"]; ?></td>
                <td>
                    <!-- Formulário de exclusão -->
                    <form action="fornecedores.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="excluir">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor cadastrado.</p>
    <?php endif; ?>

    <?php $conexao->close(); ?>
    </main>
</body>
</html>
