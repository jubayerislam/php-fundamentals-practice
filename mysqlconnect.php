<?php
/**
 * ============================================================================
 * 📌 FILE NAME: mysqlconnect.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Database Connection Configuration & Error Handling
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Variables & Configuration ($servername, $username, $password, $dbname)
 * 2. MySQLi Procedural Connection (mysqli_connect)
 * 3. Conditional Flow & Error Handling (if (!$conn), die(), mysqli_connect_error())
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to establish a connection between a PHP script and a MySQL database server.
 * - How to handle connection failures gracefully without leaking sensitive credentials.
 * - The purpose of centralizing database configuration in a single reusable file.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used in virtually every dynamic PHP application (E-commerce, CMS, Portals).
 * - Centralizing this in one file (`mysqlconnect.php` or `db.php`) allows you to change
 *   database credentials in ONE place instead of updating dozens of files.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (DRY Principle): Always `require` or `include` this connection file in other
 *   pages rather than copying connection code everywhere.
 * - 💡 Tip 2 (mysqli vs PDO): In modern PHP, you can use `mysqli` (MySQL-only) or `PDO` 
 *   (supports multiple databases like PostgreSQL, SQLite, MySQL). Both are great for learning!
 * - ⚠️ Watch Out: Never hardcode production database passwords in public Git repositories.
 *   In production, use Environment Variables (`.env`).
 * ============================================================================
 */

// Step 1: Define database connection credentials
$servername = "localhost";   // Database host server (typically localhost in XAMPP / Laragon)
$username   = "root";        // Database user (default is 'root' in local development)
$password   = "";            // Database password (default is empty in local development)
$dbname     = "php_forum";   // Name of the database we want to connect to

// Step 2: Establish the connection using procedural mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Step 3: Check if the connection was successful
if (!$conn) {
    // If connection failed, stop script execution and display the exact error message
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set character encoding to UTF-8 for proper multi-language and special character support
mysqli_set_charset($conn, "utf8mb4");
?>