<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Option 1: CoreUI for Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-PDUiPu3vDllMfrUHnurV430Qg8chPZTNhY8RUpq89lq22R3PzypXQifBpcpE1eoB" crossorigin="anonymous">

    <!-- Option 2: CoreUI PRO for Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-YVHwdj+EKSu6ocFP4DVxSkyLgrlsMf1FJPLZhInu09UMMLHWv0meKLveWYKOHgq9" crossorigin="anonymous"> -->

    <title>{{ config('app.name', 'Laravel') }}</title>
  </head>
  <body>
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            @yield('content')
        </div>
    </div>
    
    
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: CoreUI for Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/js/coreui.bundle.min.js" integrity="sha384-8QmUFX1sl4cMveCP2+H1tyZlShMi1LeZCJJxTZeXDxOwQexlDdRLQ3O9L78gwBbe" crossorigin="anonymous"></script>

    <!-- Option 2: CoreUI PRO for Bootstrap Bundle with Popper -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/js/coreui.bundle.min.js" integrity="sha384-lyJyv3HACWEj3x1TDrchCKec9B+kwP9eeoiEyDRnciadwBN/lHI99UyGTpT21WSN" crossorigin="anonymous"></script>
    -->

    <!-- Option 3: Separate Popper and CoreUI/CoreUI PRO  for Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/js/coreui.min.js" integrity="sha384-Rj9po7KQz8y0hVoeRgl1LRoQcxYkHxszkpKUdatY+9b5o35FsiENOwOWwxzWfAfF" crossorigin="anonymous"></script>
    or
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/js/coreui.min.js" integrity="sha384-10xOpxl2MSqyKMNc4hYakRMKvs6G7qFukud815ToVM5thj8k0+jPu8kC6LSKQ3/N" crossorigin="anonymous"></script>
    -->
  </body>
</html>