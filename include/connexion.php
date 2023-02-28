<?php

function connexion()
{
  $pdo = new PDO('mysql:host=localhost;dbname=huot_cuej;charset=utf8', 'cuej_bd', 'hWph108*3');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

  if ($pdo) {
    return $pdo;
  } else {
    echo '<p>Erreur de connexion</p>';
    exit;
  }
}
?>