<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/calendar.css">
        <title>Calendar</title>
    </head>

    <body>
        <nav class="navbar navbar-dark bg-primary mb-3">
            <a href="/index.php" class="navbar-brand">Mon Calendar</a>
        </nav>

        <div class="container-fluid">
        <?php

        require '../src/Date/Month.php';
        use App\Date\Month;

        try {
            $month = new Month(isset($_GET['month']) ? $_GET['month'] : null, isset($_GET['year']) ? $_GET['year'] : null);
            $start = $month->getStartingDate()->modify('last monday');
        } catch(Exception $e) {
            $month = new Month();
        }
        ?>

        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
            <h1><?= $month->toString(); ?></h1>
            <div>
                <a href="/calendar/public/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
                <a href="/calendar/public/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&gt;</a>
            </div>
        </div>

            <table class="calendar__table calendar__table__<?= $month->getWeeks(); ?>weeks">
                <?php for($i = 0; $i < $month->getWeeks(); $i++): ?>
                    <tr>
                        <?php
                            foreach($month->days as $k => $day):
                            $date = clone $start;
                            $date->modify("+" . ($k + $i * 7) . " days");
                        ?>
                        <td class="<?= $month->withinMonth($date) ? '' : 'calendar__overmonth' ?>">
                            <?php if($i === 0): ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                            <?php endif; ?>

                            <div class="calendar__day"><?= $date->format('d') ?></div>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </body>
</html>