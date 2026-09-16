<!-- DESKTOP FIXED LEFT SIDEBAR -->
<aside class="hidden lg:flex w-72 glass-sidebar p-6 flex-col justify-between border-r border-sky-100/60 shrink-0">
    <div>
        <!-- Window Controls -->
        <div class="flex items-center space-x-2 mb-8">
            <span class="w-3 h-3 rounded-full bg-rose-400 inline-block shadow-sm"></span>
            <span class="w-3 h-3 rounded-full bg-amber-400 inline-block shadow-sm"></span>
            <span class="w-3 h-3 rounded-full bg-emerald-400 inline-block shadow-sm"></span>
        </div>

        <!-- Wikipedia-Style Branding -->
        <div class="mb-8 text-left">
            <div class="text-5xl font-serif text-sky-700 tracking-tighter font-semibold mb-1">G</div>
            <h1 class="text-xl font-serif font-bold text-slate-800 tracking-wide">GOA FISHING</h1>
            <p class="text-xs text-sky-600 font-medium tracking-wider uppercase">Marine & Cultural Heritage</p>
        </div>

        <!-- Dynamic Navigation Items -->
        <nav class="space-y-1.5 max-h-[50vh] overflow-y-auto no-scrollbar pr-1">
            <?php
            $nav_items = [
                ['slug' => 'home', 'label' => 'Home Overview', 'id' => 1],
                ['slug' => 'about', 'label' => 'About Project', 'id' => 2],
                ['slug' => 'fish', 'label' => 'Fish Species', 'id' => 3],
                ['slug' => 'methods', 'label' => 'Fishing Methods', 'id' => 4],
                ['slug' => 'crabs', 'label' => 'Goan Crabs', 'id' => 5],
                ['slug' => 'contact', 'label' => 'Contact Us', 'id' => 6],
            ];
            $current_page = $current_page ?? 'home';
            foreach($nav_items as $item): 
                $isActive = ($current_page === $item['slug']);
            ?>
                <!-- FIXED HREF PATH: Points directly to /public/ folder -->
                <a href="/public/<?php echo $item['slug']; ?>.php" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-full text-xs font-medium transition-all duration-200 <?php echo $isActive ? 'bg-sky-500 text-white shadow-md shadow-sky-500/30 font-semibold' : 'text-slate-600 hover:text-sky-700 hover:bg-white/50'; ?>">
                    <span class="w-5 h-5 rounded-full <?php echo $isActive ? 'bg-white/20 text-white' : 'bg-slate-200/60 text-slate-500'; ?> flex items-center justify-center text-[10px] font-bold shrink-0">
                        <?php echo $item['id']; ?>
                    </span>
                    <span class="truncate"><?php echo htmlspecialchars($item['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>

    <!-- Active Contributor / User Badge -->
    <div class="mt-6 pt-4 border-t border-sky-200/50 flex items-center space-x-3">
        <div class="w-9 h-9 rounded-full bg-sky-600 text-white font-bold flex items-center justify-center text-xs border-2 border-white shadow-sm">
            JM
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-800 leading-tight">Jonito D'Silva</p>
            <p class="text-[10px] text-slate-400">Project Lead</p>
        </div>
    </div>
</aside>