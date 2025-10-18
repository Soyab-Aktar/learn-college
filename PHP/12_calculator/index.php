<?php
// Start the session to remember values between button clicks
session_start();

// Set starting values when page first loads
if (!isset($_SESSION['display'])) {
    $_SESSION['display'] = '';
    $_SESSION['first_number'] = '';
    $_SESSION['operator'] = '';
    $_SESSION['start_new'] = true;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // NUMBER BUTTON CLICKED (0-9)
    if (isset($_POST['number'])) {
        $clicked_number = $_POST['number'];

        if ($_SESSION['start_new'] == true) {
            // ADD to display (not replace)
            $_SESSION['display'] = $_SESSION['display'] . $clicked_number;
            $_SESSION['start_new'] = false;
        } else {
            // Add this number to display
            if ($_SESSION['display'] == '0') {
                $_SESSION['display'] = $clicked_number;
            } else {
                $_SESSION['display'] = $_SESSION['display'] . $clicked_number;
            }
        }
    }

    // DECIMAL BUTTON CLICKED
    if (isset($_POST['decimal'])) {
        if ($_SESSION['start_new'] == true) {
            $_SESSION['display'] = $_SESSION['display'] . '0.';
            $_SESSION['start_new'] = false;
        } else if (strpos($_SESSION['display'], '.') === false) {
            $_SESSION['display'] = $_SESSION['display'] . '.';
        }
    }

    // OPERATOR BUTTON CLICKED (+, -, *, /)
    if (isset($_POST['operator'])) {
        $clicked_operator = $_POST['operator'];

        // Save first number
        $_SESSION['first_number'] = $_SESSION['display'];
        // Save operator
        $_SESSION['operator'] = $clicked_operator;
        // ADD OPERATOR TO DISPLAY
        $_SESSION['display'] = $_SESSION['display'] . $clicked_operator;
        // Set flag to add second number
        $_SESSION['start_new'] = true;
    }

    // EQUALS BUTTON CLICKED (=)
    if (isset($_POST['equals'])) {
        $first = $_SESSION['first_number'];
        $second = $_SESSION['display'];
        $op = $_SESSION['operator'];

        if ($first != '' && $op != '') {
            // Extract second number from display
            $pos = strpos($second, $op);
            $second_num = substr($second, $pos + 1);

            // Calculate
            if ($op == '+') {
                $answer = $first + $second_num;
            } else if ($op == '-') {
                $answer = $first - $second_num;
            } else if ($op == '*') {
                $answer = $first * $second_num;
            } else if ($op == '/') {
                if ($second_num != 0) {
                    $answer = $first / $second_num;
                } else {
                    $answer = 'Error';
                }
            }

            // Show answer
            $_SESSION['display'] = $answer;
            $_SESSION['first_number'] = '';
            $_SESSION['operator'] = '';
            $_SESSION['start_new'] = true;
        }
    }

    // DEL BUTTON CLICKED (Delete last character)
    if (isset($_POST['del'])) {
        if ($_SESSION['display'] != '' && $_SESSION['display'] != 'Error') {
            // Remove last character
            $_SESSION['display'] = substr($_SESSION['display'], 0, -1);

            // If display becomes empty, set to ""
            if ($_SESSION['display'] === '' || $_SESSION['display'] === '-') {
                $_SESSION['display'] = '';
            }
        }
    }

    // AC BUTTON CLICKED (Clear All)
    if (isset($_POST['clear'])) {
        $_SESSION['display'] = '';
        $_SESSION['first_number'] = '';
        $_SESSION['operator'] = '';
        $_SESSION['start_new'] = true;
    }
}

