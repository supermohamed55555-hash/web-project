<?php
function checkRateLimit() {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['first_attempt_time'] = time();
    }
    
    $timeElapsed = time() - $_SESSION['first_attempt_time'];
    
    // Reset after 15 minutes
    if ($timeElapsed > 900) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['first_attempt_time'] = time();
    }
    
    // Block after 5 attempts
    if ($_SESSION['login_attempts'] >= 5) {
        $minutesLeft = ceil((900 - $timeElapsed) / 60);
        return "Too many failed attempts. Please try again in {$minutesLeft} minute(s).";
    }
    
    return null;
}

function recordFailedAttempt() {
    $_SESSION['login_attempts']++;
}

function resetLoginAttempts() {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['first_attempt_time'] = time();
}
