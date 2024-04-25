<?php

function belepo($kilepbe)
{
    if (!is_string($kilepbe)) {
        return null;
    }

    if (str_starts_with($kilepbe, " ") || str_ends_with($kilepbe, " ")) {
        return false;
    }

    return true;
}


function lakat($lakat, $zar)
{
    if ($lakat == $zar && $lakat !== $zar) {
        return true;
    }
    return false;
}

function belepojegy($ar, $emberekSzama = 1)
{
    if (!is_int($emberekSzama))
        return null;
    return $ar * $emberekSzama;
}

function allatok($allatok)
{
    $str = "Az allatkert allatai: ";

    for ($i = 0; $i < count($allatok); $i++) {
        $str .= $allatok[$i];
        $str .= $i == count($allatok) - 1 ? "." : " ";
    }
    return $str;
}

function nyilvantartas($allatNevek, $jelenLevok, $tipusok)
{

    if (
        count($allatNevek) != count($jelenLevok) ||
        count($allatNevek) != count($tipusok) ||
        count($tipusok) != count($jelenLevok)
    ) {
        return null;
    }

    $arr = [];

    for ($i = 0; $i < count($allatNevek); $i++) {
        $arr[$i]["nev"] = $allatNevek[$i];
        $arr[$i]["darab"] = $jelenLevok[$i];
        $arr[$i]["tipus"] = $tipusok[$i];
    }

    return $arr;
}

function kobold_harc($koboldNevek)
{

    if (count($koboldNevek) % 2 != 0) {
        return null;
    }

    sort($koboldNevek);
    // return $koboldNevek;

    $arr = [];
    $j = 0;
    for ($i = 0; $i < count($koboldNevek); $i += 2) {
        $arr[$j] = $koboldNevek[$i] . " vs " . $koboldNevek[$i + 1];
        $j++;
    }
    return $arr;
}

function fonixek($fajl)
{

    $adatok = file($fajl);
    $hany = 0;
    foreach ($adatok as $sor) {
        $szegmensek = explode(";", $sor);
        $allapot = $szegmensek[0];
        $napja = $szegmensek[1];

        if ($allapot == "HAMU" && 10 - $napja <= 3) {
            $hany++;
        }

    }

    return $hany;
}



echo "<p>";
// echo belepo("asd");
// print_r(nyilvantartas(["unikornisok", "minotauruszok"], [7, 11], ["novenyevo", "ragadozo"]));
// echo allatok(["asd", "dsa", "qwe"]);
// print_r(kobold_harc(['Quirkit', 'Zizzle', 'Wisp', 'Bink']));
echo fonixek("fonixek.txt");
echo "</p>";
