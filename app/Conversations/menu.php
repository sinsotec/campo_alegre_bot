<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Contact;

use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class menu extends Conversation
{
    protected $phone;

    public function teclado()
    {
        $this->ask('Selecciona un modulo 👇', function ($Answer) {
                $this->say('Haz elegido ' . $Answer);
            },
            Keyboard::create()
                ->type(Keyboard::TYPE_KEYBOARD)
                ->oneTimeKeyboard(true)
                ->resizeKeyboard()
                ->addRow(KeyboardButton::create('Ventas')->callbackData('dijiste ventas'))
                ->toArray()
        );
    }

    public function run()
    {
        // This will be called immediately
       // $this->askPhone();
       $this->teclado();
    }

    

}