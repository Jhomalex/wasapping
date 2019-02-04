<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Aloha\Twilio\Twilio;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
//979377646
   public function enviarTwilio($mensaje,$celular){
      $sid    = "ACdc70ec10156598ec7c20a96c3d6a5236"; 
      $token  = "5b658a918d42e73bb2ae18dfe77fede5"; 
      $twilio = new Client($sid, $token); 
      
      $message = $twilio->messages 
         ->create("whatsapp:+51".$celular, array( 
            "from" => "whatsapp:+14155238886",       
            "body" => $mensaje 
            ) 
         ); 
 
      print($message->sid);
      return 'Ok';
   }

   public function enviarMensajes(Request $request){
      $mensaje = request()->mensaje;
      $contactos = request()->contactos;
      foreach ($contactos as $contacto) {
         $mensajePreparado = $this->prepararMsj($mensaje,$contacto->nombre);
         //$this->enviarTwilio($mensajePreparado,$contacto->celular);
      }
   }

   public function prepararMsj($mensaje, $nombre){
      $mensajePreparado = "";
      for($i=0;$i<strlen($mensaje);$i++){
         if($mensaje[$i]=="@"){
            $mensajePreparado = $mensajePreparado.$nombre;
         }else{
            $mensajePreparado = $mensajePreparado.$mensaje[$i];
         }
      }
      return $mensajePreparado;
   }

}
