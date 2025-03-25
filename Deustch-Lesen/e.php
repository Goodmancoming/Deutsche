<?php
require 'db.php';

// Fetch all categories for the dropdown
$categoryQuery = $pdo->query("SELECT category_name FROM categories ORDER BY category_name");
$categories = $categoryQuery->fetchAll(PDO::FETCH_COLUMN);

// Handle category filter input
$categoryFilter = isset($_GET['categories']) ? $_GET['categories'] : [];

// Base SQL query
$sql = "SELECT 
            w.id, 
            w.german_word, 
            w.english_translation, 
            w.indo_translation, 
            w.more_description,
            GROUP_CONCAT(c.category_name ORDER BY c.category_name SEPARATOR ', ') AS categories
        FROM words w
        LEFT JOIN word_category wc ON w.id = wc.word_id
        LEFT JOIN categories c ON wc.category_id = c.id";

// Apply category filter if selected
if (!empty($categoryFilter)) {
    $placeholders = implode(',', array_fill(0, count($categoryFilter), '?'));
    $sql .= " WHERE c.category_name IN ($placeholders)";
}

// Group by word
$sql .= " GROUP BY w.id";

$stmt = $pdo->prepare($sql);
$stmt->execute($categoryFilter);
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/style.css" rel="stylesheet">
    <title>Biblioteck</title>
</head>
<body>
<h1>Ahong's Bibliothek</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi quasi sequi, saepe in recusandae reprehenderit aspernatur fugiat itaque veritatis cumque facilis unde. Nemo, possimus exercitationem aspernatur delectus mollitia temporibus esse!</p>

<!-- Multi-Select Filter Form -->
<form method="GET" action="">
    <label>Select Categories:</label><br>
    <select name="categories[]" multiple>
        <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category) ?>"
                <?= in_array($category, $categoryFilter) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
    <a href="bibliothek.php"><button type="button">Reset</button></a>
</form>
<div class="container">

        <tr>
        <th>ID</th>
        <th>German</th>
        <th>English</th>
        <th>Indo</th>
        <th>Description</th>
        <th>Categories</th>
        </tr>
        <?php foreach ($words as $word) : ?>
        <tr>
            <td><?= htmlspecialchars($word['id']) ?></td>
            <td><?= htmlspecialchars($word['german_word']) ?></td>
            <td><?= htmlspecialchars($word['english_translation']) ?></td>
            <td><?= htmlspecialchars($word['indo_translation']) ?></td>
            <td><?= htmlspecialchars($word['more_description']) ?></td>
            <td><?= htmlspecialchars($word['categories']) ?></td>
        </tr>
        <tr>
            <td class="divider" colspan="5">
                <hr class="divider">
            </td>
            <td>
            <a href="edit_word.php?id=<?= htmlspecialchars($word['id']) ?>">✏️ Edit</a>
        </td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
        <?php endforeach; ?>
        </table>
    </div>
    <footer>
        <a href="add_word.php">Add More Words</a>
    </footer>

</body>
</html>
