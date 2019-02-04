<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="/css/plantilla.css">
</head>
<body>
      Hola <i>{{ $demo->receiver }}!</i>,
      <p>Ha llegado una nueva petición para mensajería. Por favor revisa nuestra plataforma para poder atenderla.</p>
       
      Saludos,
      
      <br/>
      <i>{{ $demo->sender }}</i>
   
</body>
</html>