<?php
/**
 * ============================================================================
 * 📌 FILE NAME: profile.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Public User Profile Details View (CRUD - Read by ID)
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. HTTP GET Request Parameter Parsing ($_GET['id'], intval())
 * 2. Targeted SQL Querying with WHERE Clauses (SELECT * FROM users WHERE id = X)
 * 3. Handling Null/Empty Query Results (mysqli_num_rows($result) === 0)
 * 4. User-Specific Activity Queries (SELECT * FROM topics WHERE topics_creator = X)
 * 5. Sanitized Output Rendering (htmlspecialchars())
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to build a dynamic profile detail page that loads based on a URL ID.
 * - How to handle "User Not Found" errors gracefully.
 * - How to run secondary relational queries to show user activity history (topics created).
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used in social media profiles (Twitter/X, GitHub profiles, LinkedIn), forum author
 *   bios, and customer information cards in CRM software.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Type Casting): Always cast URL ID parameters to integers: `$user_id = intval($_GET['id']);`.
 *   This immediately neutralizes any string-based SQL injection payloads passed via the URL!
 * - 💡 Tip 2 (Graceful Error UI): Never leave a user on a blank screen when an ID is invalid;
 *   always show a user-friendly message and a return link.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqlconnect.php";

// Step 2: Validate ID Parameter
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("Location: members.php");
    exit();
}

$user_id = intval($_GET['id']);

// Step 3: Fetch User Data from Database
$sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $sql);

// Step 4: Include page header
require_once "header.php";

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $username    = htmlspecialchars($user['username']);
    $email       = htmlspecialchars($user['email']);
    $date        = htmlspecialchars($user['date']);
    $score       = htmlspecialchars($user['score'] ?? 0);
    $profile_pic = !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'images/users_pic.png';
?>

    <!-- Profile Card Header -->
    <div style="background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); margin-bottom: 25px; display: flex; align-items: center; gap: 25px;">
        <img src="<?php echo $profile_pic; ?>" alt="<?php echo $username; ?>" 
             style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 4px solid #dfe4ea;">
        
        <div>
            <h1 style="color: #2d3436; margin: 0 0 8px 0; font-size: 24px;"><?php echo $username; ?></h1>
            <p style="color: #636e72; margin: 0 0 10px 0; font-size: 14px;">
                📧 <?php echo $email; ?> | 📅 Member since: <?php echo $date; ?>
            </p>
            <span style="background: #e8f0fe; color: #1a73e8; padding: 5px 12px; border-radius: 12px; font-size: 13px; font-weight: bold;">
                ⭐ Activity Score: <?php echo $score; ?>
            </span>
        </div>
    </div>

    <!-- User's Created Topics Section -->
    <h3 style="color: #2d3436; margin-bottom: 15px;">📝 Topics Started by <?php echo $username; ?></h3>
    
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); overflow: hidden;">
        <?php
        $topics_sql = "SELECT * FROM topics WHERE topics_creator = '{$user['username']}' ORDER BY topics_id DESC";
        $topics_res = mysqli_query($conn, $topics_sql);

        if ($topics_res && mysqli_num_rows($topics_res) > 0) {
            while ($topic = mysqli_fetch_assoc($topics_res)) {
                $t_id   = htmlspecialchars($topic['topics_id']);
                $t_name = htmlspecialchars($topic['topics_name']);
                $t_date = htmlspecialchars($topic['date']);
                
                echo '<div style="padding: 14px 20px; border-bottom: 1px solid #f1f2f6; display: flex; justify-content: space-between; align-items: center;">
                        <a href="replies.php?topic=' . $t_id . '" style="color: #0984e3; text-decoration: none; font-weight: 600; font-size: 15px;">
                            📌 ' . $t_name . '
                        </a>
                        <span style="color: #a4b0be; font-size: 12px;">📅 ' . $t_date . '</span>
                      </div>';
            }
        } else {
            echo '<div style="padding: 25px; text-align: center; color: #747d8c;">
                    <p style="margin: 0; font-size: 14px;">No topics created by this user yet.</p>
                  </div>';
        }
        ?>
    </div>

<?php
} else {
    echo '<div style="background: #ffffff; padding: 40px; text-align: center; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">';
    echo '<h2 style="color: #d63031; margin-bottom: 10px;">⚠️ Member Not Found</h2>';
    echo '<p style="color: #636e72;">The requested member ID does not exist in the database.</p>';
    echo '<a href="members.php" style="display: inline-block; margin-top: 15px; color: #0984e3; font-weight: bold; text-decoration: none;">← Back to Members Directory</a>';
    echo '</div>';
}

// Step 5: Include Page Footer
require_once "footer.php";
?>