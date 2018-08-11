<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
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

     .todolist {
       height: 40px;
      	display: flex;
      	align-items: center;
     }

   </style>
  </head>
  <body>
    <div class="container">
    <form action="/todo/index.php" method="post" name="form1" class="text-center">
      <input type="text" name="todotext" maxlength="20" class=" form-control my-3 bg-transparent text-white border-white" id="text" placeholder="文字を入力してください。">
      <div class="text-right">
        <input type="submit" name="insert" value="追加" class="mr-1 mb-2 btn btn-outline-light col-md-1">
        <input type="submit" name="delete" value="削除" class="mr-1 mb-2 btn btn-outline-light col-md-1">
        <input type="submit" name="alldelete" value="全削除" class="mb-2 btn btn btn-outline-light col-md-1">
      </div>

    <pre>
    <?php
    // http://todotest.work/todo/index.phpのやつ
    // $dsn = 'mysql:dbname=eitus_todolist;host=mysql3011.xserver.jp;charset=utf8';
    // $user = 'eitus_todo1';
    // $password = 'lunk5155';
    try {
      $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
      die('Connect Error: ' . $e->getCode());
    }

    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    $errors = array();

    if(isset($_POST['insert'])) {
      if( empty($_POST['todotext']) || strlen($_POST['todotext']) > 10 ) {
        // $errors['todotext'] = '';
      // }elseif(strlen($_POST['todotext']) > 10 || $errors['todotext'] === ''){

      }else{

        $text =$_POST['todotext'];
        $text = htmlspecialchars($text, ENT_QUOTES);

        $sql = 'INSERT todo (todo, created) VALUES (?, CURDATE())';
        $sth = $dbh->prepare($sql);
        $sth->bindValue(1, $text, PDO::PARAM_STR);
        $sth->execute();

        // $string1 = $_POST['todotext'];
        // var_dump(strlen($string1));

      }
      }
    // echo "<div>";
    // foreach($errors as $message){
    //     echo "<div>";
    //     echo $message;
    //     echo "</div>";
    // }
    // echo "</div>";




    // 全削除
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
        echo '<div class="card text-left mb-3">';
        echo '<div class="card-body todolist">';
        echo'<input id="check" type="checkbox" name="check[]" value="';
        echo htmlspecialchars($todolist['id'], ENT_QUOTES, 'UTF-8');
        echo '">';
        echo htmlspecialchars($todolist['todo'], ENT_QUOTES, 'UTF-8'), PHP_EOL;
        echo '</div>';
        echo '</div>';
      }

    $dbh = null;
    ?>
    </pre>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>



  </body>
</html>
