<?php

require '../src/bootstrap.php';

use Calendar\Events;
use Calendar\Month;

try {
    $pdo = getPDO();
    $month = new Month(isset($_GET['month']) ? $_GET['month'] : null, isset($_GET['year']) ? $_GET['year'] : null);
    $events = new Events($pdo);

    $start = $month->getStartingDate();
    $weeks = $month->getWeeks();
    /* Si le mois commence par un lundi, alors on applique pas modify('last monday) */
    $start = $start->format('N') === '1' ? $start : $month->getStartingDate()->modify('last monday');
    /* Pour calculer le jour du fin du calendrier */
    $end = (clone $start)->modify('+' . (6 + 7 * ($weeks -1)) . ' days');

    $eventsBetweenDates = $events->getEventsBetweenByDay($start, $end);

} catch(Exception $e) {
    $month = new Month();
}
?>


<!-- HAEDER -->
<?php require '../views/header.php'; ?>

<div class="calendar">

    <!-- Affichage le nom du mois avec les bouttons de navigation -->
    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>

    <!-- Affichage du calendrier -->
    <table class="calendar__table calendar__table__<?= $weeks ?>weeks">
        <?php for($i = 0; $i < $weeks; $i++): ?>
            <tr>
                <?php
                /* Afficher le nom des jours*/
                foreach($month->days as $k => $day):
                    $date = clone $start;
                    $date->modify("+" . ($k + $i * 7) . " days");

                    //Récupérer les événements du jour sinon ça envoie un tableau vide
                    $eventsForDay = $eventsBetweenDates[$date->format('Y-m-d')] ?? [];
                    ?>
                    <td class="<?= $month->withinMonth($date) ? '' : 'calendar__overmonth' ?>">
                        <?php if($i === 0): ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                        <?php endif; ?>

                        <div class="calendar__day"><?= $date->format('d') ?></div>
                        <?php foreach($eventsForDay as $events) : ?>
                            <div class="calendar__event">
                                <?= (new DateTime($events['start']))->format('H:i'); ?> -
                                <a href="event.php?id=<?= $events['id']; ?>"><?= htmlentities($events['title']); ?></a>
                            </div>
                        <?php endforeach; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <a href="add.php" class="add__event__button">+</a>
</div>

<!-- FOOTER -->
<?php require '../views/footer.php'; ?>