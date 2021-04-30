<?php

/**
 * Use an HTML form to edit an entry in the
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

    $sql = "UPDATE users 
            SET id = ?, 
                firstname = ?, 
                lastname = ?, 
                email = ?, 
                age = ?, 
                location = ?, 
                date = ? 
            WHERE id = ?";

    $id        = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $age       = $_POST['age'];
    $location  = $_POST['location'];
    $date      = $_POST['date'];

    $statement = $connection->prepare($sql);
    $statement->bind_param("isssissi", $id, $firstname, $lastname, $email, $age, $location, $date, $id);
    $statement->execute();
    $statement->close();
  }
}

if (isset($_GET['id'])) {

  $connection = new mysqli($host, $username, $password, $dbname);

  if ($connection->connect_error) {

    echo "Connection Problem: " . $connection->connect_error;
  } else {

    $sql = "SELECT * FROM users WHERE id = ?";
    $id = $_GET['id'];
    
    $statement = $connection->prepare($sql);
    $statement->bind_param("i", $id);
    $statement->execute();

    $result = $statement->get_result();
    $user = $result->fetch_assoc();
    $statement->close();
  }
} else {
  echo "Something went wrong!";
  exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote><?php echo escape($_POST['firstname']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <?php foreach ($user as $key => $value) : ?>
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
  <?php endforeach; ?>
  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>