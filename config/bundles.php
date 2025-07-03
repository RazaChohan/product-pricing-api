<?php

return [
    Liip\MonitorBundle\LiipMonitorBundle::class => ['all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class => ['dev' => true],
    AutoMapperPlus\AutoMapperPlusBundle\AutoMapperPlusBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    App\FriendsOfCarrierIntegration\FriendsOfCarrierIntegrationBundle::class => ['all' => true],
    App\CarrierIntegration\CarrierIntegrationBundle::class => ['all' => true],
    App\CarrierIntegrationConsumer\CarrierIntegrationConsumerBundle::class => ['all' => true],
    App\LabelDataProvider\LabelDataProviderBundle::class => ['all' => true],
    App\CarrierIntegrationEntities\CarrierIntegrationEntitiesBundle::class => ['all' => true],
    App\MockServices\MockServiceBundle::class => ['all' => true],
    WF\EnvConfigSymfonyBundle\WayfairEnvConfigBundle::class => ['all' => true],
    WF\LoggingSymfonyBundle\WayfairLoggingBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
];
