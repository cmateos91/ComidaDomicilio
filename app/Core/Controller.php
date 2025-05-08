<?php

namespace Comida\Domicilio\Core;

use Doctrine\ORM\EntityManager;
use Smarty\Smarty;

abstract class Controller
{
    protected EntityManager $em;
    protected Smarty $smarty;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../Views');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c');
    }

    /**
     * Renderizar una vista con datos
     */
    protected function render(string $view, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($view);
    }

    /**
     * Responder con JSON
     */
    protected function json(array $data, int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    /**
     * Redirigir a otra URL
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
