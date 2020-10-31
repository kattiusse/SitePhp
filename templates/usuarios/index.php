<?php 
// Verifica se usuário está logado
require __DIR__."/../../includes/verifica_login.php";
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
        <link href="<?php echo $config['url']; ?>/public/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <?php require __DIR__."/../../includes/header.php"; ?>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <?php require __DIR__."/../../includes/menu.php"; ?>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Usuários</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard >> Usuários</li>
                        </ol>

                        <?php if (!empty($_SESSION["message"])) { ?>
                            <div class="alert alert-<?php echo $_SESSION["css"]; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION["message"]; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">                                        
                                        <button class="btn btn-success"><a style="color: #fff; text-decoration:none;" href="<?php echo $config['url']; ?>/actions/usuarios.php?acao=cadastrar"><i class="fas fa-plus mr-1"></i> Adicionar</a></button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Login</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        require __DIR__."/../../includes/conexao.php";
                                                        $sql = mysqli_query($conn, "SELECT * FROM usuarios");
                                                        while($dados = mysqli_fetch_assoc($sql)) { ?>
                                                            <tr>
                                                                <td><?php echo $dados['nome']; ?></td>
                                                                <td><?php echo $dados['login']; ?></td>
                                                                <td>
                                                                    <a href="<?php echo $config['url']; ?>/actions/usuarios.php?acao=editar&id=<?php echo $dados['id']; ?>"><i class="fas fa-pencil-alt"></i></a> &nbsp;
                                                                    <a href="<?php echo $config['url']; ?>/actions/usuarios.php?acao=deletar&id=<?php echo $dados['id']; ?>"><i class="fas fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php } 
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <?php require __DIR__."/../../includes/footer.php"; ?>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo $config['url']; ?>/public/js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo $config['url']; ?>/public/assets/demo/datatables-demo.js"></script>
    </body>
</html>
