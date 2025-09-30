<?php
session_start();

if (!isset($_SESSION['level'], $_SESSION['operator'], $_SESSION['num_questions'])) {
    header("Location: settings.php");
    exit;
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
    $_SESSION['wrong'] = 0;
    $_SESSION['question_count'] = 0;
}

function generateQuestion($level, $operator, $custom_min = null, $custom_max = null) {
    if ($level === 'custom') {
        $min = $custom_min;
        $max = $custom_max;
    } else {
        $min = $level == 1 ? 1 : 11;
        $max = $level == 1 ? 10 : 100;
    }
    $num1 = rand($min, $max);
    $num2 = rand($min, $max);

    switch ($operator) {
        case 'addition':
            return ["$num1 + $num2", $num1 + $num2];
        case 'subtraction':
            return ["$num1 - $num2", $num1 - $num2];
        case 'multiplication':
            return ["$num1 * $num2", $num1 * $num2];
    }
}

function generateChoices($answer, $min, $max) {
    $choices = [$answer];
    while (count($choices) < 4) {
        $fake = rand($min, $max);
        if (!in_array($fake, $choices)) {
            $choices[] = $fake;
        }
    }
    shuffle($choices);
    return $choices;
}

$isCorrect = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isCorrect = $_POST['answer'] == $_SESSION['current_question'][1];
    if ($isCorrect) {
        $_SESSION['score']++;
    } else {
        $_SESSION['wrong']++;
    }
    $_SESSION['question_count']++;
    if ($_SESSION['question_count'] >= $_SESSION['num_questions']) {
        header("Location: result.php");
        exit;
    }
}

list($question, $answer) = generateQuestion(
    $_SESSION['level'],
    $_SESSION['operator'],
    $_SESSION['custom_min'] ?? null,
    $_SESSION['custom_max'] ?? null
);

$choices = generateChoices($answer, 1, 100);
$_SESSION['current_question'] = [$question, $answer];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mathematics</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Math Quiz</h1>
        <p>Question <?= $_SESSION['question_count'] + 1; ?>/<?= $_SESSION['num_questions']; ?></p>
        <p class="question"><?= $_SESSION['current_question'][0]; ?> = ?</p>

        <?php if ($isCorrect !== null): ?>
            <p class="feedback <?= $isCorrect ? 'correct' : 'incorrect'; ?>">
                <?= $isCorrect ? 'Correct!' : 'Wrong! The correct answer is ' . $_SESSION['current_question'][1]; ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <?php foreach ($choices as $choice): ?>
                <label class="choice">
                    <input type="radio" name="answer" value="<?= $choice; ?>" required>
                    <?= $choice; ?>
                </label>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>
</html>