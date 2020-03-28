<?php
require_once("classes/Bee.php");

if (isset($_POST['hitBee'])) {
    $randomBee = array("Queen", "Worker", "Drone");
    $choseRandom = $randomBee[rand(0,2)];

    echo "You hit a $choseRandom";
    if ($choseRandom == "Queen") {
        $Queen->removeHealth(8);
        if ($_SESSION['queenHealth'] < $Queen->amountRemoved) {
            echo "The queen died!";
            // $Bee->resetGame();
        } else {
            $_SESSION['queenHealth'] = $_SESSION['queenHealth'] - $Queen->amountRemoved;
        }

        echo "<br> She lost: ". $Queen->amountRemoved ." hitpoints. She now has " . $_SESSION['queenHealth'] . "hp";
    } elseif ($choseRandom == "Worker") {
        $Worker->removeHealth(8);
        if ($_SESSION['workerHealth'] < $Worker->amountRemoved) {
            echo "The worker died!";
            $Worker->removeBee();
        } else {
            if ($Worker->amountAllowed < 1) {
                echo "All the workers dieD!";
            } else {
                $_SESSION['workerHealth'] = $_SESSION['workerHealth'] - $Worker->amountRemoved;
            }
        }

        echo "<br> It lost: ". $Worker->amountRemoved ." hitpoints. It now has " . $_SESSION['workerHealth'] . "hp";
    } elseif ($choseRandom == "Drone") {
        $Drone->removeHealth(8);
        if ($_SESSION['droneHealth'] < $Drone->amountRemoved) {
            echo "The drone died!";
            // $Bee->resetGame();
        } else {
            $_SESSION['droneHealth'] = $_SESSION['droneHealth'] - $Drone->amountRemoved;
        }

        echo "<br> It lost: ". $Drone->amountRemoved ." hitpoints. It now has " . $_SESSION['droneHealth'] . "hp";        
    }
}

?>
<br><br>
Amounts: <br>
Queens: <?= $Queen->amountAllowed; ?> <br>
Workers: <?= $Worker->amountAllowed; ?> <br>
Drones: <?= $Drone->amountAllowed; ?> <br>
<br><br>

<form method="post">
    <input type="submit" name="hitBee" value="Hit a bee">
</form>