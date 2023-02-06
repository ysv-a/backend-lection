<?php

echo "<pre>";
var_dump($_GET);
echo "</pre>";

echo "<pre>";
var_dump($_POST);
echo "</pre>";

echo "<pre>";
var_dump($_FILES);
echo "</pre>";

// const formData = new FormData();
// formData.append("username", "Groucho");
// formData.append("accountnum", 123456);

// const content = '<q id="a"><span id="b">hey!</span></q>'; // the body of the new file…
// const blob = new Blob([content], { type: "text/xml"});

// formData.append("webmasterfile", blob);

// const request = new XMLHttpRequest();
// request.open("POST", "http://localhost:5678/form.php");
// request.send(formData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST" action="http://localhost:5678/form.php">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" name="check" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<hr>


<!-- enctype - Определяет способ кодирования данных формы при их отправке на сервер.  -->

<form method="POST" action="http://localhost:5678/form.php" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail2">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail2">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword2">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword2">
  </div>

  <div class="form-group">
    <label for="exampleInputFile">Password</label>
    <input type="file" name="image" class="form-control" id="exampleInputFile">
  </div>

  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck2">
    <label class="form-check-label" name="check" for="exampleCheck2">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>
