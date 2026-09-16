<?php
// Enable error reporting for local development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// 1. Fetch crabs directory list
$crabs_result = $conn->query("SELECT * FROM crabs ORDER BY id ASC");
$crabs_list = $crabs_result ? $crabs_result->fetch_all(MYSQLI_ASSOC) : [];

// 2. Fetch selected crab via URL parameter ?id=... (or default to first entry)
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($selected_id) {
    $stmt = $conn->prepare("SELECT * FROM crabs WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $selected_id);
    $stmt->execute();
    $active_crab = $stmt->get_result()->fetch_assoc();
} else {
    $active_crab = $crabs_list[0] ?? null;
}

$current_page = 'crabs';
include __DIR__ . '/../src/views/partials/header.php';
?>

<!-- MAIN PAGE CONTAINER (INCLUDES BOTTOM PADDING FOR MOBILE NAV) -->
<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">

        <!-- LEFT/MIDDLE COLUMN: Clickable Crab Directory & Mascot Banner -->
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-4 sm:p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Crab Mascot Banner Box -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6 group">
                    <div class="relative z-10 pr-14">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Goan Crustacean Heritage</span>
                        <h3 class="text-base font-serif font-bold leading-tight">Crab Directory</h3>
                        <p class="text-xs text-sky-100 mt-1">Estuarine & Coastal Species</p>
                    </div>
                    <!-- Crab Mascot Image Asset -->
                    <img src="/../Assets/crab.png" alt="Crab Species Mascot" class="absolute -right-2 -bottom-2 w-20 h-20 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300 pointer-events-none">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Goan Crabs Directory</h2>
                    <span class="text-[10px] font-semibold bg-sky-100 text-sky-800 px-2 py-0.5 rounded-full">
                        <?php echo count($crabs_list); ?> Documented
                    </span>
                </div>

                <div class="space-y-2 max-h-[50vh] lg:max-h-[70vh] overflow-y-auto no-scrollbar pr-1">
                    <?php foreach ($crabs_list as $crab): 
                        $isSelected = ($active_crab && $active_crab['id'] == $crab['id']);
                    ?>
                        <a href="/public/crabs.php?id=<?php echo $crab['id']; ?>" 
                           class="flex items-center justify-between p-3 rounded-xl border transition-all duration-200 block <?php echo $isSelected ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white/70 border-white text-slate-700 hover:bg-white hover:border-sky-200'; ?>">
                            <div class="truncate pr-2">
                                <span class="font-semibold text-xs block truncate">
                                    <?php echo htmlspecialchars($crab['common_name'] ?? ''); ?>
                                </span>
                                <?php if (!empty($crab['scientific_name'])): ?>
                                    <span class="text-[10px] italic <?php echo $isSelected ? 'text-sky-100' : 'text-slate-400'; ?> block truncate">
                                        <?php echo htmlspecialchars($crab['scientific_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md shrink-0 <?php echo $isSelected ? 'bg-white/20 text-white' : 'bg-sky-50 text-sky-700 border border-sky-100'; ?>">
                                <?php echo htmlspecialchars($crab['local_konkani_name'] ?? ''); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Dynamic Details & Image Display -->
        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar">
            <?php if ($active_crab): ?>
                <div>
                    <!-- Category Badge -->
                    <div class="flex items-center space-x-2 text-xs text-sky-700 font-semibold tracking-wider uppercase mb-2">
                        <span>Goan Crustacean Heritage</span>
                    </div>

                    <!-- Title & Konkani Name -->
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-slate-900 tracking-tight leading-none mb-2">
                                <?php echo htmlspecialchars($active_crab['common_name'] ?? ''); ?>
                            </h1>
                            <p class="text-lg font-serif italic text-sky-700">
                                Konkani: <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($active_crab['local_konkani_name'] ?? 'N/A'); ?></span>
                                <?php if (!empty($active_crab['scientific_name'])): ?>
                                    <span class="text-xs text-slate-400 ml-2">(<?php echo htmlspecialchars($active_crab['scientific_name']); ?>)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <!-- Header Badge Mascot -->
                        <img src="/Assets/crab.png" alt="Crab Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                    </div>

                    <!-- Dynamic Image Display -->
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-md border border-white bg-slate-100 h-64 sm:h-80 w-full">
                        <?php 
                        $image_url = !empty($active_crab['image_url']) 
                            ? htmlspecialchars($active_crab['image_url']) 
                            : 'https://images.unsplash.com/photo-1559737671-6d73898fa4c6?auto=format&fit=crop&w=1200&q=80';
                        ?>
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($active_crab['common_name'] ?? 'Crab'); ?>" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Habitat</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_crab['habitat'] ?? 'Estuaries & Mangrove Creeks'); ?>
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Harvest Technique</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_crab['catch_method'] ?? 'Crab Traps (Kotto)'); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-lg font-serif font-bold text-slate-900 mb-3 pb-2 border-b border-sky-100">
                            Species & Culinary Significance
                        </h2>
                        <div class="text-slate-600 text-sm leading-relaxed space-y-4">
                            <p>
                                <?php echo nl2br(htmlspecialchars($active_crab['description'] ?? '')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-12 text-center text-slate-500">
                    <p class="text-lg font-semibold">No crab species entries found in the database.</p>
                </div>
            <?php endif; ?>

            <?php include __DIR__ . '/../src/views/partials/footer.php'; ?>
        </main>
    </div>
</div>

<!-- CLOSE LAYOUT CONTAINERS FROM HEADER.PHP -->
</div>
</div>

<!-- INJECT FLOATING MOBILE NAV DIRECTLY BEFORE BODY CLOSING TAG -->
<?php include __DIR__ . '/../src/views/partials/mobile.php'; ?>

</body>
</html>