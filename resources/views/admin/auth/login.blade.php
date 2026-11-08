<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — Disnaker NTT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-800 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    @php
        $logo = \App\Models\SiteSetting::get('logo_path');
    @endphp

    {{-- BACKGROUND LOGO WATERMARK --}}
    @if ($logo)
        <div class="absolute inset-0 z-0 opacity-[0.05] pointer-events-none bg-center bg-no-repeat bg-contain" 
             style="background-image: url('{{ asset('storage/' . $logo) }}');">
        </div>
    @endif

    {{-- KOTAK LOGIN --}}
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md relative z-10 border-t-4 border-[#facc15]">
        
        {{-- HEADER DENGAN LOGO DI KIRI --}}
        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
            <div class="w-16 h-16 bg-white border rounded-lg flex items-center justify-center p-1 shrink-0 shadow-sm">
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="w-full h-full object-contain">
                @else
                    <span class="text-[10px] text-gray-400 text-center">Logo<br>Dinas</span>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 leading-tight">Panel Admin</h1>
                <p class="text-sm text-slate-500 font-medium">DISNAKERTRANS-NTT</p>
            </div>
        </div>

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
            <button class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2.5 rounded transition shadow">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>