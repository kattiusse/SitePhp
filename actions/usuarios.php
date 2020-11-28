<?php
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";

// Conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Tabela do banco de dados
$tabela = 'usuarios';

// Destruindo sessão de campos 
unset($_SESSION['nome']);
unset($_SESSION['login']);
unset($_SESSION['email']);
unset($_SESSION['perfil']);

// Destruindo sessão de 'message' e 'css' 
unset($_SESSION['message']);
unset($_SESSION['css']);

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) {
    // É logar
    case 'logar':
        // Dados enviados
        if (!empty($_POST['email_login']) && !empty($_POST['senha'])) {
            // Armazena dados em variáveis
            $email_login = $_POST['email_login'];
            $senha = $_POST['senha'];

            // Busca usuário no banco de dados com base no email_login e $senha
            $sql = "
                SELECT * FROM {$tabela} 
                    WHERE (email = '".$email_login."' OR login = '".$email_login."') 
                        AND senha = '".md5($senha)."' 
            ";

            // Executa o sql 
            $query = mysqli_query($conn, $sql);

            // Cria o array da query         
            $dados = mysqli_fetch_assoc($query);

            // Existe dados
            if (isset($dados)) {
                // Armazena dados em sessões de autenticação, para usar no formulário
                $_SESSION['auth']["id"] = $dados['id'];
                $_SESSION['auth']["nome"] = $dados['nome'];
                $_SESSION['auth']["login"] = $dados['login'];
                $_SESSION['auth']["email"] = $dados['email'];
                $_SESSION['auth']["perfil"] = $dados['perfil'];

                // Página de dashboard
                $page = $config['url']."/templates/dashboard.php";
            } else {
                $message = "Dados de acesso inválidos";
                $css = "danger";
                $page = $config['url']."/templates/login.php";
            }
        } else {
            $message = "Dados de Acesso são obrigatórios";
            $css = "danger";
            $page = $config['url']."/templates/login.php";
        }
    break;
    // Logout
    case 'logout':
        // Deleta todas as sessões
        session_destroy();

        // Página de login
        $page = $config['url']."/templates/login.php";
    break;
    // É perfil
    case 'perfil':
        // Dados enviados
        if (!empty($_POST['nova_senha']) && !empty($_POST['confirm_nova_senha'])) {
            // Armazena dados em variáveis
            $id = $_POST['id'];
            $nova_senha = $_POST['nova_senha'];
            $confirm_nova_senha = $_POST['confirm_nova_senha'];

            // Verifica se campos de nova senha são iguais
            if ($nova_senha != $confirm_nova_senha) {
                $message = 'Senhas não correspondem';
                $css = 'danger';
                $page = $config['url']."/templates/usuarios/perfil.php";
            } else {         
                // Cria script de update
                $sql = "UPDATE {$tabela} SET senha = '".md5($nova_senha)."' WHERE id = ".$id;

                // Verifica se o script acima foi executado
                if ($conn->query($sql) == TRUE) {
                    $message = 'Cadastro alterado com sucesso';
                    $css = 'success';
                } else {
                    $message = 'Erro ao alterar cadastro';
                    $css = 'danger';
                } 

                // Página de listagem
                $page = $config['url']."/templates/usuarios/index.php";
            }
        } else {
            $message = "Os campos de senhas são obrigatórios";
            $css = "danger";

            // Página de perfil
            $page = $config['url']."/templates/usuarios/perfil.php";
        }
    break; 
    // É listagem
    case 'index':
        $page = $config['url']."/templates/usuarios/index.php";
    break;    
    // É cadastrar
    case 'cadastrar':    
        // Página de cadastro    
        $page = $config['url']."/templates/usuarios/cadastrar.php";
    
        // Dados enviados
        if ($_POST) {

            // Armazena dados em variáveis
            $nome = $_POST["nome"];
            $login = $_POST["login"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            $confirm_senha = $_POST["confirm_senha"];
            $perfil = $_POST["perfil"];

            // Campos obrigatórios foram enviados
            if (empty($nome) && empty($login) && empty($email) && empty($senha)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = $config['url']."/templates/usuarios/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["nome"] = $nome;
                $_SESSION["login"] = $login;
                $_SESSION["email"] = $email;
                $_SESSION["perfil"] = $perfil;

                // Busca login no banco de dados
                $sql = "SELECT * FROM {$tabela} WHERE login = '".$login."' ";

                // Executa o sql
                $query = mysqli_query($conn, $sql);

                // Cria o array da query
                $dados = mysqli_fetch_assoc($query);
                
                // Verifica se campos de senha são iguais
                if ($senha != $confirm_senha) {
                    $message = 'Senhas não correspondem';
                    $css = 'danger';
                    $page = $config['url']."/templates/usuarios/cadastrar.php";
                // Verifica se campo login já existe no banco de dados    
                } else if (!empty($dados['login'])) {
                    $message = 'Já existe um usuário com esse login';
                    $css = 'danger';
                    $page = $config['url']."/templates/usuarios/cadastrar.php"; 
                // Validações estão OK       
                } else {
                    // Cria script de insert, criptografando a senha
                    $sql = "
                        INSERT INTO {$tabela} (nome, login, email, senha, perfil)
                            VALUES ('".$nome."', '".$login."', '".$email."', '".md5($senha)."', '".$perfil."')
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
                    $page = $config['url']."/templates/usuarios/index.php";
                }
            }           
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
            $perfil = $_POST['perfil'];

            // Busca email no banco de dados
            $sql = "SELECT * FROM {$tabela} WHERE login = '".$login."' AND id <> ".$id;

            // Executa o sql
            $query = mysqli_query($conn, $sql);

            // Cria o array da query
            $dados = mysqli_fetch_assoc($query);            

            // Verifica se email não é vazio
            if (!empty($dados['login'])) {
                $message = 'Já existe um usuário com esse login';
                $css = 'danger';
                $page = $config['url']."/templates/clientes/editar.php";
            } else {
                // Cria script de update
                $sql = "
                    UPDATE {$tabela} SET nome = '".$nome."', login = '".$login."', email = '".$email."', perfil = '".$perfil."' 
                        WHERE id = ".$id
                    ;

                // Verifica se o script acima foi executado
                if ($conn->query($sql) == TRUE) {
                    $message = 'Cadastro alterado com sucesso';
                    $css = 'success';
                } else {
                    $message = 'Erro ao alterar cadastro';
                    $css = 'danger';
                }  
            }

            // Página de listagem
            $page = $config['url']."/templates/usuarios/index.php";
        } else {
            // Recupera id e armazena em variável
            $id = $_GET['id'];

            // Sessão do usuário logado é igual ao id enviado para edição
            if (($_SESSION['auth']["perfil"] == 'ADMIN') || ($_SESSION['auth']["id"] == $id)) {
                // Busca usuário no banco de dados com base no id acima
                $sql = "SELECT * FROM {$tabela} WHERE id = ".$id;

                // Executa o sql
                $query = mysqli_query($conn, $sql);

                // Cria o array da query
                $dados = mysqli_fetch_assoc($query);
        
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["id"] = $dados['id'];
                $_SESSION["nome"] = $dados['nome'];
                $_SESSION["login"] = $dados['login'];
                $_SESSION["email"] = $dados['email'];
                $_SESSION["perfil"] = $dados['perfil'];
        
                // Página de edição
                $page = $config['url']."/templates/usuarios/editar.php";
            } else {
                // Página de listagem
                $page = $config['url']."/templates/usuarios/index.php";
            }
        }
        break;
    // É deletar    
    case 'deletar':
        // Recupera id e armazena em variável
        $id = $_GET['id'];

        // Sessão do usuário logado é igual ao id enviado para edição
        if (($_SESSION['auth']["perfil"] == 'ADMIN') || ($_SESSION['auth']["id"] == $id)) {
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
        }  

        // Página de listagem
        $page = $config['url']."/templates/usuarios/index.php";
        break;
    // Não é nenhuma ação acima    
    default:
        die('Ação Inválida');
        break;
}

// Cria as sessões com base nas variáveis criadas acima
$_SESSION["message"] = $message;
$_SESSION["css"] = $css;

// Redireciona a página, para a variável {page}
header("Location: {$page}");