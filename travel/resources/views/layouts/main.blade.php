<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Turystyka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <!--NAVBAR-->
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/strtur/public" class="nav-link px-2 link-secondary">Strona główna</a></li>
                <li><a href="trips-abroad" class="nav-link px-2 link-dark">Zagranica</a></li>
                <li><a href="trips-poland" class="nav-link px-2 link-dark">Polska</a></li>
                <li><a href="trips" class="nav-link px-2 link-dark">Wszystie wycieczki</a></li>
            </ul>

            @yield('login')
        </header>
    </div>
        @yield('content')
        <!--FOOTER-->
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center pb-3 mb-3">
                <li class="nav-item"><a href="/strtur/public" class="nav-link px-2 text-muted">Strona główna</a></li>
                <li class="nav-item"><a href="trips-abroad" class="nav-link px-2 text-muted">Zagranica</a></li>
                <li class="nav-item"><a href="trips-poland" class="nav-link px-2 text-muted">Polska</a></li>
                <li class="nav-item"><a href="trips" class="nav-link px-2 text-muted">Wszystkie wycieczki</a></li>
            </ul>
            <p class="text-center text-muted">&copy; 2022 Company, Inc</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>