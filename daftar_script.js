function openModal() {
    const modal = document.getElementById('registrationModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('registrationModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    document.getElementById('formStatus').classList.add('hidden');
}

async function submitForm(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const status = document.getElementById('formStatus');
    const formData = new FormData(e.target);

    // Loading State
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Memproses...';

    try {
        const response = await fetch('process-register.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();

        status.classList.remove('hidden');
        if (result.success) {
            status.className = "mb-4 p-4 rounded-xl text-sm font-medium bg-green-50 text-green-700 border border-green-100";
            status.innerHTML = "✅ " + result.message;
            e.target.reset();
            setTimeout(closeModal, 3000);
        } else {
            status.className = "mb-4 p-4 rounded-xl text-sm font-medium bg-red-50 text-red-700 border border-red-100";
            status.innerHTML = "❌ " + result.message;
        }
    } catch (error) {
        status.classList.remove('hidden');
        status.className = "mb-4 p-4 rounded-xl text-sm font-medium bg-red-50 text-red-700 border border-red-100";
        status.innerHTML = "❌ Terjadi kesalahan koneksi.";
    } finally {
        btn.disabled = false;
        btn.innerHTML = 'Kirim Pendaftaran <i class="fas fa-paper-plane ml-2"></i>';
    }
}