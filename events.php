<?php
require 'config.php';

// Get filter & search
$category_filter = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$query = "SELECT * FROM events WHERE 1=1";

if ($category_filter && $category_filter !== 'all') {
    $category_filter = $conn->real_escape_string($category_filter);
    $query .= " AND category = '$category_filter'";
}

if ($search) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR location LIKE '%$search%')";
}

$query .= " ORDER BY event_date ASC";
$result = $conn->query($query);
$events = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Get unique categories
$category_result = $conn->query("SELECT DISTINCT category FROM events ORDER BY category ASC");
$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan Relawan - RelawanKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            opacity: 0; 
            transition: opacity 0.4s ease-in-out;
        }
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow: hidden; }
        .event-card:hover img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center cursor-pointer" onclick="window.location.href='index.html'">
                    <i class="fas fa-hands-helping text-yellow-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-900">RelawanKita</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="index.html" class="text-gray-600 hover:text-yellow-600 transition font-medium">Beranda</a>
                    <a href="events.php" class="text-yellow-600 font-bold border-b-2 border-yellow-600 pb-1">Kegiatan</a>
                    <a href="ajukan.php" class="text-gray-600 hover:text-yellow-600 transition font-medium">Ajukan Event</a>
                    <a href="about.html" class="text-gray-600 hover:text-yellow-600 transition font-medium">Tentang Kami</a>
                    <a href="contact.html" class="text-gray-600 hover:text-yellow-600 transition font-medium">Kontak</a>
                </div>
                <div class="hidden md:block">
                    <button onclick="window.location.href='ajukan.php'" class="bg-yellow-600 text-white px-6 py-2 rounded-full hover:bg-yellow-700 transition font-medium shadow-md">Mulai Sekarang</button>
                </div>
            </div>
        </div>
    </nav>

    <section class="bg-gradient-to-br from-yellow-50 to-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Temukan Peluang Berikutnya</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Jelajahi berbagai kegiatan relawan yang bermakna sesuai dengan minat dan jadwal Anda.
            </p>
        </div>
    </section>

    <section class="py-8 bg-white border-b sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="get" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-grow relative">
                    <input type="text" name="search" placeholder="Cari kegiatan, lokasi, atau organisasi..." value="<?php echo htmlspecialchars($search); ?>" class="w-full px-6 py-4 pl-12 border border-gray-300 rounded-full focus:ring-2 focus:ring-yellow-500 outline-none transition">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="bg-yellow-600 text-white px-8 py-4 rounded-full hover:bg-yellow-700 transition font-medium flex items-center justify-center gap-2 border border-yellow-600">
                    <i class="fas fa-search"></i> <span>Cari</span>
                </button>
            </form>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="events.php" class="<?php echo (!$category_filter || $category_filter === 'all') ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?> px-5 py-2 rounded-full text-sm font-semibold transition">
                    Semua Kategori
                </a>
                
                <?php foreach ($categories as $cat): ?>
                    <a href="?category=<?php echo urlencode($cat); ?>" class="<?php echo ($category_filter === $cat) ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200'; ?> px-5 py-2 rounded-full text-sm font-medium transition">
                        <i class="fas fa-tag mr-1"></i> <?php echo htmlspecialchars($cat); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <p class="text-gray-600">Menampilkan <span class="font-bold text-yellow-600"><?php echo count($events); ?></span> peluang aktif</p>
                <select class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option>Terbaru</option>
                    <option>Tanggal Terdekat</option>
                </select>
            </div>

            <?php if (count($events) === 0): ?>
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-2xl font-bold text-gray-600">Tidak ada kegiatan ditemukan</p>
                    <p class="text-gray-500 mt-2">Coba ubah filter atau cari dengan kata kunci lain</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($events as $event): ?>
                        <div class="event-card bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 group">
                            <div class="relative overflow-hidden h-52 bg-gray-200">
                                <?php if ($event['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-full object-cover transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-50">
                                        <i class="fas fa-image text-gray-400 text-6xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold text-gray-800 shadow-sm border border-white">
                                    <i class="fas fa-calendar-alt mr-1 text-yellow-600"></i> <?php echo date('d M Y', strtotime($event['event_date'])); ?>
                                </div>
                            </div>
                            <div class="p-6">
                                <span class="bg-yellow-100 text-yellow-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                                    <?php echo htmlspecialchars($event['category']); ?>
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2 group-hover:text-yellow-600 transition">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?>
                                </p>
                                <div class="space-y-2 mb-6 text-sm text-gray-500 font-medium">
                                    <div class="flex items-center"><i class="fas fa-map-marker-alt w-6 text-yellow-500"></i> <?php echo htmlspecialchars($event['location']); ?></div>
                                    <div class="flex items-center"><i class="fas fa-clock w-6 text-yellow-500"></i> <?php echo date('H:i', strtotime($event['event_time'])); ?> WIB</div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="event-detail.php?id=<?php echo $event['id']; ?>" class="flex-1 bg-yellow-600 text-white py-3 rounded-xl hover:bg-yellow-700 transition-all font-bold text-center text-sm shadow-yellow-100 shadow-lg">
                                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                                    </a>
                                    <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="flex-1 bg-yellow-600 text-white py-3 rounded-xl hover:bg-yellow-700 transition-all font-bold text-center text-sm shadow-yellow-100 shadow-lg">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="py-8 text-center text-gray-400 text-sm bg-white border-t">
        <p>&copy; 2026 RelawanKita. Semua hak cipta dilindungi.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
