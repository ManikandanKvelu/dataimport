<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <!-- Styles -->
        <style>

        </style>
    </head>
    <body class="antialiased">
        @component('components.header')
        @endcomponent


    <div class="container mt-5">
        <div class="form">
            <form class="form row"
                action="{{route('processFile')}}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <input type="file" class="form-control" id ="csvFile"
                    name="csvFile">
                </div>

                <div class="form-group col-md-6">
                    <input type="submit" class="btn btn-info submit">
                </div>
            </form>
</div>
    </div>
    </body>
</html>
