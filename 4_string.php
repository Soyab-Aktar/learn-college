<?php
    $name = "Soyab";

    // Length
    echo strlen("My Name is :$name");
    echo "\n";
    // Word Count
    echo str_word_count($name);
    echo "\n";
    // Search For Text Within a String
    echo strpos("Hello My World","o");
     echo "\n";
    // Upper Case
    echo strtoupper($name);
     echo "\n";
    // Lower Case
    echo strtolower($name);
     echo "\n";
    //  str_replace(find,replace,string,count) 
    echo str_replace("World","Earth","Hello My World");
    echo "\n";
    // Reverse
    echo strrev($name);
    echo "\n";
    // Remove Whitespace
    $words = "  Hello My Friends How are you    ";
    echo trim($words);
    echo "\n";
    // explode(separator,string,limit) 
    $x = "Hello World!";
    $y = explode(" ", $x);
    print_r($y);
    echo "\n";
    // String Concatenation
    $p = "Evo";
    $q = "Fresh";
    // $r = $p . $q;
    // $r = $p . " " . $q;
    $r = "$p $q";
    echo $r;
    echo "\n";
    // Slice String - substr(string,start,length) 
    echo substr($x,2,3);
    echo substr($x, -5, 3);



    ?>