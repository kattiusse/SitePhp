<a class="navbar-brand" href="<?php echo $config['url']; ?>/templates/dashboard.php" style="font-family: 'Bebas Neue';font-size: 1.4rem">
   <img src="<?php echo $config['url']; ?>/public/assets/img/logo-kachorro-preto.png" alt="Logotipo Kachorro Preto" width="80px" style="margin-right: 0.5rem">
</a>
<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

<p class="d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0" style="color: #fff">
    Olá, <?php echo $_SESSION['auth']['nome']; ?>
</p>

<ul class="navbar-nav ml-auto ml-md-0">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?php echo $config['url']; ?>/templates/usuarios/perfil.php">Perfil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $config['url']; ?>/actions/usuarios.php?acao=logout">Sair</a>
        </div>
    </li>
</ul>