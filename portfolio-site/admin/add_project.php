<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

// Fetch clients for dropdown
$clients = $conn->query("SELECT id, name FROM users WHERE role = 'client'");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $client_id = $_POST['client_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  // Image Upload
  $image = $_FILES['image']['name'];
  $temp = $_FILES['image']['tmp_name'];
  $upload_path = "../assets/images/" . $image;

  if (move_uploaded_file($temp, $upload_path)) {
    $sql = "INSERT INTO projects (client_id, title, description, image, status) 
            VALUES ('$client_id', '$title', '$description', '$image', 'pending')";
    if ($conn->query($sql)) {
      $success = "Project added successfully!";
    } else {
      $error = "DB Error: " . $conn->error;
    }
  } else {
    $error = "Image upload failed.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Project</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    form { max-width: 500px; margin: auto; }
    input, textarea, select, button {
      width: 100%; padding: 10px; margin: 10px 0;
    }
    .success { color: green; }
    .error { color: red; }
  </style>
</head>
<body>
  <h2>Add New Project</h2>
  <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <label>Client:</label>
    <select name="client_id" required>
      <option value="">Select Client</option>
      <?php while ($c = $clients->fetch_assoc()) { ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php } ?>
    </select>

    <label>Project Title:</label>
    <input type="text" name="title" required>

    <label>Description:</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Project Image:</label>
    <input type="file" name="image" required>

    <button type="submit">Add Project</button>
  </form>
</body>
</html>
