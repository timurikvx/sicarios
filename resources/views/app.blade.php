<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website">
        <meta property="og:description" content="Sicarios - Nu металкор группа из города Тулы">
        <meta property="og:locale" content="ru_RU">
        <meta property="og:image" content="{{ env('APP_URL') }}/item.png">
        <meta property="og:image:width" content="1196">
        <meta property="og:image:height" content="801">
        <meta property="og:image" content="{{ env('APP_URL') }}/item.png">
        <meta property="vk:image" content="{{ env('APP_URL') }}/item.png">
        <link rel="icon" type="image/x-icon" href="/storage/icon/favicon.ico" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
        <title>{{ env('APP_NAME')  }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-hidden">
        <div id="app" class="h-screen flex flex-col overflow-hidden"></div>
    </body>
</html>
