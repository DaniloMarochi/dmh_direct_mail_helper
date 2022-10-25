@component('mail::message')

<h1> Email enviado!! </h1>

@component('mail::button', ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'])
    CLIQUE AQUI IMEDIATAMENTE
@endcomponent

<p>Olá {{$student->name}}, você tem {{$student->frequence}} porcento de frequência!</p>

@endcomponent
