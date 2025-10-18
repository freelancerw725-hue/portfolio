<?php
include '../includes/db.php'; // Use correct path

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Messages</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .message {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
    }
    .message h3 {
      margin: 0;
      font-size: 1.2rem;
    }
    .message p {
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <h2>Contact Messages</h2>
  <?php
  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div class='message'>";
      echo "<h3>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")</h3>";
      echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
      echo "<small>Sent on: " . $row['created_at'] . "</small>";
      echo "</div>";
    }
  } else {
    echo "<p>No messages found.</p>";
  }
  ?>
</body>
</html>
