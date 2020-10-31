<?php
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";

// Conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Tabela do banco de dados
$tabela = 'produtos';

// Destruindo sessão de campos 
unset($_SESSION['id_fornecedor']);
unset($_SESSION['id_categoria']);
unset($_SESSION['nome']);
unset($_SESSION['descricao']);
unset($_SESSION['quantidade']);
unset($_SESSION['preco']);

// Destruindo sessão de 'message' e 'css' 
unset($_SESSION['message']);
unset($_SESSION['css']);

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) { 
    // É listagem
    case 'index':
        $page = $config['url']."/templates/produtos/index.php";
    break; 
    
    // É cadastrar
    case 'cadastrar':
        // Página de cadastro
        $page = $config['url']."/templates/produtos/cadastrar.php";

        // Dados enviados
        if ($_POST) {

            // Armazena dados em variáveis
            $id_fornecedor = $_POST["id_fornecedor"];            
            $id_categoria = $_POST["id_categoria"];
            $nome = $_POST["nome"];
            $descricao = $_POST["descricao"];
            $quantidade = $_POST["quantidade"];
            $preco = str_replace(',', '.', $_POST["preco"]); 

            // Campos obrigatórios foram enviados
            if (empty($id_fornecedor) && empty($id_categoria) && empty($nome) && empty($quantidade) && empty($preco)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = $config['url']."/templates/produtos/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["id_fornecedor"] = $id_fornecedor;                
                $_SESSION["id_categoria"] = $id_categoria;
                $_SESSION["nome"] = $nome;
                $_SESSION["descricao"] = $descricao;
                $_SESSION["quantidade"] = $quantidade;
                $_SESSION["preco"] = $preco;

                // Cálculo de valor total
                $valor_total = $preco * $quantidade;

                // Cria script de insert
                $sql = "
                    INSERT INTO {$tabela} (id_fornecedor, id_categoria, nome, descricao, quantidade, preco, valor_total, data_entrada)
                        VALUES (".$id_fornecedor.", ".$id_categoria.", '".$nome."', '".$descricao."', ".$quantidade.", ".$preco.", ".$valor_total.", '".date('Y-m-d h:i:s')."')
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
                $page = $config['url']."/templates/produtos/index.php";
            }           
        }
        
        break;
    // É editar
    case 'editar':
         // Dados enviados
        if ($_POST) {
            // Armazena dados em variáveis
            $id = $_POST['id'];
            $id_fornecedor = $_POST["id_fornecedor"];
            $id_categoria = $_POST["id_categoria"];
            $nome = $_POST["nome"];
            $descricao = $_POST["descricao"];            
            $quantidade = $_POST["quantidade"];
            $preco = str_replace(',', '.', $_POST["preco"]);

            // Cálculo de valor total
            $valor_total = $_POST["preco"] * $quantidade;

            // Cria script de update
            $sql = "
                UPDATE {$tabela} SET id_fornecedor = ".$id_fornecedor.", id_categoria = ".$id_categoria.", nome = '".$nome."', 
                    descricao = '".$descricao."', quantidade = ".$quantidade.", preco = ".$preco.", valor_total = ".$valor_total." 
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
            $page = $config['url']."/templates/produtos/index.php";
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
            $_SESSION["id_fornecedor"] = $dados['id_fornecedor'];
            $_SESSION["id_categoria"] = $dados['id_categoria'];
            $_SESSION["nome"] = $dados['nome'];
            $_SESSION["descricao"] = $dados['descricao'];            
            $_SESSION["quantidade"] = $dados['quantidade'];
            $_SESSION["preco"] = $dados['preco'];            
    
            // Página de edição
            $page = $config['url']."/templates/produtos/editar.php";
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
        $page = $config['url']."/templates/produtos/index.php";
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