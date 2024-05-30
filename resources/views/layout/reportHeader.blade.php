<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <title>@yield('title', 'Default Title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-dark">
    <header class="container bg-dark position-sticky top-0 p-3 row">

        <a href="test" class="col-2 btn btn-danger row ms-1 col-4 text-decoration-none text-light">Exit </a>

        <a href="report_download" class="col-2 btn btn-primary row ms-3 col-4 text-decoration-none text-dark">Download
            <i class="bi bi-box-arrow-in-down"></i></a>


        <a href="report_preview" class="col-2 btn btn-primary row ms-3 col-4 text-decoration-none text-dark">View Pdf
            <i class="bi bi-arrow-up-right-square"></i>
        </a>

    </header>
    @yield('content')
</body>

</html>
