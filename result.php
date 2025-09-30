<?php
session_start();

if (!isset($_SESSION['score'], $_SESSION['wrong'])) {
    header("Location: settings.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header("Location: settings.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <p>Total Questions: <?= $_SESSION['num_questions']; ?></p>
        <p>Correct Answers: <?= $_SESSION['score']; ?></p>
        <p>Wrong Answers: <?= $_SESSION['wrong']; ?></p>
        <table>
            <tr>
                <th>Correct |</th>
                <th>Wrong |</th>
                <th>Accuracy |</th>
            </tr>
            <tr>
                <td><?= $_SESSION['score']; ?></td>
                <td><?= $_SESSION['wrong']; ?></td>
                <td><?= round(($_SESSION['score'] / $_SESSION['num_questions']) * 100, 2); ?>%</td>
            </tr>
        </table>
        <form method="post">
            <button type="submit">Restart Quiz</button>
        </form>
    </div>
</body>
</html>