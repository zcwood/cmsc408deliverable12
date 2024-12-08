<?php
// Validate inputs
if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Invalid request: Missing table or id.");
}

$table = $_GET['table'];
$id = $_GET['id'];

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

// Sanitize inputs
$table = $conn->real_escape_string($table);
$id = $conn->real_escape_string($id);

// Get the primary key of the table
$primaryKeyQuery = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
$primaryKeyResult = $conn->query($primaryKeyQuery);
if ($primaryKeyResult && $primaryKeyResult->num_rows > 0) {
    $primaryKeyRow = $primaryKeyResult->fetch_assoc();
    $primaryKey = $primaryKeyRow['Column_name'];
} else {
    die("Error: Unable to determine the primary key for table $table.");
}

// Execute the delete query
$sql = "DELETE FROM `$table` WHERE `$primaryKey` = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully.<br>";
    echo "<button onclick=\"window.location.href='/show-table.php?table=$table';\">Return to Table</button>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>

