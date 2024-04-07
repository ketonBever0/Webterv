<?php

function hozzavalok_szama($novenyek)
{
    $egyedi = array_unique($novenyek);
    return count($egyedi);
}

function legnagyobb_mennyiseg($novenyek)
{
    if (count($novenyek) == 0)
        return null;
    $maxSzam = 0;
    foreach ($novenyek as $noveny => $szam) {
        if ($szam > $maxSzam) {
            $maxSzam = $noveny;
        }
    }
    return $maxSzam;
}

function hozzavalok_beszerzese($hozzavalok, $megtalalt)
{
    return in_array($megtalalt, $hozzavalok);
}

