<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  $connection = new mysqli($host, $username, $password, $dbname);

  if ($connection->connect_error) {

    echo "Connection Problem: " . $connection->connect_error;
  } else {

    $sql = "INSERT INTO users (firstname, lastname, email, age, location) VALUES (?, ?, ?, ?, ?);";
    $statement = $connection->prepare($sql);
    $statement->bind_param("sssis",$_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['age'], $_POST['location']);
    $statement->execute();
    $statement->close();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
<?php endif; ?>

<h2>Add a user</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="firstname">First Name</label>
  <input type="text" name="firstname" id="firstname">
  <label for="lastname">Last Name</label>
  <input type="text" name="lastname" id="lastname">
  <label for="email">Email Address</label>
  <input type="text" name="email" id="email">
  <label for="age">Age</label>
  <input type="text" name="age" id="age">
  <label for="location">Location</label>
  <input type="text" name="location" id="location">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>