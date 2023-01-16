<!-- 
PHP code is usually processed on a web server by a PHP interpreter implemented as a module, 
a daemon or as a Common Gateway Interface (CGI) executable. On a web server, 
the result of the interpreted and executed PHP code – which may be any type of data, 
such as generated HTML would form the whole or part of an HTTP response. 

This PHP file is for the user logout of the system.
-->

<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
header("Location: index.html");
?>