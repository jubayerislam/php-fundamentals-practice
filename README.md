# 💬 Jubayer's PHP Learning & Practice Codebase

> **"A step-by-step, practical learning repository built for Junior PHP Developers to master core PHP, MySQL database operations, session authentication, and dynamic web application fundamentals."**

---

## 👨‍💻 About This Repository

Welcome to **Jubayer's PHP Learning & Practice Codebase**! 

This repository was created not just to store code, but to serve as a **hands-on learning guide for Junior Developers**. Each file in this project demonstrates a fundamental backend concept with clean procedural PHP, clear variable structures, direct database interactions, and practical real-world scenarios.

### 🎯 The Learning Journey
```text
Basic PHP ➡️ Core Concepts ➡️ Real Examples ➡️ Practical Use Cases ➡️ Better Coding Practices
```

---

## 🗺️ Step-by-Step Learning Progression Roadmap

Follow the files in this recommended reading order to learn PHP web development from the ground up:

```text
Step 01: mysqlconnect.php  ───► Database Connection & Error Handling
Step 02: header.php        ───► Modular Templating & Session Check
Step 03: register.php      ───► Form Handling, Validation & Data Insertion
Step 04: login.php         ───► User Authentication & Session Management
Step 05: index.php         ───► Relational Queries (SQL JOIN) & Dynamic Feed
Step 06: post.php          ───► Content Creation & Authorization Gates (CRUD - Create)
Step 07: replies.php       ───► Query Parameters, 1-to-Many Relationships & Thread Replies
Step 08: members.php       ───► Collections Retrieval & Query String Navigation
Step 09: profile.php       ───► Master-Detail Pattern & Single Record Lookup (CRUD - Read)
Step 10: account.php       ───► User Dashboard & Password Updates (CRUD - Update)
Step 11: test.php          ───► Junior Developer Practice Lab & Interactive Sandbox
```

---

## 📂 Detailed File-by-File Learning Guide

---

### 1️⃣ [`mysqlconnect.php`](file:///c:/Users/User/php-fundamentals-practice/mysqlconnect.php) — Database Connection & Error Handling
* **What is in this file?** Centralized database configuration establishing a connection to MySQL using procedural `mysqli_connect()`.
* **PHP Concepts Used:** Variables, `mysqli_connect()`, conditional error handling (`if (!$conn)`), `die()`, `mysqli_connect_error()`, character encoding (`mysqli_set_charset()`).
* **What You Will Learn:** How PHP establishes communication with a MySQL server and how to gracefully halt execution on failure.
* **Where & Why It's Used in Real-World:** Used in every dynamic web application to centralize database credentials so they can be changed in ONE file without touching dozens of scripts.
* **💡 Junior Developer Pro-Tip:** Always `require_once` your database connection in other scripts. Never copy-paste connection parameters across multiple files (DRY Principle).

---

