<?php
// app/Utils/hash.php

echo "Introduce la contraseña a encriptar: ";
$password = trim(fgets(STDIN));

if (empty($password)) {
    echo "❌ La contraseña no puede estar vacía.\n";
    exit(1);
}

$hash = password_hash($password, PASSWORD_BCRYPT);
echo "✅ Hash generado:\n$hash\n";
