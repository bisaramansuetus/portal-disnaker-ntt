<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Informasi Publik DISNAKERTRANS NTT')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], // Menggunakan Inter
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('head')
</head>
<body class="bg-[#FAFAF6] text-[#1A1A1A] min-h-screen flex flex-col justify-between antialiased font-sans">

    <x-site.navbar />

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-site.footer />

    <script>
        // Script Toggle Mobile Menu
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            // Logika drawer mobile akan ditambahkan di tahap selanjutnya
            alert('Fitur Menu Mobile (Drawer) akan segera hadir!');
        });
    </script>
    @stack('scripts')
</body>
</html>