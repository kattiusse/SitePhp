<?php
// Iniciando sessão
session_start();

// Incluindo conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Removendo sessões criadas
unset($_SESSION['message']);
unset($_SESSION['css']);
unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['login']);
unset($_SESSION['email']); 

// Tabela do banco de dados
$tabela = 'usuarios';

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) {
    // É cadastrar
    case 'cadastrar':    
        // Página de cadastro    
        $page = "../templates/usuarios/cadastrar.php";
    
        // Dados enviados
        if ($_POST) {
            // Armazena dados em variáveis
            $nome = $_POST["nome"];
            $login = $_POST["login"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            $confirm_senha = $_POST["confirm_senha"];

            // Campos obrigatórios foram enviados
            if (empty($nome) && empty($login) && empty($email) && empty($senha)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = "../templates/usuarios/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["nome"] = $nome;
                $_SESSION["login"] = $login;
                $_SESSION["email"] = $email;

                // Busca login no banco de dados
                $sql = mysqli_query($conn, "SELECT * FROM {$tabela} WHERE login = '".$login."' ");
                $dados = mysqli_fetch_assoc($sql);
                
                // Verifica se campos de senha são iguais
                if ($senha != $confirm_senha) {
                    $message = 'Senhas não correspondem';
                    $css = 'danger';
                    $page = "../templates/usuarios/cadastrar.php";
                // Verifica se campo login já existe no banco de dados    
                } else if (!empty($dados['login'])) {
                    $message = 'Já existe um usuário com esse login';
                    $css = 'danger';
                    $page = "../templates/usuarios/cadastrar.php"; 
                // Validações estão OK       
                } else {
                    // Cria script de insert, criptografando a senha
                    $sql = "
                        INSERT INTO {$tabela} (nome, login, email, senha)
                        VALUES ('".$nome."', '".$login."', '".$email."', '".md5($senha)."')
                    ";
    
                    // Verifica se o script acima foi executado
                    if ($conn->query($sql) == TRUE) {
                        $message = 'Cadastro realizado com sucesso';
                        $css = 'success';
                    } else {
                        $message = 'Erro ao realizar cadastro';
                        $css = 'danger';
                    }
    
                    // Fecha conexão com o banco de dados
                    $conn->close();

                    // Página de listagem
                    $page = "../templates/usuarios/index.php";
                }
            }

            // Cria as sessões com base nas variáveis criadas acima
            $_SESSION["message"] = $message;
            $_SESSION["css"] = $css;            
        }
        
        break;
    // É editar
    case 'editar':
         // Dados enviados
        if ($_POST) {
            // Armazena dados em variáveis
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $login = $_POST['login'];
            $email = $_POST['email'];
            
            // Cria script de update
            $sql = "UPDATE {$tabela} SET nome = '".$nome."', login = '".$login."', email = '".$email."' WHERE id = ".$id;

            // Verifica se o script acima foi executado
            if ($conn->query($sql) == TRUE) {
                $message = 'Cadastro alterado com sucesso';
                $css = 'success';
            } else {
                $message = 'Erro ao alterar cadastro';
                $css = 'danger';
            }    

            // Cria as sessões com base nas variáveis criadas acima
            $_SESSION["message"] = $message;
            $_SESSION["css"] = $css;

            // Página de listagem
            $page = "../templates/usuarios/index.php";
        } else {
            // Recupera id e armazena em variável
            $id = $_GET['id'];

            // Busca usuário no banco de dados com base no id acima
            $sql = mysqli_query($conn, "SELECT * FROM {$tabela} WHERE id = ".$id);
            $dados = mysqli_fetch_assoc($sql);
    
            // Armazena dados em sessões, para usar no formulário
            $_SESSION["id"] = $dados['id'];
            $_SESSION["nome"] = $dados['nome'];
            $_SESSION["login"] = $dados['login'];
            $_SESSION["email"] = $dados['email'];
    
            // Página de edição
            $page = "../templates/usuarios/editar.php";
        }
        break;
    // É deletar    
    case 'deletar':
        // Recupera id e armazena em variável
        $id = $_GET['id'];

        // Cria script de update
        $sql = "DELETE FROM {$tabela} WHERE id = ".$id;

        // Verifica se o script acima foi executado
        if ($conn->query($sql) == TRUE) {
            $message = 'Cadastro deletado com sucesso';
            $css = 'success';
        } else {
            $message = 'Erro ao deletar cadastro';
            $css = 'danger';
        }

        // Fecha conexão com banco de dados
        $conn->close();

        // Cria as sessões com base nas variáveis criadas acima
        $_SESSION["message"] = $message;
        $_SESSION["css"] = $css;

        // Página de listagem
        $page = "../templates/usuarios/index.php";
        break;
    // Não é nenhuma ação acima    
    default:
        die('Ação Inválida');
        break;
}

// Redireciona a página, para a variável {page}
header("Location: {$page}");