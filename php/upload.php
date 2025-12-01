<?php
$user = $_POST['user'] ?? 'user1';

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

$gallery = json_decode(file_get_contents($file), true);

if (!isset($_FILES['file'])) die("No se recibió archivo");
$f = $_FILES['file'];

if ($f['error'] !== UPLOAD_ERR_OK) die("Error en la subida");

$ext = pathinfo($f['name'], PATHINFO_EXTENSION);
$filename = uniqid() . "." . $ext;
$target = "$dir/$filename";

if (!move_uploaded_file($f['tmp_name'], $target)) {
  die("Error al subir");
}

$gallery[] = ["name" => $f['name'], "file" => $filename];
file_put_contents($file, json_encode($gallery));

echo "Imagen subida";
