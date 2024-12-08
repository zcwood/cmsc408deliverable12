<?php
// Validate inputs
if (!isset($_GET['table'])) {
    die("Invalid request: Missing table.");
}

$table = $_GET['table'];

// Database connection parameters
$servername = "mysql_db_2";
$username = "root";
$password = "root_password";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$table = $conn->real_escape_string($table);

// Fetch the fields for the table to create the insert form
$sql = "DESCRIBE `$table`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h1>Create new record in $table</h1>";
    echo "<form method='post'>";

    // Loop through the fields to create input fields
    while ($row = $result->fetch_assoc()) {
        $column = $row['Field'];
        echo "<label for='$column'>$column: </label>";
        echo "<input type='text' name='$column' id='$column' required><br>";
    }

    echo "<input type='submit' value='Create'>";
    echo "</form>";
} else {
    die("Error: Unable to fetch table fields.");
}

// If the form is submitted, process the insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the column names and values dynamically
    $columns = [];
    $values = [];
    foreach ($_POST as $column => $value) {
        $columns[] = "`$column`";
        $values[] = "'" . $conn->real_escape_string($value) . "'";
    }
    $insertSql = "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";

    if ($conn->query($insertSql) === TRUE) {
        echo "New record created successfully.<br>";
        echo "<button onclick=\"window.location.href='/show-table.php?table=$table';\">Return to Table</button>";
    } else {
        echo "Error creating record: " . $conn->error;
    }
}

$conn->close();
?>

