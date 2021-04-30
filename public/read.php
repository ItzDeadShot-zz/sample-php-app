<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
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

    $sql = "SELECT * 
            FROM users
            WHERE location = ?";

    $location = $_POST['location'];
    $statement = $connection->prepare($sql);
    $statement->bind_param("s", $location);
    $statement->execute();

    $result = $statement->get_result();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $result->num_rows > 0) { ?>
    <h2>Results</h2>

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
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php } else { ?>
    <blockquote>No results found for <?php echo escape($_POST['location']); ?>.</blockquote>
  <?php }
} else {
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

  <?php
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

    <h2>All Users</h2>
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
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
<?php
}
?>



<h1>Find user based on location</h1>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="location">Location</label>
  <input type="text" id="location" name="location">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>