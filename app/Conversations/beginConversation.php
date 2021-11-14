<?php

namespace App\Conversations;

use App\articulo;
use App\empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;


class beginConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    protected $params;

    public function __construct($params) {
        $this->params = $params;
    }
    
    
    public function run()
    {
        
        //$empresas = empresa::where('producto', 'ADMI')->get();
      
       // $question = Question::create("Selecciona la empresa a consultar:");

        //foreach($empresas as $empresa){

           // $question->addButtons([
           //     Button::create("desc_empresa")->value("AXN000183")
            //]);

        //}

        $this->params['cod_empresa'] = "AXN000183";
            
        $this->bot->startConversation(new inventarioConversation($this->params));

      //  $this->ask($question, function($answer){
       //     $this->params['cod_empresa'] = "AXN000183";
            
        //    $this->bot->startConversation(new inventarioConversation($this->params));
            
       // }); 
    }
}
