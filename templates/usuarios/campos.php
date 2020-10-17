<div class="form-row">                                            
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Nome</label>
            <input class="form-control py-4" name="nome" type="text" placeholder="Digite um Nome" value="<?php echo $_SESSION['nome'] ?? ''; ?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Login</label>
            <input class="form-control py-4" name="login" type="text" placeholder="Digite um Login" value="<?php echo $_SESSION['login'] ?? ''; ?>" />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="small mb-1">Email</label>
    <input class="form-control py-4" name="email" type="email" placeholder="Digite um email" value="<?php echo $_SESSION['email'] ?? ''; ?>" />
</div>
