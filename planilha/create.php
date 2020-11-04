<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$errors = array();
// Check if POST data is not empty
if (!empty($_POST)) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $negociation = isset($_POST['negociation']) ? $_POST['negociation'] : '';
    $price = isset($_POST['price']) && $_POST['price'] != "" ? "R$ " . $_POST['price'] : '-';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $edition = isset($_POST['edition']) ? $_POST['edition'] : '';
    $language = isset($_POST['language']) ? $_POST['language'] : '';
    $language_dependency = isset($_POST['language_dependency']) ? $_POST['language_dependency'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $owner = isset($_POST['owner']) ? $_POST['owner'] : '';
    $owner_contact = isset($_POST['owner_contact']) ? $_POST['owner_contact'] : '';
    $deliver_region = isset($_POST['deliver_region']) ? $_POST['deliver_region'] : '';
    $wishlist = isset($_POST['wishlist']) ? $_POST['wishlist'] : '';
    $agreement = isset($_POST['agreement']) ? $_POST['agreement'] : '';
    $created_at = date("Y-m-d H:i:s");

    if (strlen($name) < 2 || strlen($owner) < 3 || strlen($owner_contact) < 8) {
        $errors['required'] = 'required-fields';
    }

    if (($negociation === "Troca e Venda" || $negociation === "Venda") && $price === "") {
        $errors['seller'] = 'seller-price';
    }

    if ($agreement != "on") {
        $errors['agreement'] = 'agreement';
    }

    // Insert new record into the boardgames table
    if (count($errors) === 0) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO `boardgames` (
            `name`,
            `negociation`,
            `price`,
            `condition`,
            `edition`,
            `language`,
            `language_dependency`,
            `description`,
            `owner`,
            `owner_contact`,
            `deliver_region`,
            `wishlist`,
            `created_at`
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            $stmt2 = $pdo->prepare('INSERT INTO `boardgames_bkp` (
            `name`,
            `negociation`,
            `price`,
            `condition`,
            `edition`,
            `language`,
            `language_dependency`,
            `description`,
            `owner`,
            `owner_contact`,
            `deliver_region`,
            `wishlist`,
            `created_at`
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            $stmt->execute([
                $name,
                $negociation,
                $price,
                $condition,
                $edition,
                $language,
                $language_dependency,
                $description,
                $owner,
                $owner_contact,
                $deliver_region,
                $wishlist,
                $created_at
            ]);

            $stmt2->execute([
                $name,
                $negociation,
                $price,
                $condition,
                $edition,
                $language,
                $language_dependency,
                $description,
                $owner,
                $owner_contact,
                $deliver_region,
                $wishlist,
                $created_at
            ]);
            // date("Y-m-d H:i:s")
            $msg = 'Jogo adicionado com sucesso!';
            echo '<script>history.pushState({}, "", "")</script>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        // Output message
    }
}
?>

<?= template_header('Adicionar jogo') ?>

<form action="create.php" method="POST" class="add-new-bg" onsubmit="return validateForm()">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Jogo: *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Negociação:</label>
                <select class="form-control" name="negociation">
                    <option value="Troca e Venda">Troca e venda</option>
                    <option value="Troca">Troca</option>
                    <option value="Venda">Venda</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Preço:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                    </div>
                    <input type="text" name="price" class="form-control dinheiro" aria-describedby="priceHelp">
                </div>
                <small id="priceHelp" class="form-text text-muted">Obrigatório para venda.</small>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Condição:</label>
                <select class="form-control" name="condition">
                    <option value="Lacrado">Lacrado</option>
                    <option value="Ótimo estado (como novo)">Ótimo estado (como novo)</option>
                    <option value="Bom estado">Bom estado</option>
                    <option value="Avariado">Avariado</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Editora:</label>
                <input type="text" name="edition" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Idioma do jogo:</label>
                <input type="text" name="language" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Depend. de Idioma:</label>
                <select class="form-control" name="language_dependency">
                    <option value="Jogo em pt-br">Jogo em pt-br</option>
                    <option value="Alta dependência">Alta dependência</option>
                    <option value="Media dependência">Media dependência</option>
                    <option value="Pouca dependência">Pouca dependência</option>
                    <option value="Sem dependência">Sem dependência</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Responsável: *</label>
                <input type="text" name="owner" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Whatsapp: *</label>
                <input type="text" name="owner_contact" class="form-control celular" required>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Lista de desejos:</label>
                <div class="input-group">
                    <input type="text" name="wishlist" class="form-control">
                </div>
                <small id="priceHelp" class="form-text text-muted">Adicione o link da sua lista na Ludopedia ou BGG caso possua.</small>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Região de entrega:</label>
                <div class="input-group">
                    <input type="text" name="deliver_region" class="form-control">
                </div>
                <small id="priceHelp" class="form-text text-muted">Informe o bairro onde o jogo pode ser retirado.</small>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="agreement" name="agreement" class="form-control">
                <label class="form-check-label terms" for="agreement">
                    Estou ciente que os jogos devem ser retirados/entregues em
                    <b>BELO HORIZONTE</b>
                </label>
            </div>
        </div>
        <div class="col-12">
            <small>Os campos com * são obrigatórios.</small>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Adicionar jogo</button>
        </div>
    </div>
</form>

<?php if ($msg) : ?>
    <div class="alert alert-success" role="alert"><?= $msg ?></div>
<?php endif; ?>

<div class="alert alert-danger" style="display: none;" role="alert"></div>
<script>
    function validateForm() {
        const bg = $('input[name="name"]').val();
        const owner = $('input[name="owner"]').val();
        const owner_contact = $('input[name="owner_contact"]').val();
        const negociation = $('select[name="negociation"]').val();
        const price = $('input[name="price"]').val();
        const agreement = $('input[name="agreement"]').is(':checked');
        let errors = 0;

        $('.alert-danger').empty();

        if (bg == "") {
            $('input[name="name"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
        }
        if (owner == "") {
            $('input[name="owner"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
        }
        if (owner_contact == "") {
            $('input[name="owner_contact"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
        }

        if (bg === "" || owner === "" || owner_contact === "") {
            $('.alert-danger').append("Os campos <b>Jogo</b>, <b>Responsável</b> e <b>Whatsapp</b> são obrigatórios.<br />");
            errors++;
        }
        if ((negociation === "Troca e Venda" || negociation === "Venda") && price === "") {
            $('.alert-danger').append("O preço é obrigatório caso a negociação inclua venda.<br />");
            errors++;
        }
        if (!agreement) {
            $('.alert-danger').append("Você deve marcar que está ciente sobre a retirada e entrega dos jogos somente em BH.<br />");
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