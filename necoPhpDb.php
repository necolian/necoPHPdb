<?php

/*
メインファイルです。
It's a main file of necoPHPdb.
*/

class necoPhpDb {
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
        if (!file_exists($filePath)) {
            // ファイルが存在しない場合は新規作成し、初期キーのみを保存
            $this->create($fileName, []);
        }
        
        $jsonData = json_decode(file_get_contents($filePath), true);
        $jsonData[] = $data; // 末尾に追加
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function update($fileName, $index, $data) {
        // 特定のインデックスのデータを書き換え
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        if (isset($jsonData[$index + 1])) { // 初行はキーなので +1
            $jsonData[$index + 1] = $data; // 配列の最初のデータはキー
            file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    public function insert($fileName, $index, $data) {
        // 特定のインデックスのひとつ下に挿入
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);
        array_splice($jsonData, $index + 2, 0, [$data]); // +2 して挿入（+1はキー、+1は現在のデータ）
        file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function move($fileName, $fromIndex, $toIndex) {
        // 指定された位置から別の位置にデータを移動
        $filePath = $this->directory . $fileName . '.json';
        $jsonData = json_decode(file_get_contents($filePath), true);

        if (isset($jsonData[$fromIndex + 1])) { // +1はデータ行の確認
            $dataToMove = $jsonData[$fromIndex + 1];
            unset($jsonData[$fromIndex + 1]); // 元の位置を削除
            array_splice($jsonData, $toIndex + 1, 0, [$dataToMove]); // 新しい位置に挿入
            file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
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

    public function loadAll($fileName) {
        // データを全て読み込む
        $filePath = $this->directory . $fileName . '.json';
        
        if (file_exists($filePath)) {
            $jsonData = json_decode(file_get_contents($filePath), true);
            return $jsonData;
        }
        
        return []; // ファイルが存在しない場合は空の配列を返す
    }

    public function exists($fileName) {
        // データベースファイルの存在確認
        return file_exists($this->directory . $fileName . '.json');
    }

    // 特定のキーに一致するデータを返す
    public function loadByKey($fileName, $key, $value) {
        $filePath = $this->directory . $fileName . '.json';

        if (file_exists($filePath)) {
            $jsonData = json_decode(file_get_contents($filePath), true);
            foreach ($jsonData as $data) {
                if (isset($data[$key]) && $data[$key] == $value) {
                    return $data; // 一致するデータを返す
                }
            }
        }

        return null; // 一致するデータがなかった場合はnullを返す
    }

    // 指定されたインデックスのデータを返す
    public function loadByIndex($fileName, $index) {
        $filePath = $this->directory . $fileName . '.json';

        if (file_exists($filePath)) {
            $jsonData = json_decode(file_get_contents($filePath), true);
            return $jsonData[$index + 1] ?? null; // +1はデータ行
        }

        return null; // ファイルが存在しない場合はnull
    }
}
?>
