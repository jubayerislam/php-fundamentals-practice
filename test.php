<?php
/**
 * ============================================================================
 * 📌 FILE NAME: test.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Junior Developer Practice Lab, PHP Syntax Sandbox & Cheat-Sheet
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Data Types & Variables (Strings, Integers, Arrays, Associative Arrays)
 * 2. Superglobals Overview ($_GET, $_POST, $_SESSION, $_SERVER)
 * 3. Essential String Functions (strlen(), trim(), strtolower(), substr())
 * 4. Database Query Inspection & Debugging Techniques
 * 5. Interactive Coding Mini-Challenges for Junior Developers
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to experiment and debug PHP scripts in an isolated playground.
 * - How essential built-in PHP functions work with live output.
 * - Practical hands-on challenges to test and solidify your PHP fundamentals.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Developers maintain scratch/test scripts during feature prototyping, testing API
 *   responses, or verifying algorithmic logic before integrating into the main codebase.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1 (var_dump vs print_r): Use `var_dump()` when you need to inspect both the value
 *   AND the exact data type of a variable. Use `print_r()` for quick, clean array viewing.
 * - 💡 Tip 2 (Error Reporting): In local development, enable full error reporting:
 *   `error_reporting(E_ALL); ini_set('display_errors', 1);`.
 * ============================================================================
 */

// Step 1: Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "mysqlconnect.php";
require_once "header.php";
?>

<div style="background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); margin-bottom: 25px;">
    
    <h1 style="color: #2d3436; margin-top: 0;">🧪 Junior Developer PHP Practice Lab</h1>
    <p style="color: #636e72; font-size: 15px;">
        Welcome to Jubayer's interactive PHP sandbox! Here you can review core language concepts, explore live code outputs, and test your skills with practice exercises.
    </p>

    <hr style="border: none; border-top: 1px solid #f1f2f6; margin: 20px 0;">

    <!-- Lab Section 1: Superglobals Overview -->
    <h3 style="color: #0984e3;">1️⃣ PHP Superglobals Live Inspection</h3>
    <p style="color: #636e72; font-size: 14px;">PHP provides special built-in global arrays available everywhere in your scripts:</p>
    
    <div style="background: #2d3436; color: #dfe6e9; padding: 15px; border-radius: 6px; font-family: monospace; font-size: 13px; overflow-x: auto;">
        <?php
        echo "<strong>📍 Current Server Software:</strong> " . htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Local CLI') . "<br>";
        echo "<strong>🌐 Request Method:</strong> " . htmlspecialchars($_SERVER['REQUEST_METHOD'] ?? 'GET') . "<br>";
        echo "<strong>👤 Active Session User:</strong> " . (isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '<em>Guest (Not Logged In)</em>') . "<br>";
        echo "<strong>📂 Script Name:</strong> " . htmlspecialchars($_SERVER['PHP_SELF'] ?? 'test.php') . "<br>";
        ?>
    </div>

    <!-- Lab Section 2: Essential String Functions -->
    <h3 style="color: #00b894; margin-top: 30px;">2️⃣ Common PHP String Manipulation Functions</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
        <thead>
            <tr style="background: #f1f2f6; text-align: left;">
                <th style="padding: 10px; border: 1px solid #dfe4ea;">Function</th>
                <th style="padding: 10px; border: 1px solid #dfe4ea;">Sample Input</th>
                <th style="padding: 10px; border: 1px solid #dfe4ea;">Live Output</th>
                <th style="padding: 10px; border: 1px solid #dfe4ea;">Purpose</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sample = "  Hello PHP Developer!  ";
            ?>
            <tr>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><code>strlen($str)</code></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">"<?php echo $sample; ?>"</td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><strong><?php echo strlen($sample); ?></strong></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">Counts total characters</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><code>trim($str)</code></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">"<?php echo $sample; ?>"</td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><strong>"<?php echo trim($sample); ?>"</strong></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">Strips leading/trailing whitespace</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><code>strtoupper($str)</code></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">"<?php echo trim($sample); ?>"</td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><strong><?php echo strtoupper(trim($sample)); ?></strong></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">Converts string to uppercase</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><code>htmlspecialchars()</code></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">&lt;script&gt;alert(1)&lt;/script&gt;</td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;"><strong><?php echo htmlspecialchars("<script>alert(1)</script>"); ?></strong></td>
                <td style="padding: 10px; border: 1px solid #dfe4ea;">Prevents XSS vulnerabilities</td>
            </tr>
        </tbody>
    </table>

    <!-- Lab Section 3: Hands-On Mini Challenges -->
    <h3 style="color: #6c5ce7; margin-top: 30px;">3️⃣ 💡 Junior Developer Mini-Challenges</h3>
    <div style="background: #f8f9fa; border-left: 4px solid #6c5ce7; padding: 15px 20px; border-radius: 4px;">
        <p style="margin: 0 0 10px 0; font-weight: bold; color: #2d3436;">Try completing these practical tasks in this repository:</p>
        <ol style="margin: 0; padding-left: 20px; color: #636e72; font-size: 14px; line-height: 1.8;">
            <li><strong>Challenge 1:</strong> Upgrade <code>register.php</code> to use <code>password_hash()</code> and <code>login.php</code> to use <code>password_verify()</code>.</li>
            <li><strong>Challenge 2:</strong> Add a column in <code>topics</code> table to track the total number of replies per topic and display it on <code>index.php</code>.</li>
            <li><strong>Challenge 3:</strong> Convert one raw <code>mysqli_query</code> into a Prepared Statement using <code>mysqli_prepare()</code> and <code>mysqli_stmt_bind_param()</code>.</li>
        </ol>
    </div>

</div>

<?php 
// Step 4: Include Page Footer
require_once "footer.php"; 
?>