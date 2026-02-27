<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "../nav.php"; ?>
<h2>Clients</h2>
<a href="clients_add.php" class="add-link">+ Add New Client</a>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Action</th>
  </tr>
  <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?php echo $row['client_id']; ?></td>
      <td><?php echo $row['full_name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
      <td>
        <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" style="color: #3498db; text-decoration: none; font-weight: bold;">Edit</a>
      </td>
    </tr>
  <?php } ?>
</table>
</body>
</html>