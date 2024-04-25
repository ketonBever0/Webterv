<?php

class Citrica
{

    private $bolyhos;
    private $sajatNarancs;


    public function __construct($bolyhos, $sajatNarancs)
    {
        $this->bolyhos = $bolyhos;
        $this->sajatNarancs = $sajatNarancs;
    }

    public function isBolyhos()
    {
        return $this->bolyhos;
    }

    public function getSajatNarancs()
    {
        return $this->sajatNarancs;
    }

    public function osztodik($narancs)
    {
        // if ($this->bolyhos || $this->sajatNarancs)
    }

}

