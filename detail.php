<?php

//１．PHP
//select.phpのPHP部分コードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正、GETの内容をSELECTする！
require_once('funcs.php');
$pdo = db_conn();

$id = $_GET['id'];

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM php03_kadai_table WHERE id =" . $id . ";" );
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>業務レポート</title>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">業務レポート</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <form method="post" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>本日の業務</legend>
                <label><p style="font-weight:bold">勤務時間：<select name="time" >
                    <option hidden><?= $result['time'] ?></option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5</option>
                    <option value="5.5">5.5</option>
                    <option value="6">6</option>
                    <option value="6.5">6.5</option>
                    <option value="7">7</option>
                    <option value="7.5">7.5</option>
                    <option value="8">8</option>
                    <option value="8.5">8.5</option>
                    <option value="9">9</option>
                    <option value="9.5">9.5</option>
                    <option value="10">10</option>
                </select>時間</p></label>
                <p style="font-weight:bold">本日の成果</p>
                <label>アウトライン作成：
                <select name="outline" value="<?= $result['outline'] ?>">
                    <option hidden><?= $result['outline'] ?></option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select></label><br>
                <label>記事の掲載：
                <select name="up">
                    <option hidden><?= $result['up'] ?></option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select></label><br>
                <label>その他：<input type="text" name="others" value="<?= $result['others'] ?>"></label>
                <p style="font-weight: bold">振り返り</p>
                <textArea name="reflection" rows="3" cols="40" ><?= $result['reflection'] ?></textArea><br>
                <p style="font-weight: bold">次回の仕事</p>
                <textArea name="next" rows="3" cols="40"><?= $result['next'] ?></textArea><br>
                <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>
</html>