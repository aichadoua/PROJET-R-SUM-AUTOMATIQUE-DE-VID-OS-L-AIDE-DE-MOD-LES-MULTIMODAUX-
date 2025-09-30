<x-guest-layout>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 150px;
            width: auto;
            display: inline-block;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }

        .form-group i {
            position: absolute;
            top: 42px;
            left: 12px;
            color: #888;
        }

        input {
            width: 100%;
            padding: 12px 12px 12px 36px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #072647;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #07294d;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 700;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #1e3e5f;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
        }

    </style>

    <div class="form-container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('image/vedeo.jpg') }}" alt="Logo">
        </div>

        <h2>Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                @if($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn">Se connecter</button>
        </form>

        <div class="login-link">
            Vous n'avez pas de compte ? <a href="{{ route('register') }}">Créer un compte</a><br>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 14px; margin-top: 10px; display: inline-block;">Mot de passe oublié ?</a>
            @endif
        </div>
    </div>
</x-guest-layout>
