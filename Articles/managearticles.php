
<?php
require_once 'session.php';
require_once 'article.php';

Session::start();
Session::authenticateUser();

$authorId = $_SESSION['userId'];
$article = new Article();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addArticle'])) {
    // Handle form submission for adding a new article
    $title = $_POST['title'];
    $fullText = $_POST['fullText'];

    // Call the addArticle method in the Article class
    if ($article->addArticle($authorId, $title, $fullText)) {
        // Article added successfully
        header("Location: managearticles.php");
        exit();
    } else {
        // Error adding article
        $error_message = "Error adding article. Please try again.";
    }
}

// Fetch the last 6 articles by the Author
$authorArticles = $article->getAuthorArticles($authorId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
</head>

<body>
    <h2>Manage Articles</h2>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Add new article form -->
    <form method="post" action="managearticles.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="fullText">Full Text:</label>
        <textarea id="fullText" name="fullText" required></textarea><br>

        <button type="submit" name="addArticle">Add Article</button>
    </form>

    <!-- Display the list of articles -->
    <h3>Your Articles</h3>
    <ul>
        <?php foreach ($authorArticles as $article) : ?>
            <li>
                <?php echo $article['article_title']; ?>
                <a href="updatearticle.php?id=<?php echo $article['articleId']; ?>">Update</a>
                <a href="deletearticle.php?id=<?php echo $article['articleId']; ?>">Delete</a>
                <a href="exportpdf.php?id=<?php echo $article['articleId']; ?>">Export PDF</a>
                <a href="exporttextfile.php?id=<?php echo $article['articleId']; ?>">Export Textfile</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>
