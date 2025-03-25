<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
<body>
    
    <?php
    require 'db.php';

    // Fetch a random word
    $stmt = $pdo->query("SELECT * FROM words ORDER BY RAND() LIMIT 1");
    $word = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_answer = strtolower(trim($_POST['answer']));
        $correct_answer = strtolower($word['english_translation']);
        $is_correct = $user_answer === $correct_answer;

        // Store quiz result (optional)
        $stmt = $pdo->prepare("INSERT INTO quizzes (word_id, user_answer, correct_answer, is_correct) VALUES (?, ?, ?, ?)");
        $stmt->execute([$word['id'], $user_answer, $correct_answer, $is_correct]);

        $feedback = $is_correct ? "✅ Correct!" : "❌ Incorrect! The answer is: {$word['english_translation']}";
        echo "<p class='feedback'>$feedback</p>";
    }
    ?>

    <h2>Translate this German word:</h2>
    <p><strong><?php echo htmlspecialchars($word['german_word']); ?></strong></p>

    <form method="POST">
        <label>Your Answer: <input type="text" name="answer" required></label>
        <button type="submit">Check</button>
    </form>
</body>
</html>