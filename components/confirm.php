<?php
function redrect($url)
{
    header("Location:$url");
}

session_start();
if (empty($_SESSION["auth"]) && empty($_SESSION["id"])) {
    redrect("../index.php");
}

require ('../config/db.php');

if(!empty($_POST['type']) && !empty($_POST['delItemId']) && !empty($_POST["changeType"]) && !empty($_POST["owner"])){
    
    if($_POST["owner"]!=$_SESSION["id"])
    redrect("../index.php");
    if($_POST['changeType']=="delete" && $_POST["type"]=="doc"){
        $id = $_POST['delItemId'];
        $query = "DELETE FROM `docs` WHERE `id`=$id";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $query = "DELETE FROM `doc_pages` WHERE `doc_id`=$id";
        mysqli_query($link, $query) or die(mysqli_error($link));
        redrect("../templates/docList.php");
    }
    if($_POST['changeType']=="delete" && $_POST["type"]=="docPart"){
        $id = $_POST['delItemId'];
        $query = "DELETE FROM `doc_pages` WHERE `id`=$id";
        mysqli_query($link, $query) or die(mysqli_error($link));
        redrect("../templates/docList.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasdiqlash</title>
    <link rel="shortcut icon" href="../assets/imgs/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <form class="card p-3 py-4" action="/components/confirm.php" method="post">
                    <div class="alert alert-info text-center" role="alert"><?=$_GET["message"]?> ?</div>
                    <input type="hidden" name="changeType" value="delete"/>
                    <input type="hidden" name="type" value="<?=$_GET["type"]?>"/>
                    <input type="hidden" name="delItemId" value="<?=$_GET["delItemId"]?>"/>
                    <input type="hidden" name="owner" value="<?=$_GET["owner"]?>"/>
                    <div class="d-flex justify-content-around">
                        <button class="btn btn-danger" type="submit" style="width: 40%">Xa</button>
                        <button class="btn btn-primary" type="button" onclick="goBack()" style="width: 40%">Yo'q</button>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
</body>

</html>