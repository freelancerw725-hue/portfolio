<?php
include 'includes/db.php';

// Set content type for HTML output
header('Content-Type: text/html; charset=utf-8');

echo "<h2>Database Structure Check</h2>";

// Check if contact_messages table exists
$table_check = $conn->query("SHOW TABLES LIKE 'contact_messages'");
if ($table_check && $table_check->num_rows > 0) {
    echo "<p>&#10003; contact_messages table exists</p>";
    
    // Show table structure
    $structure = $conn->query("DESCRIBE contact_messages");
    if ($structure && $structure->num_rows > 0) {
        echo "<h3>contact_messages table structure:</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p>&#10007; contact_messages table does not exist</p>";
}

// Check if there are any records in contact_messages
$count = $conn->query("SELECT COUNT(*) as count FROM contact_messages");
if ($count && $row = $count->fetch_assoc()) {
    echo "<p>Number of contact messages in database: " . intval($row['count']) . "</p>";
}

// Check if projects table exists
$table_check = $conn->query("SHOW TABLES LIKE 'projects'");
if ($table_check && $table_check->num_rows > 0) {
    echo "<p>&#10003; projects table exists</p>";
} else {
    echo "<p>&#10007; projects table does not exist</p>";
}

// Check if users table exists
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check && $table_check->num_rows > 0) {
    echo "<p>&#10003; users table exists</p>";
    
    // Show table structure
    $structure = $conn->query("DESCRIBE users");
    if ($structure && $structure->num_rows > 0) {
        echo "<h3>users table structure:</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p>&#10007; users table does not exist</p>";
}

$conn->close();
?>
