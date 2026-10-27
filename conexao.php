<?php
$conn = mysqli_connect("localhost", "root", "", "gestao_cafeteria");
if (!$conn) {
    die("erro ao conectar");
}
mysqli_set_charset($conn, "utf8");
