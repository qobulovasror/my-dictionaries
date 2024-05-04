<?php
function redrect($url)
{
    header("Location:$url");
}
session_start();
if (empty($_SESSION["auth"]) && empty($_SESSION["id"])) {
    redrect("/templates/login.php");
}

require ("../config/db.php");

if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    session_unset();
    unset($_SESSION["auth"]);
    redrect('../index.php');
    exit();
}

function getDict($link, $tableName)
{
    $query = "SELECT * FROM `$tableName`";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    return $data;
}
function getCoulums($link, $tableName)
{
    $query = "SELECT column_name
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE table_name = '$tableName'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result)["column_name"]; $data[] = $row);
    return $data;
}


$tabName = "";
if (!empty($_GET['dicName'])) {
    $tabName = $_GET['dicName'];
} else {
    redrect('../index.php');
}

$curTable = getDict($link, $tabName);
$columnNames = getCoulums($link, $tabName);
$columnNames = array_slice($columnNames, 1, count($columnNames));

$pageTitle = "Lug'atlar";
?>
<?php require ('../components/header.php'); ?>

<body>

    <?php require ('../components/navbar.php'); ?>
    <div class="container">
        <div class="row mt-4 justify-content-between">
            <div class="col-8">
                <h3 class="text-center">Lug'atlar ro'yxati</h3>
                <div class="card p-3">
                    <table class="table table-striped table-hover" style="width:100%; overflow: auto;">
                        <thead>
                            <tr>
                                <?php
                                    $tableHeader = "";
                                    $tableHeader .= '<th scope="col">#</th>';
                                    foreach($columnNames as $col){
                                        $tableHeader .= '<th scope="col">'.$col.'</th>';
                                    }
                                    echo $tableHeader;
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //show table items
                                $tableCell = "";
                                foreach($curTable as $key => $value) {
                                    $tableCell .= "<tr>";
                                    $tableCell .= '<th scope="row">'.($key+1).'</th>';
                                    foreach($columnNames as $i){
                                        $tableCell .= '<td>'.$value[$i].'</td>';
                                    }
                                    $tableCell .= "</tr>";
                                }
                                echo $tableCell;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <h3 class="text-cemter">Yangi ma'lumot qo'shish</h3>
                <div class="card p-4">
                    <form method="post" action="/templates/dictionary.php">
                        <?php
                            $inputFielts = "";
                            foreach($columnNames as $name){
                                $inputFielts .= '<div class="mb-3">';
                                $inputFielts .= '<label for="'.$name.'For" class="form-label">'.$name.'</label>';
                                $inputFielts .= '<input type="text" name="'.$name.'" class="form-control" id="'.$name.'For">';
                                $inputFielts .= '</div>';
                            }
                            echo $inputFielts;
                        ?>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    $list = "";
    // foreach ($curDoc as $key => $value) {
    //     $list .= '<a href="/templates/read.php?docId=' . $doc_id . '&page=' . $value['id'];
    //     if($page == 0){
    //         if($key==0){
    //             $page_content = $value['body'];
    //             $page_content_title = $value['title'];
    //             $list .= '" class="list-group-item list-group-item-action active" aria-current="true">';
    //         }else{
    //             $list .= '" class="list-group-item list-group-item-action" aria-current="true">';
    //         }
    //     }else{
    //         if ($page == $value['id']) {
    //             $list .= '" class="list-group-item list-group-item-action active" aria-current="true">';
    //             $page_content = $value['body'];
    //             $page_content_title = $value['title'];
    //         } else {
    //             $list .= '" class="list-group-item list-group-item-action" aria-current="true">';
    //         }
    
    //     }
    //     $list .= $value['title'];
    //     $list .= '</a>';
    // }
    // echo $list;
    ?>


</body>

</html>