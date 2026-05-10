<?php
// Try different connection options for XAMPP
$options = [
    ['mysql:host=127.0.0.1;port=3306', 'root', ''],
    ['mysql:host=localhost;port=3306', 'root', ''],
    ['mysql:host=127.0.0.1;port=3306', 'root', 'root'],
    ['mysql:host=localhost;port=3306', 'root', 'root'],
    ['mysql:host=127.0.0.1;port=3306', 'root', 'password'],
    ['mysql:host=127.0.0.1;port=3306', 'root', 'mysql'],
];

foreach ($options as $i => $opt) {
    try {
        $pdo = new PDO($opt[0], $opt[1], $opt[2]);
        echo "SUCCESS with option $i: {$opt[0]}, user={$opt[1]}, pass={$opt[2]}\n";
        $pdo->exec('CREATE DATABASE IF NOT EXISTS bmanager');
        echo "Database 'bmanager' created!\n";
        exit(0);
    } catch (Exception $e) {
        echo "Option $i failed: {$e->getMessage()}\n";
    }
}
echo "\nAll connection attempts failed. Please check if XAMPP MySQL is running.\n";
