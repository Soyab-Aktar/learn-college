<?php
    $x = 1;
    while($x <= 5)
    {
        echo "Value of x : $x \n";
        $x++;
        if($x == 3) break;
    }
    
    while($x <= 5):
        $a = $x *2;
        echo "$a  ";
        $x++;
    endwhile;
?>