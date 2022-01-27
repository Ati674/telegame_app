<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GetParameters extends AbstractExtension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_parameter', array($this, 'getParameter'))
        ];
    }

    public function getParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }
}
