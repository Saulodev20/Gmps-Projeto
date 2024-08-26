<?php
include_once('conexao.php');

// Função para tratar a edição do serviço
if (isset($_POST['editar'])) {
    $id = (int)$_POST['id'];
    $nome_servico = $conexao->real_escape_string($_POST['nome_servico']);
    $cliente = $conexao->real_escape_string($_POST['cliente']);
    $numero_servico = (int)$_POST['numero_servico'];
    $data = $conexao->real_escape_string($_POST['data']);
    $contato = $conexao->real_escape_string($_POST['contato']);
    $ativo = (int)$_POST['ativo'];
    $observacoes = $conexao->real_escape_string($_POST['observacoes']);

    $stmt = $conexao->prepare("UPDATE servicos SET nome_servico=?, cliente=?, numero_servico=?, data=?, contato=?, ativo=?, observacoes=? WHERE id=?");
    $stmt->bind_param("ssissisi", $nome_servico, $cliente, $numero_servico, $data, $contato, $ativo, $observacoes, $id);

    if ($stmt->execute()) {
        echo "Serviço atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar serviço: " . $conexao->error;
    }

    $stmt->close();
}

// Função para tratar a exclusão do serviço
if (isset($_POST['excluir'])) {
    $id = (int)$_POST['id'];

    $stmt = $conexao->prepare("DELETE FROM servicos WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Serviço excluído com sucesso!";
    } else {
        echo "Erro ao excluir serviço: " . $conexao->error;
    }

    $stmt->close();
}

// Preparação e execução da inserção no banco
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar']) && !isset($_POST['excluir'])) {
    $nome_servico = $conexao->real_escape_string($_POST["nome_servico"]);
    $cliente = $conexao->real_escape_string($_POST["cliente"]);
    $numero_servico = (int) $_POST["numero_servico"];
    $data = $conexao->real_escape_string($_POST["data"]);
    $contato = $conexao->real_escape_string($_POST["contato"]);
    $ativo = (int) $_POST["ativo"];
    $observacoes = $conexao->real_escape_string($_POST["observacoes"]);
    $data_criacao = date('Y-m-d H:i:s');

    $stmt = $conexao->prepare("INSERT INTO servicos (nome_servico, cliente, numero_servico, data, contato, ativo, observacoes, data_criacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssississ", $nome_servico, $cliente, $numero_servico, $data, $contato, $ativo, $observacoes, $data_criacao);

    if ($stmt->execute()) {
        echo "Serviço cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar serviço: " . $conexao->error;
    }

    $stmt->close();
}

// Selecionar todos os serviços cadastrados
$sql = "SELECT * FROM servicos";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Serviço</title>
    <link rel="icon" href="src/img/favIconGmps.png" type="image/png">
    <link rel="stylesheet" href="src/css/navbar.css">
    <link rel="stylesheet" href="src/css/cadastros1.css">
    <style>
        #data{
            margin-bottom: 20px;
            width: 100px;
            color: #184487;
        }
        #data1{
            color: #000;
            background-color: #fff;
            padding: 10px;
            width: 100%;
            margin: 2px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
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
            <i class="fas fa-concierge-bell"></i> <b>Serviços</b>
        </p>
    </div>
    <br> <br>
   
    <form action="servicos.php" method="post">
        <div class="formulario">
            <label class="texto" for="nome_servico">Nome do Serviço:</label>
            <input class="campo" type="text" id="nome_servico" name="nome_servico" required>

            <label class="texto" for="cliente">Cliente:</label>
            <input class="campo" type="text" id="cliente" name="cliente" required>

            <label class="texto" for="numero_servico">Número do Serviço:</label>
            <input class="campo" type="number" id="numero_servico" name="numero_servico" required>

            <label id="data" for="data">Data:</label>
            <input id="data1" type="date" id="data" name="data" required>
        </div>
        <div class="formulario">
            <label class="texto" for="contato">Contato:</label>
            <input class="campo" type="text" id="contato" name="contato" required>

            <label class="texto" for="ativo">Ativo:</label>
            <input class="campo" type="checkbox" id="ativo" name="ativo" value="1">

            <label class="texto" for="observacoes">Observações:</label>
            <textarea class="campo" id="observacoes" name="observacoes"></textarea>

            <button class="button" type="submit">Cadastrar Serviço</button>
        </div>
        
    </form>

    <?php if ($result->num_rows > 0): ?>
        <h2 class="titulos">Serviços Cadastrados</h2>
        <table>
            <tr>
                <th>Nome do Serviço</th>
                <th>Cliente</th>
                <th>Número do Serviço</th>
                <th>Data</th>
                <th>Contato</th>
                <th>Ativo</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["nome_servico"]; ?></td>
                <td><?php echo $row["cliente"]; ?></td>
                <td><?php echo $row["numero_servico"]; ?></td>
                <td><?php echo $row["data"]; ?></td>
                <td><?php echo $row["contato"]; ?></td>
                <td><?php echo $row["ativo"] ? 'Sim' : 'Não'; ?></td>
                <td><?php echo $row["observacoes"]; ?></td>
                <td>
                    <div class="actions">
    
                        <form action="servicos.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="excluir">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum serviço cadastrado.</p>
    <?php endif; ?>

    <?php $conexao->close(); ?>
</main>
</body>
</html>
