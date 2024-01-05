CREATE DATABASE IF NOT EXISTS myarticles;
USE myarticles;
CREATE TABLE users (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    Full_Name VARCHAR(250),
    email VARCHAR(250),
    phone_Number VARCHAR(20),
    User_Name VARCHAR(50) UNIQUE,
    Password VARCHAR(250),
    UserType VARCHAR(20),
    AccessTime DATETIME,
    profile_Image VARCHAR(255),
    Address TEXT
);


CREATE TABLE articles (
    articleId INT PRIMARY KEY AUTO_INCREMENT,
    authorId INT,
    article_title VARCHAR(250),
    article_full_text TEXT,
    article_created_date DATETIME,
    article_last_update DATETIME,
    article_display ENUM('yes', 'no'),
    article_order INT,
    FOREIGN KEY (authorId) REFERENCES users(userId)
);
