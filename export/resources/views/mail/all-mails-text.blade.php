Formular auf Website ausgefüllt

Jemand hat ein Formular auf Ihrer Website ausgefüllt. Hier sind die Details:

@foreach ($fields as $item)
{{ $item['handle'] }}: {{ $item['value'] }}

@endforeach
