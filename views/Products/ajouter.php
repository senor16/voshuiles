<?php
ob_start();
extract($results);
?>
    <h2  class="center"><?= $title ?></h2>
<?php
if (isset($message['info'])) {
    if (!$error) {
        echo '<h3 class="form-success center">' . $message['info'] . '</h3>';
    } else {
        echo '<h3 class="form-error center">' . $message['info'] . '</h3>';
    }
}
?>



    <form class="form" method="post" enctype="multipart/form-data">
        <label for="designation">Désignation :</label><br>
        <?= $message['designation'] ?? '' ?>
        <input id="designation" type="text" required name="designation" value="<?= $fields['designation'] ?? '' ?>"
               placeholder="Ex: Huile de Manyanga" class="<?= isset($message['designation']) ? 'field-error' : '' ?>">
        <br>
        <label for="quality">Qualité :</label><br>
        <?= $message['quality'] ?? '' ?>
        <input id="quality" type="text" name="quality"
               value="<?= $fields['quality'] ?? '' ?>"
               class="<?= isset($message['quality']) ? 'field-error' : '' ?>">
        <br>


        <label for="description">Description</label><br>
        <?= $message['description'] ?? '' ?><br>
        <textarea id="description" rows="5" required name="description"
                  class="<?= isset($message['description']) ? 'field-error' : '' ?>"><?= $fields['description'] ?? '' ?></textarea>
        <br>

        <label for="price">Prix (FCFA):</label><br>
        <?= $message['price'] ?? '' ?>
        <input id="price" type="number" required name="price" value="<?= $fields['price'] ?? '' ?>"
               class="<?= isset($message['price']) ? 'field-error' : '' ?>">
        <br>
        <label for="quantity">Quantité :</label><br>
        <?= $message['quantity'] ?? '' ?>
        <input id="quantity" type="number" required name="quantity" value="<?= $fields['quantity'] ?? 1 ?>"
               class="<?= isset($message['quantity']) ? 'field-error' : '' ?>">
        <br>


        <label for="image">Image:</label><br>
        <?= $message['image'] ?? '' ?><br>
        <input id="image" type="file" required name="image"
               class="<?= isset($message['image ']) ? 'field-error' : '' ?>">
        <br>
        <br>

        <input class="del-add" type="reset" value="Effacer">
        <input class="del-add" type="submit" required name="ajouter" value="Ajouter">

    </form>


<?php

$content = ob_get_clean();