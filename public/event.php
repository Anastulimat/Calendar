<?php

use Calendar\Events;

require '../src/bootstrap.php';


$pdo = getPDO();
$event_class = new Events($pdo);

if(!isset($_GET['id']))
{
    header("Location: /calendar/public/404.php");
}

try {
    $event = $event_class->find($_GET['id']);
} catch(Exception $e) {
    error404();
}

render('header', ['title' => $event->getTitle()]);
?>



<h1><?= htmlentities($event->getTitle()); ?></h1>

<ul>
    <li>Date: <?= $event->getStart()->format('d/m/Y'); ?></li>
    <li>Heure de démarrage: <?= $event->getStart()->format('H:i'); ?></li>
    <li>Heure de fin: <?= $event->getEnd()->format('H:i'); ?></li>
    <li>Description: <br>
        <?= htmlentities($event->getDescription()); ?>
    </li>
</ul>

<?php require '../views/footer.php'?>
