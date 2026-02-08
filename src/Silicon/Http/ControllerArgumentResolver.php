<?php

namespace Silicon\Http;

final class ControllerArgumentResolver
{
    private function getReflection(callable|object $controller): \ReflectionMethod
    {
        if (is_array($controller)) {
            return new \ReflectionMethod($controller[0], $controller[1]);
        }

        if (is_object($controller) && method_exists($controller, '__invoke')) {
            return new \ReflectionMethod($controller, '__invoke');
        }

        throw new \RuntimeException('Invalid controller');
    }

    public function resolve(
        callable|object $controller,
        Request $request
    ) {
        $reflection = $this->getReflection($controller);

        foreach ($reflection->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (!$type instanceof \ReflectionNamedType) {
                throw new \RuntimeException(
                    "Cannot resolve untyped parameter \${$parameter->getName()}"
                );
            }

            $class = $type->getName();

            if ($class === Request::class) {
                return $request;
            }

            if (is_subclass_of($class, CustomRequest::class)) {
                $customRequest = new $class($request);
                $customRequest->validate();
                return $customRequest;
            }

            throw new \RuntimeException(
                "Cannot resolve argument \${$parameter->getName()} of type {$class}"
            );
        }
    }
}
