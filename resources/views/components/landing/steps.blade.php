@props(['steps' => [
    [
        'number' => '01',
        'title' => 'Registrasi & Pembuatan Grup',
        'description' => 'Masuk menggunakan akun SSO institusi akademikmu dan buat ruang kolaborasi untuk kelompokmu dalam sekejap.',
    ],
    [
        'number' => '02',
        'title' => 'Otomatisasi Tugas',
        'description' => 'Sistem AI menyusun rencana kerja secara cerdas dan membagi porsi tugas ke masing-masing anggota berdasarkan skill.',
    ],
    [
        'number' => '03',
        'title' => 'Eksekusi & Pantauan',
        'description' => 'Setiap anggota fokus mengerjakan tugasnya masing-masing sementara sistem mencatat dan melaporkan progres secara real-time.',
    ],
]])

<section id="how" class="py-[130px] bg-white relative">
    <div class="max-w-[1280px] mx-auto px-10 max-md:px-5">
        <div class="text-center mb-[80px] reveal">
            <div class="inline-block text-[0.78rem] font-bold uppercase tracking-[2px] text-cyan mb-[16px]">Alur Penggunaan</div>
            <h2 class="text-[3.2rem] max-[768px]:text-[2.4rem] text-black mb-[20px]">Mulai dalam<br>3 Langkah Mudah.</h2>
            <p class="text-[1.1rem] text-muted max-w-[680px] mx-auto leading-[1.7]">Tanpa konfigurasi rumit. Langsung kolaborasi secara adil dalam hitungan menit.</p>
        </div>
        <div class="grid grid-cols-3 max-[992px]:grid-cols-1 gap-[36px] max-[992px]:max-w-[480px] max-[992px]:mx-auto">
            @foreach($steps as $index => $step)
                <div class="border-[4px] border-black rounded-[36px] px-[28px] py-[48px] text-center bg-white shadow-neo-hover transition-transform duration-300 ease flex flex-col items-center hover:-translate-y-[14px] {{ $index === 0 ? 'hover:shadow-[12px_24px_0px_var(--color-cyan)]' : ($index === 1 ? 'hover:shadow-[12px_24px_0px_#000]' : 'hover:shadow-[12px_24px_0px_var(--color-cyan-light)]') }} reveal d{{ $index + 1 }}">
                    <div class="font-mono text-[5rem] text-cyan [text-shadow:4px_4px_0px_#000] mb-[18px]">{{ $step['number'] }}</div>
                    <div class="text-[2.5rem] mb-[20px]"></div>
                    <h3 class="text-[1.3rem] text-black mb-[14px]">{{ $step['title'] }}</h3>
                    <p class="text-[0.97rem] text-muted leading-[1.65]">{{ $step['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
