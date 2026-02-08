<?php

namespace Silicon\DI;

use ReflectionClass;

class Container
{
    private array $instances = [];
    private array $bindings = [];

    public function set(string $id, callable|string $concrete): void
    {
        $this->bindings[$id] = $concrete;
    }

    /**
     * @template U of object
     * @param class-string<U>| string $id
     * @return U
     */
    public function get(string $id)
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (isset($this->bindings[$id])) {
            $concrete = $this->bindings[$id];
            $object = is_callable($concrete)
                ? $concrete($this)
                : $this->build($concrete);
        } else {
            $object = $this->build($id);
        }
        return $this->instances[$id] = $object;
    }

    private function build(string $class): object
    {
        if (!class_exists($class)) {
            throw new \RuntimeException("Class $class not found");
        }

        $ref = new ReflectionClass($class);
        $ctor = $ref->getConstructor();

        if (!$ctor) {
            return new $class();
        }

        $args = [];
        foreach ($ctor->getParameters() as $param) {
            $type = $param->getType();

            if (!$type || !($type instanceof \ReflectionNamedType) || $type->isBuiltin()) {
                throw new \RuntimeException(
                    "Cannot autowire parameter {$param->getName()} of $class"
                );
            }

            $args[] = $this->get($type->getName());
        }

        return $ref->newInstanceArgs($args);
    }
}
