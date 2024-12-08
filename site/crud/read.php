<?php
if (!isset($_POST['table'])) {
    die("No table specified.");
}

$table = $_POST['table'];
$servername = "mysql_db_2";
$username = "root";
$password = "root_password";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `$table`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Contents of table: $table</h1>";
    echo "<table border='1'>";
    $fields = $result->fetch_fields();
    echo "<tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name ?? '') . "</th>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>

