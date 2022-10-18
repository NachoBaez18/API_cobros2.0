<?php

namespace App\Services;

use App\Models\Pedido;
use Carbon\Carbon;
use App\Models\DetallePedido;


class pasarDia {
    public function sumarDia(){
        $query = Pedido::whereHas('detalles', function ($q) {
            $fecha = new Carbon('America/Asuncion');
            $fechaa =$fecha->subHour(5);
    $q->where('fecha_vencimiento', '=',$fechaa->format('Y-m-d'))
    ->where('cancelado', '=', 'N');
    })->with(['detalles'  => function ($query) {
    $fechaVencimiento =Carbon::now();
        $fecha = new Carbon('America/Asuncion');
            $fechaa =$fecha->subHour(5);
    $query->where('fecha_vencimiento', '=', $fechaa->format('Y-m-d'))
    ->where('cancelado', '=', 'N');

    }])->get();
    //return $query;
    if(!empty($query)){
        foreach($query as $pedido){
            foreach($pedido->detalles as $detalle){
              $detallepedido = DetallePedido::find($detalle->id);
              $detallepedido->fecha_vencimiento = Carbon::parse($detallepedido->fecha_vencimiento)->addDay(1)->format('Y-m-d');
              $detallepedido->update();
            }
         }
          return 'Se actualizarom todos los pedidos';
    }else{
        return 'No hay nada que actualizar';
    }
    
    }

}