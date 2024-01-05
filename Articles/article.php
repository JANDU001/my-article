<?php
require_once 'db.php';
class Article {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    // Method to add a new Article
    public function addArticle($authorId, $title, $fullText) {
        $conn = $this->db->getConnection();

        // Validate input data (add your validation logic)
        if (empty($title) || empty($fullText)) {
            return false; // Validation failed
        }

        // Insert the new article
        $stmt = $conn->prepare("INSERT INTO articles (authorId, article_title, article_full_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $authorId, $title, $fullText);

        return $stmt->execute();
    }

    // Method to update an existing Article
    public function updateArticle($articleId, $title, $fullText) {
        $conn = $this->db->getConnection();

        // Validate input data (add your validation logic)
        if (empty($title) || empty($fullText)) {
            return false; // Validation failed
        }

        // Update the article details
        $stmt = $conn->prepare("UPDATE articles SET article_title = ?, article_full_text = ? WHERE articleId = ?");
        $stmt->bind_param("ssi", $title, $fullText, $articleId);

        return $stmt->execute();
    }

    // Method to delete an article
    public function deleteArticle($articleId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM articles WHERE articleId = ?");
        $stmt->bind_param("i", $articleId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to get a list of articles
    public function getArticles() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM articles ORDER BY article_created_date DESC LIMIT 6");
        $stmt->execute();
        $result = $stmt->get_result();

        $articles = array();
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }
     // Method to retrieve the last 6 articles by the Author
     public function getAuthorArticles($authorId) {
        $conn = $this->db->getConnection();

        // Retrieve the last 6 articles by the Author, ordering by article_created_date
        $stmt = $conn->prepare("SELECT * FROM articles WHERE authorId = ? ORDER BY article_created_date DESC LIMIT 6");
        $stmt->bind_param("i", $authorId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>