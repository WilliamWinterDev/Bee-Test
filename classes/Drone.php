<?php

class Drone extends Bee {
    public function __construct($hp, $amountRemoved, $amountAllowed) {
        $this->hp = $hp;
        $this->amountRemoved = $amountRemoved;
        $this->amountAllowed = $amountAllowed;
        $_SESSION['droneHealth'];
    }

}