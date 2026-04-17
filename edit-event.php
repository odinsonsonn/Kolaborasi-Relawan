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
    <title>Edit Event - RelawanKita</title>
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
    
    <nav class="bg-white shadow-sm h-20 flex items-center sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 w-full flex justify-between items-center">
            <div class="flex items-center cursor-pointer group" onclick="window.location.href='index.html'">
                <div class="bg-yellow-600 p-2 rounded-lg mr-2 group-hover:bg-yellow-700 transition shadow-md">
                    <i class="fas fa-hands-helping text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">RelawanKita</span>
            </div>
            
            <a href="events.php" class="flex items-center gap-2 bg-yellow-600 text-white px-5 py-2.5 rounded-full font-semibold hover:bg-yellow-700 transition-all duration-300 shadow-lg hover:shadow-yellow-200">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Kembali ke Kegiatan</span>
            </a>
        </div>
    </nav>

    <section class="py-12 px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 py-10 px-8 text-white">
                <h1 class="text-3xl font-bold">Edit Kegiatan Relawan</h1>
                <p class="mt-2 text-yellow-100 opacity-90">Perbarui informasi kegiatan volunteer Anda.</p>
            </div>
            
            <form class="p-8 space-y-6" id="eventForm">
                <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="organizer" required value="<?php echo htmlspecialchars($event['organizer']); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                            <option value="Pendidikan" <?php echo $event['category'] === 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                            <option value="Lingkungan" <?php echo $event['category'] === 'Lingkungan' ? 'selected' : ''; ?>>Lingkungan</option>
                            <option value="Kesehatan" <?php echo $event['category'] === 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                            <option value="Sosial" <?php echo $event['category'] === 'Sosial' ? 'selected' : ''; ?>>Sosial</option>
                            <option value="Olahraga" <?php echo $event['category'] === 'Olahraga' ? 'selected' : ''; ?>>Olahraga</option>
                            <option value="Lainnya" <?php echo $event['category'] === 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required value="<?php echo htmlspecialchars($event['title']); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" required value="<?php echo $event['event_date']; ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Waktu <span class="text-red-500">*</span></label>
                        <input type="time" name="event_time" required value="<?php echo $event['event_time']; ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" required value="<?php echo htmlspecialchars($event['location']); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Detail <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition"><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Persyaratan & Kualifikasi</label>
                    <textarea name="requirements" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition"><?php echo htmlspecialchars($event['requirements'] ?? ''); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">URL Gambar Poster</label>
                    <input type="url" name="image_url" value="<?php echo htmlspecialchars($event['image_url'] ?? ''); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                </div>

                <!-- Messages -->
                <div id="messageBox"></div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-yellow-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-yellow-700 transition-all shadow-lg hover:shadow-yellow-200" id="submitBtn">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                    <button type="button" onclick="deleteEvent(<?php echo $event['id']; ?>)" class="flex-1 bg-red-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-red-700 transition-all shadow-lg hover:shadow-red-200">
                        <i class="fas fa-trash mr-2"></i> Hapus Event
                    </button>
                </div>
            </form>
        </div>
    </section>

    <footer class="py-8 text-center text-gray-400 text-sm">
        <p>&copy; 2026 RelawanKita. Semua hak cipta dilindungi.</p>
    </footer>

    <script src="script.js"></script>
    <script>
        document.getElementById('eventForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            const btn = document.getElementById('submitBtn');
            const msgBox = document.getElementById('messageBox');
            
            btn.disabled = true;
            msgBox.innerHTML = '';

            try {
                const response = await fetch('api-update.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    msgBox.innerHTML = `<div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl">
                        <i class="fas fa-check-circle mr-2"></i> ${result.message}
                    </div>`;
                    setTimeout(() => {
                        window.location.href = 'event-detail.php?id=' + data.id;
                    }, 1500);
                } else {
                    const errors = result.errors?.map(e => `<li>${e}</li>`).join('') || result.error;
                    msgBox.innerHTML = `<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <i class="fas fa-exclamation-circle mr-2"></i> 
                        ${result.errors ? `<ul class="list-disc ml-6">${errors}</ul>` : errors}
                    </div>`;
                }
            } catch (error) {
                msgBox.innerHTML = `<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <i class="fas fa-exclamation-circle mr-2"></i> Terjadi kesalahan: ${error.message}
                </div>`;
            } finally {
                btn.disabled = false;
            }
        });

        async function deleteEvent(id) {
            if (confirm('Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.')) {
                try {
                    const response = await fetch('api-delete.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + id
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Event berhasil dihapus!');
                        window.location.href = 'events.php';
                    } else {
                        alert('Error: ' + result.error);
                    }
                } catch (error) {
                    alert('Terjadi kesalahan: ' + error.message);
                }
            }
        }
    </script>
</body>
</html>
