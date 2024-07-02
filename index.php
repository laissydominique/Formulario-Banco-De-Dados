<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=cadastro-pessoas', username: 'admin', password: 'admin');

if (!empty($_POST)) {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['password'];

    try {
        $stmt = $pdo->prepare("INSERT INTO cadastrar (nome, email, senha) VALUES (?,?,?)");
        $wasSuccessful = $stmt->execute([$nome, $email, $senha]);
    } catch (Exception $e) {
        http_response_code(500);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>FORMULARIO</title>
</head>

<body>
    <div class="container">
        <button id="cadAgora"> Cadastrar-se agora </button>

        <div class="conjuntoForms hidden">
            <h1 class="cadastrar"> Cadastre-se </h1>
            <form action="index.php" method="POST" class="formulario">
                <label class="labelNome" for="name"> Nome*</label>
                <input type="text" class="name" placeholder="Digite o seu nome" name="name" required>

                <label class="labelEmail" for="email"> Email</label>
                <input type="email" class="email" placeholder="Digite o seu email" name="email">

                <label class="labelPassword" for="senha">Criar senha*</label>
                <div class="olho1"> <input type="password" class="password" placeholder="Digite uma senha" name="password" required>
                    <i class="fa-solid fa-eye" style="color: #ffffff;" id="olhoAberto1"></i>
                </div>


                <label class="labelConfPassword" for="confSenha"> Cofirmar senha*</label>
                <div class="olho2"> <input type="password" class="confPassword" placeholder="Confirme sua senha" name="confPassword" required>
                    <i class="fa-solid fa-eye" style="color: #ffffff;" id="olhoAberto2"></i>
                </div>

                <button type="submit" class="submit" name="submit">Enviar </button>
            </form>
        </div>

        <div class="footer"></div>
    </div>
</body>

<script>
    const cadAgora = document.querySelector("#cadAgora");
    const conjuntoForms = document.querySelector(".conjuntoForms");
    const submit = document.querySelector('.submit');
    const name = document.querySelector('.name');
    const email = document.querySelector('.email');
    const password = document.querySelector('.password');
    const confPassword = document.querySelector('.confPassword');
    const form = document.querySelector('.formulario');
    const cadastrar = document.querySelector('.cadastrar');
    const olhoAberto1 = document.querySelector('#olhoAberto1');
    const olhoAberto2 = document.querySelector('#olhoAberto2');

    olhoAberto1.addEventListener("click", function() {
        const type = password.type == "password" ? "text" : "password";
        password.type = type;

        if (olhoAberto1.style.color == "rgb(255, 0, 0)") { // Check if the color is red
            olhoAberto1.style.color = "#ffffff"; // Change to white
        } else {
            olhoAberto1.style.color = "#FF0000"; // Change to red
        }

    })

    olhoAberto2.addEventListener("click", function() {
        const type = confPassword.type == "password" ? "text" : "password";
        confPassword.type = type;

        if (olhoAberto2.style.color == "rgb(255, 0, 0)") { // Check if the color is red
            olhoAberto2.style.color = "#ffffff"; // Change to white
        } else {
            olhoAberto2.style.color = "#FF0000"; // Change to red
        }

    })

    cadAgora.addEventListener("click", () => {
        conjuntoForms.classList.remove("hidden");
        cadAgora.classList.add("hidden");
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (password.value !== confPassword.value || password.value.length < 8) {
            alert("Senha não aceita! verifique se a sua senha está idêntica á confirmação e se possui mais de 8 caracteres.");
            return;
        }

        const dadosFormulario = new FormData(form);
        const response = await fetch('http://localhost:8003/index.php', {
            method: 'POST',
            body: dadosFormulario
        });

        if (!response.ok) {
            cadastrar.innerHTML = "Erro no servidor... por favor, tente novamente!"
            return;
        }
        cadastrar.innerHTML = "Obrigada! suas informações foram enviadas.";
        name.value = " ";
        email.value = " ";
        password.value = " ";
        confPassword.value = " ";
    });
</script>

<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        font-weight: bolder;
    }

    body {
        display: flex;
    }

    .hidden {
        display: none;
    }

    .container {
        height: 3000px;
        width: 3000px;
        display: flex;
        justify-content: center;
        background-color: black;
    }

    #cadAgora {
        width: 300px;
        height: 60px;
        padding: 20px;
        margin-top: 100px;
        cursor: pointer;
        border-radius: 40px;
        background-color: aquamarine;
        font-size: 17px;
    }

    .cadastrar {
        color: white;
        margin-bottom: 30px;
        margin-left: 20px;
    }

    .conjuntoForms {
        margin-top: 180px;
        height: 500px;
        width: 700px;
        padding: 40px;
    }

    .formulario {
        display: grid;
    }

    .submit,
    .name,
    .email,
    .password,
    .confPassword {
        color: rgba(255, 255, 255, 0);
        margin-bottom: 80px;
        height: 30px;
        border-radius: 20px;
    }

    .name,
    .email,
    .password,
    .confPassword,
    .submit {
        background-color: black;
        border-color: white;
        width: 680px;
        height: 34px;
        justify-content: center;
        margin-left: 20px;
        color: black;
    }

    .name,
    .email,
    .password,
    .confPassword{
        background-color: black;
        border-style:initial;
        color: #ffffff;
    }
    label {
        justify-content: center;
        margin-left: 20px;
        color: white;
    }

    .submit {
        width: 680px;
        cursor: pointer;
        border-style:double;
        color: #ffffff;
    }


    .exibeDados {
        color: azure;
    }

    .footer {
        position: fixed;
        width: 2000px;
        left: 0;
        bottom: 0;
        height: 60px;
        align-items: center;
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 121, 91, 1) 35%, rgba(0, 234, 255, 1) 100%);
    }

    .olho1,
    .olho2 {
        width: 710px;
        height: 20px;
        display: flex;
        margin-bottom: 80px;
    }

    .confPassword {
        display: flex;
        align-items: center;
        margin-bottom: 80px;
    }

    #olhoAberto1,
    #olhoAberto2 {
        width: 18px;
        height: 16px;
        justify-content: right;
        align-items: center;
        text-align: center;
        cursor: pointer;
    }
</style>

</html>