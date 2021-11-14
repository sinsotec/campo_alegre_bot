<?php
use App\Http\Controllers\BotManController;
use App\articulo;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');


$botman->hears('/start', function($bot){
    $bot->reply('Hola ' . $bot->getUser()->getFirstname() . ', soy Alva tu nueva asistente 🧑‍💼, te ayudaré a mantenerte informado sobre lo que hace Sergio con Campo Alegre. ');
    $bot->typesAndWaits(2);
    $bot->reply('Si necesita algo, solo escribelo 🖊, si no sabe que decir, escriba *ayuda*' , ['parse_mode' => 'Markdown']);
});

$botman->hears('ayuda', function($bot){
    $bot->reply('Soy nueva en este puesto así que no sé hace muchas cosas, por ahora solo puedo decirte el inventario y el stock de un articulo');
    $bot->reply('Para ello escribe *inventario* o *articulos*', ['parse_mode' => 'Markdown']);
});

$botman->hears('enviar', function($bot){
    $bot->reply('voy a enviar un mensaje');
    $bot->say('holasdfasdfa', '412668735', TelegramDriver::class);
});

$botman->hears('sergio', function($bot) use ($botman){
    $bot->reply('voy a enviar un mensaje a Sergio');
    $botman->say('hola Sergio, Orlando me pidio que te enviara un mensaje', '759625200', TelegramDriver::class);
});

$botman->hears('laura', function($bot) use ($botman){
    $bot->reply('voy a enviar un mensaje a Laura');
    $botman->say('hola Laura, Orlando me pidio que te enviara un mensaje', '412668735', TelegramDriver::class);
});


$botman->hears('id', function($bot){
    $bot->reply($bot->getUser()->getId());
});

$botman->hears('Hola', function ($bot) {
    $bot->reply('Hola ' . $bot->getUser()->getFirstname() . ' 🙋‍♀️, ¿qué puedo hacer por ti? ', [ 'parse_mode' => 'Markdown' ]);
    $text = "here is my text.  and this is a new line \n another new line";
    //$bot->reply($text, [ 'parse_mode' => 'Markdown' ]);
    //$bot->reply('Hello11111!');
});


$botman->hears('inventario', function ($bot){
    $bot->startConversation(new App\Conversations\beginConversation([
        'solicitud' => 'inventario'
    ]));
});

$botman->hears('articulos|Artículos', function ($bot){
    $bot->startConversation(new App\Conversations\beginConversation([
        'solicitud' => 'articulos'
    ]));
});


$botman->hears('menu', BotManController::class.'@menu');


$botman->fallback(function($bot) {
    $message = $bot->getMessage();
    $bot->reply('Lo siento, no comprendo tu solicitud, soy nueva en este empleo, aún sigo aprendiendo.');
    $bot->reply('Por ahora solo puedo indicarte el estado del inventario y el stock de un articulo.');
    $bot->reply('Para ello escribe *inventario* o *articulos*', ['parse_mode' => 'Markdown']);

});