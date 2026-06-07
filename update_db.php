<?php
$db = new mysqli('localhost', 'root', '', 'db_carrera');
$db->query('ALTER TABLE t_lapang_tarif CHANGE harga_member harga_harian INT;');
echo $db->error;
?>
