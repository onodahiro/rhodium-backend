<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            text-align: center;
            padding: 10px 0;
        }
        section {
            text-align: center;
        }
        footer {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9em;
            color: #6c757d;
        }
        .code {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
        </header>
        <section>
            <p>Thank you for registering, {{ $name }} !</p>

            <p>To complete account activation, insert this code!</p>

            <p class='code'><strong>{{ $code }}</strong></p>

            <p>Yaay !</p>
        </section>
        <footer>
            © 2025 AmberRhodium
        </footer>
    </div>
</body>
</html>