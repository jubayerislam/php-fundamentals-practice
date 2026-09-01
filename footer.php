<?php
/**
 * ============================================================================
 * 📌 FILE NAME: footer.php
 * 👤 AUTHOR: Jubayer Islam
 * 🎯 PURPOSE: Modular Page Footer & HTML Document Closure
 * ============================================================================
 * 
 * 💡 PHP CONCEPTS COVERED:
 * 1. Modular Templating (Closing tags opened in header.php)
 * 2. Dynamic Date Output with date('Y')
 * 3. Consistent Page Layout & Branding
 * 
 * 📖 WHAT YOU WILL LEARN FROM THIS FILE:
 * - How to create a clean closure for pages included with header.php.
 * - Why dynamic dates (e.g., copyright year) prevent having to manually update your footer every new year.
 * 
 * 🏢 WHERE & WHY THIS IS USED IN REAL-WORLD PROJECTS:
 * - Used at the bottom of every template/view file to ensure proper DOM structure,
 *   scripts loading, and footer copyright notices.
 * 
 * 🚀 JUNIOR DEVELOPER LEARNING POINTS & PRO-TIPS:
 * - 💡 Tip 1: Always ensure that any HTML tags opened in `header.php` (e.g. `<body>`, `<div class="container">`)
 *   are properly closed in `footer.php`.
 * - 💡 Tip 2: Use PHP's `date('Y')` instead of hardcoded years like `2024` or `2026`.
 * ============================================================================
 */
?>
    </div> <!-- Closing .main-container from header.php -->

    <!-- Global Footer -->
    <footer style="margin-top: 50px; padding: 20px; text-align: center; border-top: 1px solid #e0e0e0; font-size: 14px; color: #636e72;">
        <p>
            🚀 <strong>Jubayer's PHP Learning & Practice Forum</strong> &copy; <?php echo date('Y'); ?>. 
            All Rights Reserved.
        </p>
        <p style="font-size: 12px; color: #b2bec3;">
            Designed for Junior PHP Developers to learn basic-to-practical PHP development.
        </p>
    </footer>

</body>
</html>
