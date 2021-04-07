<?php

require_once('funcs.php');

//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=ikeda_kadai2;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM php03_kadai_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('ErrorQuery:' . print_r($error, true));
}else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<p class="report">';
        $view .= h($result['indate']);
        $view .= '<br>';
        $view .= "勤務時間：";
        $view .= h($result['time']);
        $view .= "時間";
        $view .= '<br>';
        $view .= "業務内容";
        $view .= '<br>';
        $view .= "アウトライン作成：";
        $view .= h($result['outline']);
        $view .= "本";
        $view .= '<br>';
        $view .= "掲載記事数：";
        $view .= h($result['up']);
        $view .= "本";
        $view .= '<br>';
        $view .= "その他：";
        $view .= h($result['others']);
        $view .= '<br>';
        $view .= "振り返り：";
        $view .= h($result['reflection']);
        $view .= '<br>';
        $view .= "次回の仕事：";
        $view .= h($result['next']);
        $view .= '<br>';
        $view .= '<a href="detail.php?id=' . $result['id'] . '">';
        $view .= "[編集]";
        $view .= '</a>';
        $view .= '　';
        $view .= '<a onclick="return func();" href="delete.php?id=' . $result['id'] . '">';
        $view .= "[削除]";
        $view .= '</a>';
        $view .= '</p>';

        $outlineSum += h($result['outline']);
        $timeSum += h($result['time']);
        $upSum += h($result['up']);

        $timeRate = round($timeSum /90 *100,2);
        $outlineRate = round($outlineSum /50 *100,2);
        $upRate = round($upSum /30 *100,2);
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<title>業務レポート</title>
<!-- <link rel="stylesheet" href="css/range.css"> -->
<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="index.php">業務内容登録</a>
        </div>
    </div>
    </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    
<table>
  <tr>
    <th></th>
    <th>勤務時間</th>
    <th>アウトライン作成</th>
    <th>掲載記事数</th>
  </tr>
  <tr>
    <th>月間数値</th>
    <td><?= $timeSum ?></td>
    <td><?= $outlineSum ?></td>
    <td><?= $upSum ?></td>
  </tr>
  <tr>
    <th>月間目標</th>
    <td>90</td>
    <td>50</td>
    <td>30</td>
  </tr>
  <tr>
    <th>達成率</th>
    <td><?= $timeRate ?>%</td>
    <td><?= $outlineRate ?>%</td>
    <td><?= $upRate ?>%</td>
  </tr>
</table>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>

<script>
    function func(){
    if(!window.confirm('削除しますか？')){
    window.alert('キャンセルされました'); 
    return false;
    }
    return true;
}
</script>