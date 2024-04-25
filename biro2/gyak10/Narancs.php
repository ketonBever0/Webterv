<?php


class Narancs {

    private $sargasag;
    private $savanyusag;


    public function __construct($sargasag, $savanyusag) {
        if ($sargasag > 1) {
            $this->sargasag = 1;
        } else if ($sargasag < 0) {
            $this->sargasag = 0;
        } else {
            $this->sargasag = $sargasag;
        }

        if ($savanyusag > 1) {
            $this->savanyusag = 1;
        } else if ($savanyusag < 0) {
            $this->savanyusag = 0;
        } else {
            $this->savanyusag = $savanyusag;
        }
    }

    public function getSargasag()
    {
        return $this->sargasag;
    }

    public function getSavanyusag()
    {
        return $this->savanyusag;
    }



}



