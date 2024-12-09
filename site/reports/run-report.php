<?php
if (!isset($_GET['report'])) {
    die("No report specified.");
}

$report = intval($_GET['report']); // Ensure the report ID is an integer

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

// Example SQL queries for each report
$queries = [
    1 => "SELECT NPC.* 
          FROM NPC 
          INNER JOIN VIDEO_GAME ON NPC.game_id = VIDEO_GAME.game_id 
          WHERE VIDEO_GAME.game_id = 1;",
    
    2 => "SELECT SPRITE_ARTIST.Username 
          FROM SPRITE_ARTIST 
          INNER JOIN VIDEO_GAME ON SPRITE_ARTIST.SPRITE_ARTIST_id = VIDEO_GAME.SPRITE_ARTIST_id 
          WHERE VIDEO_GAME.game_id = 2;",
    
    3 => "SELECT VIDEO_GAME.title 
          FROM SOUND_DESIGNER 
          INNER JOIN VIDEO_GAME ON SOUND_DESIGNER.SOUND_DESIGNER_id = VIDEO_GAME.SOUND_DESIGNER_id 
          WHERE SOUND_DESIGNER.SOUND_DESIGNER_id = 5;",
    
    4 => "SELECT * 
          FROM NPC 
          WHERE spawns_during_day = TRUE AND biome = 'Forest';",
    
    5 => "SELECT PROJECTILE.Projectile_Name 
          FROM PROJECTILE 
          INNER JOIN NPC ON NPC.Projectile_use_ID = PROJECTILE.PROJECTILE_id 
          WHERE NPC.NPC_id = 3;",
    
    6 => "SELECT NPC.* 
          FROM NPC 
          INNER JOIN ITEM_DROPS ON NPC.ITEM_DROPS_ID = ITEM_DROPS.ITEM_id 
          WHERE ITEM_DROPS.drop_chance > 50;",
    
    7 => "SELECT NPC.* 
          FROM NPC 
          INNER JOIN VIDEO_GAME ON NPC.game_id = VIDEO_GAME.game_id 
          WHERE NPC.is_boss = TRUE AND VIDEO_GAME.game_id = 1;",
    
    8 => "SELECT SOUND.Sound_Name 
          FROM SOUND 
          INNER JOIN NPC ON NPC.SOUND_ID = SOUND.SOUND_ID 
          WHERE NPC.NPC_id = 7;",
    
    9 => "SELECT SPRITE_ARTIST.Username 
          FROM SPRITE_ARTIST 
          INNER JOIN VIDEO_GAME ON SPRITE_ARTIST.SPRITE_ARTIST_id = VIDEO_GAME.SPRITE_ARTIST_id 
          GROUP BY SPRITE_ARTIST.SPRITE_ARTIST_id 
          HAVING COUNT(VIDEO_GAME.game_id) > 5;",
    
    10 => "SELECT * 
           FROM NPC 
           WHERE SPRITE_ID = 10;",
    
    11 => "SELECT Projectile_Name, velocity 
           FROM PROJECTILE 
           ORDER BY velocity DESC 
           LIMIT 5;",
    
    12 => "SELECT * 
           FROM NPC 
           WHERE spawns_at_night = TRUE AND aggro_range > 20;",
    
    13 => "SELECT * 
           FROM NPC 
           WHERE spawns_on_hardcore_diff = TRUE 
           AND spawns_on_easy_diff = FALSE 
           AND spawns_on_mediumcore_diff = FALSE;",
    
    14 => "SELECT VIDEO_GAME.title 
           FROM GAME_DEVELOPER 
           INNER JOIN VIDEO_GAME ON GAME_DEVELOPER.GAME_DEV_id = VIDEO_GAME.GAME_DEV_id 
           WHERE GAME_DEVELOPER.GAME_DEV_id = 4;",
    
    15 => "SELECT * 
           FROM NPC 
           WHERE is_miniboss = TRUE AND defense > 100;",
    
    16 => "SELECT biome, AVG(spawn_chance) AS avg_spawn_chance 
           FROM NPC 
           GROUP BY biome;",
    
    17 => "SELECT SOUND_DESIGNER.Username 
           FROM SOUND_DESIGNER 
           INNER JOIN VIDEO_GAME ON SOUND_DESIGNER.SOUND_DESIGNER_id = VIDEO_GAME.SOUND_DESIGNER_id 
           WHERE VIDEO_GAME.game_id = 8;",
    
    18 => "SELECT DISTINCT VIDEO_GAME.title 
           FROM VIDEO_GAME 
           INNER JOIN NPC ON VIDEO_GAME.game_id = NPC.game_id 
           INNER JOIN PROJECTILE ON NPC.Projectile_use_ID = PROJECTILE.PROJECTILE_id 
           WHERE PROJECTILE.secondary_proj_id IS NOT NULL;",
    
    19 => "SELECT * 
           FROM NPC 
           WHERE number_defeated_by_player > spawn_cap_contribution;",
    
    20 => "SELECT * 
           FROM PROJECTILE 
           WHERE lifespan < 5;"
];

// Check if the report exists
if (!array_key_exists($report, $queries)) {
    die("Invalid report ID.");
}

$sql = $queries[$report];
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

// Display the report number and the query being run
echo "<h1>Report $report</h1>";
echo "<p><strong>Query being run:</strong> <code>$sql</code></p>";

if ($result->num_rows > 0) {
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
    echo "<p>No data found for this report.</p>";
}

// Close connection
$conn->close();

echo "<br><br><button onclick=\"window.location.href='reports.php';\">Return to Reports Page</button>";
?>

