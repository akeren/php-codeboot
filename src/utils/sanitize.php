<?php

function escape($data)
{
    return htmlentities($data, ENT_QUOTES, 'UTF-8');
}

function pretty($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
