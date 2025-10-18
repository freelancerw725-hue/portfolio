<?php
include 'includes/db.php';

$name = $email = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);

  if (empty($name) || empty($email) || empty($message)) {
    $error = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } else {
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
      $success = "Thank you for your message!";
      $name = $email = $message = "";
    } else {
      $error = "Error saving your message. Please try again later.";
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Me</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/style_additions.css" />
</head>
<body>
  <section id="contact" class="content-section">
    <div class="text-content">
      <h2>Contact Me</h2>
      <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>
      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <form id="contact-form" action="contact.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required />
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required />
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
        
        <button type="submit" class="cta-button">Send</button>
      </form>
    </div>
  </section>
</body>
</html>
