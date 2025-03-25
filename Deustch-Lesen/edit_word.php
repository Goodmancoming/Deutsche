<?php
require 'db.php';

// Get word ID from URL
$word_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the word and its categories
$stmt = $pdo->prepare("SELECT * FROM words WHERE id = ?");
$stmt->execute([$word_id]);
$word = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$word) {
    die("Word not found!");
}

// Fetch existing categories
$stmt = $pdo->prepare("SELECT c.category_name 
                       FROM categories c
                       JOIN word_category wc ON c.id = wc.category_id
                       WHERE wc.word_id = ?");
$stmt->execute([$word_id]);
$existingCategories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch all categories for selection
$allCategories = $pdo->query("SELECT category_name FROM categories ORDER BY category_name")
                     ->fetchAll(PDO::FETCH_COLUMN);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $german = trim($_POST['german_word']);
    $english = trim($_POST['english_translation']);
    $indo = trim($_POST['indo_translation']);
    $description = trim($_POST['more_description']);
    $newCategories = isset($_POST['categories']) ? $_POST['categories'] : [];

    // Update the word details
    $stmt = $pdo->prepare("UPDATE words SET german_word = ?, english_translation = ?, indo_translation = ?, more_description = ? WHERE id = ?");
    $stmt->execute([$german, $english, $indo, $description, $word_id]);

    // Update categories (clear old ones, add new ones)
    $pdo->prepare("DELETE FROM word_category WHERE word_id = ?")->execute([$word_id]);
    foreach ($newCategories as $category) {
        // Ensure category exists or create it
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE category_name = ?");
        $stmt->execute([$category]);
        $category_id = $stmt->fetchColumn();

        if (!$category_id) {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->execute([$category]);
            $category_id = $pdo->lastInsertId();
        }

        // Link word with category
        $stmt = $pdo->prepare("INSERT INTO word_category (word_id, category_id) VALUES (?, ?)");
        $stmt->execute([$word_id, $category_id]);
    }

    echo "<body style='background-color:rgb(60,40,60);'><p style='color: green;'>✅ Word updated successfully!</p></body>";
    header("Refresh: 2; URL=bibliothek.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Word</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<h1>Edit Word</h1>

<form method="POST">
    <label>German Word: <input type="text" name="german_word" value="<?= htmlspecialchars($word['german_word']) ?>" required></label><br>
    <label>English Translation: <input type="text" name="english_translation" value="<?= htmlspecialchars($word['english_translation']) ?>" required></label><br>
    <label>Indo Translation: <input type="text" name="indo_translation" value="<?= htmlspecialchars($word['indo_translation']) ?>" required></label><br>
    <label>Description: <textarea name="more_description" required><?= htmlspecialchars($word['more_description']) ?></textarea></label><br>

    <!-- Multi-Select for Categories -->
    <label>Categories (Hold CTRL to select multiple):</label><br>
    <select name="categories[]" multiple>
        <?php foreach ($allCategories as $category) : ?>
            <option value="<?= htmlspecialchars($category) ?>"
                <?= in_array($category, $existingCategories) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Save Changes</button>
    <a href="bibliothek.php"><button type="button">Cancel</button></a>
</form>

</body>

</html>
