<?php

namespace Silicon\Http;

class ControllerResolver
{
    public function resolve(Route $route): callable
    {
        $controller = $route->controller();

        // Closure
        if (is_callable($controller)) {
            return $controller;
        }

        // Class-string
        if (is_string($controller) && class_exists($controller)) {
            $instance = container()->get($controller);

            if (is_callable($instance)) {
                return $instance;
            }
        }

        throw new \LogicException('Invalid controller');
    }
}
