<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Fundamentals Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .section {
            background: white;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .output {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .code {
            background: #272822;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
        h1, h2 {
            color: #333;
        }
        .highlight {
            background: #fff3cd;
            padding: 10px;
            border-left: 4px solid #ffc107;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>PHP Fundamentals Demonstration</h1>
    
    <?php
    // ============================================
    // 1. BASIC PHP SYNTAX AND OUTPUT
    // ============================================
    echo "<div class='section'>";
    echo "<h2>1. Basic PHP Syntax and Output</h2>";
    echo "<p>PHP code is embedded within HTML using &lt;?php ?&gt; tags.</p>";
    
    // Simple variable declaration and output
    $message = "Hello, World!";
    echo "<div class='output'>";
    echo "<strong>Variable output:</strong> " . $message . "<br>";
    echo "<strong>Using echo:</strong> ";
    echo $message;
    echo "</div>";
    echo "</div>";

    // ============================================
    // 2. VARIABLES AND DATA TYPES
    // ============================================
    echo "<div class='section'>";
    echo "<h2>2. Variables and Data Types</h2>";
    
    // String variable
    $name = "John Doe";
    
    // Integer variable
    $age = 25;
    
    // Float variable
    $height = 5.9;
    
    // Boolean variable
    $isStudent = true;
    
    // Array variable
    $colors = array("red", "green", "blue");
    
    // Display variables and their types
    echo "<div class='output'>";
    echo "<strong>String:</strong> $name (Type: " . gettype($name) . ")<br>";
    echo "<strong>Integer:</strong> $age (Type: " . gettype($age) . ")<br>";
    echo "<strong>Float:</strong> $height (Type: " . gettype($height) . ")<br>";
    echo "<strong>Boolean:</strong> " . ($isStudent ? "true" : "false") . " (Type: " . gettype($isStudent) . ")<br>";
    echo "<strong>Array:</strong> " . implode(", ", $colors) . " (Type: " . gettype($colors) . ")<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 3. STRING OPERATIONS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>3. String Operations</h2>";
    
    $firstName = "John";
    $lastName = "Doe";
    
    // String concatenation
    $fullName = $firstName . " " . $lastName;
    
    // String functions
    $upperName = strtoupper($fullName);
    $lowerName = strtolower($fullName);
    $nameLength = strlen($fullName);
    
    echo "<div class='output'>";
    echo "<strong>Concatenation:</strong> $fullName<br>";
    echo "<strong>Uppercase:</strong> $upperName<br>";
    echo "<strong>Lowercase:</strong> $lowerName<br>";
    echo "<strong>Length:</strong> $nameLength characters<br>";
    echo "<strong>Substring (first 4 chars):</strong> " . substr($fullName, 0, 4) . "<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 4. MATHEMATICAL OPERATIONS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>4. Mathematical Operations</h2>";
    
    $num1 = 10;
    $num2 = 3;
    
    echo "<div class='output'>";
    echo "<strong>Addition:</strong> $num1 + $num2 = " . ($num1 + $num2) . "<br>";
    echo "<strong>Subtraction:</strong> $num1 - $num2 = " . ($num1 - $num2) . "<br>";
    echo "<strong>Multiplication:</strong> $num1 * $num2 = " . ($num1 * $num2) . "<br>";
    echo "<strong>Division:</strong> $num1 / $num2 = " . ($num1 / $num2) . "<br>";
    echo "<strong>Modulus:</strong> $num1 % $num2 = " . ($num1 % $num2) . "<br>";
    echo "<strong>Power:</strong> $num1 ^ $num2 = " . pow($num1, $num2) . "<br>";
    echo "<strong>Square root of $num1:</strong> " . sqrt($num1) . "<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 5. CONDITIONAL STATEMENTS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>5. Conditional Statements</h2>";
    
    $score = 85;
    
    echo "<div class='output'>";
    echo "<strong>Score:</strong> $score<br>";
    
    // If-elseif-else statement
    if ($score >= 90) {
        echo "<strong>Grade:</strong> A (Excellent!)<br>";
    } elseif ($score >= 80) {
        echo "<strong>Grade:</strong> B (Good!)<br>";
    } elseif ($score >= 70) {
        echo "<strong>Grade:</strong> C (Average)<br>";
    } else {
        echo "<strong>Grade:</strong> F (Needs improvement)<br>";
    }
    
    // Ternary operator
    $status = ($score >= 75) ? "Passed" : "Failed";
    echo "<strong>Status:</strong> $status<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 6. LOOPS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>6. Loops</h2>";
    
    echo "<div class='output'>";
    
    // For loop
    echo "<strong>For Loop (1-5):</strong> ";
    for ($i = 1; $i <= 5; $i++) {
        echo $i . " ";
    }
    echo "<br>";
    
    // While loop
    echo "<strong>While Loop (countdown):</strong> ";
    $count = 5;
    while ($count > 0) {
        echo $count . " ";
        $count--;
    }
    echo "<br>";
    
    // Foreach loop with array
    $fruits = array("Apple", "Banana", "Orange", "Mango");
    echo "<strong>Foreach Loop (fruits):</strong> ";
    foreach ($fruits as $fruit) {
        echo $fruit . " ";
    }
    echo "<br>";
    
    // Foreach loop with associative array
    $person = array(
        "name" => "John",
        "age" => 25,
        "city" => "New York"
    );
    echo "<strong>Associative Array:</strong><br>";
    foreach ($person as $key => $value) {
        echo "&nbsp;&nbsp;$key: $value<br>";
    }
    
    echo "</div>";
    echo "</div>";

    // ============================================
    // 7. FUNCTIONS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>7. Functions</h2>";
    
    // Simple function
    function greet($name) {
        return "Hello, $name!";
    }
    
    // Function with multiple parameters
    function calculateArea($length, $width) {
        return $length * $width;
    }
    
    // Function with default parameter
    function sayHello($name = "Guest") {
        return "Welcome, $name!";
    }
    
    echo "<div class='output'>";
    echo "<strong>Simple function:</strong> " . greet("Alice") . "<br>";
    echo "<strong>Area calculation:</strong> " . calculateArea(5, 3) . " square units<br>";
    echo "<strong>Default parameter:</strong> " . sayHello() . "<br>";
    echo "<strong>With parameter:</strong> " . sayHello("Bob") . "<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 8. ARRAYS
    // ============================================
    echo "<div class='section'>";
    echo "<h2>8. Arrays</h2>";
    
    // Indexed array
    $numbers = array(1, 2, 3, 4, 5);
    
    // Associative array
    $student = array(
        "name" => "Jane Smith",
        "age" => 20,
        "grade" => "A"
    );
    
    // Multidimensional array
    $matrix = array(
        array(1, 2, 3),
        array(4, 5, 6),
        array(7, 8, 9)
    );
    
    echo "<div class='output'>";
    echo "<strong>Indexed Array:</strong> " . implode(", ", $numbers) . "<br>";
    echo "<strong>Array Count:</strong> " . count($numbers) . " elements<br>";
    echo "<strong>First Element:</strong> " . $numbers[0] . "<br>";
    echo "<strong>Last Element:</strong> " . end($numbers) . "<br>";
    
    echo "<strong>Associative Array:</strong><br>";
    foreach ($student as $key => $value) {
        echo "&nbsp;&nbsp;$key: $value<br>";
    }
    
    echo "<strong>Multidimensional Array (2x2):</strong><br>";
    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < 2; $j++) {
            echo $matrix[$i][$j] . " ";
        }
        echo "<br>";
    }
    echo "</div>";
    echo "</div>";

    // ============================================
    // 9. FORM HANDLING
    // ============================================
    echo "<div class='section'>";
    echo "<h2>9. Form Handling</h2>";
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userName = $_POST["username"] ?? "Not provided";
        $userEmail = $_POST["email"] ?? "Not provided";
        
        echo "<div class='highlight'>";
        echo "<strong>Form Submitted!</strong><br>";
        echo "Name: $userName<br>";
        echo "Email: $userEmail<br>";
        echo "</div>";
    }
    ?>
    
    <!-- HTML Form -->
    <form method="POST" action="">
        <label for="username">Name:</label><br>
        <input type="text" id="username" name="username" placeholder="Enter your name"><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your email"><br><br>
        
        <input type="submit" value="Submit">
    </form>

    <?php
    // ============================================
    // 10. DATE AND TIME
    // ============================================
    echo "<div class='section'>";
    echo "<h2>10. Date and Time</h2>";
    
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");
    $currentDateTime = date("Y-m-d H:i:s");
    $timestamp = time();
    
    echo "<div class='output'>";
    echo "<strong>Current Date:</strong> $currentDate<br>";
    echo "<strong>Current Time:</strong> $currentTime<br>";
    echo "<strong>Current Date & Time:</strong> $currentDateTime<br>";
    echo "<strong>Timestamp:</strong> $timestamp<br>";
    echo "<strong>Formatted Date:</strong> " . date("l, F j, Y") . "<br>";
    echo "<strong>Day of Week:</strong> " . date("l") . "<br>";
    echo "</div>";
    echo "</div>";

    // ============================================
    // 11. ERROR HANDLING
    // ============================================
    echo "<div class='section'>";
    echo "<h2>11. Error Handling</h2>";
    
    echo "<div class='output'>";
    
    // Try-catch example
    try {
        $result = 10 / 0; // This will cause a division by zero error
    } catch (DivisionByZeroError $e) {
        echo "<strong>Error caught:</strong> " . $e->getMessage() . "<br>";
    }
    
    // Error suppression
    $file = @file_get_contents("nonexistent_file.txt");
    if ($file === false) {
        echo "<strong>File error handled:</strong> Could not read file<br>";
    }
    
    echo "</div>";
    echo "</div>";

    // ============================================
    // 12. SESSION DEMONSTRATION
    // ============================================
    echo "<div class='section'>";
    echo "<h2>12. Session Management</h2>";
    
    // Start session
    session_start();
    
    // Set session variables
    if (!isset($_SESSION['visit_count'])) {
        $_SESSION['visit_count'] = 1;
    } else {
        $_SESSION['visit_count']++;
    }
    
    $_SESSION['last_visit'] = date("Y-m-d H:i:s");
    
    echo "<div class='output'>";
    echo "<strong>Session ID:</strong> " . session_id() . "<br>";
    echo "<strong>Visit Count:</strong> " . $_SESSION['visit_count'] . "<br>";
    echo "<strong>Last Visit:</strong> " . $_SESSION['last_visit'] . "<br>";
    echo "</div>";
    echo "</div>";
    ?>

    <div class="section">
        <h2>Summary</h2>
        <p>This demonstration covers the fundamental concepts of PHP:</p>
        <ul>
            <li>Basic syntax and output</li>
            <li>Variables and data types</li>
            <li>String operations</li>
            <li>Mathematical operations</li>
            <li>Conditional statements</li>
            <li>Loops (for, while, foreach)</li>
            <li>Functions</li>
            <li>Arrays (indexed, associative, multidimensional)</li>
            <li>Form handling</li>
            <li>Date and time functions</li>
            <li>Error handling</li>
            <li>Session management</li>
        </ul>
        <p><strong>Note:</strong> This is a basic demonstration. PHP has many more advanced features and best practices for production applications.</p>
    </div>

</body>
</html> 