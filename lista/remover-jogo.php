<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$errors = array();
// Check if POST data is not empty
if (!empty($_POST)) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $owner = isset($_POST['owner']) ? $_POST['owner'] : '';
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $agreement = isset($_POST['agreement']) ? true : false;

    if (strlen($name) < 2 || strlen($owner) < 3) {
        $errors['required'] = 'required-fields';
    }

    // Insert new record into the boardgames table
    if (count($errors) === 0) {
        try {

            // Inserir na tabela a ser removido
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO `gamesToRemove` (`name`,`owner`,`reason`, `value`, `condition`, `visible`, `agreement`) VALUES (?, ?, ?, ?, ?, ?, ?)');

            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $owner, PDO::PARAM_STR);
            $stmt->bindValue(3, $reason, PDO::PARAM_STR);
            $stmt->bindValue(4, $value, PDO::PARAM_STR);
            $stmt->bindValue(5, $condition, PDO::PARAM_STR);
            $stmt->bindValue(6, true, PDO::PARAM_BOOL);
            $stmt->bindValue(7, $agreement, PDO::PARAM_BOOL);

            $stmt->execute();

            // Inserir na tabela de historico de negociações
            $stmtRemoved = $pdo->prepare('INSERT INTO `removedGames` (`name`,`owner`,`reason`, `value`, `condition`, `visible`) VALUES (?, ?, ?, ?, ?, ?)');

            $visible = $reason == "Troca pelo grupo" || $reason == "Venda pelo grupo";
            $stmtRemoved->bindValue(1, $name, PDO::PARAM_STR);
            $stmtRemoved->bindValue(2, $owner, PDO::PARAM_STR);
            $stmtRemoved->bindValue(3, $reason, PDO::PARAM_STR);
            $stmtRemoved->bindValue(4, $value, PDO::PARAM_STR);
            $stmtRemoved->bindValue(5, $condition, PDO::PARAM_STR);
            $stmtRemoved->bindValue(6, $visible, PDO::PARAM_BOOL);

            $stmtRemoved->execute();

            $msg = 'Solicitação para remover jogo feita com sucesso! Seu jogo será removido em breve.';
            echo '<script>history.pushState({}, "", "")</script>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            $errorMesg = "Ocorreu um erro com a solicitação. Tente novamente ou entre em contato com a equipe BGBH." . $e->getMessage();
        }
        // Output message
    }
}
try {
    $stmt2 = $pdo->prepare('SELECT * FROM gamesToRemove WHERE visible = true ORDER BY id DESC');
    $stmt2->execute();
    $gamesToRemove = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $stmt3 = $pdo->prepare('SELECT * FROM removedGames WHERE visible = true ORDER BY id DESC');
    $stmt3->execute();
    $removedGames = $stmt3->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<?= template_header('Remover jogo') ?>

<form action="remover-jogo.php" method="POST" class="add-new-bg" onsubmit="return validateRemoveForm()">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Nome do jogo: *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Responsável: *</label>
                <input type="text" name="owner" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Motivo: *</label>
                <select class="form-control" name="reason">
                    <option value="Troca pelo grupo">Troca pelo grupo</option>
                    <option value="Venda pelo grupo">Venda pelo grupo</option>
                    <option value="Negociação fora do grupo">Negociação fora do grupo</option>
                    <option value="Desistência">Desistência</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Condição em que o jogo estava:</label>
                <select class="form-control" name="condition">
                    <option value="Lacrado">Lacrado</option>
                    <option value="Ótimo estado (como novo)">Ótimo estado (como novo)</option>
                    <option value="Bom estado">Bom estado</option>
                    <option value="Avariado">Avariado</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Preço da venda: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                    </div>
                    <input type="text" name="value" class="form-control dinheiro" aria-describedby="priceHelp">
                </div>
                <small id="priceHelp" class="form-text text-muted">Informe o valor efetivo da venda, caso se aplique</small>
            </div>
        </div>
        <div class="col-12 d-flex">
            <div class="form-group form-check align-self-center">
                <input type="checkbox" class="form-check-input" id="agreement" name="agreement" class="form-control">
                <label class="form-check-label terms" for="agreement">
                    Estou ciente e autorizo a veiculação dessas informações no histórico de vendas/trocas do site.
                </label>
            </div>
        </div>
        <div class="col-12">
            <small>Os campos com * são obrigatórios. Os demais são opcionais.</small>
        </div>
        <?php if ($msg) : ?>
            <div class="col-12 text-center">
                <div class="alert alert-success" role="alert"><?= $msg ?></div>
            </div>
        <?php endif; ?>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-danger">Solicitar remoção</button>
        </div>
    </div>
</form>

<div class="games-to-remove">
    <h5> Histórico de negociações </h5>
    <small>(apenas jogos negociados a partir do grupo ou lista BGBH)</small>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div class="text-center" style="flex: 3">Jogo</div>
            <div class="text-center" style="flex: 3">Responsável</div>
            <div class="text-center d-none d-lg-block" style="flex: 3">Motivo</div>
            <div class="text-center" style="flex: 3">Condição</div>
            <div class="text-center" style="flex: 3">Preço da venda (R$)</div>
        </div>
        <?php foreach ($removedGames as $bg) : ?>
            <?php if ($bg['reason'] == "Troca pelo grupo" || $bg['reason'] == "Venda pelo grupo") : ?>
                <div class="d-inline-flex justify-content-start align-items-center bg-item">
                    <div class="text-center" style="flex: 3"><b><?= ucwords($bg['name']) ?></b></div>
                    <div class="text-center" style="flex: 3"><?= $bg['owner'] ?></div>
                    <div class="text-center d-none d-lg-block" style="flex: 3"><?= $bg['reason'] ?></div>
                    <div class="text-center" style="flex: 3"><?= $bg['condition'] ?></div>
                    <div class="text-center" style="flex: 3"><?= $bg['value'] ?></div>
                </div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
</div>
<hr />
<div class="games-to-remove"></div>
<h5> Jogos a serem removidos </h5>
<div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
    <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
        <div class="text-center" style="flex: 3">Jogo</div>
        <div class="text-center" style="flex: 3">Responsável</div>
        <div class="text-center d-none d-lg-block" style="flex: 3">Motivo</div>
        <div class="text-center" style="flex: 3">Condição</div>
        <div class="text-center" style="flex: 3">Preço da venda (R$)</div>
    </div>
    <?php foreach ($gamesToRemove as $bg) : ?>
        <div class="d-inline-flex justify-content-start align-items-center bg-item">
            <div class="text-center" style="flex: 3"><b><?= ucwords($bg['name']) ?></b></div>
            <div class="text-center" style="flex: 3"><?= $bg['owner'] ?></div>
            <div class="text-center d-none d-lg-block" style="flex: 3"><?= $bg['reason'] ?></div>
            <div class="text-center" style="flex: 3"><?= $bg['condition'] ?></div>
            <div class="text-center" style="flex: 3"><?= $bg['value'] ?></div>
        </div>
    <?php endforeach; ?>
</div>
</div>

<div class="alert alert-danger" style="display: none;" role="alert"></div>
<?php if ($errorMesg) {
    echo '<div class="alert alert-danger" style="display: none;" role="alert">' . $errorMesg . '</div>';
}
?>
<script>
    function validateForm() {
        const bg = $('input[name="name"]').val();
        const owner = $('input[name="owner"]').val();
        const reason = $('select[name="reason"]').val();
        const agreement = $('input[name="agreement"]').is(':checked');
        let errors = 0;

        $('.alert-danger').empty();

        if (bg == "") {
            $('input[name="name"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
            errors++;
        }
        if (owner == "") {
            $('input[name="owner"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
            errors++;
        }
        if (reason == "") {
            $('select[name="reason"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
            errors++;
        }
        if (!agreement) {
            $('.alert-danger').append("Você deve marcar que está ciente e autoriza a veiculação dessas informações no histórico de vendas/trocas do site <br />");
            errors++;
        }

        console.log("errors", errors);
        if (errors) {
            $('.alert-danger').show();
            return false;
        }
    }
</script>

<?= template_footer() ?>