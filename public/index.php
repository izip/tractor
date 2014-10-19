<?php


error_reporting(E_ALL);

try {

    /**
     * Read the configuration
     */
    $config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../app/config/config.ini');

    $loader = new \Phalcon\Loader();

    /**
     * We're a registering a set of directories taken from the configuration file
     */
    $loader->registerDirs(
        array(
            __DIR__ . $config->application->controllersDir,
            __DIR__ . $config->application->pluginsDir,
            __DIR__ . $config->application->libraryDir,
            __DIR__ . $config->application->modelsDir,
        )
    )->register();

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new \Phalcon\DI\FactoryDefault();

    /**
     * We register the events manager
     */
    $di->set('dispatcher', function () use ($di) {

        $eventsManager = $di->getShared('eventsManager');

        $security = new Security($di);

        /**
         * We listen for events in the dispatcher using the Security plugin
         */
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });


    /**
     * The URL component is used to generate all kind of urls in the application
     */
    $di->set('url', function () use ($config) {
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($config->application->baseUri);
        return $url;
    });


    $di->set('view', function () use ($config) {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir(__DIR__ . $config->application->viewsDir);

        $view->registerEngines(array(
            ".volt" => 'volt'
        ));

        return $view;
    });


    $di->set('volt', function ($view, $di) {

        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

        $volt->setOptions(array(
            "compiledPath" => "../cache/volt/"
        ));

        return $volt;
    }, true);


    $di->set('db', function () use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name,
            "options" => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            )
        ));
    });

    /**
     * If the configuration specify the use of metadata adapter use it or use memory otherwise
     */
    $di->set('modelsMetadata', function () use ($config) {
        if (isset($config->models->metadata)) {
            $metaDataConfig = $config->models->metadata;
            $metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
            return new $metadataAdapter();
        }
        return new Phalcon\Mvc\Model\Metadata\Memory();
    });

    /**
     * Start the session the first time some component request the session service
     */
    $di->set('session', function () {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    /**
     * Register the flash service with custom CSS classes
     */
    $di->set('flash', function () {
        return new Phalcon\Flash\Direct(array(
            'error' => 'alert alert-error',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
    });

    $di->set('cache', function () {

        $ultraFastFrontend = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 3600
        ));

        $fastFrontend = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        $slowFrontend = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 604800
        ));

// Backends от самого быстрого до самого медленного
        $cache = new \Phalcon\Cache\Multiple(array(
            new Phalcon\Cache\Backend\Apc($ultraFastFrontend, array(
                "prefix" => 'cache_apc',
            )),
            new Phalcon\Cache\Backend\Memcache($fastFrontend, array(
                "prefix" => 'mem_cache',
                "host" => "localhost",
                "port" => "11211"
            )),
            new Phalcon\Cache\Backend\File($slowFrontend, array(
                "prefix" => 'file_cache',
                "cacheDir" => "../cache/file"
            ))
        ));

        return $cache;
    });


    $di->set('modelsCache', function () {

        //Cache data for one day by default
        $frontCache = new \Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));


        return $cache;
    });


//    $di->set('router' , function() {
//
//        $router = new Phalcon\Mvc\Router(false);
//
//
//        $router->add(
//            "/auth",
//            array(
//                "controller" => "user",
//                "action"     => "auth",
//            )
//        );
//        $router->add(
//            "/reg",
//            array(
//                "controller" => "user",
//                "action"     => "regsocial",
//            )
//        );
//    return $router;
//    });


    /**
     * Register a user component
     */
    $di->set('elements', function () {
        return new Elements();
    });
    $di->set('ic', function () {
        return new Ic();
    });
    $di->set('assets', function () {
        return new Phalcon\Assets\Manager();
    }, true);


    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}