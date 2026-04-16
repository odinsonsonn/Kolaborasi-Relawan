
console.log('script.js loaded', typeof openModal);
// ==========================================
// 1. FADE-IN SAAT HALAMAN DIBUKA
// ==========================================
window.addEventListener('DOMContentLoaded', () => {
    // Memberi sedikit jeda agar browser siap me-render
    setTimeout(() => {
        document.body.style.opacity = "1";
    }, 50);
});

// ==========================================
// 2. GLOBAL FADE-OUT SAAT PINDAH HALAMAN
// ==========================================
document.addEventListener('click', (e) => {
    // Cari apakah yang diklik adalah link (<a>)
    const target = e.target.closest('a');
    
    if (target) {
        const href = target.getAttribute('href');
        const targetAttr = target.getAttribute('target');

        // Syarat agar animasi jalan:
        // - Memiliki href
        // - Bukan link internal/anchor (#)
        // - Bukan buka di tab baru (_blank)
        // - Mengarah ke file .html
        if (href && !href.startsWith('#') && targetAttr !== '_blank' && href.includes('.html')) {
            e.preventDefault(); // Tahan perpindahan instan
            
            document.body.style.opacity = "0"; // Mulai memudar
            
            // Pindah halaman setelah animasi pudar selesai (400ms)
            setTimeout(() => {
                window.location.href = href;
            }, 400);
        }
    }
});

// ==========================================
// 3. HIGHLIGHT MENU AKTIF (OTOMATIS)
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('nav a');
    // Ambil nama file saja, misal "contact.html"
    const currentPath = window.location.pathname.split("/").pop() || "index.html";

    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        
        if (linkPath === currentPath) {
            // Gaya untuk menu yang sedang dibuka
            link.classList.add('text-blue-600', 'font-bold', 'border-b-2', 'border-blue-600');
            link.classList.remove('text-gray-600');
        }
    });
});

// ==========================================
// 4. NAVBAR GLASSMORPHISM ON SCROLL
// ==========================================
window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');
    if (window.scrollY > 20) {
        nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-md');
    } else {
        nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-md');
    }
});

// ==========================================
// 5. FORM LOADING SIMULATION
// ==========================================
const forms = ['contactForm', 'submissionForm'];
forms.forEach(id => {
    const f = document.getElementById(id);
    if (f) {
        f.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> Mengirim...`;

            setTimeout(() => {
                alert('✨ Berhasil! Data Anda telah terkirim.');
                btn.disabled = false;
                btn.innerHTML = originalContent;
                this.reset();
            }, 1200);
        });
    }
});



