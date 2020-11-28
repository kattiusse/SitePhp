<?php session_start(); ?>
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
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">

                                        <?php if (!empty($_SESSION["message"])) { ?>
                                            <div class="alert alert-<?php echo $_SESSION["css"]; ?> alert-dismissible fade show" role="alert">
                                                <?php echo $_SESSION["message"]; ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        <?php } ?>

                                        <form action="../actions/usuarios.php?acao=logar" method="POST">
                                            <div class="form-group">
                                                <label class="small mb-1">Email ou Login</label>
                                                <input class="form-control py-4" ttpe="text" name="email_login" placeholder="Digite seu email ou Login" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1">Senha</label>
                                                <input class="form-control py-4" type="password" name="senha" placeholder="Digite sua senha" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">                                                
                                                <button type="submit" class="btn btn-primary">Entrar</button>
                                                <!--<a class="small" href="password.html">Esqueci minha senha</a>-->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <?php require __DIR__."/../includes/footer.php"; ?>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
