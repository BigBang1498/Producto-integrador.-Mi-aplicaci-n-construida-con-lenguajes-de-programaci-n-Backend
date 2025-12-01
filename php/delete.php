<?php
$user = $_POST['user'] ?? 'user1';

if ($user === 'admin') {
  $dir = __DIR__ . "/../galleries/admin";
} else {
  $dir = __DIR__ . "/../galleries/$user";
}

$file = "$dir/gallery.json";
$gallery = json_decode(file_get_contents($file), true);

$id = $_POST['id'] ?? null;
if ($id === null || !isset($gallery[$id])) die("ID inválido");

$imgFile = "$dir/" . $gallery[$id]['file'];
if (file_exists($imgFile)) unlink($imgFile);

unset($gallery[$id]);
file_put_contents($file, json_encode(array_values($gallery)));

echo "Imagen eliminada";
