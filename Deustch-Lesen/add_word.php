<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h1>Ahong's bibliothek</h1> 
<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $german = trim($_POST['german_word']); 
    $english = trim($_POST['english_translation']);
    $indo = trim($_POST['indo_translation']);
    $more_description = trim($_POST['more_description']);
    $categories = explode(',', trim($_POST['categories'])); // Accept categories as comma-separated list

    try {
        // Insert the word into 'words' table
        $stmt = $pdo->prepare('INSERT INTO words (german_word, english_translation, indo_translation, more_description) VALUES (?, ?, ?, ?)');
        $stmt->execute([$german, $english, $indo, $more_description]);
        $word_id = $pdo->lastInsertId();

        // Process categories
        foreach ($categories as $category) {
            $category = trim($category);
            if ($category === '') continue; // Skip empty categories

            // Check if category already exists
            $stmt = $pdo->prepare('SELECT id FROM categories WHERE category_name = ?');
            $stmt->execute([$category]);
            $category_id = $stmt->fetchColumn();

            // If category doesn't exist, insert it
            if (!$category_id) {
                $stmt = $pdo->prepare('INSERT INTO categories (category_name) VALUES (?)');
                $stmt->execute([$category]);
                $category_id = $pdo->lastInsertId();
            }

            // Link word to category in word_category table
            $stmt = $pdo->prepare('INSERT INTO word_category (word_id, category_id) VALUES (?, ?)');
            $stmt->execute([$word_id, $category_id]);
        }

        echo '<p style="color:green;">✅ Word added successfully!</p>';

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error
            echo '<h1 style="color:red;">⚠️ This word already exists!</h1>';
        } else {
            echo '<h1 style="color:red;">❌ Error: ' . $e->getMessage() . '</h1>';
        }
    }
}
?>

<div class="container">
<form method="POST">
    <label>German Word: <input type="text" name="german_word" required></label><br>
    <label>English Translation: <input type="text" name="english_translation" required></label><br>
    <label>Indo Translation: <input type="text" name="indo_translation" required></label><br>
    <label>Description: <textarea name="more_description" required></textarea></label><br>
    <label>Categories (comma-separated, e.g., #SLANG, #INFORMAL, #NOUN): 
        <input type="text" name="categories">
    </label><br>
    <button type="submit">Add Word</button>
</form>
</DIV>
<footer>
<a href="bibliothek.php">See all words</a>
</footer>
    
</body>
</html>
