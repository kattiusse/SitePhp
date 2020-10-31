<?php
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";

// Conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Tabela do banco de dados
$tabela = 'categorias';

// Destruindo sessão de campos 
unset($_SESSION['nome']);

// Destruindo sessão de 'message' e 'css' 
unset($_SESSION['message']);
unset($_SESSION['css']);

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) { 
    // É listagem
    case 'index':
        $page = $config['url']."/templates/categorias/index.php";
    break; 
    
    // É cadastrar
    case 'cadastrar':
        // Página de cadastro
        $page = $config['url']."/templates/categorias/cadastrar.php";

        // Dados enviados
        if ($_POST) {

            // Armazena dados em variáveis
            $nome = $_POST["nome"];

            // Campos obrigatórios foram enviados
            if (empty($nome)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = $config['url']."/templates/categorias/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["nome"] = $nome;

                // Busca categoria no banco de dados
                $sql = "SELECT * FROM {$tabela} WHERE nome = '".$nome."' ";

                // Executa o sql
                $query = mysqli_query($conn, $sql);

                // Cria o array da query
                $dados = mysqli_fetch_assoc($query);
                
                // Verifica se campos de senha são iguais
                if (!empty($dados['nome'])) {
                    $message = 'Já existe uma categoria com esse nome';
                    $css = 'danger';
                    $page = $config['url']."/templates/categorias/cadastrar.php"; 
                // Validações estão OK       
                } else {
                    // Cria script de insert
                    $sql = "
                        INSERT INTO {$tabela} (nome)
                            VALUES ('".$nome."')
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
                    $page = $config['url']."/templates/categorias/index.php";
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
            
            // Cria script de update
            $sql = "
                UPDATE {$tabela} SET nome = '".$nome."' 
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

            // Página de listagem
            $page = $config['url']."/templates/categorias/index.php";
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
            $_SESSION["nome"] = $dados['nome'];
    
            // Página de edição
            $page = $config['url']."/templates/categorias/editar.php";
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
        $page = $config['url']."/templates/categorias/index.php";
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