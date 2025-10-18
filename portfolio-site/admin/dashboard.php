<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

// Fetch projects with client names
$sql = "SELECT projects.id, projects.title, projects.description, projects.image, projects.status, projects.created_at, users.name AS client_name
        FROM projects
        JOIN users ON projects.client_id = users.id
        ORDER BY projects.created_at DESC";
$result = $conn->query($sql);

// Fetch contact messages
$contact_sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$contact_result = $conn->query($contact_sql);
if (!$contact_result) {
  die("Error fetching contact messages: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
    }
    header {
      background-color: #16a085;
      color: white;
      padding: 15px 20px;
      text-align: center;
    }
    nav {
      background: #1abc9c;
      padding: 10px 20px;
      display: flex;
      gap: 15px;
    }
    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
    nav a:hover {
      text-decoration: underline;
    }
    main {
      padding: 20px;
    }
    h1 {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 40px;
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #1abc9c;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    img.project-image {
      width: 60px;
      height: 40px;
      object-fit: cover;
      border-radius: 4px;
    }
    .status {
      padding: 5px 10px;
      border-radius: 12px;
      color: white;
      font-weight: bold;
      text-transform: capitalize;
      display: inline-block;
    }
    .status.pending {
      background-color: #f39c12;
    }
    .status.in_progress {
      background-color: #2980b9;
    }
    .status.completed {
      background-color: #27ae60;
    }
    .actions a {
      margin-right: 10px;
      color: #16a085;
      text-decoration: none;
      font-weight: bold;
    }
    .actions a:hover {
      text-decoration: underline;
    }
    .logout {
      margin-left: auto;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
  </header>
  <nav>
    <a href="dashboard.php">Projects</a>
    <a href="add_project.php">Add Project</a>
    <a href="admin.php">Create Admin</a>
    <a href="logout.php" class="logout">Logout</a>
  </nav>
  <main>
    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Project Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Client</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td>
                <?php if ($row['image']): ?>
                  <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" alt="Project Image" class="project-image" />
                <?php else: ?>
                  N/A
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td><?= htmlspecialchars($row['client_name']) ?></td>
              <td>
                <span class="status <?= htmlspecialchars($row['status']) ?>">
                  <?= htmlspecialchars($row['status']) ?>
                </span>
              </td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="actions">
                <a href="edit_project.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete_project.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this project?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No projects found.</p>
    <?php endif; ?>

    <h2>Contact Messages</h2>
    <?php if ($contact_result && $contact_result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Received At</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($msg = $contact_result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($msg['name']) ?></td>
              <td><?= htmlspecialchars($msg['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
              <td><?= htmlspecialchars($msg['created_at']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No contact messages found.</p>
    <?php endif; ?>
  </main>
</body>
</html>
