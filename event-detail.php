<?php
require 'config.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: events.php");
    exit;
}

$id = intval($id);
$result = $conn->query("SELECT * FROM events WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    header("Location: events.php");
    exit;
}

$event = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> - RelawanKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            opacity: 0; 
            transition: opacity 0.4s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center cursor-pointer" onclick="window.location.href='index.html'">
                    <i class="fas fa-hands-helping text-green-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-900">RelawanKita</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="index.html" class="text-gray-600 hover:text-green-600 transition font-medium">Beranda</a>
                    <a href="events.php" class="text-green-600 font-bold border-b-2 border-green-600 pb-1">Kegiatan</a>
                    <a href="ajukan.html" class="text-gray-600 hover:text-green-600 transition font-medium">Ajukan Event</a>
                    <a href="about.html" class="text-gray-600 hover:text-green-600 transition font-medium">Tentang Kami</a>
                    <a href="contact.html" class="text-gray-600 hover:text-green-600 transition font-medium">Kontak</a>
                </div>
                <div class="hidden md:block">
                    <button onclick="window.location.href='ajukan.html'" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition font-medium shadow-md">Mulai Sekarang</button>
                </div>
            </div>
        </div>
    </nav>

    <section class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="events.php" class="text-green-600 hover:text-green-700 font-semibold flex items-center gap-2 mb-6">
                <i class="fas fa-arrow-left"></i> Kembali ke Kegiatan
            </a>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Image Section -->
                <div class="relative h-96 bg-gray-200 overflow-hidden">
                    <?php if ($event['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-50">
                            <i class="fas fa-image text-gray-400 text-8xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold text-gray-800 shadow-sm">
                        <?php echo htmlspecialchars($event['category']); ?>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </h1>

                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal</p>
                                    <p class="text-lg font-bold text-gray-900">
                                        <?php echo date('d F Y', strtotime($event['event_date'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-green-600 text-2xl"></i>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Waktu</p>
                                    <p class="text-lg font-bold text-gray-900">
                                        <?php echo date('H:i', strtotime($event['event_time'])); ?> WIB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Lokasi</p>
                                    <p class="text-lg font-bold text-gray-900">
                                        <?php echo htmlspecialchars($event['location']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Lengkap</h2>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                        </p>
                    </div>

                    <!-- Organizer -->
                    <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-building text-green-600"></i> Penyelenggara
                        </h3>
                        <p class="text-gray-600 text-lg">
                            <?php echo htmlspecialchars($event['organizer'] ?? 'Belum ditentukan'); ?>
                        </p>
                    </div>

                    <!-- Requirements -->
                    <?php if (!empty($event['requirements'])): ?>
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-list-check text-green-600"></i> Persyaratan
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                <?php echo nl2br(htmlspecialchars($event['requirements'])); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-gray-200">
                        <button onclick="alert('Fitur pendaftaran akan segera tersedia!')" class="flex-1 bg-green-600 text-white py-4 rounded-xl hover:bg-green-700 transition-all font-bold text-lg shadow-lg shadow-green-200">
                            <i class="fas fa-check-circle mr-2"></i> Daftar Sekarang
                        </button>
                        <button onclick="window.location.href='events.php'" class="flex-1 bg-gray-100 text-gray-700 py-4 rounded-xl hover:bg-gray-200 transition-all font-bold text-lg border border-gray-200">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-8 text-center text-gray-400 text-sm bg-white border-t mt-16">
        <p>&copy; 2026 RelawanKita. Semua hak cipta dilindungi.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
