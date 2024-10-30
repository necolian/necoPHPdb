<?php

/*
necoPHPdb専用の管理パネルです。テスト用なので雑です。
本体と同ディレクトリに設置してください。

This is a dedicated administration panel for necoPHPdb.
It is for testing purposes only.
Please put it in the same directory as the main file.
*/

require 'necoPhpDb.php';

// データベースの設定
$db = new NecoPhpDb('database');
$dbFileName = 'example'; // 使用するファイル名

// リクエスト処理
$action = $_GET['action'] ?? null;

if ($action === 'create') {
    $keys = ['name', 'mailAddress'];
    $db->create($dbFileName, $keys);
}

if ($action === 'add') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $db->add($dbFileName, ['name' => $name, 'mailAddress' => $email]);
        header('Location: panel.php');
        exit;
    }
}

if ($action === 'delete' && isset($_GET['index'])) {
    $index = intval($_GET['index']);
    $db->delete($dbFileName, $index);
    header('Location: panel.php');
    exit;
}

if ($action === 'update' && isset($_POST['index'])) {
    $index = intval($_POST['index']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $db->update($dbFileName, $index, ['name' => $name, 'mailAddress' => $email]);
    header('Location: panel.php');
    exit;
}

if ($action === 'clear') {
    $db->clear($dbFileName);
    header('Location: panel.php');
    exit;
}

if ($action === 'deleteDb') {
    $db->deleteDb($dbFileName);
    header('Location: panel.php');
    exit;
}

if ($action === 'insert') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $index = intval($_POST['index']);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $db->insert($dbFileName, $index, ['name' => $name, 'mailAddress' => $email]);
        header('Location: panel.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Neco PHP DB 管理パネル</title>
</head>
<body>
    <h1>Neco PHP DB 管理パネル</h1>

    <h2>データベースの作成</h2>
    <form action="?action=create" method="post">
        <input type="submit" value="データベースを作成">
    </form>

    <h2>データの追加</h2>
    <form action="?action=add" method="post">
        <label>名前: <input type="text" name="name" required></label><br>
        <label>メールアドレス: <input type="email" name="email" required></label><br>
        <input type="submit" value="追加">
    </form>

    <h2>登録されたデータ</h2>
    <?php
    if (file_exists("database/$dbFileName.json")) {
        $jsonData = json_decode(file_get_contents("database/$dbFileName.json"), true);
        if (count($jsonData) > 1) { // キーの行を除く
            echo '<table border="1">';
            echo '<tr><th>名前</th><th>メールアドレス</th><th>操作</th></tr>';
            foreach ($jsonData as $index => $record) {
                if ($index == 0) continue; // キーはスキップ
                echo '<tr>';
                echo '<td>' . htmlspecialchars($record['name']) . '</td>';
                echo '<td>' . htmlspecialchars($record['mailAddress']) . '</td>';
                echo '<td>';
                
                // 削除ボタン
                echo '<form action="?action=delete&index=' . ($index - 1) . '" method="post" style="display:inline;">';
                echo '<input type="submit" value="削除" onclick="return confirm(\'削除しますか？\')">';
                echo '</form>';
                
                // 更新ボタン
                echo '<form action="#update" method="post" style="display:inline;">
                        <input type="hidden" name="index" value="' . ($index - 1) . '">
                        <input type="text" name="name" value="' . htmlspecialchars($record['name']) . '" required>
                        <input type="email" name="email" value="' . htmlspecialchars($record['mailAddress']) . '" required>
                        <input type="submit" value="更新">
                    </form>';
                
                //挿入ボタン
                echo '<form action="?action=insert" method="post" style="display:inline;">
                        <input type="hidden" name="index" value="' . ($index - 1) . '">
                        <input type="text" name="name" required>
                        <input type="email" name="email" required>
                        <input type="submit" value="挿入">
                    </form>';
                
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>データがありません。</p>';
        }
    } else {
        echo '<p>データベースが存在しません。</p>';
    }
    ?>

    <h2>全削除</h2>
    <form action="?action=clear" method="post">
        <input type="submit" value="キー以外全削除">
    </form>

    <h2>データベースの削除</h2>
    <form action="?action=deleteDb" method="post" onsubmit="return confirm('本当に削除しますか？');">
        <input type="submit" value="データベースを削除">
    </form>
</body>
</html>
