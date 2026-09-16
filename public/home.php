<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

$pageStmt = $conn->prepare("SELECT * FROM pages WHERE slug = 'home' LIMIT 1");
$pageStmt->execute();
$home_page = $pageStmt->get_result()->fetch_assoc();

$faqs_result = $conn->query("SELECT * FROM faqs ORDER BY sort_order ASC");
$faqs = $faqs_result ? $faqs_result->fetch_all(MYSQLI_ASSOC) : [];

$species_result = $conn->query("SELECT * FROM fish_species ORDER BY is_state_fish DESC, id ASC");
$species_list = $species_result ? $species_result->fetch_all(MYSQLI_ASSOC) : [];

$current_page = 'home';

include __DIR__ . '/../src/views/partials/header.php';
?>

<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">
        
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-6 flex flex-col justify-between shrink-0">
            <div>
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4">State Heritage</h2>
                
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6">
                    <div class="relative z-10 pr-16">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Official State Fish</span>
                        <h3 class="text-lg font-serif font-bold leading-tight">Striped Grey Mullet</h3>
                        <p class="text-xs italic text-sky-100 mb-3">Shevtto (Mugil cephalus)</p>
                        <a href="/public/fish.php" class="inline-block px-3 py-1.5 rounded-full bg-white text-sky-800 text-[10px] font-bold uppercase tracking-wider hover:bg-sky-50 transition-all">Read Profile &rarr;</a>
                    </div>
                    <img src="/Assets/mascot.png" alt="Website Mascot" class="absolute -right-2 -bottom-2 w-24 h-24 object-contain drop-shadow-lg pointer-events-none">
                </div>

                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-3">Key Species Directory</h2>
                <div class="space-y-1.5 max-h-[45vh] overflow-y-auto pr-1">
                    <?php foreach ($species_list as $fish): ?>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-white/60 border border-white text-xs">
                            <span class="font-medium text-slate-700"><?php echo htmlspecialchars($fish['common_name']); ?></span>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-100">
                                <?php echo htmlspecialchars($fish['local_konkani_name']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between">
            <div>
                <div class="mb-8 flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 tracking-tight uppercase leading-none mb-3">
                            <?php echo htmlspecialchars($home_page['title'] ?? "Goa's Fish & Fishing Techniques"); ?>
                        </h1>
                        <p class="text-xs text-sky-700 font-semibold tracking-wider uppercase">Marine Biodiversity & Traditional Knowledge Base</p>
                    </div>
                    <img src="/Assets/mascot.png" alt="Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                </div>

                <div class="space-y-4 text-slate-600 text-sm leading-relaxed mb-10">
                    <p class="first-letter:text-4xl first-letter:font-serif first-letter:font-bold first-letter:text-sky-600 first-letter:mr-2 first-letter:float-left">
                        <?php echo nl2br(htmlspecialchars($home_page['content'] ?? 'Welcome to Goa Marine Heritage hub.')); ?>
                    </p>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-serif font-bold text-slate-900 mb-4 pb-2 border-b border-sky-100">
                        Cultural & Environmental Significance
                    </h2>
                    <div class="space-y-4">
                        <?php foreach ($faqs as $faq): ?>
                            <div class="p-5 rounded-2xl bg-white/80 border border-sky-100 shadow-sm">
                                <h3 class="text-sm font-bold text-slate-800 mb-2 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-sky-500 inline-block"></span>
                                    <?php echo htmlspecialchars($faq['question']); ?>
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed pl-4">
                                    <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/../src/views/partials/footer.php'; ?>
        </main>
    </div>
</div>

<!-- CLOSING ALL WRAPPER DIVS FROM HEADER.PHP -->
</div> <!-- closes flex-1 flex flex-col -->
</div> <!-- closes max-w-[1600px] -->

<!-- MOBILE NAV RENDERED DIRECTLY UNDER BODY -->
<?php include __DIR__ . '/../src/views/partials/mobile.php'; ?>

</body>
</html>