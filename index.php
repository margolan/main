<?php
global $conn;
$conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 14px;
    }

    .logo {
      width: max-content;
      padding: 3px 20px;
      background: red;
      color: #fff;
    }

    a {
      text-decoration: none;
    }

    .remove {
      background: red;
      color: #fff;
      padding: 0 10px;
    }
  </style>
  <title>Document</title>
</head>

<body>
  <a href="/">
    <h1 class="logo">DATABASE</h1>
  </a>
  <hr>
  <h2>Add new data</h2>
  <form action="/" method="get">
    <input type="text" name="first_name" placeholder="First name">
    <input type="text" name="last_name" placeholder="Last name">
    <input type="text" name="gender" placeholder="Gender">
    <input type="submit" value="ok">
  </form>
  <hr>
  <h2>Data</h2>

  <?php

  $first_name = $_GET['first_name'];
  $last_name = $_GET['last_name'];
  $gender = $_GET['gender'];
  $del = $_GET['del'];
  $res = pg_fetch_all(pg_query($conn, 'SELECT * FROM lol ORDER BY id'));

  if (isset($first_name) && isset($last_name) && isset($gender)) {
    pg_query($conn, "INSERT INTO lol (id, first_name, last_name, gender) VALUES ((SELECT COUNT(id) + 1 FROM lol), '" . $first_name . "','" . $last_name . "', '" . $gender . "')");
  }

  if (isset($del)) {
    pg_query($conn, "DELETE FROM lol WHERE id = '" . $del . "'");
  }

  for ($i = 0; $i < count($res); $i++) {
    echo 'ID: ' . $res[$i]['id'] . '<br>First Name: ' . $res[$i]['first_name'] . '<br>Last Name: ' . $res[$i]['last_name'] . '<br>Gender: ' . $res[$i]['gender'] . '<br><a href="?del=' . $res[$i]['id'] . '" class="remove" name="del">remove</a><hr>';
  }

  ?>

</body>

</html>