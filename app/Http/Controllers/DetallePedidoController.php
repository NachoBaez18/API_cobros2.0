<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePedido;
use App\Models\Arqueo;
use App\Models\Pedido;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use Carbon\Carbon;

class DetallePedidoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request;
        $query = DetallePedido::with(['pedido' => function ($querys){
            $querys->orderBy('fecha_entrega','desc');
        }]);

        $idPedido = $request->query('id_pedido');
        if ($idPedido) {
            $query->where('id_pedido', '=', $idPedido);
        }

        $fecha_vencimiento = $request->query('fecha_vencimiento');
        if ($fecha_vencimiento) {
            $query->where('fecha_vencimiento', 'LIKE', '%'.$fecha_vencimiento.'%');
        }

        $cuota_numero = $request->query('cuota_numero');
        if ($cuota_numero) {
            $query->where('cuota_numero', '=', $cuota_numero);
        }
  
        $monto = $request->query('monto');
        if ($monto) {
            $query->where('monto', '=', $monto);
        }

        $cancelado = $request->query('cancelado');
        if ($cancelado) {
            $query->where('cancelado', 'LIKE', '%'.$cancelado.'%');
        }

        $paginar = $request->query('paginar');
        $listar = (boolval($paginar)) ? 'paginate' : 'get';

        $data = $query->$listar();
        
        return $this->sendResponse(true, 'Listado obtenido exitosamente', $data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_pedido = $request->input("id_pedido");
        $fecha_vencimiento = $request->input("fecha_vencimiento");
        $monto = $request->input("monto");
        $cuota_numero = $request->input("cuota_numero");

        $validator = Validator::make($request->all(), [
            'id_pedido'  => 'required',
            'fecha_vencimiento'  => 'required',
            'monto'  => 'required',
            'cuota_numero' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, 'Error de validacion', $validator->errors(), 400);
        }

        $detallepedido = new DetallePedido();
        $detallepedido->id_pedido = $id_pedido;
        $detallepedido->fecha_vencimiento = $fecha_vencimiento;
        $detallepedido->monto = $monto;
        $detallepedido->cuota_numero = $cuota_numero;
        $detallepedido->cancelado ='N';

        if ($detallepedido->save()) {
            return $this->sendResponse(true, 'Pedido detalle registrado', $detallepedido, 201);
        }
        
        return $this->sendResponse(false, 'Pedido detalle no registrado', null, 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detallepedido = DetallePedido::find($id);

        if (is_object($detallepedido)) {
            return $this->sendResponse(true, 'Se listaron exitosamente los registros', $detallepedido, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id_pedido = $request->input("id_pedido");
        $fecha_vencimiento = $request->input("fecha_vencimiento");
        $monto = $request->input("monto");
        $cuota_numero = $request->input("cuota_numero");
        $cancelado = $request->input("cancelado");
        $mora = $request->input("mora");
        $moraDias = $request->input("moraDias");
        $moraCancelado = $request->input("moraCancelado");

        $validator = Validator::make($request->all(), [
            'id_pedido'  => 'required',
            'fecha_vencimiento'  => 'required',
            'monto'  => 'required',
            'cuota_numero' => 'required',
            'mora'  => 'required',
            'moraDias' => 'required',
            'moraCancelado' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, 'Error de validacion', $validator->errors(), 400);
        }

        $arqueo = Arqueo::orderBy('created_at', 'desc')->take(1)->first();
        if($arqueo->cerrado === 'N'){
      


        $detallepedido = DetallePedido::find($id);
        if ($detallepedido) {
            $detallepedido->id_pedido = $id_pedido;
            $detallepedido->fecha_vencimiento = $fecha_vencimiento;
            $detallepedido->monto = $monto;
            $detallepedido->cuota_numero = $cuota_numero;
            $detallepedido->cancelado =$cancelado;
            $detallepedido->mora =$mora;
            $detallepedido->moraDias =$moraDias;
            $detallepedido->moraCancelado =$moraCancelado;

            $pedido = Pedido::find($id_pedido);
            if($pedido){
                $pedido->moraCancelado = ($pedido->moraCancelado == 'S') ? 'N' : 'N';
                $pedido->update();
            }

            if ($detallepedido->save()) {
                return $this->sendResponse(true, 'Detalle actualizado', $detallepedido, 200);
            }
            
            return $this->sendResponse(false, 'Detalle no actualizado', null, 400);
        }
        
        return $this->sendResponse(false, 'No se encontro el detalle', null, 404);
    }
    return $this->sendResponse(false, 'Favor cargar la caja', $arqueo, 404);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detallepedido = DetallePedido::find($id);

        if ($detallepedido) {
            $detallepedido->cancelado = ($detallepedido->cancelado == 'N') ? 'S' : 'S';
            
            if ($detallepedido->update()) {
                return $this->sendResponse(true, 'Detalle eliminado', $detallepedido, 200);
            }
            
            return $this->sendResponse(false, 'Detalle no eliminado', $detallepedido, 400);
        }
        
        return $this->sendResponse(true, 'No se encontro pedido', $detallepedido, 404);
    }

    public function pagadoParcial(Request $request, $id){

        $id_pedido = $request->input("id_pedido");
        $fecha_vencimiento = $request->input("fecha_vencimiento");
        $monto = $request->input("monto");
        $cuota_numero = $request->input("cuota_numero");
        $cancelado = $request->input("cancelado");
        $mora = $request->input("mora");
        $moraDias = $request->input("moraDias");
        $moraCancelado = $request->input("moraCancelado");

        $validator = Validator::make($request->all(), [
            'id_pedido'  => 'required',
            'fecha_vencimiento'  => 'required',
            'monto'  => 'required',
            'cuota_numero' => 'required',
            'mora'  => 'required',
            'moraDias' => 'required',
            'moraCancelado' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, 'Error de validacion', $validator->errors(), 400);
        }
        $arqueo = Arqueo::orderBy('created_at', 'desc')->take(1)->first();
        if($arqueo->cerrado === 'N'){
        $arqueo->cobrado =  $arqueo->cobrado + $monto;
        $arqueo->update();

        //le ponemos la fecha de la siguente cuota para que le aparezca que debe mora
        // $detalle_fecha = DetallePedido::where('id_pedido',$id_pedido)->where('id',$id + 1)->first();
        // $fecha_nueva = $detalle_fecha ? $detalle_fecha->fecha_vencimiento : $fecha_vencimiento;


        $detallepedido = DetallePedido::find($id);
        if ($detallepedido) {
            $detallepedido->id_pedido = $id_pedido;
            $detallepedido->fecha_vencimiento = $fecha_vencimiento;
            $detallepedido->monto = $monto;
            $detallepedido->cuota_numero = $cuota_numero;
            $detallepedido->cancelado =$cancelado;
            $detallepedido->mora =$mora;
            $detallepedido->moraDias =$moraDias;
            $detallepedido->moraCancelado =$moraCancelado;
            $detallepedido->id_arqueo = $arqueo->id;
            if ($detallepedido->save()) {
                
                return $this->sendResponse(true, 'Detalle actualizado', $detallepedido, 200);
            }
            
            return $this->sendResponse(false, 'Detalle no actualizado', null, 400);
         }
        
        return $this->sendResponse(false, 'No se encontro el detalle', null, 404);
    }
     return $this->sendResponse(false, 'Favor cargar la caja', $arqueo, 404);
 }


    public function pagadoTotal(Request $request, $id){
        

        $id_pedido = $request->input("id_pedido");
        $fecha_vencimiento = $request->input("fecha_vencimiento");
        $monto = $request->input("monto");
        $cuota_numero = $request->input("cuota_numero");
        $cancelado = $request->input("cancelado");
        $mora = $request->input("mora");
        $moraDias = $request->input("moraDias");
        $moraCancelado = $request->input("moraCancelado");

        $validator = Validator::make($request->all(), [
            'id_pedido'  => 'required',
            'fecha_vencimiento'  => 'required',
            'monto'  => 'required',
            'cuota_numero' => 'required',
            'mora'  => 'required',
            'moraDias' => 'required',
            'moraCancelado' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, 'Error de validacion', $validator->errors(), 400);
        }

        $detallepedido = DetallePedido::find($id);
        $arqueo = Arqueo::orderBy('created_at', 'desc')->take(1)->first();
        if($arqueo->cerrado === 'N'){
        $arqueo->cobrado = $arqueo->cobrado + $monto + $mora;
        $arqueo->update();

        if ($detallepedido) {
            $detallepedido->id_pedido = $id_pedido;
            $detallepedido->fecha_vencimiento = $fecha_vencimiento;
            $detallepedido->monto = $monto;
            $detallepedido->cuota_numero = $cuota_numero;
            $detallepedido->cancelado =$cancelado;
            $detallepedido->mora =$mora;
            $detallepedido->moraDias =$moraDias;
            $detallepedido->moraCancelado =$moraCancelado;
            $detallepedido->id_arqueo = $arqueo->id;

            //sentecia para darle Cuotas totalmente pagada osea el pedido
            $pedido = Pedido::find($id_pedido);
            if($pedido->n_cuota === $cuota_numero){
                $pedido->cancelado = ($pedido->cancelado == 'N') ? 'S' : 'S';
               // $pedido->moraCancelado = ($pedido->moraCancelado == 'N') ? 'S' : 'S';
                $pedido->update();
            }
            if ($detallepedido->save()) {
                $Pedido = Pedido::with(['detalles'])->find($id_pedido);
                if($Pedido->moraCancelado == 'N'){
                      $activo = false;
                      foreach($Pedido->detalles as $detalle ){
                         if($detalle->moraCancelado =='N'){
                             $activo = true;
                         }
                      }
                    if($activo == false){
                        $Pedido->moraCancelado = ($Pedido->moraCancelado == 'N') ? 'S' : 'S';
                        $Pedido->update();
                    }
                }
                
                return $this->sendResponse(true, 'Detalle actualizado', $detallepedido, 200);
            }
            
            return $this->sendResponse(false, 'Detalle no actualizado', null, 400);
         }
        
        return $this->sendResponse(false, 'No se encontro el detalle', null, 404);
     }

        return $this->sendResponse(false, 'Favor cargar la caja',null, 404);
  }

  public function pagoParcialMora(Request $request){
    $mora = $request->input("mora");
    $id = $request->input("id");
    $monto = $request->input("montoArqueo");
 
    $validator = Validator::make($request->all(), [
        'mora'  => 'required',
        'id' => 'required',

    ]);

    if ($validator->fails()) {
        return $this->sendResponse(false, 'Error de validacion', $validator->errors(), 400);
    }
    $detallepedido = DetallePedido::find($id);
    $arqueo = Arqueo::orderBy('created_at', 'desc')->take(1)->first();
    if($arqueo->cerrado === 'N'){
    $arqueo->cobrado = $arqueo->cobrado + $monto;
    $arqueo->update();

    if ($detallepedido) {
        $detallepedido->mora =$mora;
        $detallepedido->id_arqueo = $arqueo->id;
        if ($detallepedido->save()) {
            return $this->sendResponse(true, 'Detalle actualizado', $detallepedido, 200);
        }
        return $this->sendResponse(false, 'Detalle no actualizado', null, 400);
     }
    return $this->sendResponse(false, 'No se encontro el detalle', null, 404);
    }
    return $this->sendResponse(false, 'Favor cargar la caja',null, 404);
 }
 public function updateFechaVencimiento(Request $request){
     $id = $request->input("id");
     $dato = $request->input("dato");
        $detalles = DetallePedido::select('id')
        ->where('id_pedido',$id)
        ->get();
            if($detalles){
                foreach($detalles as $detalle){
                    $detallepedido = DetallePedido::find($detalle->id);
                    $detallepedido->fecha_vencimiento = Carbon::parse($detallepedido->fecha_vencimiento)->addDay($dato)->format('Y-m-d');
                    $detallepedido->update(); 
                }
                return $this->sendResponse(true, 'Se actualizaron correctamente las fechas', null,200);

            }
            return $this->sendResponse(false, 'No se pudo actualizar fecha', null,400);

 }
 public function getDetalles($id_pedido){

    $detalles = DetallePedido::where('id_pedido',$id_pedido)->where(function($q){
        $q->orWhere('cancelado','N')->orWhere('moraCancelado','N');
    })->get();
     
    if($detalles){
        return $this->sendResponse(true, 'Se obtuvieron los detalles', $detalles,200); 
    }
    return $this->sendResponse(false, 'No se pudo obtener datos', null,400);

 }

 public function getDetallesAll($id_pedido){

    $detalles = DetallePedido::where('id_pedido',$id_pedido)->get();
     
    if($detalles){
        return $this->sendResponse(true, 'Se obtuvieron los detalles', $detalles,200); 
    }
    return $this->sendResponse(false, 'No se pudo obtener datos', null,400);


 }

 public function rollback(Request $request){

    $detalles = DetallePedido::where('id',$request->id)->first();
    $pedido   = Pedido::where('id',$detalles->id_pedido)->first();

    $resta = 0;

    switch($request->accion) {
        case('total'):

            $detalles->cancelado     = 'N';
            if($detalles->moraDias > 0){
                $detalles->moraCancelado = 'N';
                $pedido->moraCancelado   = 'N';
                $pedido->save(); 
            }

            $resta = $detalles->monto + $detalles->mora;
   
            
            $detalles->save();
            break;

        case('parcial'):
             
            $detalles->monto     = ($pedido->monto + ($pedido->monto * 40) / 100) / $pedido->n_cuota;
            $detalles->cancelado = 'N';

            $resta = $detalles->monto;
          
            $detalles->save();

            break;

        case('noPago'):

            $detalles->fecha_vencimiento = Carbon::parse($detalles->fecha_vencimiento)->addDay(-1)->format('Y-m-d');
            $detalles->mora              = $detalles->mora - 5000;
            $detalles->moraDias          = $detalles->moraDias - 1;
 
               $detalleCount = DetallePedido::where('id_pedido',$detalles->id_pedido)
                                            ->where('moraCancelado','N')->count();

                if ($detalles->moraDias == 1){
                    $detalles->moraCancelado = 'S';
                }
                if ($detalleCount == 1){
                    $pedido->moraCancelado = 'S';
                    $pedido->save();
                }                      
            $detalles->save();
           
             break;

        case('moraTotal'):
             
            $detalles->moraCancelado = 'N';
            $pedido->moraCancelado   = 'N';
            $resta = $detalles->mora;
            $pedido->save();
            $detalles->save();

            break;

        case('moraParcial'):
             
            $detalles->mora =$detalles->mora + $request->mora;
            $resta = $request->mora;
            $detalles->save();
    
                break;
        default:
        $this->sendResponse(true, 'Ocurrio un error en la reversa',null,401);
    }

    if($detalles){
        $arqueo   = Arqueo::where('id',$detalles->id_arqueo)->first();


        $arqueo->cobrado   = $arqueo->cobrado - $resta;
        $arqueo->arqueoDia = $arqueo->caja + $arqueo->cobrado - $arqueo->entregado;
        $arqueo->save();

        return $this->sendResponse(true, 'Se reverso correctamente',null,200);
    }

 }
   
}
