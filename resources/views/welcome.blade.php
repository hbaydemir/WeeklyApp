<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Weekly Planning App">
    <meta name="author" content="Hüseyin Baydemir">
    <meta name="theme-color" content="#712cf9">
    <title>Weekly App - Weekly Plan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/weekly-icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>



<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <h3 class="float-md-start mb-0">
                    <img src="{{ asset('images/weekly-logo.png') }}" alt="Weekly Logo" height="30">
                </h3>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    @if (Route::has('login'))
                        @auth
                            <a class="nav-link fw-bold py-1 px-0 active" aria-current="page"
                                href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link fw-bold py-1 px-0" href="{{ route('login') }}">Giriş Yap</a>
                            @if (Route::has('register'))
                                <a class="nav-link fw-bold py-1 px-0" href="{{ route('register') }}">Kayıt Ol</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main class="px-3">
            <h1>Haftanızı Düzenleyin.</h1>
            <p class="lead">Weekly App, planlarınızı ve görevlerinizi kolayca yönetmenize yardımcı olan modern bir
                uygulamadır. Günlük hayatınızı düzenleyin, verimliliğinizi artırın ve hiçbir şeyi kaçırmayın. Tek bir
                sayfada tüm kontrol sizde!</p>
            <p class="lead">
                @if (Route::has('register'))
                    <a class="btn btn-lg btn-light fw-bold border-white bg-white" href="{{ route('register') }}">Kayıt Ol</a>
                @endif
            </p>
        </main>

        <footer class="mt-auto text-white-50">
            <p>Developed by <a target="_blank" href="https://www.instagram.com/huseyinn.baydemir/"
                    class="text-white">Hüseyin Baydemir</a></p>
        </footer>
    </div>

    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
