# necoPhpDb

日本語版: [readme-ja.md](readme-ja.md)

necoPhpDb is a PHP class for manipulating simple JSON-based databases. Using this library, you can easily perform create, read, update, and delete (CRUD) operations on data. Additionally, a management panel is also provided.

## Installation

1. Download or copy `necoPhpDb.php` to your project.
2. Include `necoPhpDb.php` in the PHP file where you want to use the `NecoPhpDb` class.

    ```php
    require 'necoPhpDb.php';
    ```

## Class Structure

The `necoPhpDb` class provides the following methods.

### Methods

- **`__construct($directory)`**
    - Creates an instance of `necoPhpDb`, specifying the directory where the database will be stored.

- **`create($filename, $keys)`**
    - Creates a new database file.
    - **Arguments**:
        - `$filename`: The database filename (no extension required).
        - `$keys`: An array of column names.

- **`add($filename, $data)`**
    - Adds the specified data to the database.
    - **Arguments**:
        - `$filename`: The database filename.
        - `$data`: An associative array of data to add.

- **`getAll($filename)`**
    - Retrieves all data from the database and returns it as an array.
    - **Arguments**:
        - `$filename`: The database filename.
    - **Return value**: An associative array containing all data.

- **`update($filename, $index, $data)`**
    - Updates the data at the specified index.
    - **Arguments**:
        - `$filename`: The database filename.
        - `$index`: The index of the data to be updated.
        - `$data`: An associative array of the new data.

- **`delete($filename, $index)`**
    - Deletes the data at the specified index.
    - **Arguments**:
        - `$filename`: The database filename.
        - `$index`: The index of data to delete.

- **`insert($filename, $index, $data)`**
    - Inserts new data at the specified index.
    - **Arguments**:
        - `$filename`: The database filename.
        - `$index`: The index to insert the data.
        - `$data`: An associative array of data to insert.

- **`clear($filename)`**
    - Removes all data from the database (but keeps the keys).
    - **Arguments**:
        - `$filename`: The database filename.

- **`deleteDb($filename)`**
    - Completely deletes the database file.
    - **Arguments**:
        - `$filename`: The database filename.

## Example Usage

The following code snippet demonstrates the basic usage of `necoPhpDb`.

```php
require 'necoPhpDb.php';

// Create an instance of the database
$db = new NecoPhpDb('database');

// Create a new database
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

// Clear all data
$db->clear('example');

// Delete the database
$db->deleteDb('example');
```

## Notes

- **Directory Permissions**: You must have write permissions for the directory containing the database.
- **Error Handling**: This library provides basic functionality, but it is recommended that users implement their own error handling.
- **Security**: When used in a production environment, user input validation and sanitization should be performed.

------------------------------------
Copyright (c) 2024 necolian  
Released under the MIT license  
[https://opensource.org/licenses/mit-license.php](https://opensource.org/licenses/mit-license.php)
