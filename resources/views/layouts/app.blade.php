<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.app_name') }}</title>

    <!-- الخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap RTL/LTR -->
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    @endif

    <!-- الأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- نمط مخصص -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        
        .language-switcher {
            position: fixed;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
            z-index: 1000;
        }
        
        .language-switcher .btn {
            padding: 8px 16px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
            <div style="color: blue;">
    <i class="fas fa-charging-station"></i> <span>شاحني</span>
</div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('messages.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">{{ __('messages.contact') }}</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color: inherit; text-decoration: none;">{{ __('messages.logout') }}</button>
                            </form>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('messages.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings') }}">
                                        {{ __('messages.settings') }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            {{ __('messages.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- المحتوى -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html> 