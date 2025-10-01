<?php
// Simple SQLite config + helper functions
$DB_PATH = __DIR__ . '/database.db';

function db() {
    static $pdo = null;
    global $DB_PATH;
    if ($pdo === null) {
        $needInit = !file_exists($DB_PATH);
        $pdo = new PDO('sqlite:' . $DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($needInit) init_db($pdo);
    }
    return $pdo;
}

function init_db($pdo) {
    $pdo->exec("
        CREATE TABLE users(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            password TEXT,      -- intentionally weak (MD5)
            role TEXT
        );
        CREATE TABLE notes(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            body TEXT
        );
    ");
    // Seed: admin / student (MD5 hashes for demo)
    $pdo->prepare("INSERT INTO users(username,password,role) VALUES
        ('admin',  '21232f297a57a5a743894a0e4a801fc3','admin'), -- 'admin'
        ('student','ee11cbb19052e40b07aac0ca060c23ee','user')   -- 'test'
    ")->execute();

    $pdo->prepare("INSERT INTO notes(body) VALUES
        ('Welcome to Shelly School. This 404 page is being redesigned…'),
        ('Reminder: Do not expose debug parameters in production!')
    ")->execute();
}

function is_logged_in() { return isset($_COOKIE['user']); }
function current_user()  { return $_COOKIE['user'] ?? null; }
function current_role()  { return $_COOKIE['role'] ?? 'guest'; }

// Flags (normally hidden; shown only when vulns are successfully exploited)
define('FLAG_SQLI',   'THM{SQLI_WIN_9f1}');
define('FLAG_XSS',    'THM{XSS_GLINT_28b}');
define('FLAG_UPLOAD', 'THM{UPLOAD_PWN_4c2}');
define('FLAG_IDOR',   'THM{IDOR_KEYS_77e}');
