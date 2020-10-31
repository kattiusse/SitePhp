<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Fornecedor</label>
            <select class="form-control" name="id_fornecedor">
                <option value="0">Selecione um Fornecedor</option>
                <?php
                require __DIR__."/../../includes/conexao.php";
                $sql = mysqli_query($conn, "SELECT * FROM fornecedores");
                while($dados = mysqli_fetch_assoc($sql)) { ?>
                    <option <?php echo (isset($_SESSION['id_fornecedor']) && $_SESSION['id_fornecedor'] == $dados['id']) ? "selected" : ""; ?> value="<?php echo $dados['id']; ?>"><?php echo $dados['nome_fantasia']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Categoria</label>
            <select class="form-control" name="id_categoria">
                <option value="0" selected>Selecione uma Categoria</option>
                <?php
                require __DIR__."/../../includes/conexao.php";
                $sql = mysqli_query($conn, "SELECT * FROM categorias");
                while($dados = mysqli_fetch_assoc($sql)) { ?>
                    <option <?php echo (isset($_SESSION['id_categoria']) && $_SESSION['id_categoria'] == $dados['id']) ? "selected" : ""; ?> value="<?php echo $dados['id']; ?>"><?php echo $dados['nome']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="small mb-1">Nome</label>
            <input class="form-control py-4" name="nome" type="text" placeholder="Digite um Nome" value="<?php echo $_SESSION['nome'] ?? ''; ?>" />
        </div>
        <div class="form-group">
            <label class="small mb-1">Descrição</label>
            <textarea class="form-control py-4" name="descricao" placeholder="Digite uma Descrição"><?php echo $_SESSION['descricao'] ?? ''; ?></textarea>

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Quantidade</label>
            <input class="form-control py-4" name="quantidade" type="number" placeholder="Digite uma Quantidade" value="<?php echo $_SESSION['quantidade'] ?? ''; ?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="small mb-1">Valor Unitário</label>
            <input class="form-control py-4" name="preco" type="text" placeholder="Digite um Preço" value="<?php echo $_SESSION['preco'] ?? ''; ?>" />
        </div>
    </div>
</div>
