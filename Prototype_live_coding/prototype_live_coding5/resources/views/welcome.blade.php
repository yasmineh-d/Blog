<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenue sur le Blog</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8fafc;
        }
        .welcome-container {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .welcome-title {
            font-size: 2rem;
            color: #1a202c;
            margin-bottom: 1rem;
        }
        .welcome-message {
            color: #4a5568;
            margin-bottom: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #3182ce;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1 class="welcome-title">Bienvenue sur notre Blog</h1>
        <p class="welcome-message">Découvrez nos derniers articles et partagez vos idées avec la communauté.</p>
        <a href="{{ route('articles.index') }}" class="btn">Voir les articles</a>
    </div>
</body>
</html>
