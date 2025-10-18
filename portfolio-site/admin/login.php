<?php
session_start();
include '../includes/db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Use prepared statement to prevent SQL injection
  if ($stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Incorrect password";
      }
    } else {
      $error = "Admin not found";
    }
    $stmt->close();
  } else {
    $error = "Database prepare failed: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }
    h2 {
      margin-bottom: 20px;
      color: #16a085;
      text-align: center;
    }
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 16px;
    }
    button {
      width: 100%;
      background-color: #16a085;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #13876a;
    }
    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Admin Login</h2>
    <?php if (!empty($error)) { ?>
      <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>
