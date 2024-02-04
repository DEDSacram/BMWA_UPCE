<?php
include 'db.php';
include 'endpoint.php';
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

function createuser($data) {
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "SELECT COUNT(*) FROM Users WHERE Email = :email";
    $params = array(':email' => $email);

    $db = new Database();
    $stmt = $db->query($sql, $params);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        send_response([
            'status' => 0,
            'message' => 'Uživatel již existuje',
        ]);
        $db->close();
        return;
    }

    $sql = "INSERT INTO Users (Email, Password) VALUES (:email, :password)";
    $params = array(':email' => $email, ':password' => $password);
    $stmt = $db->query($sql, $params);
    $db->close();
    send_response([
        'status' => 1,
        'message' => 'Uživatel úspěšně vytvořen',
    ]);
}

function loginuser($data) {
    $email = $data['email'];
    $password = $data['password'];

    $sql = "SELECT * FROM Users WHERE Email = :email";
    $params = array(':email' => $email);

    $db = new Database();
    $stmt = $db->query($sql, $params);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['Password'])) {
        send_response([
            'status' => 0,
            'message' => 'Neplatné přihlašovací údaje',
        ]);
        $db->close();
        return;
    }


    // if ($data['remember']) { // If the user checked "Remember Me"
    //     $token = bin2hex(random_bytes(16)); // Generate a random token
    //     $hashedToken = hash('sha256', $token); // Hash the token

    //     // Store the hashed token and user ID in your database
    //     // Replace this with your actual database code
    //     $timestamp = time() + 60 * 60 * 24 * 30;
    //     $datetime = date('Y-m-d H:i:s', $timestamp);

    //     $sql = "SELECT * FROM Users WHERE Email = :email";
    //     $db->query('INSERT INTO Users (Cookie, ExpiryTime) VALUES (?, ?) WHERE ID = ?', [$hashedToken, $datetime, $user['UserID']]);

    //     // Set a cookie in the user's browser containing the original token and user ID
    //     // The cookie expires in 30 days
    //     setcookie('rememberme', $user['ID'] . ':' . $token,  $timestamp);
    // }

    

    session_set_cookie_params([
        'samesite' => 'Lax', // or 'Strict' or 'None'
    ]);
    session_start();
    $_SESSION['user'] = $user['Email'];
    send_response([
        'status' => 1,
        'message' => 'Přihlášení úspěšné',
    ]);
    $db->close();
}


$data = get_request_data();
switch ($data['action']) {
    case 'login':
        loginuser($data);
        break;
    case 'register':
        createuser($data);
        break;
    default:
        send_response([
            'status' => 0,
            'message' => 'Neplatná akce',
        ]);
}
createuser($data);










