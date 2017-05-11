<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta nome="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta nome="csrf-token" content="{{ csrf_token() }}">

  <title>Essential Technologies</title>

  <!-- Styles2 -->

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/pdv.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/hover-min.css') }}" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">

  <!--
  <script>

  window.Laravel = <?php echo json_encode([
  'csrfToken' => csrf_token(),
]); ?>

</script>
Scripts -->
</head>
<body>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-12 caixa">
          <div class="col-md-6 pesquisa">
            <h1>teste</h1>
          </div>
          <div class="col-md-6 produtos">
            <h1>teste</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="{{ asset('js/app.js') }}"></script>


</body>
</html>
