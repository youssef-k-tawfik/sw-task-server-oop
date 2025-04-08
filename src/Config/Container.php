<?php

declare(strict_types=1);

namespace App\Config;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class Container
 * 
 * A simple Dependency Injection Container implementation.
 * Provides methods to register, resolve, and retrieve dependencies.
 */
final class Container implements ContainerInterface
{
    /**
     * @var array Stores registered services and their instances.
     */
    private static $container = [];

    /**
     * Retrieve an instance of the given class or service.
     *
     * @param string $id The class name or service identifier.
     * @return mixed The resolved instance.
     * @throws \Exception If the class or service cannot be resolved.
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return self::$container[$id];
        }

        return $this->resolve($id);
    }

    /**
     * Check if a service or class is registered in the container.
     *
     * @param string $id The class name or service identifier.
     * @return bool True if the service is registered, false otherwise.
     */
    public function has(string $id): bool
    {
        return isset(self::$container[$id]);
    }

    /**
     * Register a service or instance in the container.
     *
     * @param string $id The class name or service identifier.
     * @param mixed $value The instance or factory to register.
     * @return void
     */
    public function set(string $id, $value): void
    {
        self::$container[$id] = $value;
    }

    /**
     * Resolve a class or service by creating its instance.
     *
     * @param string $id The class name or service identifier.
     * @return mixed The resolved instance.
     * @throws \Exception If the class cannot be instantiated or dependencies cannot be resolved.
     */
    private function resolve(string $id)
    {
        try {
            $reflectionClass = new ReflectionClass($id);

            // Check if the class is instantiable
            if (!$reflectionClass->isInstantiable()) {
                throw new ReflectionException("Class {$id} is not instantiable");
            }

            $constructor = $reflectionClass->getConstructor();

            // If no constructor, create a new instance and register it
            if (is_null($constructor)) {
                $object = new $id;
                $this->set($id, $object);
                return $object;
            }

            $parameters = $constructor->getParameters();

            // If no parameters, create a new instance and register it
            if (empty($parameters)) {
                $object = new $id;
                $this->set($id, $object);
                return $object;
            }

            // Resolve dependencies recursively
            $dependencies = $this->extractDependencies($parameters, $id);

            // Create a new instance with resolved dependencies
            $object = $reflectionClass->newInstanceArgs($dependencies);
            $this->set($id, $object);

            return $object;
        } catch (ReflectionException $e) {
            throw new \Exception("Unable to resolve {$id}: " . $e->getMessage());
        }
    }

    /**
     * Extract and resolve dependencies for a class constructor.
     *
     * @param array $parameters The constructor parameters.
     * @param string $id The class name or service identifier.
     * @return array The resolved dependencies.
     * @throws ReflectionException If a dependency cannot be resolved.
     */
    private function extractDependencies(
        array $parameters,
        string $id
    ): array {
        return array_map(
            function (\ReflectionParameter $parameter) use ($id) {
                $name = $parameter->getName();
                $type = $parameter->getType();

                if ($type === null) {
                    throw new ReflectionException(
                        "Missing type hint for {$name} in {$id}"
                    );
                }

                $classType = $type->getName();
                if (
                    !$type->isBuiltin()
                    && $type instanceof \ReflectionNamedType
                ) {
                    if ($classType === self::class) {
                        // Return the container itself if requested
                        return $this;
                    }
                    return $this->get($classType);
                }

                // Throw an exception for invalid or unsupported parameters
                throw new ReflectionException(
                    "Invalid parameter {$name} in {$id}"
                );
            },
            $parameters
        );
    }
}
