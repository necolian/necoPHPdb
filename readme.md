
# necoPhpDb

日本語版:[readme-ja.md](readme-ja.md)

`necoPhpDb` is a PHP class for manipulating simple JSON-based databases. Using this library, you can easily perform create, read, update, and delete (CRUD) operations on data. panel is for administration. Miscellaneous.

## Calls

1. download or copy `necoPhpDb.php` to your project.
2. require `necoPhpDb.php` in the PHP file where you want to use the `NecoPhpDb` class.

    ```php
    require 'necoPhpDb.php'; 
    ```

## Class structure

The `NecoPhpDb` class provides the following methods.

### Methods.

- **``__construct($directory)``**
    - Create an instance of `NecoPhpDb` specifying the directory where the database will be stored.

- **``create($filename, $keys)``**
    - create a new database file.
    - **Arguments**:.
        - `$filename`: database filename (no extension required)
        - `$keys`: array of column names.

- **`add($filename, $data)``**
    - add($filename, $data)`** adds the given data to the database.
    - **arguments**:.
        - `$filename`: database filename.
        - `$data`: an associative array of data.

- **``getAll($filename)``**
    - Get all data from the database and return it as an array.
    - **Arguments**:.
        - `$filename`: database filename
    - **Return value**: an associative array containing all data.

- **`update($filename, $index, $data)`**
    - update($filename, $index, $data)`** updates the data at the given index.
    - **Arguments**:.
        - `$filename`: database filename.
        - `$index`: Index of the data to be updated.
        - `$data`: an associative array of the new data.

- **`delete($filename, $index)`**
    - Deletes data at the specified index.
    - **Arguments**:.
        - `$filename`: database filename.
        - `$index`: index of data to delete.

- **`insert($filename, $index, $data)`**
    - inserts new data at the specified index.
    - **Arguments**:.
        - `$filename`: database filename.
        - `$index`: index to insert.
        - `$data`: an associative array of data to insert.

- **`clear($filename)`**
    - remove all data in the database (keys will remain).
    - **Arguments**:.
        - `$filename`: the database filename.

- **`deleteDb($filename)`**
    - completely deletes the database file.
    - **Arguments**: ``$filename``: database filename
        - `$filename`: database filename

## Example usage

The following code snippet shows the basic usage of `NecoPhpDb`.

```php
require 'NecoPhpDb.php';

// Create an instance of the database
$db = new NecoPhpDb('database');

// Create database
$keys = ['name', 'mailAddress'];
$db->create('example', $keys);

// Add data
$db->add('example', ['name' => 'Taro Tanaka', 'mailAddress' => 'tanaka@example.com']);

// Retrieve data
$data = $db->getAll('example');

// Update data
$db->update('example', 0, ['name' => 'Jiro Suzuki', 'mailAddress' => 'suzuki@example.com']);

// Delete data
$db->delete('example', 0);

// delete all data
$db->clear('example');

// Delete database
$db->deleteDb('example');
```

## Notes

- **Directory Permissions**: You must have write permission to the directory containing the database.
- **Error Handling**: This library provides basic functionality, but it is recommended that the error handling process be implemented by the user.
- **Security**: When used in a production environment, input validation and sanitization should be performed.


**Security**: If used in a production environment, input validation and sanitization should be done on the user side.

------------------------------------
Copyright (c) 2024 necolian
Released under the MIT license
[https://opensource.org/licenses/mit-license.php](https://opensource.org/licenses/mit-license.php)
