<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Solo el admin puede usar este script
$user = $_POST['user'] ?? null;

if ($user === null) die("Usuario no especificado");
if ($user === 'admin') die("No puedes borrar al admin");

$dir = __DIR__ . "/../galleries/$user";

function rrmdir($dir) {
  if (!is_dir($dir)) return;
  $objects = scandir($dir);
  foreach ($objects as $object) {
    if ($object != "." && $object != "..") {
      $path = $dir . "/" . $object;
      if (is_dir($path)) {
        rrmdir($path);
      } else {
        unlink($path);
      }
    }
  }
  rmdir($dir);
}

if (is_dir($dir)) {
  rrmdir($dir);
  echo "Usuario $user eliminado con todos sus datos";
} else {
  echo "Usuario no encontrado";
}
