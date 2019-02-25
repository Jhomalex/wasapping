<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link rel="shortcut icon" href="/img/logo.png">
   <link rel="stylesheet" href="/css/plantilla.css">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Wasapping</title>
</head>
<body class="grey lighten-3">
   <div id="app">
      <ul id="dropdownOpciones" class="dropdown-content">
         {{-- <li><a class="flat waves-effect grey-text" href="#!"><i class="fas fa-user-circle"></i>Mi Perfil</a></li> --}}
         <li class="divider"></li>
         <li><a href="{{ route('logout') }}" class="flat waves-effect grey-text"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a></li>
      </ul>
      <nav class="teal" style="position:fixed;top:0;z-index:2">
         <div class="nav-wrapper">
            <a href="" class="brand-logo"><img src="/img/logo.png" style="margin-left:10px" width="90px"></img></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
               <li><a href="/dashboard" class="flat waves-effect white-text">Dashboard</a></li>
               <li><a href="/contactos" class="flat waves-effect white-text">Contactos</a></li>
               {{-- <li><a href="/mensajeria" class="flat waves-effect white-text">Mensajeria</a></li> --}}
               <li>
                  <a class="dropdown-trigger" style="height:65px" data-target="dropdownOpciones"> 
                     <img class="circle responsive" style="margin-top:10px;margin-left:5px;margin-right:5px" src="/img/usuarios/{{ Auth::user()['foto'] }}" height="40px" width="40px"></img> 
                     <i class="material-icons right">arrow_drop_down</i>
                  </a>
               </li>
            </ul>
         </div>
      </nav>
   
      <ul class="sidenav" id="mobile-demo">
         
         <li><a href="/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
         <li><a href="/contactos"><i class="fas fa-users"></i> Contactos</a></li>
         {{-- <li><a href="/mensajeria"><i class="fas fa-envelope"></i> Mensajeria</a></li> --}}
         <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
      </ul>
      <div style="margin-top:5em;">

      @yield('content')
      
      </div>
      
   </div>

   <script src="/js/plantilla.js"></script>
   <script src="/js/app.js"></script>
   </body>
</html>