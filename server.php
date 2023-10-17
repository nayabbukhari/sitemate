<?php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "sitemate";

$method = $_SERVER['REQUEST_METHOD'];
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($method == 'POST') {
    // Create a new issue
    $data = json_decode(file_get_contents('php://input'), true);
    $description = $data['description'];

    $sql = "INSERT INTO issues (description) VALUES ('$description')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Issue created successfully'));
    } else {
        echo json_encode(array('error' => 'Error creating issue: ' . $conn->error));
    }
} elseif ($method == 'GET') {
    // Read an issue
    $sql = "SELECT id, description FROM issues WHERE id = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(array('message' => 'No issue found'));
    }
} elseif ($method == 'PUT') {
    // Update an issue
    $data = json_decode(file_get_contents('php://input'), true);
    $description = $data['description'];

    $sql = "UPDATE issues SET description = '$description' WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Issue updated successfully'));
    } else {
        echo json_encode(array('error' => 'Error updating issue: ' . $conn->error));
    }
} elseif ($method == 'DELETE') {
    // Delete an issue
    $sql = "DELETE FROM issues WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Issue deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting issue: ' . $conn->error));
    }
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
}

$conn->close();
?>
