<?php
function redrect($url)
{
  header("Location:$url");
}

if (!empty($_SESSION['auth'])) {
  redrect("../index.php");
}

require ("../config/db.php");

$error_message = "";


if (!empty($_POST["email"]) and !empty($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM user WHERE email='$email'";
  $resoult = mysqli_fetch_assoc(mysqli_query($link, $query));

  if (!empty($resoult)) {
    $hash = $resoult['password'];
    if (password_verify($password, $hash)) {
      session_start();
      $_SESSION["auth"] = true;
      $_SESSION['email'] = $email;
      $_SESSION['id'] = $resoult['id'];
      if ($login == 'Admin') {
        $_SESSION['admin'] = 'Admin01';
      }
      redrect("../index.php");
    } else {
      $error_message = "email yoki parol xato";
    }
  } else {
    $error_message = "email yoki parol xato";
  }
}
$pageTitle = "Kirish";
?>
<?php require('../components/header.php'); ?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-md-4"></div>
      <div class="col-sm-8 col-md-4 mt-5">
        <div class="card p-4 mt-5">
          <h2 class="text-center">Tizimga kirish</h2>
          <form action="/templates/login.php" method="POST">
            <?php
            if ($error_message) {
              echo "<div class='alert alert-warning text-center' role='alert'>
              " . $error_message . "
            </div>";
            }
            ?>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" name="email" class="form-control bg-light" placeholder="Emailingizni kiriting"
                id="exampleInputEmail1" required />
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Parol</label>
              <input type="password" name="password" class="form-control bg-light" id="exampleInputPassword1"
                placeholder="Parolingizni kiriting" required />
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Kirish</button>
            <div class="text-center mt-3">
              <a href="regis.php" class="m-3 text-center">Ro'yxatdan o'tish</a>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-2 col-md-4"></div>
    </div>
  </div>
</body>

</html>