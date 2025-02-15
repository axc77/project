<?php

require_once 'Database.php';
require_once 'UserUploader.php';

// Ambil opsi dari command line
$shortopts  = "u:p:h:"; 
$longopts  = ["file:", "create_table", "dry_run", "help"];
$options = getopt($shortopts, $longopts);

// Tampilkan bantuan
if (isset($options['help'])) {
    echo "Usage: php user_upload.php --file [filename.csv] -u [username] -p [password] -h [host] [--create_table] [--dry_run]\n";
    exit;
}

// Pastikan ada username dan password
if (empty($options['u']) || empty($options['p'])) {
    die("Error: PostgreSQL username (-u) and password (-p) are required.\n");
}

$host = $options['h'] ?? 'localhost';
$user = $options['u'];
$password = $options['p'];
$dbname = 'testdb2';

// Buat koneksi database
$db = new Database($host, $dbname, $user, $password);
$pdo = $db->getConnection();

// Buat tabel jika opsi --create_table diberikan
if (isset($options['create_table'])) {
    $db->createTable();
    exit;
}

// Pastikan ada file CSV
if (!isset($options['file'])) {
    die("Error: No file specified. Use --file [filename.csv]\n");
}

$file = $options['file'];
$dryRun = isset($options['dry_run']);

// Proses CSV
$uploader = new UserUploader($pdo, $dryRun);
$uploader->processFile($file);

?>