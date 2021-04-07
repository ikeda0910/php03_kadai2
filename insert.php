<?php
/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */
$time = $_POST['time'];
$outline = $_POST['outline'];
$up = $_POST['up'];
$others = $_POST['others'];
$reflection = $_POST['reflection'];
$next = $_POST['next'];
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
//2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=ikeda_kadai2;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}
// 1. SQL文を用意
$stmt = $pdo->prepare(
    "INSERT INTO
        php03_kadai_table(id, time, outline, up, others, reflection, next, indate)
    VALUES(
        NULL, :time, :outline, :up, :others, :reflection, :next, sysdate())"
);
//  2. バインド変数を用意
$stmt->bindValue(':time', $time, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':outline', $outline, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':up', $up, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':others', $others, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':reflection', $reflection, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':next', $next, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//  3. 実行
$status = $stmt->execute();
//４．データ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . print_r($error, true));
} else {
    //５．index.phpへリダイレクト
    header('Location: select.php');
    exit();
}