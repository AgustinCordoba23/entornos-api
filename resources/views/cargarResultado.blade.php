Ya se encuentra disponible la carga de resultados para la vacante #{{ $vacante }}.

<p>Los CV de los postulados los puede consultar en los siguientes enlaces o visitando http://www.entornos-spa.tk/: </p>

@foreach ($cvs as $cv)
    <p>http://api.entornos-frro.tk:8080/api/vacantes/descargar-pdf/{{$cv}}</p>
@endforeach

<p> Este es un mensaje autogenerado. Por favor no responder. </p>
