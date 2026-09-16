<?php
$current_page = $current_page ?? 'home';
?>

<!-- FIXED MOBILE BOTTOM NAVIGATION WITH GLASSMORPHISM -->
<div id="mobile-nav-bar" class="lg:hidden" style="position: fixed !important; bottom: 12px !important; left: 12px !important; right: 12px !important; z-index: 999999 !important; transition: transform 0.3s ease-in-out;">
    <nav class="bg-slate-900/40 backdrop-blur-xl border border-white/20 text-white rounded-2xl px-2 py-2.5 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] flex justify-around items-center overflow-x-auto no-scrollbar space-x-1">
        
        <!-- Home -->
        <a href="/public/home.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'home') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 001 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[9px]">Home</span>
        </a>

        <!-- Species / Fish -->
        <a href="/public/fish.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'fish') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <span class="text-[9px]">Species</span>
        </a>

        <!-- Crabs -->
        <a href="/public/crabs.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'crabs') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="text-[9px]">Crabs</span>
        </a>

        <!-- Techniques / Methods -->
        <a href="/public/methods.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'techniques' || $current_page === 'methods') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <span class="text-[9px]">Techniques</span>
        </a>

        <!-- About -->
        <a href="/public/about.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'about') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-[9px]">About</span>
        </a>

        <!-- Contact -->
        <a href="/public/contact.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'contact') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span class="text-[9px]">Contact</span>
        </a>

        <!-- Dashboard / Portal -->
        <a href="/public/dashboard.php" class="flex flex-col items-center space-y-1 shrink-0 px-2 py-1 rounded-xl transition-all duration-300 <?php echo ($current_page === 'dashboard') ? 'text-sky-300 font-bold bg-sky-500/20 border border-sky-400/40' : 'text-slate-300 hover:text-white border border-transparent'; ?>">
            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-[9px]">Portal</span>
        </a>

    </nav>
</div>

<script>
(function() {
    let lastScrollTop = 0;
    const navBar = document.getElementById('mobile-nav-bar');

    window.addEventListener('scroll', function() {
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        if (currentScroll > lastScrollTop && currentScroll > 60) {
            navBar.style.transform = 'translateY(150%)';
        } else {
            navBar.style.transform = 'translateY(0)';
        }
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    }, { passive: true });
})();
</script>