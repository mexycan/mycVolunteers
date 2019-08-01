<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mexican Pavilion Volunteers
    </title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://www.mexycanmb.ca/mexicanpavilionvolunteers/css/myc.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light ">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="https://www.mexycanmb.ca/wp-content/uploads/2019/03/cropped-logo_transparentbackground.png" height="30" class="d-inline-block align-top" alt="MYC Volunteers">
         Mex y Can Volunteers
    </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse order-3" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    @guest
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
    @else
        <li class="nav-item"><a class="nav-link" href="{{ route('admin') }}" style="display:none;">Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coordinator') }}"  style="display:none;">Coordinator</a></li>
        <li class="nav-item">
            <a  class="nav-link" href="#">
            Hola {{ Auth::user()->firstname }}!
            </a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
    @endguest
    </ul>
    
  </div>
    </nav>
</div>
        
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    @yield('footer')

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118658017-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-118658017-1');
</script>

</body>
</html>
