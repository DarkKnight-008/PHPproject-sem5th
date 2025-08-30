<?php
// Configuration file for iNotes CRUD application
// Railway.app deployment ready with environment variables

// Database configuration - Railway will provide these via environment variables
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'inotes');

// Application settings
define('APP_NAME', 'iNotes CRUD');
define('APP_VERSION', '1.0.0');

// Error reporting (set to false in production)
define('DEBUG_MODE', $_ENV['DEBUG_MODE'] ?? 'false');

// Timezone
date_default_timezone_set('UTC');

// Session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);

// Railway specific settings
if (isset($_ENV['RAILWAY_ENVIRONMENT'])) {
    // We're on Railway
    define('IS_RAILWAY', true);
    define('BASE_URL', $_ENV['RAILWAY_PUBLIC_DOMAIN'] ?? '');
} else {
    define('IS_RAILWAY', false);
    define('BASE_URL', '');
}
?>
