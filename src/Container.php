<?php


namespace kitten\component\container;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ExpandContainerInterface
{
    private $entries = [];
    /** @var ServiceProviderInterface[] */
    private $providers=[];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!array_key_exists($id, $this->entries)) {
            throw new NotFoundException(sprintf('The entry for %s was not found.', $id));
        }
        // Pass in the container as the only argument to the closure when we invoke it.
        return $this->entries[$id]($this);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id):bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * Adds an entry to the container.
     * @param string $id Identifier of the entry.
     * @param \Closure $value The closure to invoke when this entry is resolved.
     */
    function set(string $id, \Closure $value)
    {
        $this->entries[$id] = $value;
    }

    /**
     * Adds a shared (singleton) entry to the container.
     * @param string $id Identifier of the entry.
     * @param \Closure $value The closure to invoke when this entry is resolved.
     */
    function share(string $id, \Closure $value)
    {
        $this->entries[$id] = function ($container) use ($value) {
            static $resolvedValue;
            if (is_null($resolvedValue)) {
                $resolvedValue = $value($container);
            }
            return $resolvedValue;
        };
    }

    function addServiceProvider(ServiceProviderInterface $provider)
    {
        $provider->register($this);
        $this->providers[]=$provider;
    }

    function boot()
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof BootServiceProviderInterface){
                $provider->boot($this);
            }
        }
    }
}