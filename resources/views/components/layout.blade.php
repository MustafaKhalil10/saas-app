<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-graylight text-dark min-h-screen font-sans">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-soft p-6 flex flex-col space-y-6 rounded-r-xl min-h-screen">
            <h1 class="text-2xl font-bold text-dark">SaaS App</h1>
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="hover:bg-sand hover:text-dark rounded-xl p-2 transition {{ request()->routeIs('dashboard') ? 'bg-sand text-dark' : '' }}">Dashboard</a>
                <a href="{{ route('plans') }}" class="hover:bg-sand hover:text-dark rounded-xl p-2 transition {{ request()->routeIs('plans') ? 'bg-sand text-dark' : '' }}">Plans</a>
                <a href="{{ route('profile.edit') }}" class="hover:bg-sand hover:text-dark rounded-xl p-2 transition {{ request()->routeIs('profile.edit') ? 'bg-sand text-dark' : '' }}">Profile</a>
            </nav>
            
            @auth
            <div class="mt-auto pt-6 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left hover:bg-sand hover:text-dark rounded-xl p-2 transition text-graydark">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10 bg-graylight">
            <div class="max-w-6xl mx-auto space-y-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>



