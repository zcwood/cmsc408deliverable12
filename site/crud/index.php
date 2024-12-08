<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Interface</title>
</head>
<body>
    <h1>CRUD Operations</h1>
    
    <h2>Create</h2>
    <form method="POST" action="create.php">
        <label>Table:</label>
        <input type="text" name="table" required><br>
        <label>Columns (comma-separated):</label>
        <input type="text" name="columns" required><br>
        <label>Values (comma-separated):</label>
        <input type="text" name="values" required><br>
        <button type="submit">Create</button>
    </form>
    
    <h2>Read</h2>
    <form method="POST" action="read.php">
        <label>Table:</label>
        <input type="text" name="table" required><br>
        <button type="submit">Read</button>
    </form>
    
    <h2>Update</h2>
    <form method="POST" action="update.php">
        <label>Table:</label>
        <input type="text" name="table" required><br>
        <label>Set Clause:</label>
        <input type="text" name="set" required><br>
        <label>Where Clause:</label>
        <input type="text" name="where" required><br>
        <button type="submit">Update</button>
    </form>
    
    <h2>Delete</h2>
    <form method="POST" action="delete.php">
        <label>Table:</label>
        <input type="text" name="table" required><br>
        <label>Where Clause:</label>
        <input type="text" name="where" required><br>
        <button type="submit">Delete</button>
    </form>
</body>
</html>

