<?php

namespace Calendar;

use DateTime;
use Exception;

class Event
{

    private $id;

    private $title;

    private $description;

    private $color;

    private $start;

    private $end;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * @return mixed
     */
    public function getDescription() : string
    {
        if(is_null($this->description))
        {
            return '';
        }
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getStart() : DateTime
    {
        return new DateTime($this->start);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getEnd() : DateTime
    {
        return new DateTime($this->end);
    }

}