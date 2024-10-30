<?php

/*
メインファイルです。
It's a main file of necoPHPdb.
*/

class NecoPhpDb {
    private $directory;

    public function __construct($directory) {
        $this->directory = rtrim($directory, '/') . '/';  // ディレクトリの末尾にスラッシュを追加
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777, true); // ディレクトリが無ければ作成
        }
    }

    public function create($fileName, $initialKeys) {
        // 新しいjsonデータファイルを作成
        $filePath = $this->directory . $fileName . '.json';
        $data = [$initialKeys];
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function deleteDb($fileName) {
        // データベースファイルを削除
        $filePath = $this->directory . $fileName . '.json';
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function add($fileName, $data) {
        // データの追加
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        $jsonData[] = $data; // 末尾に追加
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function update($fileName, $index, $data) {
        // 特定のインデックスのデータを書き換え
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        if (isset($jsonData[$index + 1])) { // 初行はキー
            $jsonData[$index + 1] = $data; // 配列の最初のデータはキーなので +1
            file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    public function insert($fileName, $index, $data) {
        // 特定のインデックスのひとつ下に挿入
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        array_splice($jsonData, $index + 1, 0, [$data]); // +1 して挿入
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function clear($fileName) {
        // キー以外全消し
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        $jsonData = [$jsonData[0]]; // 1行目（キーの行）のみを残す
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function delete($fileName, $indexes) {
        // 指定されたインデックスのデータを削除
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        
        if (!is_array($indexes)) {
            $indexes = [$indexes]; // 単一のインデックスを配列に変換
        }

        // インデックスを降順にソート（削除時のインデックスが先にずれないように）
        rsort($indexes);
        
        foreach ($indexes as $index) {
            if (isset($jsonData[$index + 1])) { // +1 でデータ行の確認
                unset($jsonData[$index + 1]); // 削除
            }
        }
        
        // インデックスを再インデックス
        $jsonData = array_values($jsonData);
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
?>
