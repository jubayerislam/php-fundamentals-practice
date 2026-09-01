# 💬 PHP Forum & Fundamentals Practice

A lightweight discussion forum web application built with **PHP** and **MySQL (Procedural `mysqli`)** for learning and practicing core PHP concepts, user authentication, session management, and database operations.

---

## 🚀 Features

- 🔐 **User Authentication System**:
  - User Registration with form validation (length checks, password confirmation).
  - User Login with session persistence.
  - Secure session-based Logout functionality.
- 📋 **Forum & Discussion Topics**:
  - Browse all forum topics with author information and timestamps.
  - Create/Post new topics with character limit validation.
- 💬 **Replies & Answers**:
  - View topic details and associated replies.
  - Post replies/answers to specific topics.
- 👤 **User Profiles & Members**:
  - Public member directory.
  - User profile pages showing activity details (registration date, email, topic/reply counts, score).
  - "My Account" page with password change interface.

---

## 🛠️ Tech Stack

- **Backend**: PHP (Procedural style with `mysqli`)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, FontAwesome

---

## 📁 Project Structure

```text
php-fundamentals-practice/
│
├── images/
│   └── users_pic.png       # Default user avatar
│
├── account.php             # User account details and password change
├── footer.php              # Shared footer component
├── header.php              # Shared navigation bar and session header
├── index.css               # Styling for forum home layout
├── index.php               # Forum home page (List of topics)
├── login.php               # User login page
├── members.php             # Directory of registered members
├── mysqlconnect.php        # Database connection configuration
├── post.php                # Topic creation page
├── profile.php             # Member profile viewer
├── register.php            # User registration page
├── replies.php             # View and submit topic replies
├── style.css               # Navigation bar and global styles
├── test.php                # Testing scratchpad
└── README.md               # Project documentation
```

---

## 🗄️ Database Setup

Create a database named **`php_forum`** in MySQL (e.g., via phpMyAdmin or MySQL CLI) and execute the following SQL queries:

```sql
CREATE DATABASE IF NOT EXISTS `php_forum`;
USE `php_forum`;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `profile_pic` VARCHAR(255) DEFAULT 'images/users_pic.png',
  `date` DATE NOT NULL,
  `topics` INT(11) DEFAULT 0,
  `replies` INT(11) DEFAULT 0,
  `score` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Topics Table
CREATE TABLE IF NOT EXISTS `topics` (
  `topics_id` INT(11) NOT NULL AUTO_INCREMENT,
  `topics_name` VARCHAR(255) NOT NULL,
  `topics_creator` VARCHAR(50) NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`topics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Answers/Replies Table
CREATE TABLE IF NOT EXISTS `answer` (
  `replies_id` INT(11) NOT NULL AUTO_INCREMENT,
  `topic_answer` TEXT NOT NULL,
  `date` DATE NOT NULL,
  `topics_id` INT(11) NOT NULL,
  PRIMARY KEY (`replies_id`),
  FOREIGN KEY (`topics_id`) REFERENCES `topics`(`topics_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## ⚙️ Installation & Running Locally

### 1. Prerequisites
- **PHP** (v7.4 or v8.x)
- **MySQL / MariaDB** (via XAMPP, WampServer, Laragon, or standalone)
- Web Server (Apache or PHP Built-in Server)

### 2. Setup Steps

1. **Clone or move the project** into your local web server root:
   - For XAMPP: `C:/xampp/htdocs/php-fundamentals-practice`
   - For Laragon: `C:/laragon/www/php-fundamentals-practice`

2. **Configure Database Connection**:
   Open [mysqlconnect.php](file:///c:/Users/User/php-fundamentals-practice/mysqlconnect.php) and verify your MySQL credentials:
   ```php
   $servarname = "localhost";
   $usename    = "root";
   $password   = "";
   $dbname     = "php_forum";
   ```

3. **Start MySQL and Web Server**:
   - Start Apache & MySQL from the XAMPP / Laragon control panel, OR
   - Run PHP's built-in development server from this directory:
     ```bash
     php -S localhost:8000
     ```

4. **Access the Application**:
   - Open your browser and navigate to:
     - `http://localhost/php-fundamentals-practice/` (via Apache) or
     - `http://localhost:8000/` (via PHP CLI server)

---

## 📝 License

This project is open-source and intended for educational and practice purposes.
