### Introduced
<p>This package is a lightweight service container.</p>

### install
> composer require kittenphp/container

### Example
#### 1. Define the service
<p>Each service is an ordinary PHP class that can provide some functionality:</p>

```php
class Service{
    public function show(){
        echo 'hello world! (kittenphp/container)';
    }
}
```

#### 2. Registration service

```php
use kitten\component\container\Container;
$c=new Container();
$c->set(Service::class,function (){
    return new Service();
});
```

#### 3.Registering Shared Services

```php
$c->share(Service::class,function (){
   return new Service();
});
```

#### 4. Registering multiple services

```php
class ServiceProvider implements ServiceProviderInterface{

    function register(ExpandContainerInterface $container)
    {
        $container->share(ServiceA::class,function (){
            return new ServiceA();
        });
        $container->share(ServiceB::class,function (){
            return new ServiceB();
        });
        $container->share(ServiceC::class,function (){
            return new ServiceC();
        });
    }
}
$c->addServiceProvider(new ServiceProvider());
```

#### 5. Get Service

```php
$c->get(Service::class)->show();
```

