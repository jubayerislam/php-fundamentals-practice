<?php
/**
 * ============================================================================
 * 📌 FILE NAME: post.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Creating & Publishing New Forum Discussion Topics (CRUD - Create)
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Authentication & Route Guarding (Checking if user is logged in before rendering)
 * 2. Form Input Handling with $_POST Superglobal
 * 3. Validation Rules with strlen() (Between 10 and 70 characters)
 * 4. SQL INSERT Queries into the `topics` table
 * 5. Clean Redirection (header("Location: index.php"))
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to build a secure content creation form in PHP.
 * - How to associate a newly created record with the currently logged-in user (`$_SESSION['username']`).
 * - How to enforce content constraints to ensure data quality in a forum.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used in CMS platforms (creating blog posts), discussion boards (starting threads),
 *   issue trackers, and social feeds.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Authentication Guard): Always protect form submission endpoints so unauthenticated
 *   users cannot post data by simply sending a POST request to your URL.
 * - 💡 Tip 2 (Date Consistency): Standardize all dates using `date("Y-m-d")` across your entire
 *   codebase to make sorting and querying straightforward in MySQL.
 * - ⚠️ Watch Out: Don't use `@` error suppression on `$_POST` variables; use `isset()` or `empty()` instead.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 2: Route Guard - Ensure only logged-in users can access this page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once "mysqlconnect.php";

$error_message = "";

// Step 3: Handle Form Submission
if (isset($_POST['submit'])) {
    
    // Sanitize topic name input
    $topic_name = isset($_POST['topic_name']) ? trim(mysqli_real_escape_string($conn, $_POST['topic_name'])) : '';
    $creator    = mysqli_real_escape_string($conn, $_SESSION['username']);
    $date       = date("Y-m-d");

    // Validation: Check if field is not empty
    if (!empty($topic_name)) {
        
        $len = strlen($topic_name);
        
        // Validation: Length constraint (Between 10 and 70 characters)
        if ($len >= 10 && $len <= 70) {
            
            $sql = "INSERT INTO topics (`topics_name`, `topics_creator`, `date`) 
                    VALUES ('$topic_name', '$creator', '$date')";

            if (mysqli_query($conn, $sql)) {
                // Success: Redirect back to home topic feed
                header("Location: index.php");
                exit();
            } else {
                $error_message = "❌ Database Error: Could not publish topic. " . mysqli_error($conn);
            }

        } else {
            $error_message = "⚠️ Topic title must be between 10 and 70 characters long (Current length: $len).";
        }

    } else {
        $error_message = "⚠️ Please enter a topic title before submitting.";
    }
}

// Step 4: Include page header
require_once "header.php";
?>

<div style="max-width: 600px; margin: 30px auto; padding: 25px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
    
    <div style="border-bottom: 1px solid #dfe4ea; padding-bottom: 15px; margin-bottom: 20px;">
        <h2 style="color: #2d3436; margin: 0 0 5px 0;">✍️ Create a New Discussion Topic</h2>
        <p style="color: #636e72; margin: 0; font-size: 14px;">Share a question, concept, or discussion with the community.</p>
    </div>

    <!-- Display Error Alert if validation fails -->
    <?php if (!empty($error_message)): ?>
        <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Topic Creation Form -->
    <form action="post.php" method="POST">
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #2d3436;">
                Topic Title:
            </label>
            <input type="text" name="topic_name" 
                   value="<?php echo isset($_POST['topic_name']) ? htmlspecialchars($_POST['topic_name']) : ''; ?>" 
                   placeholder="e.g. How does PHP session_start() work internally?" 
                   required
                   style="width: 100%; padding: 12px; font-size: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            <small style="color: #636e72; display: block; margin-top: 5px;">
                Must be between 10 and 70 characters.
            </small>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" style="color: #636e72; text-decoration: none; font-size: 14px;">
                ← Cancel & Return Home
            </a>
            <input type="submit" name="submit" value="Publish Topic" 
                   style="padding: 12px 25px; background: #00b894; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        </div>

    </form>

</div>

<?php 
// Step 5: Include Page Footer
require_once "footer.php"; 
?>