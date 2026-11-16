<?php
session_start();
include "conexao.php";

// se o usuário já estiver logado, envia-lo para o index.php
if(isset($_SESSION["usuario_id"])){
    header("location:index.php");
    exit;
}

$erro = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"] ?? "");
    $senha =$_POST["senha"] ?? "";

    if($email === "" || $senha === ""){
        $erro =  "Informar usuário ou senha.";
    }
    else{
        $sqLogin = "select usuario_id,nome,email,senha from tbl_Usuarios where email = :email";
        $preparaLogin = $cn->prepare($sqlLogin);
        $preparaLogin->bindValue(":email", PDO::PARAM_STR);
        $preparaLogin->execute();
        $usuarioLogado = $preparaLogin->fetch(PDO::FETCH_ASSOC);

        if($usuarioLogado && password_verify($senha,$usuarioLogado["senha"])){
            $_SESSION[id] = $usuarioLogado["usuario_id"];
            $_SESSION[nome] = $usuarioLogado["usuario_id"];
            $_SESSION[perfil] = $usuarioLogado["usuario_id"];
            header("location:index.php");
        }
    }

    
}

?>

<?php
    session_start();
    include "conexão.php";

    if(isset($_SESSION["usuario_id"])){
        header("location:index.php");
        exit;
    }

    $erro = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = trim($_POST['email'] ?? "");
        $senha = $_POST['senha'] ?? "";

        if($email === "" || $senha === ""){
            $erro = "favor informar o email e a senha.";
        }
        else {
            $SqlLogin = "select usuario_id, nome, email, senha, tipo_perfil from tbl_usuarios where email = :email";
            $prepareLogin = $cn->prepare($sqlLogin);
             $prepareLogin->bindValue(":email", $email, PDO::PARAM_STR);
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgênciaJobs</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/css_login.css">
</head>
<body>

    <!-- TOPNAV -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">AgênciaJobs</a>
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link">Início</a></li>
                    <li><a href="index.php#vagas" class="nav-link">Vagas</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL: LOGIN -->
    <main class="container login-container">
        <div class="login-card">
            <h1 class="login-title">Acesse sua conta</h1>
            <p class="login-subtitle">Bem-vindo de volta! Insira seus dados para continuar.</p>

            <!-- Formulário de Login -->
            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="seu@email.com" required>
                </div>

                <div class="form-group">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit-login">Entrar no Sistema</button>
            </form>

            <hr class="divider">

            <!-- Área para quem não tem cadastro -->
            <div class="register-box">
                <p>Ainda não possui cadastro?</p>
                <a href="cadastro.php" class="btn-register">Criar uma conta (Candidato ou Empresa)</a>
            </div>
        </div>
    </main>

    <!-- RODAPÉ -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 AgênciaJobs. Desenvolvido para fins didáticos nas aulas de Desenvolvimento de Sistemas.</p>
        </div>
    </footer>

</body>
</html>