<?php

class Game
{

    public static $idIncrement = 0;
    public $x;
    public $y;
    public $players = [];
    public $is_game_started = false;


    public function __construct($request)
    {
        // TODO
        $data = json_decode($request, true);

        if (isset($data["x"]) && $data["x"] >= 0 && isset($data["y"]) && $data["y"] >= 0) {
            $this->x = $data["x"];
            $this->y = $data["y"];
        }
    }

    // SAJAT
    public function who_is_there($x, $y)
    {
        foreach ($this->players as $player) {
            if ($player["x"] == $x && $player["y"] == $y) {
                return $player;
            }
        }
        return null;
    }

    // SAJAT
    public function player_lookup($id)
    {
        foreach ($this->players as $player) {
            if ($player["id"] == $id)
                return $player;
        }
        return null;
    }

    //  SAJAT
    public function player_update($id, $to)
    {
        foreach ($this->players as &$player) {
            if ($player["id"] == $id) {
                $player = $to;
                return;
            }
        }
    }

    public function register_player($request)
    {
        // TODO
        $data = json_decode($request, true);


        if (
            !$this->is_game_started &&
            $this->who_is_there($data["x"], $data["y"]) == null &&
            $data["x"] >= 0 && $data["x"] < $this->x &&
            $data["y"] >= 0 && $data["y"] < $this->y &&
            $data["hp"] + $data["damage"] + $data["mana"] == 10

        ) {
            $this->idIncrement++;
            $max_hp = $data["hp"] * 5 + 10;
            $max_mana = $data["mana"] * 5 + 10;
            $this->players[] = array("id" => $this->idIncrement, "name" => $data["name"], "x" => $data["x"], "y" => $data["y"], "max_hp" => $max_hp, "hp" => floor($max_hp / 2), "damage" => $data["damage"] * 2, "max_mana" => $max_mana, "mana" => floor($max_mana / 2));
            return json_encode(array("status" => "success", "id" => $this->idIncrement), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(array("status" => "error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }




    }

    public function start_game()
    {
        // TODO
        if ($this->is_game_started && count($this->players) < 2)
            return json_encode(array("status" => "error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->is_game_started = true;
        return json_encode(array("status" => "success"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function move($request)
    {
        // TODO
        $data = json_decode($request, true);
        $id = $data["id"];
        $direction = $data["direction"];

        $player = $this->player_lookup($id);

        $after_move_x = null;
        $after_move_y = null;

        switch ($direction) {
            case 'UP': {
                $after_move_y = $player["y"] - 1;
                break;
            }
            case 'DOWN': {
                $after_move_y = $player["y"] + 1;
                break;
            }
            case 'LEFT': {
                $after_move_x = $player["x"] - 1;
                break;
            }
            case 'RIGHT': {
                $after_move_x = $player["x"] + 1;
                break;
            }
            default: {
                return json_encode(array("status" => "error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }

        if (($direction == "UP" || $direction == "DOWN") && ($after_move_y >= 0 && $after_move_y < $this->y) && $this->who_is_there($player["x"], $after_move_y) == null) {
            $player["y"] = $after_move_y;
        } else if (($direction == "LEFT" || $direction == "RIGHT") && ($after_move_x >= 0 && $after_move_x < $this->x) && $this->who_is_there($after_move_x, $player["y"]) == null) {
            $player["x"] = $after_move_y;
        } else
            return json_encode(array("status" => "error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->player_update($id, $player);
        return json_encode(array("status" => "success"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function attack($request)
    {
        // TODO
        $data = json_decode($request, true);
        $player = $this->player_lookup($data["id"]);

        if ($player == null || $player["mana"] < 8)
            return json_encode(array("status" => "error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        //  UP-LEFT
        $target = $this->who_is_there($player["x"] - 1, $player["y"] - 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  UP
        $target = $this->who_is_there($player["x"], $player["y"] - 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  UP-RIGHT
        $target = $this->who_is_there($player["x"] + 1, $player["y"] - 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  DOWN-LEFT
        $target = $this->who_is_there($player["x"] - 1, $player["y"] + 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  DOWN
        $target = $this->who_is_there($player["x"], $player["y"] + 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  DOWN-RIGHT
        $target = $this->who_is_there($player["x"] + 1, $player["y"] + 1);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  LEFT
        $target = $this->who_is_there($player["x"] - 1, $player["y"]);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }

        //  RIGHT
        $target = $this->who_is_there($player["x"] + 1, $player["y"]);
        if ($target != null) {
            $target["hp"] = max($target["hp"] - $player["damage"], 0);
            $this->player_update($target["id"], $target);
        }
        $player["mana"] -= 8;
        $this->player_update($player["id"], $player);
        return json_encode(array("status" => "success"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function nap($request)
    {
        // TODO
        $data = json_decode($request, true);
        $player = $this->player_lookup($data["id"]);
        if ($player == null)
            return json_encode(["status" => "error"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $missing = $player["max_mana"] - $player["mana"];
        if ($missing > 10)
            $player["mana"] += 10;
        else
            $player["mana"] += $missing;
        $this->player_update($data["id"], $player);
        return json_encode(["status" => "success"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function heal($request)
    {
        // TODO
        $data = json_decode($request, true);
        $player = $this->player_lookup($data["id"]);
        if ($player == null)
            return json_encode(["status" => "error"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $missing = $player["max_hp"] - $player["hp"];
        if ($missing > 10)
            $player["hp"] += 10;
        else
            $player["hp"] += $missing;
        $this->player_update($data["id"], $player);
        return json_encode(["status" => "success"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_player($request)
    {
        // TODO

        $id = json_decode($request, true)["id"];
        $player = $this->player_lookup($id);
        if ($player == null)
            return json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        else
            return json_encode(["id" => $player["id"], "x" => $player["x"], "y" => $player["y"], "name" => $player["name"], "hp" => $player["hp"], "max_hp" => $player["max_hp"], "damage" => $player["damage"], "mana" => $player["mana"], "max_mana" => $player["max_mana"]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function get_size()
    {
        // TODO
        return json_encode(array("x" => $this->x, "y" => $this->y), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_winner()
    {
        // TODO
        if ($this->is_game_started)
            return json_encode(["winner" => null], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $alive = [];
        foreach ($this->players as $player) {
            if ($player["hp"] > 0) {
                $alive[] = $player;
            }
        }
        if (count($alive) > 1) {
            return json_encode(["winner" => null], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        return json_encode(["winner" => $alive[0]["name"]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
