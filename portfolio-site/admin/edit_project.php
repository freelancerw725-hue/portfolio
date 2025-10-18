<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
$project = $conn->query("SELECT * FROM projects WHERE id = $id")->fetch_assoc();
$clients = $conn->query("SELECT id, name FROM users WHERE role = 'client'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $client_id = $_POST['client_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $status = $_POST['status'];

  $sql = "UPDATE projects SET client_id='$client_id', title='$title', description='$description', status='$status' WHERE id=$id";
  $conn->query($sql);
  header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Project</title></head>
<body>
  <h2>Edit Project</h2>
  <form method="POST">
    <label>Client</label>
    <select name="client_id" required>
      <?php while ($c = $clients->fetch_assoc()) { ?>
        <option value="<?= $c['id'] ?>" <?= $c['id'] == $project['client_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php } ?>
    </select>

    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>

    <label>Description</label>
    <textarea name="description" rows="4"><?= htmlspecialchars($project['description']) ?></textarea>

    <label>Status</label>
    <select name="status">
      <option value="pending" <?= $project['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
      <option value="in_progress" <?= $project['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
      <option value="completed" <?= $project['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
    </select>

    <button type="submit">Update</button>
  </form>
</body>
</html>
