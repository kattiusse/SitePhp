<div class="form-row">                                            
    <div class="col-md-12">
        <div class="form-group">
            <label class="small mb-1">Razão Social</label>
            <input class="form-control py-4" name="razao_social" type="text" placeholder="Digite uma Razão Social" value="<?php echo $_SESSION['razao_social'] ?? ''; ?>" />
        </div>
        <div class="form-group">
            <label class="small mb-1">Nome Fantasia</label>
            <input class="form-control py-4" name="nome_fantasia" type="text" placeholder="Digite um Nome Fantasia" value="<?php echo $_SESSION['nome_fantasia'] ?? ''; ?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">CNPJ</label>
            <input class="form-control py-4" name="cnpj" type="text" placeholder="Digite um CNPJ" value="<?php echo $_SESSION['cnpj'] ?? ''; ?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Email</label>
            <input class="form-control py-4" name="email" type="text" placeholder="Digite um Email" value="<?php echo $_SESSION['email'] ?? ''; ?>" />
        </div>
    </div>
</div>
