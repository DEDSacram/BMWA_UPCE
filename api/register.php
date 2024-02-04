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
            'message' => 'User already exists',
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
        'message' => 'User created successfully',
    ]);
}
$data = get_request_data();
createuser($data);










