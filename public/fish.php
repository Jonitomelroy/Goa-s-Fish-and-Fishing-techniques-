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

// 1. Fetch species list for left sidebar directory
$species_result = $conn->query("SELECT * FROM fish_species ORDER BY is_state_fish DESC, id ASC");
$species_list = $species_result ? $species_result->fetch_all(MYSQLI_ASSOC) : [];

// 2. Fetch specific fish based on URL parameter ?id=... (or default to state fish/first fish)
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($selected_id) {
    $stmt = $conn->prepare("SELECT * FROM fish_species WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $selected_id);
    $stmt->execute();
    $active_fish = $stmt->get_result()->fetch_assoc();
} else {
    // Default to the first fish in list
    $active_fish = $species_list[0] ?? null;
}

$current_page = 'fish';
include __DIR__ . '/../src/views/partials/header.php';
?>

<!-- MAIN PAGE CONTAINER (INCLUDES BOTTOM PADDING FOR MOBILE NAV) -->
<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">

        <!-- LEFT/MIDDLE COLUMN: Clickable Directory & Mascot Banner -->
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-4 sm:p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Mascot Banner Box -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6 group">
                    <div class="relative z-10 pr-14">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Goan Marine Life</span>
                        <h3 class="text-base font-serif font-bold leading-tight">Species Catalog</h3>
                        <p class="text-xs text-sky-100 mt-1">Local Coastal Biodiversity</p>
                    </div>
                    <!-- Mascot Image Asset -->
                    <img src="/../Assets/fish.png" alt="Fish Species Mascot" class="absolute -right-2 -bottom-2 w-20 h-20 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300 pointer-events-none">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Species Directory</h2>
                    <span class="text-[10px] font-semibold bg-sky-100 text-sky-800 px-2 py-0.5 rounded-full">
                        <?php echo count($species_list); ?> Cataloged
                    </span>
                </div>

                <div class="space-y-2 max-h-[50vh] lg:max-h-[70vh] overflow-y-auto no-scrollbar pr-1">
                    <?php foreach ($species_list as $fish): 
                        $isSelected = ($active_fish && $active_fish['id'] == $fish['id']);
                    ?>
                        <a href="/public/fish.php?id=<?php echo $fish['id']; ?>" 
                           class="flex items-center justify-between p-3 rounded-xl border transition-all duration-200 block <?php echo $isSelected ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white/70 border-white text-slate-700 hover:bg-white hover:border-sky-200'; ?>">
                            <div class="truncate pr-2">
                                <span class="font-semibold text-xs block truncate">
                                    <?php echo htmlspecialchars($fish['common_name'] ?? ''); ?>
                                </span>
                                <?php if (!empty($fish['scientific_name'])): ?>
                                    <span class="text-[10px] italic <?php echo $isSelected ? 'text-sky-100' : 'text-slate-400'; ?> block truncate">
                                        <?php echo htmlspecialchars($fish['scientific_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md shrink-0 <?php echo $isSelected ? 'bg-white/20 text-white' : 'bg-sky-50 text-sky-700 border border-sky-100'; ?>">
                                <?php echo htmlspecialchars($fish['local_konkani_name'] ?? ''); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Dynamic Details & Image Display -->
        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar">
            <?php if ($active_fish): ?>
                <div>
                    <!-- Breadcrumb Badge -->
                    <div class="flex items-center space-x-2 text-xs text-sky-700 font-semibold tracking-wider uppercase mb-2">
                        <span>Goan Marine Species</span>
                        <?php if (!empty($active_fish['is_state_fish'])): ?>
                            <span>•</span>
                            <span class="bg-amber-100 text-amber-800 text-[10px] px-2.5 py-0.5 rounded-full font-bold">Official State Fish</span>
                        <?php endif; ?>
                    </div>

                    <!-- Title & Scientific Name -->
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-slate-900 tracking-tight leading-none mb-2">
                                <?php echo htmlspecialchars($active_fish['common_name'] ?? ''); ?>
                            </h1>
                            <p class="text-lg font-serif italic text-sky-700">
                                Konkani: <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($active_fish['local_konkani_name'] ?? 'N/A'); ?></span>
                                <?php if (!empty($active_fish['scientific_name'])): ?>
                                    <span class="text-xs text-slate-400 ml-2">(<?php echo htmlspecialchars($active_fish['scientific_name']); ?>)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <!-- Header Badge Mascot -->
                        <img src="/../Assets/fish.png" alt="Fish Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                    </div>

                    <!-- Dynamic Image with Unsplash Marine Fallback -->
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-md border border-white bg-slate-100 h-64 sm:h-80 w-full">
                        <?php 
                        $image_url = !empty($active_fish['image_url']) 
                            ? htmlspecialchars($active_fish['image_url']) 
                            : 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80';
                        ?>
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($active_fish['common_name'] ?? 'Fish'); ?>" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Key Species Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Habitat & Distribution</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_fish['habitat'] ?? 'Estuarine & Coastal Waters'); ?>
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Traditional Catch Technique</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_fish['catch_method'] ?? 'Gillnets / Cast Nets (Pagel)'); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Narrative Description -->
                    <div class="mb-8">
                        <h2 class="text-lg font-serif font-bold text-slate-900 mb-3 pb-2 border-b border-sky-100">
                            Biological & Culinary Profile
                        </h2>
                        <div class="text-slate-600 text-sm leading-relaxed space-y-4">
                            <p>
                                <?php echo nl2br(htmlspecialchars($active_fish['description'] ?? 'Species details are being documented for the Goan marine repository.')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-12 text-center text-slate-500">
                    <p class="text-lg font-semibold">No species entries found.</p>
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