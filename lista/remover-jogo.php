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

    if (strlen($name) < 2 || strlen($owner) < 3) {
        $errors['required'] = 'required-fields';
    }

    // Insert new record into the boardgames table
    if (count($errors) === 0) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO `gamesToRemove` (`name`,`owner`,`reason`) VALUES (?, ?, ?)');

            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(1, $owner, PDO::PARAM_STR);
            $stmt->bindValue(1, $reason, PDO::PARAM_STR);

            $stmt->execute();

            $msg = 'Solicitação para remover jogo feita com sucesso! Seu jogo será removido em breve.';
            echo '<script>history.pushState({}, "", "")</script>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        // Output message
    }
}
try {
    $stmt2 = $pdo->prepare('SELECT * FROM gamesToRemove ORDER BY id');
    $stmt2->execute();
    $gamesToRemove = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<?= template_header('Remover jogo') ?>

<form action="remover-jogo.php" method="POST" class="add-new-bg" onsubmit="return validateRemoveForm()">
    <div class="row">
        <div class="col-12">
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
        <div class="col-12">
            <small>Os campos com * são obrigatórios.</small>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-danger">Solicitar remoção</button>
        </div>
    </div>
</form>

<div class="games-to-remove">
    <h5> Jogos a serem removidos </h5>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div style="flex: 4">JOGO</div>
            <div style="flex: 4">RESPONSÁVEL</div>
            <div style="flex: 4">MOTIVO</div>
        </div>
        <?php foreach ($gamesToRemove as $bg) : ?>
            <div class="d-inline-flex justify-content-start align-items-center bg-item">
                <div style="flex: 4"><b><?= ucwords($bg['name']) ?></b></div>
                <div style="flex: 4"><?= $bg['owner'] ?></div>
                <div style="flex: 4"><?= $bg['reason'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<hr />
<div class="games-to-remove">
    <h5> Histórico de negociações </h5>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div style="flex: 4">JOGO</div>
            <div style="flex: 4">RESPONSÁVEL</div>
            <div style="flex: 4">MOTIVO</div>
        </div>
        <?php foreach ($gamesToRemove as $bg) : ?>
            <?php if ($bg['reason'] == "Troca pelo grupo" || $bg['reason'] != "Venda pelo grupo") : ?>
                <div class="d-inline-flex justify-content-start align-items-center bg-item">
                    <div style="flex: 4"><b><?= ucwords($bg['name']) ?></b></div>
                    <div style="flex: 4"><?= $bg['owner'] ?></div>
                    <div style="flex: 4"><?= $bg['reason'] ?></div>
                </div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
</div>

<?php if ($msg) : ?>
    <div class="alert alert-success" role="alert"><?= $msg ?></div>
<?php endif; ?>

<div class="alert alert-danger" style="display: none;" role="alert"></div>
<script>
    function validateForm() {
        const bg = $('input[name="name"]').val();
        const owner = $('input[name="owner"]').val();
        const reason = $('select[name="reason"]').val();
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

        console.log("errors", errors);
        if (errors) {
            $('.alert-danger').show();
            return false;
        }
    }
</script>

<?= template_footer() ?>