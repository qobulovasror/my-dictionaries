<?php
require ("config/db.php");
?>
<div class="container px-4 text-center">
  <div class="row">
    <?php
    $query = "SELECT * FROM `docs` WHERE `status`=1 ORDER BY id DESC;";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row)
      ;
    $result = '';
    foreach ($data as $value) {
      $result .= '<div class="col-md-4 my-2"> <div class="card">
    <div class="card-body">';
      $result .= '<h3 class="card-title">' . $value['name'] . '</h3>';
      $result .= "<a href='/templates/read.php?docId=" . $value['id'] . "' class='btn btn-primary'>Batafsil</a>";
      $result .= '  </div>
      </div>
      </div>';
    }
    echo $result;
    ?>
  </div>
</div>