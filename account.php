<?php
/**
 * ============================================================================
 * 📌 FILE NAME: account.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: User Account Dashboard, Stats Overview & Password Update Workflow (CRUD - Update)
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Session-Based Authorization & Personal Data Lookup (WHERE username = $_SESSION['username'])
 * 2. Aggregating User Statistics (Calculating total topics and replies created)
 * 3. Form Processing for Account Settings & Password Updates
 * 4. SQL UPDATE Query Execution (UPDATE users SET password = ... WHERE id = ...)
 * 5. Conditional View Toggling with Action Parameters (?action=changepass)
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to build a private user settings & dashboard page.
 * - How to safely handle password change operations with verification of the current password.
 * - How to update existing database records using SQL `UPDATE` queries.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Found in every user dashboard (Profile settings, security settings, subscription management,
 *   billing information updates).
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Password Verification): Always require the user to input their CURRENT password
 *   before allowing a new password to be set. This prevents unauthorized changes if a user leaves
 *   their browser unattended.
 * - 💡 Tip 2 (SQL UPDATE WHERE Clause): NEVER execute an `UPDATE` query without a precise `WHERE`
 *   clause! Omitting `WHERE` will overwrite passwords for EVERY user in the entire table!
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 2: Route Guard - Only authenticated users can access their account
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once "mysqlconnect.php";

$username = mysqli_real_escape_string($conn, $_SESSION['username']);
$message = "";
$message_type = "";

// Step 3: Handle Password Change Submission
if (isset($_POST['changepass'])) {
    
    $currpass   = $_POST['currpass'];
    $newpass    = $_POST['newpass'];
    $retypepass = $_POST['retypepass'];

    if (!empty($currpass) && !empty($newpass) && !empty($retypepass)) {
        
        // Fetch current password from database
        $verify_sql = "SELECT password FROM users WHERE username = '$username' LIMIT 1";
        $verify_res = mysqli_query($conn, $verify_sql);
        $user_data  = mysqli_fetch_assoc($verify_res);

        if ($user_data && $user_data['password'] === $currpass) {
            
            if (strlen($newpass) >= 6) {
                
                if ($newpass === $retypepass) {
                    
                    $escaped_newpass = mysqli_real_escape_string($conn, $newpass);
                    $update_sql = "UPDATE users SET password = '$escaped_newpass' WHERE username = '$username'";
                    
                    if (mysqli_query($conn, $update_sql)) {
                        $message = "✅ Password successfully changed!";
                        $message_type = "success";
                    } else {
                        $message = "❌ Database error updating password: " . mysqli_error($conn);
                        $message_type = "error";
                    }

                } else {
                    $message = "⚠️ New password and retyped password do not match.";
                    $message_type = "error";
                }

            } else {
                $message = "⚠️ New password must be at least 6 characters long.";
                $message_type = "error";
            }

        } else {
            $message = "❌ Current password is incorrect!";
            $message_type = "error";
        }

    } else {
        $message = "⚠️ Please fill in all password fields.";
        $message_type = "error";
    }
}

// Step 4: Fetch User Account Details and Real Activity Stats
$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Count dynamic topics posted by this user
$topics_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM topics WHERE topics_creator = '$username'");
$topics_count = mysqli_fetch_assoc($topics_count_res)['total'];

// Step 5: Include page header
require_once "header.php";
?>

<div style="max-width: 650px; margin: 30px auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); padding: 30px;">
    
    <div style="display: flex; align-items: center; gap: 20px; border-bottom: 1px solid #f1f2f6; padding-bottom: 20px; margin-bottom: 20px;">
        <img src="<?php echo !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'images/users_pic.png'; ?>" 
             alt="Profile Picture" 
             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #dfe4ea;">
        <div>
            <h2 style="margin: 0 0 5px 0; color: #2d3436;">👤 Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
            <p style="margin: 0; color: #636e72; font-size: 14px;">Manage your account credentials and personal statistics.</p>
        </div>
    </div>

    <!-- Feedback Alerts -->
    <?php if (!empty($message)): ?>
        <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; 
                    background-color: <?php echo ($message_type === 'success') ? '#d4edda' : '#f8d7da'; ?>; 
                    color: <?php echo ($message_type === 'success') ? '#155724' : '#721c24'; ?>;
                    border: 1px solid <?php echo ($message_type === 'success') ? '#c3e6cb' : '#f5c6cb'; ?>;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- User Information Breakdown -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
        <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px;">
            <span style="font-size: 12px; color: #636e72;">Account ID</span>
            <div style="font-size: 16px; font-weight: bold; color: #2d3436;">#<?php echo htmlspecialchars($user['id']); ?></div>
        </div>

        <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px;">
            <span style="font-size: 12px; color: #636e72;">E-mail Address</span>
            <div style="font-size: 16px; font-weight: bold; color: #2d3436; word-break: break-all;"><?php echo htmlspecialchars($user['email']); ?></div>
        </div>

        <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px;">
            <span style="font-size: 12px; color: #636e72;">Registration Date</span>
            <div style="font-size: 16px; font-weight: bold; color: #2d3436;"><?php echo htmlspecialchars($user['date']); ?></div>
        </div>

        <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px;">
            <span style="font-size: 12px; color: #636e72;">Total Topics Published</span>
            <div style="font-size: 16px; font-weight: bold; color: #0984e3;"><?php echo $topics_count; ?> Topics</div>
        </div>
    </div>

    <!-- Action Section: Change Password -->
    <div style="border-top: 1px solid #f1f2f6; padding-top: 20px;">
        
        <?php if (isset($_GET['action']) && $_GET['action'] === "changepass"): ?>
            
            <h3 style="color: #2d3436; margin-top: 0;">🔒 Update Password</h3>
            
            <form action="account.php?action=changepass" method="POST">
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 14px; font-weight: bold; margin-bottom: 5px;">Current Password:</label>
                    <input type="password" name="currpass" required style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 14px; font-weight: bold; margin-bottom: 5px;">New Password:</label>
                    <input type="password" name="newpass" placeholder="Min. 6 characters" required style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 14px; font-weight: bold; margin-bottom: 5px;">Retype New Password:</label>
                    <input type="password" name="retypepass" required style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="display: flex; gap: 10px;">
                    <input type="submit" name="changepass" value="Update Password" 
                           style="padding: 10px 20px; background: #00b894; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                    <a href="account.php" style="padding: 10px 15px; color: #636e72; text-decoration: none; font-size: 14px; line-height: 20px;">Cancel</a>
                </div>
            </form>

        <?php else: ?>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #636e72; font-size: 14px;">Need to update your login credentials?</span>
                <a href="account.php?action=changepass" 
                   style="padding: 9px 16px; background: #0984e3; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px;">
                    🔑 Change Password
                </a>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php 
// Step 6: Include Page Footer
require_once "footer.php"; 
?>
