<?php

namespace Comida\Domicilio\Middleware;

use Comida\Domicilio\Utils\SessionHelper;

class RoleMiddleware
{
    /**
     * Middleware para verificar rol de usuario
     *
     * @param array $roles Roles permitidos
     * @return callable
     */
    public static function check(array $roles): callable
    {
        return function () use ($roles) {
            SessionHelper::check();
            
            $userRole = SessionHelper::get('usuario_rol');
            
            if (!in_array($userRole, $roles)) {
                if ($userRole === 'usuario') {
                    header('Location: /cliente/dashboard');
                } else {
                    header('Location: /dashboard');
                }
                exit;
            }
        };
    }
}
