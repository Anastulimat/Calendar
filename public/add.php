<?php

use Calendar\EventValidator;

require '../src/bootstrap.php';
render('header', ['title' => 'Ajouter un événement']);

$data = [];
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $data = $_POST;
    $errors = [];
    $validator = new EventValidator();
    $errors = $validator->validates($_POST);
    if(empty($errors))
    {

    }
}

?>

<div class="container">
    <?php if(!empty($errors)) : ?>
        <?php var_dump($errors) ;?>
        <div class="alert alert-danger">
            Merci de corriger vos erreurs
        </div>

    <?php endif; ?>

    <h1>Ajouter un événement</h1>

    <form action="" method="post" class="form mt-4">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="title">Titre :</label>
                    <input id="title" type="text" required class="form-control" name="title" value="<?= isset($data['title']) ? htmlentities($data['title']) : 'demo' ?>">
                    <?php if(isset($errors['title'])) : ?>
                        <small id="titre" class="form-text text-danger">
                            <?= $errors['title']; ?>
                        </small>
                    <?php endif; ?>


                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="date">Date :</label>
                    <input id="date" type="date" required class="form-control" name="date" value="<?= isset($data['date']) ? htmlentities($data['date']) : '2019-04-04' ?>">
                    <?php if(isset($errors['date'])) : ?>
                        <small id="date" class="form-text text-danger">
                            <?= $errors['date']; ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="start">Démarrage :</label>
                    <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start']) ? htmlentities($data['start']) : '20:00' ?>">
                    <?php if(isset($errors['start'])) : ?>
                        <small id="start" class="form-text text-danger">
                            <?= $errors['start']; ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="end">Fin :</label>
                    <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? htmlentities($data['end']) : '21:00' ?>">
                    <?php if(isset($errors['end'])) : ?>
                        <small id="end" class="form-text text-danger">
                            <?= $errors['end']; ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10" ><?= isset($data['description']) ? htmlentities($data['description']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Ajouter l'événement</button>
        </div>
    </form>
</div>


<?php render('footer'); ?>

