<?php
include_once('conexao.php');

$sql = "SELECT * FROM produtos";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estoque</title>
    <link rel="icon" href="src/img/favIconGmps.png" type="image/png">
    <link rel="stylesheet" href="src/css/navbar.css">
    <link rel="stylesheet" href="src/css/estoque.css">
    <style>
        .indicador {
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
            max-width: 1200px;
            margin: 0 auto;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 300px;
            text-align: center;
        }

        .card img {
            max-width: 100%;
            border-radius: 10px;
        }

        .card h3 {
            color: #184487;
        }

        .card p {
            color: #555;
        }

        .card .price, .card .quantity {
            font-weight: bold;
            color: #184487;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .actions form {
            display: inline;
        }

        .actions button {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            background-color: #184487;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
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
        <a href="produtos.php" class="button">
            <i class="fas fa-shopping-cart"></i> Produtos
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
            <i class="fas fa-box-open"></i> <b>Estoque</b>
        </p>
    </div>
    <br><br>
    <?php if ($result->num_rows > 0): ?>
        <h2 class="titulos">Produtos em Estoque</h2>
        <div class="cards">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?php echo $row['link_imagem']; ?>" alt="Imagem do Produto">
                    <h3><?php echo $row["nome"]; ?></h3>
                    <p>Fornecedor: <?php echo $row["fornecedor"]; ?></p>
                    <p>Categoria: <?php echo $row["categoria"]; ?></p>
                    <p>Modelo: <?php echo $row["modelo"]; ?></p>
                    <p>Marca: <?php echo $row["marca"]; ?></p>
                    <p class="price">Preço: R$ <?php echo number_format($row["preco"], 2, ',', '.'); ?></p>
                    <p class="quantity">Quantidade: <?php echo $row["quantidade"]; ?></p>
                    <div class="actions">
                        <form action="produtos.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="excluir">Excluir</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Nenhum produto cadastrado.</p>
    <?php endif; ?>

    <?php $conexao->close(); ?>
</main>
</body>
</html>
