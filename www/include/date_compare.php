<?php

function date_compare($d1, $d2)
{
    $d1 = explode('/', $d1);
    $d2 = explode('/', $d2);

    $d1 = array_reverse($d1);
    $d2 = array_reverse($d2);

    if (strtotime(implode('/', $d1)) > strtotime(implode('/', $d2)))
    {
        return true;
    }
    else
    {
        return false;
    }
}



?>