<?php

/**
 * Delete a user
 */

require "../config.php";
require "../common.php";

$success = null;

if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  $connection = new mysqli($host, $username, $password, $dbname);

  if ($connection->connect_error) {

    echo "Connection Problem: " . $connection->connect_error;
  } else {

    $id = $_POST["submit"];
    $sql = "DELETE FROM users WHERE id = ?";

    $statement = $connection->prepare($sql);
    $statement->bind_param('i', $id);
    $statement->execute();

    $statement->close();
  }
}

$connection = new mysqli($host, $username, $password, $dbname);

if ($connection->connect_error) {

  echo "Connection Problem: " . $connection->connect_error;
} else {

  $sql = "SELECT * FROM users";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->get_result();
  $statement->close();
}

?>
<?php require "templates/header.php"; ?>
        
<h2>Delete users</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address</th>
        <th>Age</th>
        <th>Location</th>
        <th>Date</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["id"]); ?></td>
        <td><?php echo escape($row["firstname"]); ?></td>
        <td><?php echo escape($row["lastname"]); ?></td>
        <td><?php echo escape($row["email"]); ?></td>
        <td><?php echo escape($row["age"]); ?></td>
        <td><?php echo escape($row["location"]); ?></td>
        <td><?php echo escape($row["date"]); ?> </td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>