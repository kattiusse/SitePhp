<?php 
// Verifica se usuário está logado
require __DIR__."/../includes/verifica_login.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Adega Kachorro Preto</title>
        <link href="../public/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <?php require __DIR__."/../includes/header.php"; ?>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <?php require __DIR__."/../includes/menu.php"; ?>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Adega Kachorro Preto</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-8">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Gráfico de Vendas - Ano base <?php echo date('Y'); ?> 
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Relatório de Estoque
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th>Nome do Produto</th>
                                                <th>Quantidade</th>
                                                <th>Valor Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                require __DIR__."/../includes/conexao.php";
                                                $sql = mysqli_query($conn, "
                                                    SELECT 
                                                        p.id, p.nome, SUM(p.quantidade) AS quantidade, SUM(p.valor_total) as valor_total, c.nome AS categoria
                                                            FROM produtos AS p 
                                                                INNER JOIN categorias AS c ON p.id_categoria = c.id
                                                                    GROUP BY p.nome
                                                ");
                                                while($dados = mysqli_fetch_assoc($sql)) { ?>
                                                    <tr>
                                                        <td><?php echo $dados['categoria']; ?></td>
                                                        <td><?php echo $dados['nome']; ?></td>
                                                        <td><?php echo $dados['quantidade']; ?></td>
                                                        <td><?php echo "R$ ".number_format($dados['valor_total'], 2, ",", "."); ?></td>
                                                    </tr>
                                                <?php } 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <?php require __DIR__."/../includes/footer.php"; ?>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../public/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../public/assets/demo/datatables-demo.js"></script>
    </body>
</html>

<?php
$sqlBarras = mysqli_query($conn, "
    SELECT 
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '01') AS 'janeiro',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '02') AS 'fevereiro',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '03') AS 'marco',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '04') AS 'abril',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '05') AS 'maio',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '06') AS 'junho',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '07') AS 'julho',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '08') AS 'agosto',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '09') AS 'setembro',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '10') AS 'outubro',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '11') AS 'novembro',
        (SELECT sum(quantidade) FROM pedidos WHERE YEAR(data_pedido) = '".date('Y')."' AND MONTH(data_pedido) = '12') AS 'dezembro'
");
$barras = mysqli_fetch_assoc($sqlBarras);
?>

<script>
$(document).ready(function() {
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                "Janeiro", 
                "Fevereiro", 
                "Março", 
                "Abril", 
                "Maio", 
                "Junho", 
                "Julho", 
                "Agosto", 
                "Setembro", 
                "Outubro", 
                "Novembro", 
                "Dezembro"
            ],
            datasets: [{
                label: "Quantidade",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: [
                    <?php echo $barras['janeiro']; ?>,
                    <?php echo $barras['fevereiro']; ?>,
                    <?php echo $barras['marco']; ?>,
                    <?php echo $barras['abril']; ?>,
                    <?php echo $barras['maio']; ?>,
                    <?php echo $barras['junho']; ?>,
                    <?php echo $barras['julho']; ?>,
                    <?php echo $barras['agosto']; ?>,
                    <?php echo $barras['setembro']; ?>,
                    <?php echo $barras['outubro']; ?>,
                    <?php echo $barras['novembro']; ?>,
                    <?php echo $barras['dezembro']; ?>
                ],
            }],
        },
        options: {
            scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 12
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 300,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
            },
            legend: {
                display: false
            }
        }
    });
});
</script>
