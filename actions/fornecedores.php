<?php
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";

// Conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Tabela do banco de dados
$tabela = 'fornecedores';

// Destruindo sessão de campos 
unset($_SESSION['razao_social']);
unset($_SESSION['nome_fantasia']);
unset($_SESSION['cnpj']);
unset($_SESSION['email']);

// Destruindo sessão de 'message' e 'css' 
unset($_SESSION['message']);
unset($_SESSION['css']);

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) { 
    // É listagem
    case 'index':
        $page = $config['url']."/templates/fornecedores/index.php";
    break; 
    
    // É cadastrar
    case 'cadastrar':
        // Página de cadastro
        $page = $config['url']."/templates/fornecedores/cadastrar.php";

        // Dados enviados
        if ($_POST) {

            // Armazena dados em variáveis
            $razao_social = $_POST["razao_social"];
            $nome_fantasia = $_POST["nome_fantasia"];
            $cnpj = $_POST["cnpj"];
            $email = $_POST["email"];

            // Campos obrigatórios foram enviados
            if (empty($razao_social) && empty($nome_fantasia) && empty($cnpj)  && empty($email)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = $config['url']."/templates/fornecedores/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["razao_social"] = $razao_social;
                $_SESSION["nome_fantasia"] = $nome_fantasia;
                $_SESSION["cnpj"] = $cnpj;
                $_SESSION["email"] = $email;

                // Busca cnpj no banco de dados
                $sql = "SELECT * FROM {$tabela} WHERE cnpj = '".$cnpj."' ";

                // Executa o sql
                $query = mysqli_query($conn, $sql);

                // Cria o array da query
                $dados = mysqli_fetch_assoc($query);
                
                // Verifica se cnpj não é vazio
                if (!empty($dados['cnpj'])) {
                    $message = 'Já existe um fornecedor com esse cnpj';
                    $css = 'danger';
                    $page = $config['url']."/templates/fornecedores/cadastrar.php"; 
                // Validações estão OK       
                } else {
                    // Cria script de insert, criptografando a senha
                    $sql = "
                        INSERT INTO {$tabela} (razao_social, nome_fantasia, cnpj, email)
                        VALUES ('".$razao_social."', '".$nome_fantasia."', '".$cnpj."', '".$email."')
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
                    $page = $config['url']."/templates/fornecedores/index.php";
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
            $razao_social = $_POST["razao_social"];
            $nome_fantasia = $_POST["nome_fantasia"];
            $cnpj = $_POST["cnpj"];
            $email = $_POST["email"];

            // Busca cnpj no banco de dados
            $sql = "SELECT * FROM {$tabela} WHERE cnpj = '".$cnpj."' AND id <> ".$id;

            // Executa o sql
            $query = mysqli_query($conn, $sql);

            // Cria o array da query
            $dados = mysqli_fetch_assoc($query);

            // Verifica se cnpj não é vazio
            if (!empty($dados['cnpj'])) {
                $message = 'Já existe um fornecedor com esse cnpj';
                $css = 'danger';
                $page = $config['url']."/templates/fornecedores/editar.php";
            } else {
                // Cria script de update
                $sql = "
                    UPDATE {$tabela} SET razao_social = '".$razao_social."', nome_fantasia = '".$nome_fantasia."', cnpj = '".$cnpj."', 
                        email = '".$email."' 
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
            $page = $config['url']."/templates/fornecedores/index.php";
        } else {
            // Recupera id e armazena em variável
            $id = $_GET['id'];

            // Busca usuário no banco de dados com base no id acima
            $sql = "SELECT * FROM {$tabela} WHERE id = ".$id;

            // Executa o sql
            $query = mysqli_query($conn, $sql);

            // Cria o array da query
            $dados = mysqli_fetch_assoc($query);
    
            // Armazena dados em sessões, para usar no formulário
            $_SESSION["id"] = $dados['id'];
            $_SESSION["razao_social"] = $dados['razao_social'];
            $_SESSION["nome_fantasia"] = $dados['nome_fantasia'];
            $_SESSION["cnpj"] = $dados['cnpj'];
            $_SESSION["email"] = $dados['email'];
    
            // Página de edição
            $page = $config['url']."/templates/fornecedores/editar.php";
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

        // Página de listagem
        $page = $config['url']."/templates/fornecedores/index.php";
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