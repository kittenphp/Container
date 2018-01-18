<?php


namespace kitten\component\container;


interface BootServiceProviderInterface extends ServiceProviderInterface
{
    function boot(ExpandContainerInterface $container);
}