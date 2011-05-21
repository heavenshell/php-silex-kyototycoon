<?php
require_once 'silex.phar';
require_once dirname(__DIR__) . '/src/KyotoTycoonExtension.php';

$ktpath = getenv('KT_PATH');

$app = new Silex\Application();
$app->register(new \KyotoTycoonExtension(), array(
    'kt.class_path' => $ktpath,
    'kt.options'    => array('port' => 19780)
));

$app->get('/set', function () use ($app) {
    $client = $app['kt.client'];
    $client->set('test', 'ok');

    return json_encode(true);
});

$app->get('/get', function () use ($app) {
    $client = $app['kt.client'];
    $result = $client->get('test');

    return json_encode($result);
});

$app->get('/remove', function () use ($app) {
    $client = $app['kt.client'];
    $result = $client->remove('test');

    return json_encode($result);
});

$app->get('/remove/fail', function () use ($app) {
    $client = $app['kt.client'];
    $result = $client->remove('test_fail');

    return json_encode($result);
});

if (getenv('SILEX_TEST')) {
    return $app;
}
$app->run();
