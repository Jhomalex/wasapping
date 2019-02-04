<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login - Wasapping</title>
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/plantilla.css">
    <link rel="shortcut icon" href="/img/logo.png">
   <style>
      body {
         display: flex;
         min-height: 100vh;
         flex-direction: column;
      }
   
      main {
         flex: 1 0 auto;
      }
   
      
   
      .input-field input[type=date]:focus + label,
      .input-field input[type=text]:focus + label,
      .input-field input[type=email]:focus + label,
      .input-field input[type=password]:focus + label {
         color: #e91e63;
      }
   
      .input-field input[type=date]:focus,
      .input-field input[type=text]:focus,
      .input-field input[type=email]:focus,
      .input-field input[type=password]:focus {
         border-bottom: 2px solid #e91e63;
         box-shadow: none;
      }
</style>
</head>
<body class="login-background-color">
    <script src="/js/plantilla.js"></script>
    <div class="section"></div> 
   <main>
      <center>
         <img src="/img/logo.png" width="250">
         <!--h1 class="blue-grey-text text-darken-2" style="margin-bottom:0"><b>SIBS</b></h1>
         <span class="blue-text text-darken-3"><b>Sistema Integrado de Bancos de Sangre</b></span-->
         <div class="section"></div>
         <div class="container">
            <div class="z-depth-1 grey lighten-4 row z-depth-5" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
                <form method="POST" action="{{ route('login') }}" class="col s12">
                    @csrf
                    <div class='row'>
                         <div class='input-field col s12'>
                            <input class='validate' type='email' name='email' id='email' value="{{ old('email') }}"/>
                            <label for='email'>Usuario</label>
                            @if ($errors->has('email'))
                                <script>
                                    M.toast({html: '{{ $errors->first('email') }}'})
                                </script>
                            @endif
                        </div>
                    </div>
   
                  <div class='row'>
                     <div class='input-field col s12'>
                        <input class='validate' type='password' name='password' id='password' value="{{ old('password') }}"/>
                        <label for='password'>Contraseña</label>
                        @if ($errors->has('password'))
                        <script>
                                M.toast({html: '{{ $errors->first('password') }}'})
                            </script>
                        @endif
                     </div>
                     <label style='float: right;'>
                        <a class='blue-grey-text text-darken-1' href='{{ route('password.request') }}'><b>¿Olvidaste tu contraseña?</b></a>
                     </label>
                  </div>
                  <br />
                  <center>
                     <div class='row'>
                        <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect teal'>Iniciar Sesión</button>
                     </div>
                  </center>
               </form>
            </div>
         </div>
      </center>
   </main>  
   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.updateTextFields();
      });
    </script>
</body>
</html>