### 2️⃣ [`header.php`](file:///c:/Users/User/php-fundamentals-practice/header.php) & [`footer.php`](file:///c:/Users/User/php-fundamentals-practice/footer.php) — Modular Templating & Dynamic Navigation
* **What is in this file?** Shared layout templates containing the HTML skeleton, CSS links, dynamic navbar, and footer.
* **PHP Concepts Used:** `session_start()`, `$_SESSION` superglobal, conditional rendering (`if-else`), `require_once`, dynamic date formatting (`date('Y')`).
* **What You Will Learn:** How to build DRY (Don't Repeat Yourself) web layouts that change navigation links dynamically depending on whether a user is logged in or a guest.
* **Where & Why It's Used in Real-World:** Applied in CMS themes, SaaS admin panels, and e-commerce stores to keep navbar, logo, and footer consistent across hundreds of pages.
* **💡 Junior Developer Pro-Tip:** Always check `session_status() === PHP_SESSION_NONE` before calling `session_start()` to avoid `"session already started"` notices.

---

### 3️⃣ [`register.php`](file:///c:/Users/User/php-fundamentals-practice/register.php) — Form Handling & Input Validation
* **What is in this file?** A user registration page that validates input and creates new user records in the database.
* **PHP Concepts Used:** `$_POST` superglobal, `isset()`, `empty()`, `trim()`, `strlen()`, string escaping (`mysqli_real_escape_string()`), SQL `INSERT`, user feedback alerts.
* **What You Will Learn:** How to validate required fields, enforce string length constraints, check for matching passwords, prevent duplicate accounts, and insert data into MySQL.
* **Where & Why It's Used in Real-World:** The onboarding gateway for user accounts on membership portals, social networks, and e-commerce platforms.
* **💡 Junior Developer Pro-Tip:** Watch out for logical operator traps: When validating string length within a range (e.g. 5 to 25 chars), you **must use `&&` (AND)** (`strlen($user) >= 5 && strlen($user) <= 25`), **never `||` (OR)**!

---

### 4️⃣ [`login.php`](file:///c:/Users/User/php-fundamentals-practice/login.php) — Authentication & Session Initialization
* **What is in this file?** User login interface that verifies credentials against MySQL and creates an authenticated session.
* **PHP Concepts Used:** `session_start()`, `$_SESSION`, HTTP POST handling, SQL `SELECT ... WHERE`, `mysqli_fetch_assoc()`, `header("Location: ...")`, `exit()`.
* **What You Will Learn:** The complete authentication lifecycle: User Input ➡️ DB Verification ➡️ Session Storage ➡️ Safe Redirection.
* **Where & Why It's Used in Real-World:** Used on any portal requiring access control, user permission gates, and personalized dashboards.
* **💡 Junior Developer Pro-Tip:** **The Header Redirection Rule:** Always call `header("Location: ...")` **BEFORE** printing any HTML or `echo` output, and always follow it with `exit();` to prevent PHP from executing the rest of the script.

---

### 5️⃣ [`index.php`](file:///c:/Users/User/php-fundamentals-practice/index.php) — Relational Queries & Dynamic Topic Feed
* **What is in this file?** The forum homepage that displays all posted discussion topics joined with author information, plus the session logout handler.
* **PHP Concepts Used:** SQL `LEFT JOIN`, `session_destroy()`, cookie expiration, `while ($row = mysqli_fetch_assoc($result))`, dynamic HTML table generation, `htmlspecialchars()`.
* **What You Will Learn:** How to use SQL `JOIN` to pull data from multiple tables in a single query rather than running nested queries (preventing the N+1 problem).
* **Where & Why It's Used in Real-World:** The primary landing feed for blogs, Reddit-style forums, news portals, and social media walls.
* **💡 Junior Developer Pro-Tip:** When sanitizing user-generated text displayed in HTML, always wrap values in `htmlspecialchars($text)` to prevent Cross-Site Scripting (XSS).

---

### 6️⃣ [`post.php`](file:///c:/Users/User/php-fundamentals-practice/post.php) — Content Creation & Route Guarding (CRUD - Create)
* **What is in this file?** Form for authenticated users to publish new discussion topics to the forum.
* **PHP Concepts Used:** Route guarding (redirecting guests to login), `$_POST` processing, length validation (`strlen()`), SQL `INSERT`, automated timestamping (`date("Y-m-d")`).
* **What You Will Learn:** How to protect submission endpoints so only logged-in members can publish content, and how to link newly created records to `$_SESSION['username']`.
* **Where & Why It's Used in Real-World:** Creating blog articles, submitting support tickets, opening forum discussions, and uploading products.
* **💡 Junior Developer Pro-Tip:** Never rely solely on frontend HTML `required` attributes; always validate data on the backend in PHP!

---

### 7️⃣ [`replies.php`](file:///c:/Users/User/php-fundamentals-practice/replies.php) — Relational Data & Thread Discussions
* **What is in this file?** Interactive topic discussion page that displays topic details, lists all posted replies, and allows users to submit new answers.
* **PHP Concepts Used:** `$_GET` query string parsing, `intval()` casting, 1-to-Many foreign key relationships, hidden form inputs (`<input type="hidden">`), `nl2br()`.
* **What You Will Learn:** How child records (`answer`) relate to parent records (`topics`) via foreign keys, and how to pass parent IDs silently through forms.
* **Where & Why It's Used in Real-World:** Comment sections on YouTube/blogs, answers on StackOverflow, and customer reviews on Amazon.
* **💡 Junior Developer Pro-Tip:** Always cast integer URL parameters with `intval($_GET['topic'])` or `(int)$_GET['topic']` to immediately stop string-based SQL injection attacks in their tracks!

---

### 8️⃣ [`members.php`](file:///c:/Users/User/php-fundamentals-practice/members.php) & [`profile.php`](file:///c:/Users/User/php-fundamentals-practice/profile.php) — Master-Detail Pattern & Single Record Lookup
* **What is in this file?** 
  - `members.php`: Directory listing all registered users with avatar cards.
  - `profile.php`: Dedicated public profile page for a single user showing their stats and created topics.
* **PHP Concepts Used:** Master-Detail design pattern, `SELECT * FROM users WHERE id = X`, empty result handling (`mysqli_num_rows() === 0`), dynamic links (`profile.php?id=ID`).
* **What You Will Learn:** How to pass unique record IDs between pages to create seamless master-detail interfaces.
* **Where & Why It's Used in Real-World:** User profile pages on GitHub/Twitter, employee directories, and product detail pages on e-commerce sites.
* **💡 Junior Developer Pro-Tip:** Always handle the "Not Found" state gracefully so users aren't left staring at an empty white screen if an ID doesn't exist.

---

### 9️⃣ [`account.php`](file:///c:/Users/User/php-fundamentals-practice/account.php) — User Dashboard & Password Updates (CRUD - Update)
* **What is in this file?** Private account management page for the logged-in user with live activity statistics and password change workflow.
* **PHP Concepts Used:** `SQL UPDATE`, `COUNT(*)` database aggregation, session user matching, multi-field verification, state toggling with query strings (`?action=changepass`).
* **What You Will Learn:** How to build private user settings and safely update records in a database table.
* **Where & Why It's Used in Real-World:** User account settings, profile update forms, and password management in any web application.
* **💡 Junior Developer Pro-Tip:** **Crucial SQL Rule:** NEVER run an `UPDATE` query without a specific `WHERE` clause (`UPDATE users SET ... WHERE username = '$user'`), or you will overwrite data for every single user in the table!

---

### 🔟 [`test.php`](file:///c:/Users/User/php-fundamentals-practice/test.php) — Junior Dev Practice Lab & Sandbox
* **What is in this file?** An interactive coding sandbox with live superglobal inspections, string function demonstrations, and practical mini-challenges.
* **PHP Concepts Used:** Live superglobal inspection (`$_SERVER`, `$_SESSION`), string manipulation (`strlen`, `trim`, `strtoupper`), sandbox testing techniques.
* **What You Will Learn:** How to debug PHP scripts, test built-in functions, and solve mini-challenges.

---

## 🗄️ Database Schema & SQL Setup

To set up the MySQL database, create a database named **`php_forum`** in MySQL/phpMyAdmin and execute this SQL script:

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

-- 2. Topics Table (Parent entity)
CREATE TABLE IF NOT EXISTS `topics` (
  `topics_id` INT(11) NOT NULL AUTO_INCREMENT,
  `topics_name` VARCHAR(255) NOT NULL,
  `topics_creator` VARCHAR(50) NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`topics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Answers Table (Child entity linked to topics)
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

## ⚙️ How to Run Locally

### 1. Prerequisites
- **PHP 7.4+** or **PHP 8.x**
- **MySQL / MariaDB** (via XAMPP, Laragon, WampServer, or Docker)

### 2. Quick Start
1. Place this project folder inside your web server root:
   - **XAMPP:** `C:/xampp/htdocs/php-fundamentals-practice`
   - **Laragon:** `C:/laragon/www/php-fundamentals-practice`
2. Start **Apache** and **MySQL**.
3. Import the SQL schema above into phpMyAdmin (`http://localhost/phpmyadmin`).
4. Or run directly with PHP's built-in server:
   ```bash
   php -S localhost:8000
   ```
5. Open your browser and visit: `http://localhost:8000/` or `http://localhost/php-fundamentals-practice/`.

---

## 🏆 Junior Developer Next-Level Challenges

Ready to level up your PHP skills? Try implementing these improvements in this repository:

1. **Password Security Upgrade:** Replace plain text passwords with `password_hash($password, PASSWORD_BCRYPT)` and verify them in `login.php` with `password_verify()`.
2. **Prepared Statements Migration:** Convert procedural `mysqli_query()` calls into parameterized Prepared Statements (`mysqli_prepare()` and `mysqli_stmt_bind_param()`) to achieve 100% SQL injection immunity.
3. **Pagination Implementation:** Add pagination (`LIMIT 5 OFFSET ...`) to `index.php` and `members.php` so long lists are broken into numbered pages.
4. **OOP / PDO Refactor:** Create a `Database` class using `PDO` and convert procedural functions into clean Object-Oriented methods.

---

## 👤 Author & Coding Identity

Developed & Structured by **Jubayer Islam**.  
*Crafted as an open educational resource for aspiring and junior PHP developers.*
