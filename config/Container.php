<?php

class Container {
    //private PDO $pdo;
    private array $instances = [];
    private array $factories = [];

    public function get(string $class) :object {
        if(isset($this->instances[$class]))
            return $this->instances[$class];

        if(isset($this->factories[$class])) {
            $this->instances[$class] = ($this->factories[$class])();
            return $this->instances[$class];
        }
        $instance = $this->resolve($class);

        $this->instances[$class] = $instance;
        return $instance;
    }

    private function resolve(string $class) : object {
        $reflector = new ReflectionClass($class);

        if(!$reflector -> isInstantiable()) {
            throw new Exception("Class {$class} is not instantiable");
        }
        $constructor = $reflector->getConstructor();
        if($constructor === null)
            return new $class();
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach($parameters as $parameter) {
            $type = $parameter->getType();

            if(!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                    continue;
                }
                throw new Exception("Parameter {$parameter->getName()} cannot be resolved ");           
            }
            $dependencies[] = $this->get($type->getName());
        }
        return $reflector->newInstanceArgs($dependencies);
    }
    public function instance(string $class, object $instance) {
        $this->instances[$class] = $instance;
    }
    public function factory(string $class, callable $factory) {
        $this->factories[$class] = $factory;
    }
}