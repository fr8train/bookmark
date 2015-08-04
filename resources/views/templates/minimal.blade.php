<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>bookmark</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootflat.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        body {
            background-color: #F1F2F6;
        }
    </style>
</head>
<body>

<div class="container">
    @yield('content')
</div>

<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<!-- Bootflat's JS files.-->
<script src="{{ asset('js/icheck.min.js') }}"></script>
<script src="{{ asset('js/jquery.fs.selecter.min.js') }}"></script>
<script src="{{ asset('js/jquery.fs.stepper.min.js') }}"></script>

<!-- Page based scripts -->
<script type="text/javascript">
    @yield('scripts')
</script>
</body>
</html>