<?php
    session_start();
    
	class BeeGame
	{
        var $bee_array = null;
        var $bee_types = null;
		
		function BeeGame($bee_information)
		{
            if (isset($_SESSION["bee_array"])) 
            {
                echo "Updating existing<hr>";
                print_r($_SESSION["bee_array"]);
                echo "<hr>";
                print_r($_SESSION["bee_types"]);
                echo "<hr>";
				$this->bee_array = $_SESSION["bee_array"];
				$this->bee_types = $_SESSION["bee_types"];
            }
            else 
            {
                echo "Starting new game";
                $this->NewGame($bee_information);
            }
        }

        function ShuffleBees($list)
        {
            if (!is_array($list)) return $list; 
            
            $keys = array_keys($list); 
            shuffle($keys); 
            $random = array(); 

            foreach ($keys as $key) { 
                $random[$key] = $list[$key]; 
            }
            return $random; 
        }
        
        function NewGame($bee_information)
        {
            foreach($bee_information as $bee_type => $bee_info)
            {
                if(!in_array($bee_type, $this->bee_types))
                {
                    $this->bee_types[] = $bee_type;
                }

                $bee_amount = $bee_info["amount"];
                $bee_health = $bee_info["health"];
                $bee_damage = $bee_info["hit_damage"];
                $bee_is_special = $bee_info["special_bee"];

                for ($i=0; $i < $bee_amount; $i++)
                { 
                    $new_bee_array[$bee_type]["bee" . $i] = array("health" => $bee_health, "bee_damage" => $bee_damage, "is_special" => $bee_is_special);
                }
            }
            
            $this->bee_array       = $new_bee_array;
            $_SESSION["bee_array"] = $new_bee_array;
            $_SESSION["bee_types"] = $this->bee_types;
        }
		
		function SelectRandomBee()
		{
            echo "Types:<br>";
            print_r($this->bee_types);
            $select_random_type_key = mt_rand(0, (count($this->bee_types) - 1));
            $random_type = $this->bee_types[$select_random_type_key];

            echo "Random Type: " . $random_type;

            $available_bees = $this->bee_array[$random_type];
            echo "<hr>";
            print_r($available_bees);

            $available_bees = $this->ShuffleBees($available_bees);
            $first_key = key($available_bees);
            $chosen_bee = $available_bees[$first_key];
            print_r($chosen_bee);

            echo "Original health: " . $chosen_bee["health"] . "<br>";
            $this->bee_array[$random_type][$first_key]["health"] = $this->bee_array[$random_type][$first_key]["health"] - $chosen_bee["bee_damage"];
            if($this->bee_array[$random_type][$first_key]["health"] <= 0)
            {
                if($chosen_bee["is_special"] == 1)
                {
                    echo "You killed the Queen Bee you win the game!";
                    $this->ResetGame();
                    return;
                }

                echo "New Health:" . $this->bee_array[$random_type][$first_key]["health"];
                unset($this->bee_array[$random_type][$first_key]);
            }

            $_SESSION["bee_array"] = $this->bee_array;
            
            foreach($this->bee_types as $type)
            {
                $bees_left += count($this->bee_array[$type]);
            }

            if($bees_left == 0)
            {
                echo "You won the game, resetting!";
            }
        }

        function HitBee()
        {

        }
        
        function ResetGame()
        {
            unset($_SESSION["bee_array"]);
            $this->bee_array = null;
            $this->bee_types = null;


        }
    }
    
    $default_config = array(
		"queen_bees" => array(
			"amount" => 1,
			"health" => 100,
			"hit_damage" => 8,
			"special_bee" => true
		),
		"worker_bees" => array(
			"amount" => 5,
			"health" => 75,
			"hit_damage" => 10,
			"special_bee" => false
		),
		"drone_bees" => array(
			"amount" => 8,
			"health" => 50,
			"hit_damage" => 12,
			"special_bee" => false
		)
    );
	
    $BeeGame = new BeeGame($default_config);

    if(isset($_POST["reset_game"]))
    {
        $BeeGame->ResetGame();
        $BeeGame->NewGame($default_config);
    }
    else if(isset($_POST["hit_bee"]))
    {
        print_r($BeeGame->SelectRandomBee());
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Bee Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?
        if(isset($BeeGame->bee_array))
        {
            foreach($BeeGame->bee_array as $bee_type => $bees)
            {
                echo "<h2>" . $bee_type . "</h2>";
                $count = 1;
                foreach($bees as $bee)
                {
                    echo "Bee " . $count . ": " . print_r($bee, true) . "<br>";
                }
            }
        }
    ?>
    <br>
    <form method="post">
        <input type="submit" name="hit_bee" value="Hit Random Bee">
        <input type="submit" name="reset_game" value="Reset Game">
    </form>
</body>
</html>