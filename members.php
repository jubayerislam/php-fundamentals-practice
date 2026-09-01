<?php
/**
 * ============================================================================
 * 📌 FILE NAME: members.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Community Member Directory, User List Query & Profile Navigation
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Database Collection Retrieval (SELECT * FROM users)
 * 2. Result Set Iteration with while ($row = mysqli_fetch_assoc($result))
 * 3. Dynamic URL Query Strings (<a href='profile.php?id=...'>)
 * 4. Safe Output Escaping (htmlspecialchars())
 * 5. Clean Grid Layout Rendering
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to query a full table collection and display items as interactive profile cards.
 * - How to pass unique identifiers (IDs) through URL query parameters for master-detail views.
 * - How to handle empty states when no records are returned.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Common in team directories, member rosters, customer lists in admin dashboards,
 *   and social networking user search results.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Master-Detail Pattern): Listing files (Master) pass an ID via `?id=X` to detail files
 *   (Detail) which fetch and display full data for that single record.
 * - 💡 Tip 2 (Pagination): In large real-world applications with thousands of users, always add
 *   SQL `LIMIT` and `OFFSET` (Pagination) so you don't load the entire database into memory at once!
 * - ⚠️ Watch Out: Don't display sensitive columns like passwords in directory views.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqlconnect.php";

// Step 2: Include page header
require_once "header.php";
?>

<div style="margin-bottom: 25px;">
    <h1 style="color: #2d3436; margin: 0; font-size: 24px;">👥 Community Members</h1>
    <p style="color: #636e72; margin: 5px 0 0 0; font-size: 14px;">Browse registered developers and forum participants.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px;">

<?php
// Step 3: Query all registered users from database
$sql = "SELECT id, username, email, profile_pic, date, score FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id          = htmlspecialchars($row['id']);
        $uname       = htmlspecialchars($row['username']);
        $email       = htmlspecialchars($row['email']);
        $date        = htmlspecialchars($row['date']);
        $score       = htmlspecialchars($row['score'] ?? 0);
        $profile_pic = !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : 'images/users_pic.png';
?>

    <div style="background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 3px 8px rgba(0,0,0,0.06); text-align: center; border: 1px solid #f1f2f6;">
        <img src="<?php echo $profile_pic; ?>" alt="User Avatar" 
             style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid #dfe4ea; margin-bottom: 12px;">
        
        <h3 style="margin: 0 0 5px 0; font-size: 18px;">
            <a href="profile.php?id=<?php echo $id; ?>" style="color: #2d3436; text-decoration: none; font-weight: bold;">
                <?php echo $uname; ?>
            </a>
        </h3>
        
        <p style="color: #636e72; font-size: 13px; margin: 0 0 10px 0;">
            📅 Joined: <?php echo $date; ?>
        </p>
        
        <span style="display: inline-block; background: #e8f0fe; color: #1a73e8; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 15px;">
            ⭐ Score: <?php echo $score; ?>
        </span>

        <div>
            <a href="profile.php?id=<?php echo $id; ?>" 
               style="display: inline-block; width: 80%; padding: 8px 0; background: #0984e3; color: white; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold;">
                View Profile
            </a>
        </div>
    </div>

<?php
    }

} else {
    echo '<div style="grid-column: 1 / -1; padding: 40px; text-align: center; background: #fff; border-radius: 8px; color: #747d8c;">
            <p style="font-size: 16px; margin: 0;">No members registered yet.</p>
          </div>';
}
?>

</div>

<?php 
// Step 4: Include Page Footer
require_once "footer.php"; 
?>
