<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Validation</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <?php
    // Define error variables
    $nameErr = $emailErr = $websiteErr = $genderErr = "";
    $name = $email = $website = $comment = $gender = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $hasError = false;

        // Validate Name - Required and minimum 5 characters
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
            $hasError = true;
        } else {
            $name = $_POST["name"];
            if (strlen($name) < 5) {
                $nameErr = "Name must be at least 5 characters long";
                $hasError = true;
            }
        }

        // Validate Email - Required and must be valid email format
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $hasError = true;
        } else {
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $hasError = true;
            }
        }

        // Validate Website - Optional, but if filled must be valid
        if (!empty($_POST["website"])) {
            $website = $_POST["website"];
        }

        // Validate Comment - Optional
        if (!empty($_POST["comment"])) {
            $comment = $_POST["comment"];
        }

        // Validate Gender - Required
        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
            $hasError = true;
        } else {
            $gender = $_POST["gender"];
        }

        // If no errors, redirect to welcome page
        if (!$hasError) {
            // Store data in session to pass to welcome.php
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['website'] = $website;
            $_SESSION['comment'] = $comment;
            $_SESSION['gender'] = $gender;
            header("Location: welcome.php");
            exit();
        }
    }
    ?>

    <h2>Registration Form</h2>
    <p><span class="error">* Required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <input type="text" name="name" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br><br>

        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>

        Website: <input type="text" name="website" value="<?php echo $website; ?>">
        <br><br>

        Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment; ?></textarea>
        <br><br>

        Gender:
        <input type="radio" name="gender" value="female" <?php if ($gender == "female")
            echo "checked"; ?>>Female
        <input type="radio" name="gender" value="male" <?php if ($gender == "male")
            echo "checked"; ?>>Male
        <input type="radio" name="gender" value="other" <?php if ($gender == "other")
            echo "checked"; ?>>Other
        <span class="error">* <?php echo $genderErr; ?></span>
        <br><br>

        <input type="submit" value="Submit">
    </form>

</body>

</html>