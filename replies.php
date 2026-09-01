<?php
/**
 * ============================================================================
 * 📌 FILE NAME: replies.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Topic Discussion Thread, Dynamic GET Routing & Submitting Answers
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. HTTP GET Query Parameters ($_GET['topic'], intval() validation)
 * 2. Relational Database Concepts (1-to-Many Relationship: 1 Topic has Many Answers)
 * 3. Form Processing with Hidden Inputs (<input type="hidden" name="topic">)
 * 4. Text Validation & String Sanitization (htmlspecialchars(), mysqli_real_escape_string())
 * 5. Data Rendering & HTML Tables (while ($row = mysqli_fetch_assoc($result)))
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to build dynamic, interactive thread pages that load content based on URL query IDs.
 * - How to link child records (`answer`) to parent records (`topics`) using foreign keys.
 * - How to pass parent IDs silently in forms using hidden input fields.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Essential in comment sections (YouTube, Reddit), blog post comments, support ticket replies,
 *   and product reviews on e-commerce sites (Amazon).
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Parameter Sanitization): Always validate `$_GET` IDs using `intval()` or `filter_var()`
 *   to ensure only integers are processed, preventing injection attempts.
 * - 💡 Tip 2 (Hidden Form Fields): Use `<input type="hidden" ...>` when you need the form submission
 *   to know which parent entity it belongs to without asking the user to re-enter it.
 * - ⚠️ Watch Out: Always check if the parent topic actually exists in the database before accepting replies.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqlconnect.php";

// Step 2: Validate the incoming `topic` GET parameter
if (!isset($_GET['topic']) || intval($_GET['topic']) <= 0) {
    header("Location: index.php");
    exit();
}

$topic_id = intval($_GET['topic']);
$error_message = "";
$success_message = "";

// Step 3: Handle Reply Submission
if (isset($_POST['submit'])) {
    
    // Check if user is logged in before allowing reply
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $reply_ans = isset($_POST['reply_ans']) ? trim(mysqli_real_escape_string($conn, $_POST['reply_ans'])) : '';
    $post_topic_id = intval($_POST['topic']);
    $date = date("Y-m-d");

    // Validation: Check if answer is provided
    if (!empty($reply_ans)) {
        
        $len = strlen($reply_ans);
        
        // Validation: Length constraint (Between 10 and 1000 characters)
        if ($len >= 10 && $len <= 1000) {
            
            $sql_insert = "INSERT INTO answer (`topic_answer`, `date`, `topics_id`) 
                           VALUES ('$reply_ans', '$date', '$post_topic_id')";
            
            if (mysqli_query($conn, $sql_insert)) {
                $success_message = "✅ Your reply has been posted successfully!";
            } else {
                $error_message = "❌ Database Error: Could not post reply. " . mysqli_error($conn);
            }

        } else {
            $error_message = "⚠️ Reply must be between 10 and 1000 characters long (Current length: $len).";
        }

    } else {
        $error_message = "⚠️ Please write an answer before submitting.";
    }
}

// Step 4: Include page header
require_once "header.php";

// Step 5: Fetch Topic Details
$topic_query = "SELECT * FROM topics WHERE topics_id = '$topic_id' LIMIT 1";
$topic_result = mysqli_query($conn, $topic_query);

if (!$topic_result || mysqli_num_rows($topic_result) === 0) {
    echo '<div style="padding: 30px; text-align: center; background: #fff; border-radius: 8px;">
            <h3>⚠️ Topic not found!</h3>
            <p><a href="index.php">Return to Home</a></p>
          </div>';
    require_once "footer.php";
    exit();
}

$topic_data = mysqli_fetch_assoc($topic_result);
?>

<!-- Topic Title Banner -->
<div style="background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); margin-bottom: 25px;">
    <div style="font-size: 13px; color: #747d8c; margin-bottom: 5px;">
        <a href="index.php" style="color: #0984e3; text-decoration: none;">Home</a> &raquo; Topic #<?php echo $topic_id; ?>
    </div>
    <h1 style="color: #2f3542; margin: 0 0 10px 0; font-size: 22px;">
        📌 <?php echo htmlspecialchars($topic_data['topics_name']); ?>
    </h1>
    <div style="font-size: 13px; color: #747d8c;">
        Posted by: <strong><?php echo htmlspecialchars($topic_data['topics_creator']); ?></strong> on 
        <span>📅 <?php echo htmlspecialchars($topic_data['date']); ?></span>
    </div>
</div>

<!-- Feedback Alerts -->
<?php if (!empty($success_message)): ?>
    <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<!-- Reply Submission Section -->
<?php if (isset($_SESSION["username"])): ?>
    
    <div style="background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: #2d3436; font-size: 17px;">✍️ Leave a Reply</h3>
        <form action="replies.php?topic=<?php echo $topic_id; ?>" method="POST">
            <!-- Hidden field passing the parent topic ID -->
            <input type="hidden" name="topic" value="<?php echo $topic_id; ?>">
            
            <textarea name="reply_ans" rows="5" placeholder="Share your thoughts or answer here..." required
                      style="width: 100%; padding: 12px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; resize: vertical;"></textarea>
            
            <div style="margin-top: 10px; text-align: right;">
                <input type="submit" name="submit" value="Submit Reply" 
                       style="padding: 10px 20px; background: #0984e3; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
            </div>
        </form>
    </div>

<?php else: ?>
    
    <div style="background: #f1f2f6; padding: 15px; border-radius: 6px; text-align: center; margin-bottom: 25px;">
        <p style="margin: 0; color: #57606f;">
            🔒 You must be <a href="login.php" style="color: #0984e3; font-weight: bold;">logged in</a> to post a reply.
        </p>
    </div>

<?php endif; ?>

<!-- Existing Answers / Discussion Feed -->
<h3 style="color: #2d3436; margin-bottom: 15px;">💬 Answers & Discussion</h3>

<div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); overflow: hidden;">
    
    <?php 
    // Step 6: Query all replies associated with this topic ID
    $answers_sql = "SELECT * FROM answer WHERE topics_id = '$topic_id' ORDER BY replies_id ASC";
    $answers_res = mysqli_query($conn, $answers_sql);

    if ($answers_res && mysqli_num_rows($answers_res) > 0) {
        
        $counter = 1;
        while ($answer = mysqli_fetch_assoc($answers_res)) {
            $ans_id   = htmlspecialchars($answer['replies_id']);
            $ans_body = nl2br(htmlspecialchars($answer['topic_answer']));
            $ans_date = htmlspecialchars($answer['date']);
            
            echo '<div style="padding: 18px 20px; border-bottom: 1px solid #f1f2f6;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px; color: #a4b0be;">
                        <span><strong># ' . $counter . '</strong> (Reply ID: ' . $ans_id . ')</span>
                        <span>📅 ' . $ans_date . '</span>
                    </div>
                    <div style="color: #2f3542; font-size: 15px; line-height: 1.6;">' . $ans_body . '</div>
                  </div>';
            $counter++;
        }

    } else {
        echo '<div style="padding: 30px; text-align: center; color: #747d8c;">
                <p style="margin: 0;">📭 No replies yet for this topic.</p>
                <p style="font-size: 13px; margin-top: 5px;">Be the first to share your answer above!</p>
              </div>';
    }
    ?>

</div>

<?php 
// Step 7: Include Page Footer
require_once "footer.php"; 
?>
