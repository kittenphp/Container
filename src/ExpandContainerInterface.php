<?php


namespace kitten\component\container;
use Psr\Container\ContainerInterface;

interface ExpandContainerInterface extends ContainerInterface
{
    /**
     * Adds an entry to the container.
     * @param string   $id       Identifier of the entry.
     * @param \Closure $value    The closure to invoke when this entry is resolved.
     */
    function set(string $id, \Closure $value);

    /**
     * Adds a shared (singleton) entry to the container.
     * @param string   $id       Identifier of the entry.
     * @param \Closure $value    The closure to invoke when this entry is resolved.
     */
    function share(string $id, \Closure $value);

    function addServiceProvider(ServiceProviderInterface $provider);

    function boot();
}