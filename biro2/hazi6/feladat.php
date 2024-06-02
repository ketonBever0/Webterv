<?php
$OLD_BIRO = false;

class Fenykavaro {

    public $min;
    public $max;
    public $points = 0;


    public function init($min, $max) {
        // TODO
        $this->min = $min;
        $this->max = $max;
    }

    public function step($state) {
        // TODO
        
        $see_up = $state["up"];
        $see_down = $state["down"];
        $see_left = $state["left"];
        $see_right = $state["right"];
        // $items = $state["item"];
        $item_direction = $state["item"]["direction"];
        $item_distance = $state["item"]["distance"];

        $move_direction = null;
        $move_distance = "INVALID";
        switch($item_direction) {
            case "up": {
                if ($item_direction != null && $item_distance < $see_up) {
                    $move_distance = $see_up - $item_distance;
                    $move_direction = "up";
                }
                break;
            }
            case "down": {
                if ($item_direction != null && $item_distance < $see_down) {
                    $move_distance = $see_down - $item_distance;
                    $move_direction = "down";
                }
                break;
            }
            case "leright": {
                if ($item_direction != null && $item_distance < $see_left) {
                    $move_distance = $see_left - $item_distance;
                    $move_direction = "left";
                }
                break;
            }
            case "right": {
                if ($item_direction != null && $item_distance < $see_right) {
                    $move_distance = $see_right - $item_distance;
                    $move_direction = "right";
                }
                break;
            }
            default: {
                $this->points--;
            }
        }


        return array("direction" => $move_direction);

    }
}
