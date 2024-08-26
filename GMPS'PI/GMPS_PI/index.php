<?php
session_start();
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($conexao)) {
        $username = mysqli_real_escape_string($conexao, $_POST['username']);
        $password = mysqli_real_escape_string($conexao, $_POST['password']);

        // Verificar as credenciais no banco de dados
        $query = "SELECT * FROM usuarios WHERE email = '$username' AND senha = '$password'";
        $result = mysqli_query($conexao, $query);

        if (mysqli_num_rows($result) == 1) {
            // Login bem-sucedido
            $_SESSION['username'] = $username;
            header("Location: /home.php"); // substitua por sua URL
            exit();
        } else {
            $error_message = "Usuário ou senha inválidos!";
        }
    } else {
        $error_message = "Erro de conexão com o banco de dados!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="icon" href="src\img\favIconGmps.png" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<title>GMP's Login</title>
<style>
  {
    margin: 0;
    padding: 0;
    font-family: "Montserrat", sans-serif;
  }
  body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f7f7f7;
  }
  .login-container {
    text-align: center;
    padding: 50px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 0 100px #0000001a;
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
  .login-input {
    width: 400px;
    padding: 10px;
    margin-bottom: 20px;
    border: 2px solid #eee;
    border-radius: 50px;
    font-size: 16px;
    text-align: center;
  }
  .login-button {
    padding: 10px;
    width: 100%;
    text-align: center;
    background-color: #184487;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 50px;
    margin-bottom: 20px;
  }
  .login-button:hover {
    font-weight: 700;
    transition: 0.10s;
    box-shadow: 0px 0px 60px #184487;
  }
  .error-message {
    color: #184487;
    margin-bottom: 20px;
  }
</style>
</head>
<body>
  <div class="login-container">
    <img src="src/img/loginLogo.png" alt="Logo">
    <div class="welcome-text">Bem-vindo!</div>
    <?php
    if (isset($error_message)) {
        echo "<div class='error-message'>$error_message</div>";
    }
    ?>
    <form method="POST" action="">
      <div>
        <input type="text" name="username" class="login-input" placeholder="Usuário" required>
      </div>
      <div>
        <input type="password" name="password" class="login-input" placeholder="Senha" required>
      </div>
      <br>
      <button type="submit" class="login-button">Entrar!</button>
    </form>
  </div>
</body>
</html>
