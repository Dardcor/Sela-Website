@props(['items' => [
    [
        'question' => 'Bagaimana SELA memastikan pembagian tugas dalam kelompok benar-benar adil?',
        'answer' => 'SELA menggunakan algoritma berbasis profil skill, riwayat kontribusi, dan ketersediaan waktu setiap anggota untuk mendistribusikan tugas secara proporsional. Setiap pembagian bersifat transparan dan dapat dilihat oleh seluruh anggota kelompok. Dashboard real-time memudahkan identifikasi ketidakseimbangan beban kerja.',
    ],
    [
        'question' => 'Apakah fitur AI dapat memecah semua jenis tugas akademik?',
        'answer' => 'AI SELA dirancang untuk menangani berbagai jenis tugas akademik — mulai dari laporan tertulis, presentasi, proyek pemrograman, hingga penelitian kelompok. Untuk tugas kreatif atau yang memerlukan judgment khusus, gunakan AI sebagai starting point dan review bersama kelompok sebelum eksekusi.',
    ],
    [
        'question' => 'Bagaimana dosen pembimbing dapat mendeteksi mahasiswa yang tidak berkontribusi (free-rider)?',
        'answer' => 'Dashboard dosen menampilkan laporan kontribusi real-time setiap anggota kelompok, termasuk persentase tugas yang diselesaikan, waktu pengerjaan, dan riwayat aktivitas. Anggota dengan kontribusi rendah secara otomatis ditandai untuk perhatian dosen.',
    ],
    [
        'question' => 'Apakah data akademik dan kredensial login mahasiswa dijamin keamanannya?',
        'answer' => 'Keamanan data adalah prioritas utama kami. Semua data dienkripsi menggunakan standar AES-256, dan autentikasi dilakukan melalui protokol SSO institusi yang aman. Kami tidak pernah menyimpan kata sandi pengguna secara langsung, dan semua akses diaudit untuk compliance.',
    ],
    [
        'question' => 'Apakah aplikasi SELA hanya tersedia di ponsel pintar?',
        'answer' => 'SELA tersedia di platform mobile (Android & iOS) maupun web browser. Kamu bisa mengakses seluruh fitur SELA dari smartphone, tablet, laptop, maupun desktop sesuai preferensimu.',
    ]
]])


<style>
    .faq-item.open .faq-a {
        max-height: 500px;
    }
    .faq-item.open .faq-icon {
        transform: rotate(45deg);
    }
</style>

<section id="faq" class="py-[130px] bg-[#f7f9fc]">
    <div class="max-w-[1280px] mx-auto px-10 max-md:px-5">
        <div class="text-center mb-[80px] reveal">
            <div class="inline-block text-[0.78rem] font-bold uppercase tracking-[2px] text-cyan mb-[16px]">Pertanyaan Umum</div>
            <h2 class="text-[3.2rem] max-[768px]:text-[2.4rem] text-black mb-[20px]">Ada Pertanyaan?<br>Kami Jawab.</h2>
            <p class="text-[1.1rem] text-muted max-w-[680px] mx-auto leading-[1.7]">Temukan jawaban atas pertanyaan yang paling sering ditanyakan tentang SELA.</p>
        </div>
        <div class="max-w-[820px] mx-auto flex flex-col gap-[16px]">
            @foreach($items as $index => $item)
                <div class="faq-item border-[3px] border-black rounded-[20px] bg-white shadow-[4px_4px_0px_#000] overflow-hidden transition-[box-shadow] duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] hover:shadow-neo-cyan reveal d{{ ($index % 3) + 1 }}">
                    <button class="faq-q w-full flex items-center justify-between px-[28px] py-[22px] cursor-pointer bg-transparent border-none text-left font-sans text-[1rem] font-bold text-black" onclick="toggleFaq(this)">
                        <span>{{ $item['question'] }}</span>
                        <span class="faq-icon text-[1.4rem] font-light text-cyan transition-transform duration-300 ease shrink-0">+</span>
                    </button>
                    <div class="faq-a max-h-0 overflow-hidden [transition:max-height_0.4s_ease,padding_0.3s]">
                        <p class="px-[28px] pb-[24px] pt-0 text-[0.97rem] text-muted leading-[1.7]">{{ $item['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
