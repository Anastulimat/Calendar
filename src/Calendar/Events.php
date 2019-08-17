<?php


namespace Calendar;

use DateTime;
use Exception;
use PDO;

class Events
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Events constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Récupérer les événement commencent entre 2 dates
     *
     * @param DateTime $start
     * @param DateTime $end
     *
     * @return array
     */
    public function getEventsBetween(DateTime $start, DateTime $end) : array
    {

        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }


    /**
     * Récupérer les événements commencent entre 2 dates indexés par jour
     *
     * @param DateTime $start
     * @param DateTime $end
     *
     * @return array
     */
    public function getEventsBetweenByDay(DateTime $start, DateTime $end) : array
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];

        foreach($events as $event)
        {
            //Récupérer la première partie de la date
            $date = explode(' ', $event['start'])[0];

            //Regrouper les événements par date
            if(!isset($days[$date]))
            {
                $days[$date] = [$event];
            }
            else
            {
                $days[$date][] = $event;
            }
        }
        return $days;
    }


    /**
     * @param int $id
     *
     * @return Event
     * @throws Exception
     */
    public function find(int $id) : Event
    {
        $stmt =  $this->pdo->query("SELECT * FROM events WHERE id =  $id LIMIT 1");
        $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
        $result = $stmt->fetch();
        if(!$result)
        {
            throw new Exception('Aucun résultat n\'a été trouvé !');
        }
        return $result;
    }

}