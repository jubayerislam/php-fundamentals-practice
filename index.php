<?php
/**
 * ============================================================================
 * 📌 FILE NAME: index.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Forum Home Page, Topic Feed, SQL JOIN Queries & Logout Handler
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Session Destruction & Logout Flow (session_destroy(), unset())
 * 2. SQL JOIN Operations (INNER/LEFT JOIN between `topics` and `users` tables)
 * 3. Loop Iteration & Result Fetching (while ($row = mysqli_fetch_assoc($result)))
 * 4. Dynamic URL Generation with Query Strings (replies.php?topic=ID, profile.php?id=ID)
 * 5. Conditional UI Gatekeeping (Checking if user is logged in before allowing actions)
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to perform relational queries using SQL `JOIN` to pull topic data alongside user IDs.
 * - How to iterate through a database result set and display each record dynamically in HTML.
 * - How to handle user logout requests safely using query parameters (`?action=logout`).
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used as the main landing dashboard / discussion feed in blogs, news portals, Reddit-like
 *   forums, and social communities.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (SQL JOIN): Instead of running a separate query for each topic to get author info (which
 *   creates the notorious N+1 query problem), use SQL `JOIN` to get everything in ONE efficient query!
 * - 💡 Tip 2 (Session Logout): When logging out, always call `session_destroy()`, `session_unset()`,
 *   and redirect with `header("Location: login.php")` followed by `exit()`.
 * - ⚠️ Watch Out: Always sanitize user-rendered data with `htmlspecialchars()` to prevent Stored XSS.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 2: Handle User Logout BEFORE sending any HTML output
if (isset($_GET['action']) && $_GET['action'] === "logout") {
    $_SESSION = array(); // Clear session array
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy(); // Destroy session
    header("Location: login.php");
    exit();
}

// Step 3: Include the page header
require_once "header.php";
?>

<div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #2d3436; margin: 0; font-size: 24px;">💬 Community Forum Topics</h1>
        <p style="color: #636e72; margin: 5px 0 0 0; font-size: 14px;">Browse discussions or start a new topic.</p>
    </div>
    
    <?php if (isset($_SESSION["username"])): ?>
        <a href="post.php" style="background: #00b894; color: white; padding: 10px 18px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            ➕ Post New Topic
        </a>
    <?php endif; ?>
</div>

<?php
// Step 4: Check if the user is authenticated
if (isset($_SESSION["username"])) {
?>

    <!-- Forum Topics Table Layout -->
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); overflow: hidden;">
        
        <!-- Table Header Row -->
        <div class="row" style="background: #f1f2f6; font-weight: bold; color: #2f3542; padding: 12px 15px; border-bottom: 2px solid #dfe4ea;">
            <div class="col" style="flex: 0.5;"># ID</div>
            <div class="col" style="flex: 3;">📌 Topic Name</div>
            <div class="col" style="flex: 1.5;">👤 Author</div>
            <div class="col" style="flex: 1.5;">📅 Date Posted</div>
        </div>

        <?php 
        // Step 5: Execute SQL JOIN to fetch topics and creator user ID simultaneously
        $sql = "SELECT topics.*, users.id AS user_id 
                FROM `topics` 
                LEFT JOIN `users` ON users.username = topics.topics_creator 
                ORDER BY topics.topics_id DESC";
                
        $result = mysqli_query($conn, $sql);

        // Step 6: Check if records exist and loop through them
        if ($result && mysqli_num_rows($result) > 0) {
            
            while ($row = mysqli_fetch_assoc($result)) {
                $id            = htmlspecialchars($row['topics_id']);
                $raw_name      = htmlspecialchars($row['topics_name']);
                $topic_link    = "<a href='replies.php?topic={$id}' style='color: #0984e3; text-decoration: none; font-weight: 600;'>{$raw_name}</a>";
                
                $creator_name  = htmlspecialchars($row['topics_creator']);
                $user_id       = !empty($row['user_id']) ? htmlspecialchars($row['user_id']) : '#';
                $creator_link  = "<a href='profile.php?id={$user_id}' style='color: #2d3436; text-decoration: none;'>👤 {$creator_name}</a>";
                
                $date          = htmlspecialchars($row['date']);

                echo '<div class="row" style="padding: 14px 15px; border-bottom: 1px solid #f1f2f6; display: flex; align-items: center;">
                        <div class="col" style="flex: 0.5; color: #a4b0be; font-weight: bold;">' . $id . '</div>
                        <div class="col" style="flex: 3;">' . $topic_link . '</div>
                        <div class="col" style="flex: 1.5;">' . $creator_link . '</div>
                        <div class="col" style="flex: 1.5; color: #747d8c; font-size: 13px;">' . $date . '</div>
                      </div>';
            }

        } else {
            echo '<div style="padding: 40px; text-align: center; color: #747d8c;">
                    <p style="font-size: 18px; margin: 0;">📭 No topics posted yet.</p>
                    <p style="font-size: 14px; margin-top: 5px;">Be the first one to create a topic!</p>
                  </div>';
        }
        ?>

    </div>

<?php 
} else { 
    // Guest message if not logged in
?>
    <div style="background: #ffffff; padding: 40px 20px; text-align: center; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
        <h2 style="color: #2d3436; margin-bottom: 10px;">👋 Welcome to Jubayer's PHP Forum</h2>
        <p style="color: #636e72; font-size: 15px; max-width: 500px; margin: 0 auto 20px auto;">
            You must be logged in to view topics, participate in discussions, and share your answers.
        </p>
        <div>
            <a href="login.php" style="display: inline-block; background: #0984e3; color: white; padding: 10px 22px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-right: 10px;">
                🔑 Login
            </a>
            <a href="register.php" style="display: inline-block; background: #00b894; color: white; padding: 10px 22px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                📝 Create Account
            </a>
        </div>
    </div>
<?php 
} 
?>

<?php 
// Step 7: Include Page Footer
require_once "footer.php"; 
?>
