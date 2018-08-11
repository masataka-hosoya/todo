<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
 <title>todo</title>
 <style>
body {
  background-size: cover; /*ボックス全体をカバーする大きさで表示*/
  background-image: url(img/AMEMAN17826009_TP_V.jpg);
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center center;
}

.form-control::-webkit-input-placeholder{
    color: white;
}
</style>
 </head>
 <body>

<form action="/todo/index3.php" method="post" class="my-4" name="form1">
<div class="container-fluid">
  <div class="form-group">
    <div>
      <input type="text" name="todotext" class="form-control my-3 bg-transparent text-white border-white" id="formGroupExampleInput" placeholder="文字を入力してください。" maxlength="20">
    </div>
  </div>
</div>

<div>
    <div class="container-fluid text-right">
        <button name="insert" class="btn btn-outline-light mb-3 mr-2" type="button">追加</button>
        <button name="delete" class="btn btn-outline-light mb-3 mr-2" type="button">削除</button>
        <button name="alldelete" class="btn btn-outline-light mb-3" type="button">全削除</button>
    </div>
</div>

<div class="container-fluid">
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <input type="checkbox" name="check" aria-label="Checkbox for following text input" class="bg-white">
        </div>
        </div>
          <input type="text" class="form-control bg-white" aria-label="Text input with checkbox">
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  $dsn = 'mysql:dbname=todolist;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  try {
    $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    die('Connect Error: ' . $e->getCode());
  }

$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


$errors = array();

if(isset($_POST['insert'])) {
  if(empty($_POST['todotext'])) {
    $errors['todotext'] = '入力してください。';
  }else{
    $text = $_POST['todotext'];
    $text = htmlspecialchars($text, ENT_QUOTES);

    $sql = 'INSERT todo (todo, created) VALUES (?, CURDATE())';
    $sth = $dbh->prepare($sql);
    $sth->bindValue(1, $_POST["todotext"], PDO::PARAM_STR);
    $sth->execute();

    // $str = mb_substr($text,0,20,'UTF-8');
    // echo $str;
//     if (mb_strlen($getuname) <= 1){
//     $getuname = "0".$getuname;
// }
  }
  }
echo "<div>";
foreach($errors as $message){
    echo "<div>";
    echo $message;
    echo "</div>";
}
echo "</div>";


if(isset($_POST['alldelete'])) {
$sql = 'DELETE FROM todo';
$sth = $dbh->prepare($sql);
$sth->execute();
}

if (isset( $_POST['delete'], $_POST['check'])) {
$sql = 'DELETE FROM todo WHERE id = ?';
$sth = $dbh->prepare($sql);
foreach ($_POST['check'] as $chk) {
    $id = (int)$chk;
    $sth->bindValue(1, $id, PDO::PARAM_INT);
    $sth->execute();
  }
}

  $sql = 'SELECT id ,todo, created FROM todo';
  $sth = $dbh->prepare($sql);
  // print_r($dbh->errorInfo());
  $sth->execute();


  while($todolist = $sth->fetch(PDO::FETCH_ASSOC)) {
    echo'<input id="check" type="checkbox" name="check[]" value="';
    echo htmlspecialchars($todolist['id'], ENT_QUOTES, 'UTF-8');
    echo '">';
    echo htmlspecialchars($todolist['todo'], ENT_QUOTES, 'UTF-8'), PHP_EOL;
  }

$dbh = null;
?>
</pre>
</form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>


</body>
</html>
