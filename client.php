<!DOCTYPE html>
<html>
<head>
    <title>REST API Client</title>
</head>
<body>
    <h1>REST API Client</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $description = $_POST['description'];
        $data = json_encode(array('description' => $description));

        $apiUrl = 'http://localhost/sitemate/sitemate/server.php'; // Replace with your server URL

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);

        if ($response === false) {
            echo "Error: " . curl_error($curl);
        } else {
            $result = json_decode($response, true);
            if (isset($result['message'])) {
                echo "Message: " . $result['message'];
            } else if (isset($result['error'])) {
                echo "Error: " . $result['error'];
            }
        }

        curl_close($curl);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $apiUrl = 'http://localhost/sitemate/sitemate/server.php'; // Replace with your server URL

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            echo "Error: " . curl_error($curl);
        } else {
            $result = json_decode($response, true);
            if (isset($result['message'])) {
                echo "Message: " . $result['message'];
            } else {
                $result = json_decode($response, true);
                if (isset($result['message'])) {
                    echo '<h2>Issues</h2>';
                    echo '<table>';
                    echo '<tr><th>Description</th><th>Action</th></tr>';
                    foreach ($result as $issue) {
                        echo '<tr>';
                        echo '<td>' . $issue['description'] . '</td>';
                        echo '<td><a href="client.php?action=edit&id=' . $issue['id'] . '">Edit</a> | <a href="client.php?action=delete&id=' . $issue['id'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                echo '</table>';
                }
            }
        }

        curl_close($curl);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'edit') {
        $id = $_GET['id'];

        // Fetch the issue by its ID and allow editing
        // You can use a similar cURL request to fetch the issue by ID

        // Example: $apiUrl = "http://localhost/your-project-folder/server.php?id=$id";
    }
    ?>

    <form method="post">
        <label for="description">Issue Description:</label>
        <input type="text" name="description" id="description" required>
        <button type="submit">Create Issue</button>
    </form>
</body>
</html>
