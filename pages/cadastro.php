<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../js/navbar.js"></script>
    <title>Cadastro</title>
</head>
<body>
    <div id="navbar"></div>

    <div class="main-container">
        <div class="sub-container">
            <div class="cadastro-container">
                <h1>Cadastro</h1>
                <form action="" method="post" class="cadastro-form">
                    <p>
                        <label for="name">Nome</label><br>
                        <input type="text" placeholder="Digite seu nome completo">
                    </p>
                    <p>
                        <label for="cpf">CPF</label><br>
                        <input type="text" placeholder="Digite aqui seu CPF">
                    </p>
                    <p>
                        <label for="telefone">Numero de telefone</label><br>
                        <input type="number" placeholder="(XX)-XXXXX-XXXX">
                    </p>
                    <p>
                        <label for="endereco">Endereço</label><br>
                        <input type="text" placeholder="Digite aqui seu endereço">
                    </p>
                    <p>
                        <label for="cep">CEP</label><br>
                        <input type="number" placeholder="Digite aqui seu CEP">
                    </p>
                    <form action="" method="post">
                        <p>
                            <label for="laudo">Envie aqui seu laudo médico</label><br>
                            <input type="file">
                        </p>
                    </form>
                </div>
                </form>
        </div>
    </div>
</body>
</html>