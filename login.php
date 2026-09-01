<?php
/**
 * ============================================================================
 * 📌 FILE NAME: login.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: User Authentication, Credential Verification & Session Initialization
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Session Management (session_start(), $_SESSION superglobal array)
 * 2. HTTP POST Processing & Form Submission (isset($_POST['submit']))
 * 3. Database Querying & Record Fetching (mysqli_query(), mysqli_fetch_assoc())
 * 4. HTTP Header Redirection (header("Location: index.php"), exit())
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How authentication workflows operate: Form Input ➡️ DB Verification ➡️ Session Creation.
 * - Why processing login logic BEFORE any HTML output is essential to prevent "Headers already sent" errors.
 * - How to store user identity across multiple requests using PHP sessions.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used in every web app where user access control and personalization are required
 *   (Admin panels, member dashboards, banking, e-commerce checkouts).
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Header Redirection Rule): Always call `header("Location: ...")` BEFORE emitting
 *   any HTML, whitespace, or `echo` statements. Always add `exit();` or `die();` immediately after.
 * - 💡 Tip 2 (Session Persistence): `$_SESSION` data lives on the server and is tied to the client
 *   via a secure cookie named `PHPSESSID`.
 * - ⚠️ Watch Out (SQL Injection): Never concatenate raw user input directly into SQL strings.
 *   Use `mysqli_real_escape_string()` or Prepared Statements.
 * ============================================================================
 */

// Step 1: Start the session before any visual output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is already logged in, redirect them directly to home
if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

require_once "mysqlconnect.php";

$error_message = "";

// Step 2: Process the Login Form Submission
if (isset($_POST['submit'])) {

    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];

    // Validate that inputs are not empty
    if (!empty($username) && !empty($password)) {

        // Query the database for the user record
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            
            $row = mysqli_fetch_assoc($result);
            $db_username = $row['username'];
            $db_password = $row['password'];

            // Compare passwords (Basic procedural approach matching Jubayer's codebase)
            // Note for Junior Devs: If hashed with password_hash(), use password_verify($password, $db_password)
            if ($password === $db_password) {
                
                // Set the session variable to authenticate the user
                $_SESSION["username"] = $db_username;
                $_SESSION["user_id"]  = $row['id'];

                // Redirect to the home page
                header("Location: index.php");
                exit();

            } else {
                $error_message = "❌ Incorrect password! Please try again.";
            }

        } else {
            $error_message = "❌ No account found with that username.";
        }

    } else {
        $error_message = "⚠️ Please enter both username and password.";
    }
}

// Step 3: Include the page header AFTER backend redirect logic
require_once "header.php";
?>

<div style="max-width: 420px; margin: 40px auto; padding: 25px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
    
    <h2 style="text-align: center; color: #2d3436; margin-bottom: 20px;">🔑 Member Login</h2>

    <!-- Display Error Message if authentication failed -->
    <?php if (!empty($error_message)): ?>
        <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="login.php" method="POST">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">Username:</label>
            <input type="text" name="username" 
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                   placeholder="Enter your username" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">Password:</label>
            <input type="password" name="password" 
                   placeholder="Enter your password" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <input type="submit" name="submit" value="Login" 
               style="width: 100%; padding: 12px; background: #0984e3; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
        
        <p style="text-align: center; margin-top: 15px; color: #636e72;">
            Don't have an account? <a href="register.php" style="color: #00b894; text-decoration: none; font-weight: bold;">Register here</a>
        </p>

    </form>
</div>

<?php 
// Step 4: Include Page Footer
require_once "footer.php"; 
?>