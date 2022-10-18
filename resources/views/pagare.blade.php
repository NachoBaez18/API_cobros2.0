<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Impresion de pagare</title>
    </head>
    <body>
     <h1 class="centrar">Pagare a la orden</h1>
    <div>
      <div class="one">
        <label for="">N°</label>
        <input class="bordes" type="text" value="{{$id}}" />
      </div>
      <div class="two">
        <label for="">Gs</label>
        <input   class="bordes" type="text" value="{{number_format($monto)}}" />
      </div>

     <div class="three">
      <label for="">
      Vencimeinto
      </label>
      <input class="input" type="text" value="{{$dia}}">
      <label for="">de</label>
      <input type="text" class="input2" value="{{$mesLetra}}">
      <label for="">del</label>
      <input type="text" class="input8" value="{{$ano}}">
      </div>

      <div class="four">
        <label for="">El dia</label>
        <input class="input" type="text">
        <label for="">de</label>
        <input type="text" class="input3">
        <label for="">de</label>
        <input type="text" class="input3">
        <label for="">pagare</label>
        <input type="text" class="input8">
      </div>

      <div class="five">
        <label for="">al señor/a</label>
        <input type="text" class="input4" >
        <label for="">a su orden</label>
      </div>

      <div class="six">
        <label for="">la suma de guaranies</label>
        <input type="text" class="input5" value="{{$letras}}">
      </div>
      
      <div class="seven">
      <label for="">por igual valor recibido</label>
      <input type="text" class="input6">
      <label for="">a</label>
      <input type="text" class="input6">
      <label for="">entera satisfaccion</label>
    </div>

    <div class="eight">
      <label for="">Este pagare a la orden, devengara un interes de______%mensual, mas una comision de_______% mensual</label>
    </div>
    <div class="nine">
      <label for="">desde la fecha de su (_____________) hasta el dia del pago efectivo, en caso de retardo o incumplimiento total</label>
    </div>

    <div class="ten">
    <label for=""> o parcial a la fecha de vencimiento quedara constituida la mora automatica, sin necesidad de interpretacion</label>
    </div>

    <div class="eleven">
    <label for="">Nombre:</label>
    <input type="text" class="input7" value="{{$nombreCliente}}">
    </div>

    <div class="twelve">
      <label for="">Firma:</label>
      <input type="text" class="input7">
    </div>

    <div class="thirteen">
    <label for="">Direccion:</label>
    <input type="text" class="input7" value="{{$direccion}}">
    </div>

    <div class="fourteen">
    <label for="" >C.I:</label>
    <input type="text" class="input7" value="{{number_format($cedula)}}">
    </div>

    </div>
    </body>
</html>

<style>
  .centrar {
    text-align: center;
  }
  .fourteen{
    margin-left:15px;
    margin-top:20px;
    text-align:right;
  }

  .thirteen{
       position: relative; 
        top: 40px;
    margin-left:15px;
    margin-top:20px;

  }
  .twelve{
    margin-left:15px;
    margin-top:20px;
    grid-column: 2;
    grid-row:11;
    text-align:right;
  }
  .eleven{
       position: relative; 
        top: 40px;
    margin-left:15px;
    margin-top:20px;
  }
  .ten{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row:10;
  }
  .nine{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row:9;
  }
  .eight{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row:8;
  }
  .seven{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row: 7;
  }
  .six{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row: 6;
  }
  .five{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row: 4;
  }
  .one {
    margin-left:5px;
  }
  .two {  
      position: relative; 
        top: -43px;
    text-align:right;
    margin-right:5px; 
    
  }
  .three{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row: 2;
  }
  .four{
    margin-left:15px;
    margin-top:20px;
    grid-column: 1 / span 2;
    grid-row: 3;
  }
  .bordes {
    border: 1px solid #ccc;
    background-color: #a39f9f;
    height: 30px;
   border-radius: 10% / 50%;
   text-align: center
  }
  .input{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width: 60px;
  }
  .input2{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width: 300px;
  }
  .input3{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width: 160px;
  }
  .input4{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width:550px;
  }
  .input5{
    border: 1px solid #ccc;
    background-color: #a39f9f;
    height: 30px;
   border-radius: 10px;
   width:540px;
  }
  .input6{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width:200px;
  }
  .input7{
    border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width: 220px;
    text-align:left;
    text-transform: capitalize;
  }
  .input8{
     border: none;
    border-bottom: 1px solid #ccc;
    margin-left:10px;
    width: 100px;
  }
</style>
