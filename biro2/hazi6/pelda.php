<?php
$OLD_BIRO = false;

function startGame() {
    $agent = new Fenykavaro();

    // TODO a példát szabadon át lehet írni!
    echo "--- Példamutatás ---\n";
    $min = 27;
    $max = 100;

    // 0: fal; 1: fu; 2: start; 3: cel; 4: kristaly
    $map = [
        [0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0],
        [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1],
        [0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0],
        [0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 1, 0],
        [0, 0, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0],
        [0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0],
        [0, 1, 1, 0, 1, 1, 1, 0, 4, 0, 1, 0, 1, 1],
        [0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0],
        [0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0]
    ];

    new Game($agent, $min, $max, $map);
}

class Game {
    public $min;
    public $max;
    public $remaining;
    public $map;
    public $currentX; // ???
    public $currentY; // ???
    public $player;
    public $invalid;
    public $cristalFound;
    public $won;

    public function __construct($agent, $min, $max, $map) {
        $this->min = $min;
        $this->max = $max;
        $this->remaining = $this->max;
        $this->map = $map;
        $this->init();

        $this->player = $agent;
        $this->player->init($this->min, $this->max);
        $this->invalid = 0;
        $this->cristalFound = 0;
        $this->won = false;

        $this->gameLoop();
    }

    private function gameLoop() {
        while ($this->remaining > 0) {
            $state = $this->createCurrentStateObject();

            $this->remaining--;

            if ($this->makeMove($state)) {
                break;
            }
        }

        $this->finishGame();
    }

    private function makeMove($state) {
        global $OLD_BIRO;

        if ($OLD_BIRO) {
            $new_state = get_object_vars($state);
        } else {
            $new_state = [];

            foreach ($state as $key => $value) {
                $new_state[$key] = $value;
            }

            if ($state->item != null) {
                $item = [];
                foreach ($state->item as $key => $value) {
                    $item[$key] = $value;
                }
                $new_state['item'] = $item;
            }
        }

        $result = $this->player->step($new_state);

        $fieldValue = $this->getNeighbour($this->currentX, $this->currentY, $result);
        if ($fieldValue === null || $fieldValue === 0 || $fieldValue === 2) {
            $this->invalid++;
            return false;
        }

        switch ($result) {
            case 'LEFT':
                $this->currentY--;
                break;
            case 'RIGHT':
                $this->currentY++;
                break;
            case 'UP':
                $this->currentX--;
                break;
            case 'DOWN':
                $this->currentX++;
                break;
        }

        if ($this->getValue($this->currentX, $this->currentY) === 4) {
            $this->cristalFound = true;
            $this->map[$this->currentX][$this->currentY] = 1;
        } else if ($this->getValue($this->currentX, $this->currentY) === 3) {
            $this->won = true;
            return true;
        }

        return false;
    }

    private function createCurrentStateObject() {
        $obj = new stdClass();

        $sightDistances = [
            $this->getMaxSightDistance($this->currentX, $this->currentY, 'UP'),
            $this->getMaxSightDistance($this->currentX, $this->currentY, 'DOWN'),
            $this->getMaxSightDistance($this->currentX, $this->currentY, 'LEFT'),
            $this->getMaxSightDistance($this->currentX, $this->currentY, 'RIGHT')
        ];

        $obj->up = $sightDistances[0]['distance'];
        $obj->down = $sightDistances[1]['distance'];
        $obj->left = $sightDistances[2]['distance'];
        $obj->right = $sightDistances[3]['distance'];

        $obj->item = null;
        for ($i = 0; $i < 4; $i++) {
            if ($sightDistances[$i]['key'] !== null) {
                $direction = '';
                switch ($i) {
                    case 0: $direction = 'UP'; break;
                    case 1: $direction = 'DOWN'; break;
                    case 2: $direction = 'LEFT'; break;
                    case 3: $direction = 'RIGHT'; break;
                }

                $obj->item = (object)[
                    'direction' => $direction,
                    'distance' => $sightDistances[$i]['key']
                ];
            }
        }

        return $obj;
    }

    private function getMaxSightDistance($x, $y, $direction) {
        $distance = 0;
        $keyFound = null;

        while (true) {
            switch ($direction) {
                case 'LEFT': $y--; break;
                case 'RIGHT': $y++; break;
                case 'UP': $x--; break;
                case 'DOWN': $x++; break;
            }

            if ($this->getValue($x, $y) === 4) {
                $keyFound = $distance + 1;
            }

            if ($this->getValue($x, $y) === null) {
                return ['distance' => INF, 'key' => $keyFound];
            }

            if ($this->getValue($x, $y) === 0 || $this->getValue($x, $y) === 2) {
                return ['distance' => $distance, 'key' => $keyFound];
            }

            $distance++;
        }
    }

    private function getValue($x, $y) {
        return $this->map[$x][$y] ?? null;
    }

    private function getNeighbour($x, $y, $direction) {
        switch ($direction) {
            case 'LEFT': return $this->getValue($x, $y-1);
            case 'RIGHT': return $this->getValue($x, $y+1);
            case 'UP': return $this->getValue($x-1, $y);
            case 'DOWN': return $this->getValue($x+1, $y);
        }

        return null;
    }

    private function init() {
        for ($i = 0; $i < count($this->map); $i++) {
            for ($j = 0; $j < count($this->map[$i]); $j++) {
                if ($this->map[$i][$j] === 2) {
                    $this->currentX = $i;
                    $this->currentY = $j;
                }
            }
        }
    }

    private function finishGame() {
        $escapeScore = $this->won ? 50 : 0;
        $keyScore = $this->cristalFound ? ($this->won ? 25 : 10) : 0;
        $stepScore = min(25, round((1 - (($this->max - $this->remaining) - $this->min) / ($this->max - $this->min)) * 25));
        $penalty = -$this->invalid;
        $score = max(0, $escapeScore + $keyScore + $stepScore + $penalty);

        echo "Kijutás: {$escapeScore}\n";
        echo "Időszakító kristály: {$keyScore}\n";
        echo "Lépések: {$stepScore}\n";
        echo "Büntetés: {$penalty}\n";
        echo "Összesen: {$score}\n";
    }
}

class Fenykavaro {
    public function init($min, $max) {
        // TODO
    }

    public function step($state) {
        // TODO
    }
}

startGame();
?>
