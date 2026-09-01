<?php
/**
 * ============================================================================
 * 📌 FILE NAME: header.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Modular Page Header, Dynamic Navigation Bar & Session State Check
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Modular Templating (DRY - Don't Repeat Yourself using require/include)
 * 2. Session Management (session_start(), checking $_SESSION["username"])
 * 3. Conditional HTML Rendering (if-else rendering based on authentication state)
 * 4. Relational Database Querying (fetching current user ID for dynamic profile links)
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to build a unified navigation bar that automatically changes when a user logs in.
 * - Why starting sessions safely before any HTML output prevents headers-already-sent errors.
 * - How to include reusable components across all pages in a PHP website.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Real-world applications separate common UI layouts (Header, Sidebar, Footer) from
 *   page-specific content to maintain consistency and ease of updates across the entire site.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1: Always check `session_status() === PHP_SESSION_NONE` before calling `session_start()`
 *   to avoid PHP notices when including multiple files.
 * - 💡 Tip 2: Use `require` for essential dependencies (like database connections) where the page
 *   cannot function without them, and `include` for optional visual elements.
 * - ⚠️ Watch Out: Don't echo HTML output before setting sessions or sending header redirects.
 * ============================================================================
 */

// Step 1: Ensure session is active so we can access user login state
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 2: Include the database connection configuration
require_once "mysqlconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubayer's PHP Forum & Practice</title>
    <!-- Link to global styles and navbar CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

    <!-- Main Navigation Bar -->
    <div class="custom-padding">
        <nav>
            <div class="logo">
                <a href="index.php" style="color: white; text-decoration: none; font-weight: bold;">
                    💬 Jubayer's Forum
                </a>
            </div>

            <ul class="menu-area">
                <li><a href="index.php">Home</a></li>
                <li><a href="members.php">Members</a></li>
                
                <?php 
                // Step 3: Check if a user is currently logged in
                if (isset($_SESSION["username"])) { 
                    
                    // Retrieve logged-in user's database ID for the profile link
                    $current_user = mysqli_real_escape_string($conn, $_SESSION['username']);
                    $sql = "SELECT id FROM users WHERE username = '$current_user' LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    $logged_in_id = 0;

                    if ($result && mysqli_num_rows($result) > 0) {
                        $user_row = mysqli_fetch_assoc($result);
                        $logged_in_id = $user_row['id'];
                    }
                ?>
                    <!-- Navigation links visible ONLY to Authenticated Users -->
                    <li><a href="post.php">➕ Post Topic</a></li>
                    <li><a href="account.php">⚙️ My Account</a></li>
                    <li><a href="profile.php?id=<?php echo $logged_in_id; ?>">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                    <li><a href="index.php?action=logout" style="color: #ff7675;">🚪 Log Out</a></li>

                <?php } else { ?>
                    <!-- Navigation links visible ONLY to Guests (Not logged in) -->
                    <li><a href="register.php">📝 Register</a></li>
                    <li><a href="login.php">🔑 Login</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    
    <!-- Main Content Container Wrapper -->
    <div class="main-container" style="max-width: 900px; margin: 20px auto; padding: 0 15px;">