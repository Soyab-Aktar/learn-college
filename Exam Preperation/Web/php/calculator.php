<?php
$result = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $num1 = $_POST["num1"];
  $num2 = $_POST["num2"];
  $operation = $_POST["operation"];

  if($num1 == "" || $num2 == ""){
    $result = "Please Enter number";
  }else{
    if($operation == "add"){
      $result = $num1 + $num2;
    }elseif($operation == "sub"){
      $result = $num1 - $num2;
    }elseif($operation == "mul"){
      $result = $num1 * $num2;
    }elseif($operation == "div"){
      if($num2 == 0){
        $result = "Can Not divided";
      }else{
        $result = $num1 / $num2;
      }
    }
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP - Calculator</title>
</head>
<body>
  <h1>Calculator</h1>

  <form method="post">
    <input type="number" name="num1" placeholder="Enter Number 1">
    <br><br>
    <input type="number" name="num2" placeholder="Enter Number 1">
    <br><br>
    <select name="operation">
      <option value="add">+</option>
      <option value="sub">-</option>
      <option value="mul">*</option>
      <option value="div">/</option>
    </select>
    <br><br>
    <input type="submit" value="Calculate">
    
  </form>

  <h3>
    Result : <?php echo $result;?>
  </h3>
</body>
</html>