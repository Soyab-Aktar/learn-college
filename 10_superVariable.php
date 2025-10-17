<?php
    // $GLOBALS
    $x = 10;
    function myFunction(){
        echo $GLOBALS['x'];
        // global $x;
        // echo $x;
    }
    myFunction();
    echo "\n";
    
?>