<?php
$current_page = $current_page ?? 'home';
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goa Marine Heritage & Biodiversity Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Cinzel', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full font-sans text-slate-100 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-slate-900 via-sky-950 to-slate-900 selection:bg-sky-500 selection:text-white min-h-screen">

<div class="min-h-full flex flex-col lg:flex-row max-w-[1600px] mx-auto shadow-2xl bg-slate-900/30 backdrop-blur-2xl border-x border-white/10">

    <!-- ENHANCED GLASSMORPHISM SIDEBAR -->
    <aside class="hidden lg:flex w-full lg:w-72 xl:w-80 bg-white/[0.07] backdrop-blur-xl text-white p-6 flex-col justify-between shrink-0 relative z-20 border-r border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)]">
        
        <!-- Ambient Radial Glow overlay behind sidebar -->
        <div class="absolute inset-0 bg-gradient-to-b from-sky-500/10 via-transparent to-blue-600/10 pointer-events-none rounded-l-2xl"></div>

        <div class="space-y-8 relative z-10">
            <!-- Brand / Header with Glass Card Effect -->
            <div class="flex items-center space-x-3 pb-6 border-b border-white/15">
                <div class="p-2 bg-gradient-to-tr from-sky-400/80 to-sky-600/80 backdrop-blur-md rounded-2xl shadow-lg shadow-sky-500/20 shrink-0 border border-white/30">
                    <img src="/Assets/mascot.png" alt="Goa Marine Mascot" class="w-10 h-10 object-contain drop-shadow-md">
                </div>
                <div>
                    <h1 class="font-serif font-bold text-base tracking-wider text-white uppercase leading-tight drop-shadow-sm">Goa Marine</h1>
                    <p class="text-[10px] text-sky-300 font-semibold tracking-widest uppercase">Heritage Portal</p>
                </div>
            </div>

            <!-- Navigation Links with Ultra-Glass Badges -->
            <nav class="space-y-2 relative z-10">
                <!-- Home -->
                <a href="/public/home.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'home' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 001 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Home Overview</span>
                    </div>
                </a>

                <!-- Fish Directory -->
                <a href="/public/fish.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'fish' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Fish Directory</span>
                    </div>
                </a>

                <!-- Crabs & Crustaceans -->
                <a href="/public/crabs.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'crabs' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Crabs & Crustaceans</span>
                    </div>
                </a>

                <!-- Fishing Techniques -->
                <a href="/public/methods.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'techniques' || $current_page === 'methods' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>Fishing Techniques</span>
                    </div>
                </a>

                <!-- About -->
                <a href="/public/about.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'about' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>About Portal</span>
                    </div>
                </a>

                <!-- Contact Us -->
                <a href="/public/contact.php" class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold transition-all duration-300 border <?php echo $current_page === 'contact' ? 'bg-sky-500/25 text-sky-200 border-sky-400/50 shadow-[0_4px_20px_rgba(56,189,248,0.25)] font-bold backdrop-blur-lg scale-[1.02]' : 'text-slate-300 border-white/5 hover:bg-white/10 hover:text-white hover:border-white/20 hover:backdrop-blur-md'; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Contact & Feedback</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Glass Footer Button & Metadata -->
        <div class="pt-6 mt-6 border-t border-white/15 space-y-3 relative z-10">
            <a href="/public/login.php" class="flex items-center justify-center space-x-2 w-full px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-sky-300 hover:text-white text-xs font-bold border border-white/20 hover:border-sky-400/40 transition-all duration-300 backdrop-blur-md shadow-lg shadow-black/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                <span>Team & Contributor Login</span>
            </a>
            <p class="text-[10px] text-center text-slate-400 font-mono tracking-wider">Goa Marine Biodiversity v2.0</p>
        </div>
    </aside>

    <div class="flex-1 flex flex-col lg:flex-row min-w-0">