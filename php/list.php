<?php
$user = $_GET['user'] ?? 'user1';

if ($user === 'admin') {
  $dir = __DIR__ . "/../galleries/admin";
} else {
  $dir = __DIR__ . "/../galleries/$user";
}

$file = "$dir/gallery.json";

if (!is_dir($dir)) {
  mkdir($dir, 0775, true);
}
if (!file_exists($file)) {
  file_put_contents($file, json_encode([]));
}

header('Content-Type: application/json');
echo file_get_contents($file);
