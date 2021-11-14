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



class inventarioConversation extends Conversation
{
    
    /**
     * Start the conversation
     */
    protected $params;
    protected $count = 0;    

    public function __construct($params) {
        $this->params = $params;
    }


    public function run()
    {
        config()->set('database.connections.sqlsrv.database', $this->params['cod_empresa']);
        switch($this->params['solicitud']) {
            case 'articulos':
                $this->params['articulos'] = articulo::where('tipo', '!=', 'S')->get();
                $this->mostrarStock();
                break;
            case 'inventario':
                $this->mostrarInventario();
                break;
        }
        
      
    }
    
    
    public function mostrarStock(){

       // $articulos = articulo::where('tipo', '!=', 'S')->get();
        $question = Question::create("Selecciona el articulo a consultar");

        foreach($this->params['articulos'] as $articulo){

            $question->addButtons([
                Button::create($articulo['art_des'])->value($articulo['co_art'])
            ]);
 
         }
 
        $this->ask($question, function($answer) {

            config()->set('database.connections.sqlsrv.database', $this->params['cod_empresa']);
          // $this->say(DB::connection()->getDatabaseName());
            $cantidad = DB::table('dbo.v_saStockActual')->where([
                                                        ['co_art', $answer->getText()],
                                                        ['tipo', 'act']
                                                    ])
                                                    ->get();
            if(count($cantidad) > 0){
               $this->say(strval($cantidad[0]->stock));
            }else{
               $this->say('no tiene');
            }
            $question = Question::create("Quieres consultar otro articulo?")
            ->fallback('No es posible en estos momentos')
            ->addButtons([
                Button::create('Si')->value('si'),
                Button::create('No')->value('no'),
            ]);
            
            $this->ask($question, function($answer){
                if($answer->isInteractiveMessageReply()){
                    //$this->count = 0;
                    if($answer->getValue() == 'si'){
                        $this->mostrarStock();
                    }else{
                        return $this->say('Ok, estaré acá si me necesitas.');
                    }
                }else{
                    $this->count++;
                    if($this->count >=4){
                        $this->say('Bueno cabron que parte de que uses los botones no entiendes ');                    
                    }elseif($this->count > 2 && $this->count < 4){
                        $this->say('Me estas haciendo molestar! Por favor usa los botones! acaso no los ves? 👇');
                    }else{
                        $this->say('Debes contestar usando los botones. 👇');                    
                    }
                    $this->repeat();
                }
            });
        });

    }

    protected function mostrarInventario(){
        config()->set('database.connections.sqlsrv.database', $this->params['cod_empresa']);
        //$this->say('estamos probando');
        try{
             $inventario = DB::select('SET NOCOUNT ON; exec [dbo].[RepStockArticulos]');
         }catch (Throwable $e){
             $inventario = $e;
         }
        //$this->say('estamos probando');

        
       $this->say($this->generarInventario($inventario), ['parse_mode' => 'Markdown']);

       $this->say('Estaré acá si necesitas algo.');
        

    }


    public function generarInventario($inventario){
        $resultado = "*Inventario al: " . date("j F, Y, g:i a") ."*\n\n";
        foreach($inventario as $key => $item){
            if($item->StockActual == 0 ){
                continue;
            }
            if($key > 50){
                break;
            }
            $resultado .= sprintf("%.35s", ucfirst(strtolower($item->art_des))) . "\nCant:  " . 
                                    "*".sprintf("%01.2f", $item->StockActual) . " " . $item->des_uni . "*\n\n";
        } 
        
        //$resultado += $inventario[0]->art_des;
        
        return $resultado;
        
    }

    public function seleccionarArticulo(){


        $keyboard = [
            ['300 €', '400 €', '450 €'],
            ['500 €', '600 €', '700 €'],
            ['800 €', '900 €', '1000 €'],
            ['1200 €', '1400 €', '2000 €'],
            ['2500 €', '3000 €', 'any'],
        ];

        $this->ask('How much?',
            function (Answer $answer) {
                //$this->askAdress();
            }, ['reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => true,
                'resize_keyboard' => true
            ])]
        );

    }


}
