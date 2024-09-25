<?php


return [
    App\Providers\AppServiceProvider::class,
    BaoPham\DynamoDb\DynamoDbServiceProvider::class,
    App\Providers\ServiceRegisterServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RepositoriesRegisterServiceProvider::class,
];
