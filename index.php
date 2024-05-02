<?php
function redrect($url)
{
  header("Location:$url");
}
session_start();
if (empty($_SESSION["auth"]) && empty($_SESSION["id"])) {
    redrect("/templates/login.php");
}

if (isset($_GET['logout'])) {
  $_SESSION = array();
  session_destroy();
  session_unset();
  unset($_SESSION["auth"]);
  // redrect('index.php');
  header("Location: index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mening lug'atlarim</title>
    <link rel="shortcut icon" href="./assets/imgs/favicon.png" type="image/x-icon">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
    <link rel="stylesheet" href="assets/bootstrap/icons/font/bootstrap-icons.min.css">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="bg-light">
  <?php include 'components/navbar.php'; ?>
  <div class="container">
    <h3 class="text-center my-3">Lug'atlari</h3>
    <div class="container px-4 text-center">
    <div class="row">
      <?php
        require ("./config/db.php");
        $query = "SHOW TABLES FROM my_vocabulary WHERE Tables_in_my_vocabulary != \"user\"";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result)["Tables_in_my_vocabulary"]; $data[] = $row);
      ?>

      <?php
        $col = "";
        foreach($data as $value){
          $col .= '<div class="col-md-4 my-2">';
          $col .= '<div class="card">';
          $col .= '<div class="card-body">';
          $col .= '<h3 class="card-title mb-3">Mening lug\'atlarim </h3>';
          $col .= '<a href="./templates/dictionary.php?dicName='.$value.'" class="btn btn-primary px-3">kirish</a>';
          $col .= '</div>';
          $col .= '</div>';
          $col .= '</div>';
        }
        echo $col;
      ?>
    </div>
  </div>
  <?php include 'components/footer.php'; ?>
</body>

</html>