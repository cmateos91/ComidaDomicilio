<?php

namespace Comida\Domicilio\Utils;

class SessionHelper
{
    private const TIMEOUT = 1800; // 30 minutos de inactividad

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        // Control de expiración por inactividad
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > self::TIMEOUT) {
            self::logout();
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    public static function login(array $usuario): void
    {
        self::start();
        session_regenerate_id(true); // Previene fijación de sesión

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
    }

    public static function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }

    public static function check(): void
    {
        self::start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /');
            exit;
        }
    }

    public static function get(string $clave): mixed
    {
        return $_SESSION[$clave] ?? null;
    }
}
