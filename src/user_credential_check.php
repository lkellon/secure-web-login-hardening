<?php

declare(strict_types=1);

session_start();

/*
 * Secure Web Login Hardening Demo
 *
 * Portfolio adaptation of an academic Network Security project.
 * Demonstrates POST authentication, prepared statements,
 * password verification, session handling, and safer error responses.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$userId = trim($_POST['userId'] ?? '');
$password = $_POST['password'] ?? '';

if ($userId === '' || $password === '') {
    http_response_code(400);
    exit('Invalid login request.');
}

/*
 * Database settings are read from environment variables
 * so that credentials are not stored in source code.
 */

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'example_db';
$dbUser = getenv('DB_USER') ?: 'app_user';
$dbPassword = getenv('DB_PASSWORD');

if ($dbPassword === false || $dbPassword === '') {
    http_response_code(500);
    exit('Server configuration error.');
}

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {

    $pdo = new PDO(
        $dsn,
        $dbUser,
        $dbPassword,
        $options
    );

    /*
     * Prepared statements keep user-controlled input
     * separate from the SQL query structure.
     */

    $stmt = $pdo->prepare(
        'SELECT id, password_hash
         FROM users
         WHERE id = :userId
         LIMIT 1'
    );

    $stmt->execute([
        'userId' => $userId
    ]);

    $user = $stmt->fetch();

    /*
     * Verify the submitted password against
     * the stored password hash.
     */

    if (
        $user &&
        password_verify(
            $password,
            $user['password_hash']
        )
    ) {

        /*
         * Regenerate the session ID after authentication
         * before storing authenticated user information.
         */

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];

        echo 'Login successful.';

    } else {

        /*
         * Use a generic failure message rather than revealing
         * whether the username or password was incorrect.
         */

        http_response_code(401);

        echo 'Invalid user ID or password.';
    }

} catch (PDOException $e) {

    /*
     * Do not expose database exception details to the user.
     */

    http_response_code(500);

    echo 'A server error occurred.';
}

?>
