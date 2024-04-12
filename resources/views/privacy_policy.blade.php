<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
</head>
<body style="background: #0A314B; color: white;">
<h1>{{ $data['title'] }}</h1>
@foreach($data['sections'] as $section)
    <h2>{{ $section['title'] }}</h2>
    {!! $section['content'] !!}
@endforeach
</body>
</html>
