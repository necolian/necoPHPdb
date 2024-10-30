# necoPhpDb

`necoPhpDb` は、シンプルなJSONベースのデータベースを操作するためのPHPクラスです。このライブラリを使用することで、データの作成、読み取り、更新、削除（CRUD）操作を容易に実行できます。panelは管理用です。雑です。

## 呼び出し

1. プロジェクトに `necoPhpDb.php` をダウンロードまたはコピーします。
2. PHPファイルの中から `NecoPhpDb` クラスを使用する箇所で、`necoPhpDb.php` をrequireします。

    ```php
    require 'necoPhpDb.php';
    ```

## クラスの構造

`NecoPhpDb` クラスは以下のメソッドを提供しています。

### メソッド

- **`__construct($directory)`**
    - データベースを格納するディレクトリを指定してインスタンスを作成します。

- **`create($filename, $keys)`**
    - 新しいデータベースファイルを作成します。
    - **引数**:
        - `$filename`: データベースファイル名（拡張子は不要）
        - `$keys`: カラム名の配列

- **`add($filename, $data)`**
    - 指定したデータをデータベースに追加します。
    - **引数**:
        - `$filename`: データベースファイル名
        - `$data`: データの連想配列

- **`getAll($filename)`**
    - データベースからすべてのデータを取得し、配列として返します。
    - **引数**:
        - `$filename`: データベースファイル名
    - **戻り値**: すべてのデータを含む連想配列

- **`update($filename, $index, $data)`**
    - 指定したインデックスのデータを更新します。
    - **引数**:
        - `$filename`: データベースファイル名
        - `$index`: 更新するデータのインデックス
        - `$data`: 新しいデータの連想配列

- **`delete($filename, $index)`**
    - 指定したインデックスのデータを削除します。
    - **引数**:
        - `$filename`: データベースファイル名
        - `$index`: 削除するデータのインデックス

- **`insert($filename, $index, $data)`**
    - 指定したインデックスの位置に新しいデータを挿入します。
    - **引数**:
        - `$filename`: データベースファイル名
        - `$index`: 挿入するインデックス
        - `$data`: 挿入するデータの連想配列

- **`clear($filename)`**
    - データベースのすべてのデータを削除します（キーは残ります）。
    - **引数**:
        - `$filename`: データベースファイル名

- **`deleteDb($filename)`**
    - データベースファイルを完全に削除します。
    - **引数**:
        - `$filename`: データベースファイル名

## 使用例

以下のコードスニペットは `NecoPhpDb` の基本的な使い方を示しています。

```php
require 'NecoPhpDb.php';

// データベースのインスタンスを作成
$db = new NecoPhpDb('database');

// データベースの作成
$keys = ['name', 'mailAddress'];
$db->create('example', $keys);

// データの追加
$db->add('example', ['name' => '田中太郎', 'mailAddress' => 'tanaka@example.com']);

// データの取得
$data = $db->getAll('example');

// データの更新
$db->update('example', 0, ['name' => '鈴木次郎', 'mailAddress' => 'suzuki@example.com']);

// データの削除
$db->delete('example', 0);

// すべてのデータの削除
$db->clear('example');

// データベースの削除
$db->deleteDb('example');
```

## 注意事項

-   **ディレクトリの権限**: データベースを格納するディレクトリに書き込み権限が必要です。
-   **エラーハンドリング**: 本ライブラリは基本的な機能を提供しますが、エラーハンドリング処理はユーザー側で実装することをおすすめします。
-   **セキュリティ**: 本番環境で使用する場合は、入力のバリデーションやサニタイジングを行ってください。

-----
Copyright (c) 2024 necolian
Released under the MIT license
[https://opensource.org/licenses/mit-license.php](https://opensource.org/licenses/mit-license.php)
