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

// Fetch the fields for the table to create the update form
$sql = "DESCRIBE `$table`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h1>Update record in $table</h1>";
    echo "<form method='post'>";

    // Loop through the fields to create input fields
    while ($row = $result->fetch_assoc()) {
        $column = $row['Field'];
        if ($column != $primaryKey) { // Skip the primary key column
            echo "<label for='$column'>$column: </label>";
            echo "<input type='text' name='$column' id='$column' required><br>";
        }
    }

    echo "<input type='submit' value='Update'>";
    echo "</form>";
} else {
    die("Error: Unable to fetch table fields.");
}

// If the form is submitted, process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the SET part of the UPDATE query dynamically
    $updateValues = [];
    foreach ($_POST as $column => $value) {
        $value = $conn->real_escape_string($value);
        $updateValues[] = "`$column` = '$value'";
    }
    $updateSql = "UPDATE `$table` SET " . implode(", ", $updateValues) . " WHERE `$primaryKey` = '$id'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Record updated successfully.<br>";
        echo "<button onclick=\"window.location.href='/show-table.php?table=$table';\">Return to Table</button>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

