<?php

namespace Excelent\Helpers;

class Data
{
    public function add($key, $value)
    {
        $this->$key = $value;
        if (isset($this->$key))
            return true;
        else
            return false;
    }
    public function get($key)
    {
        if (isset($this->$key))
            return $this->$key;
        return false;
    }
    public function remove($key)
    {
        if (isset($this->$key)) {
            $this->$key = "";
            return true;
        }
        return false;
    }
}
$DataClass = new Data();
function DataAdd($key, $value)
{
    global $DataClass;
    $res = $DataClass->add($key, $value);
    if ($res)
        return true;
    return false;
}
function DataGet($key)
{
    global $DataClass;
    if ($DataClass->get($key))
        return $DataClass->get($key);
    return false;
}

