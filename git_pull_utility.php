<?php
/**
 * Git Pull Utility
 * This script runs 'git pull' from the browser.
 */

echo "<h2>Git Pull Status:</h2>";
echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px; border: 1px solid #ddd;'>";

// 1. Mark directory as safe to fix 'dubious ownership' error
$repoPath = '/Applications/XAMPP/xamppfiles/htdocs/web-project-main';
shell_exec("git config --global --add safe.directory $repoPath 2>&1");

// 2. Run the git pull command
$output = shell_exec("git pull origin main 2>&1");

if ($output) {
    echo htmlspecialchars($output);
} else {
    echo "No output from command. Make sure git is installed and accessible by the web server.";
}

echo "</pre>";
echo "<br><a href='index.php'>Back to Home</a>";
?>
