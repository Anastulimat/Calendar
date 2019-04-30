<?php

namespace App\Date;

use DateTime;
use Exception;

class Month {

    /**
     * @var array
     */
    var $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

    /**
     * @var array
     */
    private $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

    /**
     * @var int
     */
    public $month;

    /**
     * @var int
     */
    public $year;


    /**
     * Month constructor.
     *
     * @param int $month Le mois compris entre 1 et 12
     * @param int $year  L'année
     *
     * @throws Exception
     */
    public function __construct($month = null, $year = null)
    {
        if($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }

        if($year === null) {
            $year = intval(date('Y'));
        }

        if($year < 1970) {
            throw new Exception("L'année est inférieure à 1970");
        }

        $this->month = $month;
        $this->year = $year;
    }


    /**
     * Renvoie le nombre de semaines dans le mois
     *
     * @return int
     * @throws Exception
     */
    public function getWeeks()
    {
        $start = $this->getStartingDate();
        $clone_start = clone $start;
        $end = $clone_start->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

        if($weeks < 0) {
            $weeks = intval($end->format('W'));
        }

        return $weeks;
    }

    /**
     * Retourne le premier jour du mois
     *
     * @return DateTime
     * @throws Exception
     */
    public function getStartingDate()
    {
        $starting_date = new DateTime("{$this->year}-{$this->month}-01");
        return $starting_date;
    }


    /**
     * Retourne le mois en toute lettre (ex: Mars 2018)
     *
     * @return string
     */
    public function toString()
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }


    /**
     * Est-ce que le jour est dans le mois en cours
     *
     * @param DateTime $date
     *
     * @return bool
     * @throws Exception
     */
    public function withinMonth(DateTime $date)
    {
        return $this->getStartingDate()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le mois suivnat
     *
     * @return Month
     * @throws Exception
     */
    public function nextMonth()
    {
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoie le mois précédent
     *
     * @return Month
     * @throws Exception
     */
    public function previousMonth()
    {
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }

}