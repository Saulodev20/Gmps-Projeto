<?php
session_start();
include_once('conexao.php'); // Certifique-se de que este arquivo exista e contenha a conexão com o banco de dados

// Apagar usuários selecionados
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_users'])) {
        $selected_users = $_POST['selected_users'];
        foreach ($selected_users as $id) {
            $id = intval($id);
            $query_delete = "DELETE FROM usuarios WHERE id = $id";
            mysqli_query($conexao, $query_delete);
        }
        $success_message = "Usuário(s) deletado(s) com sucesso!";
    } else {
        $error_message = "Nenhum usuário selecionado para exclusão.";
    }
}

// Cadastro de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    // Validação dos dados (adicione mais validações conforme necessário)
    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha'])) {
        $error_message = "Por favor, preencha todos os campos.";
    } else {
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        $email = mysqli_real_escape_string($conexao, $_POST['email']);
        $senha = mysqli_real_escape_string($conexao, $_POST['senha']); // Sem criptografia

        // Inserir os dados no banco de dados
        $query_inserir = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if (mysqli_query($conexao, $query_inserir)) {
            $success_message = "Usuário cadastrado com sucesso!";
        } else {
            $error_message = "Erro ao cadastrar usuário: " . mysqli_error($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GMP's - Cadastro de Usuário</title>
    <link rel="icon" href="src\img\favIconGmps.png" type="image/png">
    <link rel="stylesheet" href="src/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .body {
            font-family: "Montserrat", sans-serif;
            background-color: #f0f0f0;
            padding-top: 80px;
            margin: 0;
        }
        .login-container {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 100px #0000001a;
            max-width: 600px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container img {
            width: 375px;
            margin-bottom: 25px;
        }
        .welcome-text {
            color: #184487;
            font-size: 26px;
            margin-bottom: 25px;
        }
        .form-input,
        .login-input {
            width: 200px;
            margin-bottom: 20px;
            border: 2px solid #eee;
            border-radius: 50px;
            font-size: 16px;
            text-align: center;
        }
        .btnCadastrar {
            padding: 10px;
            width: auto;
            text-align: center;
            background-color: #184487;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 50px;
            margin-bottom: 20px;
        }
        .btnCadastrar:hover {
            font-weight: 700;
            transition: 0.10s;
            box-shadow: 0px 0px 60px #184487;
        }
        .mensagemErro,
        .mensagemSucesso {
            color: #184487;
            margin-bottom: 20px;
        }
        .tabelaUsuarios {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;,
            
        }
        .tabelaUsuarios,
        .tabelaUsuarios th,
        .tabelaUsuarios td {
            border: 1px solid #ddd;
        }
        .tabelaUsuarios th,
        .tabelaUsuarios td {
            padding: 10px;
            text-align: left;
        }
        .tabelaUsuarios th {
            background-color: #184487;
            color: white;
        }
        .btnDeletar {
            padding: 10px;
            width: auto;
            text-align: center;
            background-color: #184487;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 50px;
            margin-bottom: 20px;
            margin-top: 20px;
            text-align: center;
            
        }
        .btnDeletar:hover {
            font-weight: 700;
            transition: 0.10s;
            box-shadow: 0px 0px 60px #184487;
        }
        .titulos {
            color: #184487;
        }
        
        .hide-id {
            display: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            
            }
        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 15px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 50px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #184487;
            text-decoration: none;
            cursor: pointer;
        }
        .add-btn {
            background-color: #184487;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .add-btn:hover {
            font-weight: 700;
            transition: 0.10s;
            box-shadow: 0px 0px 60px #184487;
        }


    </style>
</head>

<body class="body">
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
    <div class="login-container">
        <img src="src/img/loginLogo.png" alt="Logo">
        <div class="welcome-text">Cadastre-se</div>
        
        <?php if (isset($error_message)): ?>
            <div class="mensagemErro"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="mensagemSucesso"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Botão para abrir o formulário de cadastro -->
        <button class="add-btn" id="addUserBtn">Adicionar Usuários</button>

        <!-- Modal para o formulário de cadastro -->
        <div id="addUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="">
                    <div>
                        <input type="text" name="nome" class="form-input login-input" placeholder="Nome" required>
                    </div>
                    <div>
                        <input type="email" name="email" class="form-input login-input" placeholder="Email" required>
                    </div>
                    <div>
                        <input type="password" name="senha" class="form-input login-input" placeholder="Senha" required>
                    </div>
                    <br>
                    <button type="submit" class="btnCadastrar">Cadastrar</button>
                </form>
            </div>
        </div>


        <!-- Exibir usuários cadastrados -->
        <h2 class="titulos">Usuários Cadastrados</h2>
        <form method="POST" action="">
            <table class="tabelaUsuarios">
                <tr>
                    <th></th>
                    <th class="hide-id">ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
                <?php
                $query_selecionar = "SELECT * FROM usuarios";
                $result = mysqli_query($conexao, $query_selecionar);
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_users[]" value="<?php echo $row['id']; ?>"></td>
                        <td class="hide-id"><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <div class="delete-container">
                <button type="submit" name="delete_selected" class="btnDeletar" onclick="return confirm('Tem certeza que deseja deletar os usuários selecionados?');">Excluir Usuários Selecionados</button>
            </div>
        </form>
    </div>
</main>
<script>
    // Abrir o modal
    var modal = document.getElementById("addUserModal");
    var btn = document.getElementById("addUserBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "flex";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
