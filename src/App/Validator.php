<?php

namespace App;

use DateTime;

class Validator
{

    protected $data;
    protected $errors = [];

    /**
     * @param array $data
     */
    public function validates(array $data)
    {
        $this->errors = [];
        $this->data = $data;
    }

    /**
     * @param string $field
     * @param string $method
     * @param mixed  ...$params
     */
    public function validate(string $field, string $method, ...$params)
    {
        if(!isset($this->data[$field]))
        {
            $this->errors[$field] = "Le champs $field n'est pas rempli";
        }
        else
        {
            call_user_func([$this, $method], $field, ...$params);
        }
    }

    /**
     * @param string $field
     * @param int    $length
     *
     * @return bool
     */
    public function minLength(string $field, int $length)
    {
        if(mb_strlen($field) < $length)
        {
            $this->errors[$field] = "Le champs $field doit avoir plus de $length caractères";
            return false;
        }
        return true;
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function date(string $field)
    {
        if(DateTime::createFromFormat('Y-m-d', $this->data[$field]) == false)
        {
            $this->errors[$field] = "La date ne semble pas valide";
            return false;
        }
        return true;
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function time(string $field)
    {
        if(DateTime::createFromFormat('H:i', $this->data[$field]) == false)
        {
            $this->errors[$field] = "Le temps ne semble pas valide";
            return false;
        }
        return true;
    }

    /**
     * @param string $startField
     * @param string $endField
     *
     * @return bool
     */
    public function beforeTime(string $startField, string $endField)
    {
        if($this->time($startField) && $this->time($endField))
        {
            $start = DateTime::createFromFormat('H:i', $this->data[$startField]);
            $end = DateTime::createFromFormat('H:i', $this->data[$endField]);

            if($start->getTimestamp() > $end->getTimestamp())
            {
                $this->errors[$startField] = "L'heure de démarrage ne doit pas dépasser l'heurer de fin";
                return false;
            }
            return true;
        }
        return false;
    }

}