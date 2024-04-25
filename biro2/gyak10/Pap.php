<?php


class Pap {

    private $turelem;
    private $el = true;


    public function __construct($turelem) {
        $this->turelem = $turelem < 0 ? 0 : $turelem;
    }

    public function isEl() {
        return $this->el;
    }

    public function getTurelem() {
        return $this->turelem;
    }

    public function meghal() {
        if (!$this->el) throw new Exception();
        else $this->el = false;
    }

    function narancsotAd()
    {
        if (!$this->el || $this->turelem == 0) return null;

        return new Narancs(rand() / getrandmax(), rand() / getrandmax());
    }


}


