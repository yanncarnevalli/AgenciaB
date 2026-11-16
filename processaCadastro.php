<?php
include "conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo_perfil = $_POST['tipo_perfil'];

    $sqlUsuario = "select usuario_id from tbl_usuarios where email = :email";
    $verificaUsuario = $cn->prepare($sqlUsuario);
    $verificaUsuario->bindValue(':email', $email);
    $verificaUsuario->execute();

    if($verificaUsuario->rowCount() > 0){
        echo "<script>
                alert('Email já cadastrado no sistema.');
                window.location.href='login.php';
            </script>";
            exit;
    }
    else{
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $inserirUsuario = "insert into tbl_usuarios(nome,email,senha,tipo_perfil)
                            values(:nome,:email,:senha,:perfil)";

        $prepararInsert = $cn->prepare($inserirUsuario);
        $prepararInsert->bindValue(":nome", $nome);
        $prepararInsert->bindValue(":email", $email);
        $prepararInsert->bindValue(":senha", $senhaHash);
        $prepararInsert->bindValue(":perfil", $tipo_perfil);
        $prepararInsert->execute();

        echo "<script>
                alert('Usuário cadastrado com sucesso !!');
                window.location.href='login.php';
            </script>";
    }    
}
?>