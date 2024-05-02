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

//get data from Form
if (!empty($_POST)) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  //if already user this email then show error message and redirect to register page again
  $query = "SELECT * FROM user WHERE email='$email'";
  $result = mysqli_fetch_assoc(mysqli_query($link, $query));
  if (empty($result)) {
    // Check input datas
    $pattern_name = "/^[a-z0-9 ._-]{2,}$/i";
    $pattern_email = "/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,}$/i";
    $pattern_password = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    // check name
    if (!preg_match($pattern_name, $name)) {
      $error_message = "Ismni to'g'ri kiriting.";
    }
    // check email
    if (!$error_message && !preg_match($pattern_email, $email)) {
      $error_message = "Email qiymati mos emas.";
    }
    // check password
    if (!$error_message && !preg_match($pattern_password, $password)) {
      $error_message = "Password qiymati mos emas.";
    }
    // create user
    if (!$error_message) {
      $hash_password = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO user SET name='$name',email='$email',password='$hash_password'";
      mysqli_query($link, $query) or die(mysqli_error($link));
      session_start();
      $_SESSION['auth'] = true;
      $_SESSION['id'] = mysqli_insert_id($link);
      $_SESSION['email'] = $email;
      redrect("../index.php");
    }
  } else {
    $error_message = "Bu email oldin ro'yhatda olingan.";
  }
}

$pageTitle = "Ro'yxatdan o'tish";
?>

<?php require('../components/header.php'); ?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4 mt-5">
        <div class="card p-4 mt-5">
          <h2 class="text-center">Ro'yxatdan o'tish</h2>
          <?php
          if ($error_message) {
            echo "<div class='alert alert-warning text-center' role='alert'>
              " . $error_message . "
            </div>";
          }
          ?>
          <form action="/templates/regis.php" method="POST">
            <div class="mb-3">
              <label for="exampleInputname" class="form-label">Ism</label>
              <input type="text" name="name" class="form-control bg-light" placeholder="Ismingizni kiriting"
                id="exampleInputname" required />
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" name="email" class="form-control bg-light" placeholder="Emailingizni kiriting"
                id="exampleInputEmail1" required />
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Parol</label>
              <input type="password" name="password" class="form-control bg-light" id="exampleInputPassword1"
                placeholder="parolingizni kiriting" required />
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Ro'yhatdan o'tish</button>
            <div class="text-center mt-3">
              <a href="login.php" class="m-3 text-center">Tizimga kirish</a>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>
</body>

</html>