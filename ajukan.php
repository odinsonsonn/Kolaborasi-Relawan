<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Event - RelawanKita</title>
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
                <div class="bg-green-600 p-2 rounded-lg mr-2 group-hover:bg-green-700 transition shadow-md">
                    <i class="fas fa-hands-helping text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">RelawanKita</span>
            </div>
            
            <a href="index.html" class="flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-full font-semibold hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-green-200">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </nav>

    <section class="py-12 px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-green-700 py-10 px-8 text-white">
                <h1 class="text-3xl font-bold">Ajukan Kegiatan Relawan</h1>
                <p class="mt-2 text-green-100 opacity-90">Bantu kami menghubungkan organisasi Anda dengan relawan hebat di seluruh Indonesia.</p>
            </div>
            
            <form class="p-8 space-y-6" id="eventForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="organizer" required placeholder="Contoh: Yayasan Peduli Hijau" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Lingkungan">Lingkungan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Kegiatan Volunteer <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Aksi Bersih Pantai & Edukasi Mangrove" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Waktu <span class="text-red-500">*</span></label>
                        <input type="time" name="event_time" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" required placeholder="Contoh: Pantai Ancol, Jakarta" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Detail Kegiatan <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="6" required placeholder="Jelaskan secara detail tentang kegiatan volunteer..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Persyaratan & Kualifikasi</label>
                    <textarea name="requirements" rows="4" placeholder="Sebutkan persyaratan yang dibutuhkan relawan..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">URL Gambar Poster (Optional)</label>
                    <input type="url" name="image_url" placeholder="https://example.com/gambar.jpg" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    <p class="text-xs text-gray-500 mt-2">Gunakan link gambar dari internet atau upload ke hosting terlebih dahulu</p>
                </div>

                <!-- Error & Success Messages -->
                <div id="messageBox"></div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-green-200 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan Sekarang
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4 italic">
                        *Admin akan meninjau pengajuan Anda dalam waktu 1x24 jam.
                    </p>
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
                const response = await fetch('api-create.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const text = await response.text();
                
                if (!text) {
                    throw new Error('Response kosong dari server');
                }

                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e, 'Response:', text);
                    throw new Error('Response bukan JSON: ' + text.substring(0, 100));
                }

                if (result.success) {
                    msgBox.innerHTML = `<div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">
                        <i class="fas fa-check-circle mr-2"></i> ${result.message}
                    </div>`;
                    e.target.reset();
                    setTimeout(() => {
                        window.location.href = 'events.php';
                    }, 2000);
                } else {
                    const errors = result.errors?.map(e => `<li>${e}</li>`).join('') || result.error;
                    msgBox.innerHTML = `<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        <i class="fas fa-exclamation-circle mr-2"></i> 
                        ${result.errors ? `<ul class="list-disc ml-6">${errors}</ul>` : errors}
                    </div>`;
                }
            } catch (error) {
                msgBox.innerHTML = `<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    <i class="fas fa-exclamation-circle mr-2"></i> Terjadi kesalahan: ${error.message}
                </div>`;
            } finally {
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>
