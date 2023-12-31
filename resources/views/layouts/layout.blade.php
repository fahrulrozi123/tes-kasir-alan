<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Kasir Alan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 60px;
        }

        .footer {
            flex-shrink: 0;
            height: 60px;
            background-color: #f8f9fa;
            text-align: center;
            padding-top: 20px;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="/">Alan Resto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item {{ Request::is('/', 'products/create', 'products/{id}/edit') ? 'active' : '' }}">
                        <a class="nav-link" href="/">Food</a>
                    </li>
                    <li class="nav-item {{ Request::is('transaksi') ? 'active' : '' }}">
                        <a class="nav-link" href="/transaksi">Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="content">
        @yield('content')
    </div>
    
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2023 <b>Alan Resto.</b> All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
