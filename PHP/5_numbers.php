<?php
    $a = 4;
    $b = 2.5;
    $c = "25";
    $d = $a * $b;

    //var_dump()
    var_dump($a);
    var_dump($b);
    var_dump($c);
    var_dump($d);

    //is_init(), is_float(),is_numeric() 
    $x = 5989;
    var_dump(is_int($x));
    $x = 59.89;
    var_dump(is_int($x));

    // The PHP is_finite() function checks whether a value is finite or not.
    // A value is finite if it is within the allowed range for a PHP float on this platform.
    // The PHP is_infinite() function checks whether a value is infinite or not.
    // The value is infinite if it is outside the allowed range for a PHP float on this platform.

    // Casting
    // Cast float to int 
    $x = 23465.768;
    $int_cast = (int)$x;
    echo $int_cast;
    // Cast string to int
    $x = "23465.768";
    $int_cast = (int)$x;
    echo $int_cast;
    
 ?>
