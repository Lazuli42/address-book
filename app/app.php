<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();
    if (empty($_SESSION['contacts_list'])) {
        $_SESSION['contacts_list'] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render( 'home.html.twig', array ("contacts" => Contact::getAll()) );
    });

    $app->post("/new_contact", function() use ($app) {
        $contact = new Contact($_POST['name'], $_POST['phone'], $_POST['address']);
        $contact->save();
        return $app['twig']->render( 'home.html.twig', array ("contacts" => Contact::getAll()) );
    });

    $app->post("/clear_list", function() use ($app) {
        Contact::clearList();
        return $app['twig']->render( 'home.html.twig', array ("contacts" => Contact::getAll()) );
    });

    return $app;
 ?>
