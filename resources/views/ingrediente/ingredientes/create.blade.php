@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Ingrediente</div>
                    <div class="panel-body">
                        <a href="{{ url('/ingrediente/ingredientes') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/ingrediente/ingredientes', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('ingrediente.ingredientes.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
     if ($("#tipo").val() == "0"){
       $("#peso").hide();
       $("#quantidade").show()
     }else{
       $("#peso").show();
       $("#quantidade").hide();
     }
     $('select').on('change', function() {
       if ($("#tipo").val() == "0"){
         $("#peso").hide();
         $("#quantidade").show();
       }else{
         $("#peso").show();
         $("#quantidade").hide();
       }
     });
   });
</script>
@endsection
