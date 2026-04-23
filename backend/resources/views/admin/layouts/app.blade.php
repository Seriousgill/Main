<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
<div class="flex min-h-screen">
    <aside class="w-64 bg-slate-900 border-r border-slate-800 p-5 space-y-3">
        <h1 class="text-lg font-bold">Ticket Admin</h1>
        <nav class="space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block hover:text-cyan-400">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block hover:text-cyan-400">Users</a>
            <a href="{{ route('admin.events.index') }}" class="block hover:text-cyan-400">Events</a>
            <a href="{{ route('admin.bookings.index') }}" class="block hover:text-cyan-400">Bookings</a>
            <a href="{{ route('admin.payments.index') }}" class="block hover:text-cyan-400">Payments</a>
            <a href="{{ route('admin.settings.index') }}" class="block hover:text-cyan-400">Settings</a>
        </nav>
    </aside>
    <main class="flex-1 p-6">
        @if(session('status'))
            <div class="bg-emerald-800 px-4 py-2 rounded mb-4">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
