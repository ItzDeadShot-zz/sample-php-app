<?php

/**
 * List all users with a link to edit
 */

require "../config.php";
require "../common.php";

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
        
<h2>Update users</h2>

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
            <th>Edit</th>
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
            <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>