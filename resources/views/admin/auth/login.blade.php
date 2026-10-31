<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — Disnaker NTT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-800 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-slate-800 mb-1">Panel Admin</h1>
        <p class="text-sm text-slate-500 mb-6">Disnaker NTT</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-3 py-2 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>
            <button class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2 rounded">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>