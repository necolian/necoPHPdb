# necoPhpDb

日本語版: [readme-ja.md](readme-ja.md)

`necoPhpDb` は、シンプルなJSONベースのデータベースを操作するためのPHPクラスです。このライブラリを使用すると、データに対して簡単に作成、読み込み、更新、削除（CRUD）操作を実行できます。また、管理用の `panel` も用意されています。

## インストール

1. `necoPhpDb.php` をプロジェクトにダウンロードまたはコピーします。
2. `NecoPhpDb` クラスを使用するPHPファイルで、`necoPhpDb.php` を読み込みます。

    ```php
    require 'necoPhpDb.php';
    ```

## クラス構造

`necoPhpDb` クラスは、以下のメソッドを提供します。

### メソッド

- **`__construct($directory)`**
    - `NecoPhpDb` のインスタンスを作成します。データベースを保存するディレクトリを指定します。

- **`create($filename, $keys)`**
    - 新しいデータベースファイルを作成します。
    - **引数**:
        - `$filename`: データベースファイル名（拡張子は不要）
        - `$keys`: カラム名の配列。

- **`add($filename, $data)`**
    - 指定されたデータをデータベースに追加します。
    - **引数**:
        - `$filename`: データベースファイル名。
        - `$data`: 追加するデータの連想配列。

- **`getAll($filename)`**
    - データベースからすべてのデータを取得し、配列として返します。
    - **引数**:
        - `$filename`: データベースファイル名。
    - **戻り値**: すべてのデータを含む連想配列。

- **`update($filename, $index, $data)`**
    - 指定されたインデックスのデータを更新します。
    - **引数**:
        - `$filename`: データベースファイル名。
        - `$index`: 更新するデータのインデックス。
        - `$data`: 新しいデータの連想配列。

- **`delete($filename, $index)`**
    - 指定されたインデックスのデータを削除します。
    - **引数**:
        - `$filename`: データベースファイル名。
        - `$index`: 削除するデータのインデックス。

- **`insert($filename, $index, $data)`**
    - 指定されたインデックスに新しいデータを挿入します。
    - **引数**:
        - `$filename`: データベースファイル名。
        - `$index`: 挿入するインデックス。
        - `$data`: 挿入するデータの連想配列。

- **`clear($filename)`**
    - データベース内のすべてのデータを削除します（キーは残ります）。
    - **引数**:
        - `$filename`: データベースファイル名。

- **`deleteDb($filename)`**
    - データベースファイルを完全に削除します。
    - **引数**:
        - `$filename`: データベースファイル名。

## 使用例

以下のコードスニペットは、基本的な使用法を示しています。

```php
require 'necoPhpDb.php';

// データベースのインスタンスを作成
$db = new necoPhpDb('database');

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

// すべてのデータを削除
$db->clear('example');

// データベースの削除
$db->deleteDb('example');
```

## 注意事項

- **ディレクトリの権限**: データベースを含むディレクトリには書き込み権限が必要です。
- **エラーハンドリング**: このライブラリは基本的な機能を提供しますが、エラーハンドリングはユーザー側で実装することを推奨します。
- **セキュリティ**: 本番環境で使用する際は、ユーザー入力の検証とサニタイズを行う必要があります。

------------------------------------
Copyright (c) 2024 necolian  
Released under the MIT license  
[https://opensource.org/licenses/mit-license.php](https://opensource.org/licenses/mit-license.php)
