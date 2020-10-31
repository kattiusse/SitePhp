<?php
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";

// Conexão com banco de dados
require __DIR__."/../includes/conexao.php";

// Tabela do banco de dados
$tabela = 'pedidos';

// Destruindo sessão de campos 
unset($_SESSION['id_cliente']);
unset($_SESSION['id_produto']);
unset($_SESSION['id_usuario']);
unset($_SESSION['quantidade']);
unset($_SESSION['status']);

// Destruindo sessão de 'message' e 'css' 
unset($_SESSION['message']);
unset($_SESSION['css']);

// Requisição GET, verificar qual ação 
switch ($_GET['acao']) { 
    // É listagem
    case 'index':
        $page = $config['url']."/templates/pedidos/index.php";
    break; 
    
    // É cadastrar
    case 'cadastrar':
        // Página de cadastro
        $page = $config['url']."/templates/pedidos/cadastrar.php";

        // Dados enviados
        if ($_POST) {

            // Armazena dados em variáveis
            $id_cliente = $_POST["id_cliente"];            
            $id_produto = $_POST["id_produto"];
            $quantidade = $_POST["quantidade"];            
            $status = $_POST["status"];

            // Campos obrigatórios foram enviados
            if (empty($id_cliente) && empty($id_produto) && empty($quantidade)) {
                $message = 'Favor preecher os campos obrigatórios';
                $css = 'danger';
                $page = $config['url']."/templates/pedidos/cadastrar.php";
            } else {
                // Armazena dados em sessões, para usar no formulário
                $_SESSION["id_cliente"] = $id_cliente;                
                $_SESSION["id_produto"] = $id_produto;
                $_SESSION["quantidade"] = $quantidade;
                $_SESSION["status"] = $status;

                // Busca o produto no banco de dados
                $sqlProduto = "SELECT * FROM produtos WHERE id = ".$id_produto;

                // Executa o sql
                $queryProdutos = mysqli_query($conn, $sqlProduto);

                // Cria o array da query
                $dadosProduto = mysqli_fetch_assoc($queryProdutos);

                // Cálculo do valor total
                $valor_total = $dadosProduto['preco'] * $quantidade;

                // Cria script de insert
                $sql = "
                    INSERT INTO {$tabela} (id_cliente, id_produto, id_usuario, valor_total, quantidade, status, data_pedido)
                        VALUES (".$id_cliente.", ".$id_produto.", ".$_SESSION['auth']['id'].", ".$valor_total.", ".$quantidade.", '".$status."', '".date('Y-m-d h:i:s')."')
                ";

                // Verifica se o script acima foi executado
                if ($conn->query($sql) == TRUE) {
                    
                    // Status do pedido é fechado
                    if ($status == 'FECHADO') {

                        // Cálculo de quantidade atual do produto
                        $quantidadeProduto = $dadosProduto['quantidade'] - $quantidade;

                        // Cálculo de valor atual do produto
                        $valorTotalProduto = $dadosProduto["preco"] * $quantidadeProduto;

                        // Cria script de update
                        $sql = "
                            UPDATE produtos SET quantidade = ".$quantidadeProduto.", valor_total = ".$valorTotalProduto." 
                                WHERE id = ".$dadosProduto['id']
                        ;

                        // Executa conexão
                        $conn->query($sql);
                    }

                    $message = 'Cadastro realizado com sucesso';
                    $css = 'success';
                } else {
                    $message = 'Erro ao realizar cadastro';
                    $css = 'danger';
                }

                // Fecha conexão com o banco de dados
                $conn->close();

                // Página de listagem
                $page = $config['url']."/templates/pedidos/index.php";
            }           
        }
        
        break;
    // É editar
    case 'editar':
         // Dados enviados
        if ($_POST) {
            // Armazena dados em variáveis
            $id = $_POST['id'];
            $id_cliente = $_POST["id_cliente"];            
            $id_produto = $_POST["id_produto"];
            $quantidade = $_POST["quantidade"];
            $status = $_POST["status"];

            /* === Busca os dados atuais do pedido === */

            // Busca o dados no banco de dados
            $sqAtual = "SELECT * FROM {$tabela} WHERE id = ".$id;

            // Executa o sql
            $queryAtual = mysqli_query($conn, $sqAtual);

            // Cria o array da query
            $dadosAtual = mysqli_fetch_assoc($queryAtual);

            /* === Busca os dados do produto selecionado === */

            // Busca o produto no banco de dados
            $sqlProduto = "SELECT * FROM produtos WHERE id = ".$id_produto;

            // Executa o sql
            $queryProdutos = mysqli_query($conn, $sqlProduto);

            // Cria o array da query
            $dadosProduto = mysqli_fetch_assoc($queryProdutos);

            // Cálculo do valor total
            $valor_total = $dadosProduto['preco'] * $quantidade;

            // Cria script de update
            $sql = "
                UPDATE {$tabela} SET id_cliente = ".$id_cliente.", id_produto = ".$id_produto.", 
                    quantidade = ".$quantidade.", valor_total = '".$valor_total."', status = '".$status."' 
                        WHERE id = ".$id
            ;

            // Verifica se o script acima foi executado
            if ($conn->query($sql) == TRUE) {

                // Status do pedido é fechado
                if (($status == 'FECHADO') && ($dadosAtual["status"] == 'ABERTO')) {
                    // Cálculo de quantidade atual do produto
                    $quantidadeProduto = $dadosProduto['quantidade'] - $quantidade;

                    // Cálculo de valor atual do produto
                    $valorTotalProduto = $dadosProduto["preco"] * $quantidadeProduto;

                    // Cria script de update
                    $sql = "
                        UPDATE produtos SET quantidade = ".$quantidadeProduto.", valor_total = ".$valorTotalProduto." 
                                WHERE id = ".$dadosProduto['id']
                    ;

                    // Executa sql
                    $conn->query($sql);
                }

                $message = 'Cadastro alterado com sucesso';
                $css = 'success';
            } else {
                $message = 'Erro ao alterar cadastro';
                $css = 'danger';
            }

            // Página de listagem
            $page = $config['url']."/templates/pedidos/index.php";
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
            $_SESSION["id_cliente"] = $dados["id_cliente"];            
            $_SESSION["id_produto"] = $dados["id_produto"];
            $_SESSION["id_usuario"] = $dados["id_usuario"];
            $_SESSION["quantidade"] = $dados["quantidade"];
            $_SESSION["status"] = $dados["status"];
    
            // Página de edição
            $page = $config['url']."/templates/pedidos/editar.php";
        }
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