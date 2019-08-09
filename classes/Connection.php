<?php

class Connection extends PDO
{
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    public function select($query, $bind = [])
    {
        $results = $this->prepare($query);
        foreach ($bind as $key=>$value) {
            if (is_int($key)) {
                $key++;
            }
            $results->bindValue($key, $value);
            //is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
        }
        $results->execute();
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}