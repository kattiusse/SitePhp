<?php
session_start();

switch ($_GET['acao']) {
    case 'cadastrar':        
        $_SESSION["message"] = "";
        $_SESSION["css"] = "";
        $page = "../templates/usuarios/cadastrar.php";
    
        if ($_POST) {
            $_SESSION["message"] = 'Cadastro realizado com sucesso';
            $_SESSION["css"] = "success";
            $page = "../templates/usuarios.php";
        }
        
        break;
    case 'visualizar':
        die('template visualizar');
        break;
    case 'editar':
        die('template editar');
        break;
    case 'deletar':
        $_SESSION["message"] = 'Cadastro deletado com sucesso';
        $_SESSION["css"] = "danger";
        $page = "../templates/usuarios.php";
        break;    
    default:
        die('Ação Inváida');
        break;
}

header("Location: {$page}");