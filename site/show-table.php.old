<?php
// Check if the table name is provided as a query parameter
if (!isset($_GET['table'])) {
    die("No table specified.");
}

$table_name = $_GET['table'];

// Database connection parameters
$servername = "mysql_db_2";
$username = "root";
$password = "root_password";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve the primary key of the specified table
$primaryKey = null;
$keyQuery = "SHOW KEYS FROM `$table_name` WHERE Key_name = 'PRIMARY'";
$keyResult = $conn->query($keyQuery);
if ($keyResult && $keyResult->num_rows > 0) {
    $keyRow = $keyResult->fetch_assoc();
    $primaryKey = $keyRow['Column_name'];
}

// Query to retrieve the contents of the specified table
$sql = "SELECT * FROM `$table_name`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<a href='/'>[home]</a><br/>";
    echo "<h1>Contents of table: $table_name</h1>";
    echo "<table border='1'>";
    
    // Output table headers
    $fields = $result->fetch_fields();
    echo "<tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name ?? '') . "</th>";
    }
    echo "<th>Actions</th>"; // Add a header for the action links
    echo "</tr>";

    // Output table rows with CRUD links
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
        }

        // Add CRUD links if the primary key exists
        if ($primaryKey && isset($row[$primaryKey])) {
    $primaryKeyValue = htmlspecialchars($row[$primaryKey]); // Prevent XSS
    echo "<td>
        <a href='/crud/update.php?table=$table_name&id=$primaryKeyValue'>Update</a>
        <a href='/crud/delete.php?table=$table_name&id=$primaryKeyValue'>Delete</a>
    </td>";
} else {
    echo "<td>No actions available</td>";
}

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found in table: $table_name";
}

$conn->close();
?>

