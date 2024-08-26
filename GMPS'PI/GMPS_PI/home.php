<?php
  include_once('conexao.php');
  
  

?>
<!DOCTYPE html>
<html>
<head>
    <title>Página Inicial</title>
    <link rel="icon" href="src\img\favIconGmps.png" type="image/png">
    <link rel="stylesheet" href="src/css/navbar.css">
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
    <main >
        <div class="botao-grupo" >
            <div>
                <a href="usuarios.php" class="botao">
                    <i class="fas fa-users"></i> Usuários
                </a>
                <a href="fornecedores.php" class="botao">
                    <i class="fas fa-truck"></i> Fornecedores
                </a>
            </div>
            <div>
                <a href="produtos.php" class="botao">
                    <i class="fas fa-box-open"></i> Produtos
                </a>
                <a href="servicos.php" class="botao">
                    <i class="fas fa-tools"></i> Serviços
                </a>
            </div>
            
        </div>
    </main>
    <p>Lo</p>
    <script src="index.js"></script> 
</body>
</html>
