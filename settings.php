<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['level'] = $_POST['level'];
    $_SESSION['operator'] = $_POST['operator'];
    $_SESSION['num_questions'] = $_POST['num_questions'];
    if ($_SESSION['level'] === 'custom') {
        $_SESSION['custom_min'] = $_POST['custom_min'];
        $_SESSION['custom_max'] = $_POST['custom_max'];
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quiz Settings</title>
</head>
<body>
    <div class="container">
        <h1>Quiz Settings >></h1>
        <form method="post">
            <label for="level">Select Difficulty:</label>
            <input type="radio" name="level" value="1" required> Level 1 (1-10)<br>
            <input type="radio" name="level" value="2"> Level 2 (11-100)<br>
            <input type="radio" name="level" value="custom"> Custom Level (Enter Range)<br>
            <div id="custom-range">
                <label>Min:</label>
                <input type="number" name="custom_min" min="1">
                <label>Max:</label>
                <input type="number" name="custom_max" min="1">
            </div>
            <br>
            <label for="operator">Select Operator:</label>
            <input type="radio" name="operator" value="addition" required> Addition<br>
            <input type="radio" name="operator" value="subtraction"> Subtraction<br>
            <input type="radio" name="operator" value="multiplication"> Multiplication<br>
            <br>
            <label for="num_questions">Number of Questions:</label>
            <input type="number" name="num_questions" min="1" max="50" value="10" required>
            <br>
            <button type="submit">Start Quiz</button>
        </form>
    </div>
    <script>
        document.querySelectorAll('input[name="level"]').forEach((input) => {
            input.addEventListener('change', function () {
                document.getElementById('custom-range').style.display =
                    this.value === 'custom' ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>