// Get current display value
$show = $_SESSION['display'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Simple Calculator</title>
    <style>
        /* Reset everything */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Page background */
        body {
            background: #7a8ba3;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        }

        /* Calculator box */
        .calculator {
            background: #0f1419;
            padding: 30px;
            border-radius: 25px;
            width: 400px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.6);
        }

        /* Display screen */
        .display {
            background: #1a2129;
            color: #b8c1cc;
            font-size: 48px;
            text-align: right;
            padding: 30px 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            min-height: 100px;
            word-wrap: break-word;
            word-break: break-all;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            font-weight: 300;
        }

        /* Button container */
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        /* All buttons */
        button {
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.25rem;
            padding: 25px;
            cursor: pointer;
            transition: all 0.15s ease;
            font-weight: 400;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            height: 75px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Number buttons - dark gray */
        .num-btn {
            background: #3d4450;
        }

        .num-btn:hover {
            background: #4d5460;
            transform: translateY(-2px);
        }

        /* Operator buttons - orange */
        .op-btn {
            background: #ff9800;
        }

        .op-btn:hover {
            background: #ffaa33;
            transform: translateY(-2px);
        }

        /* AC button - orange */
        .ac-btn {
            background: #ff9800;
            font-weight: 500;
        }

        .ac-btn:hover {
            background: #ffaa33;
            transform: translateY(-2px);
        }

        /* DEL button - orange */
        .del-btn {
            background: #ff9800;
            font-weight: 500;
        }

        .del-btn:hover {
            background: #ffaa33;
            transform: translateY(-2px);
        }

        /* Equals button - orange, spans 2 rows */
        .eq-btn {
            background: #ff9800;
            grid-row: span 2;
            font-size: 32px;
            height: auto;
        }

        .eq-btn:hover {
            background: #ffaa33;
            transform: translateY(-2px);
        }

        /* Zero button spans 3 columns */
        .zero-btn {
            grid-column: span 3;
            background: #3d4450;
        }

        .zero-btn:hover {
            background: #4d5460;
            transform: translateY(-2px);
        }

        /* Button active effect */
        button:active {
            transform: scale(0.96);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Date Time Display */
        .datetime {
            background: #1a2129;
            color: #b8c1cc;
            text-align: center;
            padding: 15px 20px;
            border-radius: 15px;
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.6;
        }

        .datetime .date {
            font-weight: 500;
            color: #ff9800;
            margin-bottom: 5px;
        }

        .datetime .time {
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 1px;
        }

        /* Footer */
        .footer {
            color: #b8c1cc;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .footer span {
            color: #ff9800;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="calculator">
        <!-- Display Screen -->
        <div class="display"><?php echo htmlspecialchars($show); ?></div>

        <!-- All Buttons -->
        <form method="POST">
            <div class="buttons">
                <!-- Row 1: AC, DEL, /, * -->
                <button type="submit" name="clear" class="ac-btn">AC</button>
                <button type="submit" name="del" class="del-btn">DEL</button>
                <button type="submit" name="operator" value="/" class="op-btn">/</button>
                <button type="submit" name="operator" value="*" class="op-btn">*</button>

                <!-- Row 2: 7, 8, 9, - -->
                <button type="submit" name="number" value="7" class="num-btn">7</button>
                <button type="submit" name="number" value="8" class="num-btn">8</button>
                <button type="submit" name="number" value="9" class="num-btn">9</button>
                <button type="submit" name="operator" value="-" class="op-btn">-</button>

                <!-- Row 3: 6, 5, 4, + -->
                <button type="submit" name="number" value="6" class="num-btn">6</button>
                <button type="submit" name="number" value="5" class="num-btn">5</button>
                <button type="submit" name="number" value="4" class="num-btn">4</button>
                <button type="submit" name="operator" value="+" class="op-btn">+</button>

                <!-- Row 4: 1, 2, 3, = (row 1 of 2) -->
                <button type="submit" name="number" value="1" class="num-btn">1</button>
                <button type="submit" name="number" value="2" class="num-btn">2</button>
                <button type="submit" name="number" value="3" class="num-btn">3</button>
                <button type="submit" name="equals" value="=" class="eq-btn">=</button>

                <!-- Row 5: 0 (spans 3 columns) -->
                <button type="submit" name="number" value="0" class="zero-btn">0</button>
            </div>
        </form>

        <!-- Date and Time Display -->
        <div class="datetime">
            <div class="date" id="dateDisplay"></div>
            <div class="time" id="timeDisplay"></div>
        </div>
    </div>

    <script>
        // Function to update date and time
        function updateDateTime() {
            const now = new Date();

            // Get day of week
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayName = days[now.getDay()];

            // Get month name
            const months = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            const monthName = months[now.getMonth()];

            // Get date parts
            const date = now.getDate();
            const year = now.getFullYear();

            // Format date: "Friday, October 17, 2025"
            const dateString = `${dayName}, ${monthName} ${date}, ${year}`;

            // Get time parts
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();

            // Add leading zeros
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Format time: "19:04:35"
            const timeString = `${hours}:${minutes}:${seconds}`;

            // Update HTML
            document.getElementById('dateDisplay').textContent = dateString;
            document.getElementById('timeDisplay').textContent = timeString;
        }

        // Update immediately when page loads
        updateDateTime();

        // Update every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>