<?php

//  1.1
function hozzavalok_szama($novenyek)
{
    $egyedi = array_unique($novenyek);
    return count($egyedi);
}

//  1.2
function legnagyobb_mennyiseg($novenyek)
{
    if (count($novenyek) == 0)
        return null;

    $maxSzam = null;
    $maxNoveny = null;

    foreach ($novenyek as $noveny => $szam) {
        if ($maxSzam === null || $szam > $maxSzam) {
            $maxSzam = $szam;
            $maxNoveny = $noveny;
        }
    }
    return $maxNoveny;
}

//  2.1
function hozzavalok_beszerzese($hozzavalok, $megtalalt)
{
    return in_array($megtalalt, $hozzavalok);
}

//  2.2
function rendszerezes($str)
{
    $tomb = explode(";", $str);
    $novenyek = array_count_values($tomb);
    return $novenyek;
}

//  3.1
function varazslat_elokeszitese($str)
{
    for ($i = 0; $i < strlen($str) - 1; $i++) {
        if (strtolower($str[$i]) == strtolower($str[$i + 1])) {
            return true;
        }
    }
    return false;
}

//  3.2
function fozes(&$ust, $uj)
{
    $ust[] = $uj;
}

