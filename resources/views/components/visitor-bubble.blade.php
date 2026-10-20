{{-- ═══ FLOATING DRAGGABLE VISITOR BUBBLE (Warna Biru Identitas Resmi BNN) ═══ --}}
<div id="visitor-draggable-bubble"
     class="fixed z-[99] select-none cursor-grab active:cursor-grabbing touch-none transition-shadow hover:shadow-2xl"
     style="bottom: 24px; right: 24px;"
     title="Klik untuk melihat statistik • Tahan dan geser untuk memindahkan">

    <div class="relative flex items-center gap-3 px-4 py-2.5 rounded-full bg-white/95 dark:bg-surface-900/95 backdrop-blur-md shadow-2xl border border-surface-200/90 dark:border-white/15 hover:border-primary-500/50 dark:hover:border-primary-400/50 transition-all duration-200 hover:scale-105">

        {{-- Icon Mata dalam Lingkaran Biru dengan Indikator Aktif --}}
        <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-50 dark:bg-primary-950/70 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/30 shadow-xs">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{-- Pulse Dot Biru --}}
            <span class="absolute top-0 right-0 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary-500"></span>
            </span>
        </div>

        {{-- Teks & Angka Pengunjung --}}
        <div class="flex flex-col pr-1">
            <span class="text-[9px] font-bold text-surface-400 dark:text-surface-400 uppercase tracking-wider leading-none">
                PENGUNJUNG
            </span>
            <div class="flex items-baseline gap-1.5 mt-0.5">
                <span id="visitor-total-main" class="text-base font-black text-surface-900 dark:text-white tracking-tight leading-none">
                    {{ number_format($totalPengunjung ?? 0, 0, ',', '.') }}
                </span>
                <span class="inline-flex items-center text-[11px] font-bold text-primary-600 dark:text-primary-400 leading-none">
                    <svg class="w-3 h-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span id="visitor-today-main">{{ $pengunjungHariIni ?? 0 }}</span>
                </span>
            </div>
        </div>

        {{-- Grip Handle (Indikator bahwa bubble bisa digeser) --}}
        <div class="flex flex-col gap-0.5 text-surface-400 dark:text-surface-500 pl-1 border-l border-surface-200 dark:border-surface-800 opacity-60">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                <circle cx="8" cy="6" r="2"/>
                <circle cx="16" cy="6" r="2"/>
                <circle cx="8" cy="12" r="2"/>
                <circle cx="16" cy="12" r="2"/>
                <circle cx="8" cy="18" r="2"/>
                <circle cx="16" cy="18" r="2"/>
            </svg>
        </div>
    </div>
</div>

{{-- ═══ SCRIPT DRAGGABLE LOGIC ═══ --}}
<script>
(function() {
    const bubble = document.getElementById('visitor-draggable-bubble');
    if (!bubble) return;

    let isDragging = false;
    let startX = 0, startY = 0;
    let initialLeft = 0, initialTop = 0;
    let hasMoved = false;

    // Pulihkan posisi terakhir dari localStorage jika ada
    function restorePosition() {
        const saved = localStorage.getItem('bnnp-visitor-bubble-pos');
        if (saved) {
            try {
                const pos = JSON.parse(saved);
                const margin = 12;
                const bubbleRect = bubble.getBoundingClientRect();
                const maxLeft = window.innerWidth - (bubbleRect.width || 180) - margin;
                const maxTop = window.innerHeight - (bubbleRect.height || 55) - margin;

                let left = Math.max(margin, Math.min(pos.left, maxLeft));
                let top = Math.max(margin, Math.min(pos.top, maxTop));

                bubble.style.left = left + 'px';
                bubble.style.top = top + 'px';
                bubble.style.right = 'auto';
                bubble.style.bottom = 'auto';
            } catch (e) {
                // Gunakan default bottom-right
            }
        }
    }

    // Jalankan restorasi setelah render awal
    window.addEventListener('DOMContentLoaded', restorePosition);
    setTimeout(restorePosition, 50);

    // Event Pointer / Mouse / Touch
    function onDragStart(e) {
        // Jangan drag jika klik kanan
        if (e.type === 'mousedown' && e.button !== 0) return;

        const clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        const clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;

        startX = clientX;
        startY = clientY;

        const rect = bubble.getBoundingClientRect();
        initialLeft = rect.left;
        initialTop = rect.top;

        hasMoved = false;
        isDragging = true;

        bubble.style.transition = 'none';
        bubble.classList.add('scale-105', 'opacity-90');

        if (e.type === 'mousedown') {
            document.addEventListener('mousemove', onDragMove);
            document.addEventListener('mouseup', onDragEnd);
        } else if (e.type === 'touchstart') {
            document.addEventListener('touchmove', onDragMove, { passive: false });
            document.addEventListener('touchend', onDragEnd);
        }
    }

    function onDragMove(e) {
        if (!isDragging) return;

        const clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        const clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;

        const deltaX = clientX - startX;
        const deltaY = clientY - startY;

        if (Math.abs(deltaX) > 5 || Math.abs(deltaY) > 5) {
            hasMoved = true;
        }

        if (hasMoved) {
            if (e.cancelable) e.preventDefault();

            const margin = 10;
            const bubbleWidth = bubble.offsetWidth;
            const bubbleHeight = bubble.offsetHeight;
            const maxLeft = window.innerWidth - bubbleWidth - margin;
            const maxTop = window.innerHeight - bubbleHeight - margin;

            let newLeft = initialLeft + deltaX;
            let newTop = initialTop + deltaY;

            newLeft = Math.max(margin, Math.min(newLeft, maxLeft));
            newTop = Math.max(margin, Math.min(newTop, maxTop));

            bubble.style.left = newLeft + 'px';
            bubble.style.top = newTop + 'px';
            bubble.style.right = 'auto';
            bubble.style.bottom = 'auto';
        }
    }

    function onDragEnd(e) {
        if (!isDragging) return;
        isDragging = false;

        bubble.style.transition = 'transform 0.15s ease, opacity 0.15s ease';
        bubble.classList.remove('scale-105', 'opacity-90');

        document.removeEventListener('mousemove', onDragMove);
        document.removeEventListener('mouseup', onDragEnd);
        document.removeEventListener('touchmove', onDragMove);
        document.removeEventListener('touchend', onDragEnd);

        if (hasMoved) {
            // Simpan posisi ke localStorage
            const rect = bubble.getBoundingClientRect();
            localStorage.setItem('bnnp-visitor-bubble-pos', JSON.stringify({
                left: rect.left,
                top: rect.top
            }));
        } else {
            // Murni klik/tap tanpa digeser -> Buka modal statistik pengunjung
            if (typeof openVisitorModal === 'function') {
                openVisitorModal();
            }
        }
    }

    bubble.addEventListener('mousedown', onDragStart);
    bubble.addEventListener('touchstart', onDragStart, { passive: true });

    // Handle resize window agar bubble tidak terpotong ke luar layar
    window.addEventListener('resize', function() {
        const rect = bubble.getBoundingClientRect();
        const margin = 10;
        const maxLeft = window.innerWidth - bubble.offsetWidth - margin;
        const maxTop = window.innerHeight - bubble.offsetHeight - margin;

        if (rect.left > maxLeft || rect.top > maxTop) {
            bubble.style.left = Math.max(margin, Math.min(rect.left, maxLeft)) + 'px';
            bubble.style.top = Math.max(margin, Math.min(rect.top, maxTop)) + 'px';
        }
    });
})();
</script>
