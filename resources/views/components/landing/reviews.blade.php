@props(['reviews' => [
    [
        'badge' => 'mhs',
        'text' => '"Serius, ini game-changer buat tugas kelompok! Sebelumnya selalu ada yang numpang nama, sekarang semua kebagian tugas sesuai kemampuan dan kelihatan ngerjainnya. Drama bebas!"',
        'name' => 'Anisa Rahmawati',
        'role' => 'Teknik Informatika, Universitas Brawijaya',
        'initial' => 'A',
        'color' => 'c1',
    ],
    [
        'badge' => 'dosen',
        'text' => '"Sebagai dosen, penilaian kelompok selalu jadi tantangan. Dengan SELA, saya bisa melihat kontribusi nyata setiap mahasiswa — bukan sekadar laporan akhir yang bisa diklaim siapa saja."',
        'name' => 'Dr. Budi Santosa, M.Kom',
        'role' => 'Dosen, Universitas Indonesia',
        'initial' => 'B',
        'color' => 'c4',
    ],
    [
        'badge' => 'mhs',
        'text' => '"AI-nya bikin gue takjub. Tinggal input judul tugas besar, dalam hitungan detik langsung ada breakdown sub-tugas yang logis dan siap dibagi ke masing-masing anggota. Efisiensi banget!"',
        'name' => 'Rizky Firmansyah',
        'role' => 'Sistem Informasi, Institut Teknologi Bandung',
        'initial' => 'R',
        'color' => 'c2',
    ],
    [
        'badge' => 'dosen',
        'text' => '"Dashboard pemantauan SELA memangkas waktu saya dalam mengevaluasi kelas secara drastis. Grafik progres per kelompok sangat informatif dan membantu saya memberikan feedback yang lebih tepat sasaran."',
        'name' => 'Prof. Siti Marlinda, Ph.D',
        'role' => 'Dosen Senior, Universitas Gadjah Mada',
        'initial' => 'S',
        'color' => 'c3',
    ],
]])

<section id="reviews" class="py-[130px] max-[768px]:py-[70px] bg-black text-white rounded-t-[60px] max-[480px]:rounded-t-[36px] relative">
    <div class="max-w-[1280px] mx-auto px-10 max-[768px]:px-5">
        <div class="text-center mb-[80px] max-[768px]:mb-[48px] reveal">
            <div class="inline-block text-[0.78rem] font-bold uppercase tracking-[2px] text-cyan mb-4">Testimoni Pengguna</div>
            <h2 class="font-mono uppercase leading-[1.1] text-[3.2rem] max-[768px]:text-[2.4rem] max-[480px]:text-[1.7rem] mb-[20px] text-cyan">Dipercaya oleh<br>Mahasiswa & Dosen.</h2>
            <p class="text-[1.1rem] max-[480px]:text-[0.95rem] max-w-[680px] mx-auto leading-[1.7] text-[#aaa]">Dengarkan langsung pengalaman mereka yang telah merasakan manfaat SELA.</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-[28px] max-[480px]:gap-[20px]">
            @foreach($reviews as $index => $review)
                <div class="bg-[#111] border-[3px] max-[480px]:border-[2.5px] border-[#2a2a2a] rounded-[28px] max-[480px]:rounded-[20px] p-[36px] max-[480px]:p-[24px] transition-all duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] relative hover:border-cyan hover:-translate-y-[6px] hover:shadow-[0_12px_32px_rgba(9,99,126,0.25)] reveal d{{ $index + 1 }}">
                    <span class="absolute top-[20px] max-[480px]:top-[14px] right-[20px] max-[480px]:right-[14px] text-[0.72rem] font-bold uppercase tracking-[1px] px-[12px] py-[5px] rounded-full {{ $review['badge'] === 'mhs' ? 'bg-[rgba(9,99,126,0.25)] text-cyan' : 'bg-[rgba(124,58,237,0.25)] text-[#a78bfa]' }}">
                        {{ $review['badge'] === 'mhs' ? 'Mahasiswa' : 'Dosen' }}
                    </span>
                    <div class="text-[#fbbf24] text-[1.2rem] mb-[18px] tracking-[2px]">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p class="text-[1.05rem] max-[480px]:text-[0.92rem] text-[#ddd] leading-[1.75] italic mb-[28px] max-[480px]:mb-[20px]">{{ $review['text'] }}</p>
                    <div class="flex items-center gap-4">
                        <div class="w-[52px] h-[52px] max-[480px]:w-[42px] max-[480px]:h-[42px] rounded-full flex items-center justify-center text-[1.4rem] max-[480px]:text-[1.1rem] font-bold text-white border-[3px] max-[480px]:border-[2px] border-[#333] shrink-0" 
                             style="{{ $review['color'] === 'c1' ? 'background: var(--color-cyan);' : ($review['color'] === 'c2' ? 'background: linear-gradient(135deg, var(--color-cyan), var(--color-cyan-bright));' : ($review['color'] === 'c3' ? 'background: #1d4ed8;' : 'background: #7c3aed;')) }}">
                            {{ $review['initial'] }}
                        </div>
                        <div>
                            <div class="font-bold text-[1rem] text-white">{{ $review['name'] }}</div>
                            <div class="text-[0.85rem] text-[#777] mt-[3px]">{{ $review['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
