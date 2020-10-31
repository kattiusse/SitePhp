<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Cliente</label>
            <select class="form-control" name="id_cliente">
                <option value="0">Selecione um Cliente</option>
                <?php
                require __DIR__."/../../includes/conexao.php";
                $sql = mysqli_query($conn, "SELECT * FROM clientes");
                while($dados = mysqli_fetch_assoc($sql)) { ?>
                    <option <?php echo (isset($_SESSION['id_cliente']) && $_SESSION['id_cliente'] == $dados['id']) ? "selected" : ""; ?> value="<?php echo $dados['id']; ?>"><?php echo $dados['nome']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Produto</label>
            <select class="form-control" name="id_produto">
                <option value="0" selected>Selecione uma Produto</option>
                <?php
                require __DIR__."/../../includes/conexao.php";
                $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE quantidade > 0 GROUP BY nome");
                while($dados = mysqli_fetch_assoc($sql)) { ?>
                    <option <?php echo (isset($_SESSION['id_produto']) && $_SESSION['id_produto'] == $dados['id']) ? "selected" : ""; ?> value="<?php echo $dados['id']; ?>"><?php echo $dados['nome']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Quantidade</label>
            <input class="form-control" name="quantidade" type="number" placeholder="Digite uma Quantidade" value="<?php echo $_SESSION['quantidade'] ?? ''; ?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Status</label>
            <select class="form-control" name="status">
                <option <?php echo (isset($_SESSION['status']) && $_SESSION['status'] == "ABERTO") ? "selected" : ""; ?> value="ABERTO">Aberto</option>
                <option <?php echo (isset($_SESSION['status']) && $_SESSION['status'] == "FECHADO") ? "selected" : ""; ?> value="FECHADO">Fechado</option>
            </select>
        </div>
    </div>
</div>
