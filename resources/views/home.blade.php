@extends('layouts.app')
@section('css')
   <link href="{{ URL::asset('css/home.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container espaco-menu">
    <div class="row">
        <div class="col-md-12">
           <div class="col-md-6 botoes">
             <div class="row">
                <div class="col-md-4 botao">
                  <h1>B</h1>
               </div>
               <div class="col-md-4 botao">
                  <h1>B</h1>
               </div>
             </div>
             <div class="row">
                <div class="col-md-4 botao">
                  <h1>B</h1>
               </div>
               <div class="col-md-4 botao">
                  <h1>B</h1>
               </div>
             </div>
           </div>
           <div class="col-md-6 avisos">
             <h1>Teste</h1>
           </div>
        </div>
    </div>
</div>
@endsection
