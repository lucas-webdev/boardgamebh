<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$errors = array();
// Check if POST data is not empty
if (isset($_GET['id'])) {
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
        $wishlist = isset($_POST['wishlist']) ? $_POST['wishlist'] : '';

        if (strlen($name) < 2 || strlen($owner) < 3 || strlen($owner_contact) < 8) {
            $errors['required'] = 'required-fields';
        }

        if (($negociation === "Troca e Venda" || $negociation === "Venda") && $price === "") {
            $errors['seller'] = 'seller-price';
        }

        // Insert new record into the boardgames table
        if (count($errors) === 0) {
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->prepare('UPDATE `boardgames` SET (
                    name = ?,
                    negociation = ?,
                    price = ?,
                    condition = ?,
                    edition = ?,
                    language = ?,
                    language_dependency = ?,
                    description = ?,
                    owner = ?,
                    owner_contact = ?,
                    wishlist = ?,
                    WHERE id = ?');

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
                    $wishlist,
                    $_GET['id']
                ]);
                // date("Y-m-d H:i:s")
                $msg = 'Jogo atualizado com sucesso!';
                echo '<script>history.pushState({}, "", "")</script>';
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            // Output message
        }
        // Get the boardgame from the boardgames table

    }
} else {
    exit('ID não especificado!');
}
?>

<?= template_header('Update') ?>
<?php
$stmt = $pdo->prepare('SELECT * FROM boardgames WHERE id = ?');
$stmt->execute([$_GET['id']]);
$bg = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$bg) {
    exit('Não foi encontrado jogo com esse ID!');
}
?>

<form action="update.php?id=<?= $bg['id'] ?>" method="POST" class="add-new-bg" onsubmit="return validateForm()">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Jogo: *</label>
                <input type="text" name="name" class="form-control" value="<?= $bg['name'] ?>" required>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Negociação:</label>
                <select class="form-control" name="negociation">
                    <option value="Troca e Venda" selected="<?= $bg['negociation'] === "Troca e Venda" ?>">Troca e venda</option>
                    <option value="Troca" selected="<?= $bg['negociation'] === "Troca" ?>">Troca</option>
                    <option value="Venda" selected="<?= $bg['negociation'] === "Venda" ?>">Venda</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Preço:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                    </div>
                    <input type="text" name="price" class="form-control dinheiro" aria-describedby="priceHelp" value="<?= $bg['price'] ?>">
                </div>
                <small id="priceHelp" class="form-text text-muted">Obrigatório para venda.</small>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Condição:</label>
                <select class="form-control" name="condition">
                    <option value="Lacrado" selected="<?= $bg['condition'] === "Lacrado" ?>">Lacrado</option>
                    <option value="Ótimo estado (como novo)" selected="<?= $bg['condition'] === "Ótimo estado (como novo)" ?>">Ótimo estado (como novo)</option>
                    <option value="Bom estado" selected="<?= $bg['condition'] === "Bom estado" ?>">Bom estado</option>
                    <option value="Avariado" selected="<?= $bg['condition'] === "Avariado" ?>">Avariado</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Edição / Editora:</label>
                <input type="text" name="edition" class="form-control" value="<?= $bg['edition'] ?>">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Idioma do jogo:</label>
                <input type="text" name="language" class="form-control" value="<?= $bg['language'] ?>">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Depend. de Idioma:</label>
                <select class="form-control" name="language_dependency">
                    <option value="Jogo em pt-br" selected="<?= $bg['language_dependency'] === "Jogo em pt-br" ?>">Jogo em pt-br</option>
                    <option value="Alta dependência" selected="<?= $bg['language_dependency'] === "Alta dependência" ?>">Alta dependência</option>
                    <option value="Media dependência" selected="<?= $bg['language_dependency'] === "Media dependência" ?>">Media dependência</option>
                    <option value="Pouca dependência" selected="<?= $bg['language_dependency'] === "Pouca dependência" ?>">Pouca dependência</option>
                    <option value="Sem dependência" selected="<?= $bg['language_dependency'] === "Sem dependência" ?>">Sem dependência</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="description" class="form-control"><?= $bg['description'] ?></textarea>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Responsável: *</label>
                <input type="text" name="owner" class="form-control" required value="<?= $bg['owner'] ?>">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Whatsapp: *</label>
                <input type="text" name="owner_contact" class="form-control celular" required value="<?= $bg['owner_contact'] ?>">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Link wishlist:</label>
                <input type="text" name="wishlist" class="form-control" value="<?= $bg['wishlist'] ?>">
            </div>
        </div>

        <div class="col-12">
            <small>Os campos com * são obrigatórios.</small>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Enviar</button>
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
        let errors = 0;

        $('.alert-danger').empty();

        if (bg === "" || owner === "" || owner_contact === "") {
            $('input[name="name"').css('border-color', bg === '' ? '#ff3232' : '#ced4da');
            $('input[name="owner"').css('border-color', owner === '' ? '#ff3232' : '#ced4da');
            $('input[name="owner_contact"').css('border-color', owner_contact === '' ? '#ff3232' : '#ced4da');
            $('.alert-danger').append("Os campos <b>Jogo</b>, <b>Responsável</b> e <b>Whatsapp</b> são obrigatórios.<br />");
            errors++;
        }
        if ((negociation === "Troca e Venda" || negociation === "Venda") && price === "") {
            $('.alert-danger').append("O preço é obrigatório caso a negociação inclua venda.<br />");
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