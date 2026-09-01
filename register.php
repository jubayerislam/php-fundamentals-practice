<?php
/**
 * ============================================================================
 * 📌 FILE NAME: register.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: User Registration System, Form Processing & Input Validation
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. HTTP POST Method Handling (isset($_POST['submit']), $_POST['uname'])
 * 2. Form Input Validation & String Length (strlen(), empty())
 * 3. Conditional Logic & Password Matching ($password == $confirmpwd)
 * 4. SQL INSERT Query Execution (mysqli_query(), mysqli_real_escape_string())
 * 5. Date Formatting (date("Y-m-d"))
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to receive and validate submitted form data safely.
 * - How to check if passwords match and satisfy length requirements.
 * - How to insert new user records into a MySQL database table.
 * - How to provide clear feedback messages (success or error) to the user.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Every membership website, SaaS platform, and social network uses a registration
 *   flow to onboard new users and create their digital profiles.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (Logical Operator Trap): Be careful with `&&` (AND) vs `||` (OR). When validating
 *   a range (e.g. between 5 and 25 characters), you MUST use `&&`:
 *   `strlen($username) >= 5 && strlen($username) <= 25`. Using `||` causes unintended passes!
 * - 💡 Tip 2 (Password Hashing): In production code, NEVER store plain text passwords!
 *   Always use `password_hash($password, PASSWORD_BCRYPT)` and `password_verify()`.
 * - 💡 Tip 3 (Duplicate Check): Always verify if the username or email already exists before inserting.
 * ============================================================================
 */

// Step 1: Start session and initialize message variables
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqlconnect.php";

$message = "";
$message_type = ""; // 'success' or 'error'

// Step 2: Check if the user submitted the registration form
if (isset($_POST['submit'])) {

    // Sanitize and capture input values from $_POST
    $username   = trim(mysqli_real_escape_string($conn, $_POST['uname']));
    $email      = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password   = $_POST['pwd'];
    $confirmpwd = $_POST['confirmpwd'];
    $date       = date("Y-m-d"); // Standard 4-digit year format (YYYY-MM-DD)

    // Validation Step 1: Check if any required field is empty
    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirmpwd)) {

        // Validation Step 2: Validate username length (5 to 25 chars) and password length (min 6 chars)
        if (strlen($username) >= 5 && strlen($username) <= 25) {
            
            if (strlen($password) >= 6) {
                
                // Validation Step 3: Check if both passwords match
                if ($password === $confirmpwd) {

                    // Validation Step 4: Check if username or email is already registered
                    $check_sql = "SELECT id FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
                    $check_res = mysqli_query($conn, $check_sql);

                    if (mysqli_num_rows($check_res) > 0) {
                        $message = "⚠️ Username or Email already exists! Please choose another.";
                        $message_type = "error";
                    } else {
                        // Prepare insertion query (Basic approach matching Jubayer's structure)
                        // Note for Junior Devs: In advanced code, use password_hash($password, PASSWORD_DEFAULT)
                        $sql = "INSERT INTO `users` (`username`, `email`, `password`, `date`)
                                VALUES ('$username', '$email', '$password', '$date')";

                        if (mysqli_query($conn, $sql)) {
                            $message = "✅ Registration successful! <a href='login.php' style='color:#0984e3; font-weight:bold;'>Click here to Login</a>";
                            $message_type = "success";
                        } else {
                            $message = "❌ Registration failed: " . mysqli_error($conn);
                            $message_type = "error";
                        }
                    }

                } else {
                    $message = "⚠️ Passwords do not match!";
                    $message_type = "error";
                }

            } else {
                $message = "⚠️ Password must be at least 6 characters long.";
                $message_type = "error";
            }

        } else {
            $message = "⚠️ Username must be between 5 and 25 characters.";
            $message_type = "error";
        }

    } else {
        $message = "⚠️ Please fill in all the required fields.";
        $message_type = "error";
    }
}

// Step 3: Include Page Header
require_once "header.php";
?>

<div style="max-width: 450px; margin: 30px auto; padding: 25px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
    
    <h2 style="text-align: center; color: #2d3436; margin-bottom: 20px;">📝 Create an Account</h2>

    <!-- Display Feedback Message if any -->
    <?php if (!empty($message)): ?>
        <div style="padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 14px; 
                    background-color: <?php echo ($message_type === 'success') ? '#d4edda' : '#f8d7da'; ?>; 
                    color: <?php echo ($message_type === 'success') ? '#155724' : '#721c24'; ?>;
                    border: 1px solid <?php echo ($message_type === 'success') ? '#c3e6cb' : '#f5c6cb'; ?>;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="register.php" method="POST">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">Username:</label>
            <input type="text" name="uname" value="<?php echo isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : ''; ?>" 
                   placeholder="e.g. jubayer_dev" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            <small style="color: #636e72;">5 to 25 characters</small>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">E-mail:</label>
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                   placeholder="e.g. user@example.com" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">Password:</label>
            <input type="password" name="pwd" placeholder="At least 6 characters" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #2d3436;">Confirm Password:</label>
            <input type="password" name="confirmpwd" placeholder="Re-enter password" required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <input type="submit" name="submit" value="Register Now" 
               style="width: 100%; padding: 12px; background: #00b894; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
        
        <p style="text-align: center; margin-top: 15px; color: #636e72;">
            Already have an account? <a href="login.php" style="color: #0984e3; text-decoration: none; font-weight: bold;">Login here</a>
        </p>

    </form>
</div>

<?php 
// Step 4: Include Page Footer
require_once "footer.php"; 
?>