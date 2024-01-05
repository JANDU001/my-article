<?php
require_once 'session.php';
require_once 'article.php';

Session::start();

// Authenticate user and check user type
Session::authenticateUser();

$article = new Article();
$articles = $article->getArticles();

// Add HTML content for viewing articles
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Articles</title>
</head>

<body>
    <h2>View Articles</h2>
    <!-- Display the last 6 articles -->
    <?php foreach ($articles as $article) : ?>
        <div>
            <h3><?php echo $article['article_title']; ?></h3>
            <p><?php echo $article['article_full_text']; ?></p>
            <!-- Add export links for PDF and text file -->
            <a href="exportpdf.php?articleId=<?php echo $article['articleId']; ?>">Export as PDF</a>
            <a href="exporttext.php?articleId=<?php echo $article['articleId']; ?>">Export as Text</a>
        </div>
    <?php endforeach; ?>

    <a href="logout.php">Logout</a>
</body>

</html>
