<?php


namespace kitten\component\container;


interface ServiceProviderInterface
{
    function register(ExpandContainerInterface $container);
}