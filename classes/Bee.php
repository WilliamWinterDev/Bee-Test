<?php

session_start();

class Bee {

    public $hp;
    public $amountRemoved;
    public $amountAllowed;

    public function removeHealth($amount) {
        $finalAmount = $this->hp - $this->amountRemoved;
        if ($finalAmount <= 0) {
            return false;
        } else {
            $this->hp = $this->hp - $this->amountRemoved;
            echo $this->hp;
            return $finalAmount;
        }
    }
    public function removeBee() {
        $finalBeeAmount = $this->amountAllowed - 1;
        $this->amountAllowed = $this->amountAllowed - 1;
        if ($finalBeeAmount <= 0) {
            return false;
        } else {
            return $finalBeeAmount;
        }
    }

}

require_once("Queen.php");
require_once("Drone.php");
require_once("Worker.php");

$Queen = new Queen(100, 8, 1);
$Worker = new Worker(75, 10, 5);
$Drone = new Drone(50, 12, 8);