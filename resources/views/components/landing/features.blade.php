@props(['features' => [
    [
        'number' => '01',
        'title' => 'Generate Sub-Tugas Otomatis (AI)',
        'description' => 'AI SELA memecah tugas besar menjadi langkah-langkah kecil yang actionable secara instan — tidak perlu rapat panjang untuk membagi pekerjaan.',
        'points' => [
            'Input judul tugas, AI langsung buat breakdown sub-tugas',
            'Sub-tugas terstruktur dan dapat langsung didelegasikan',
            'Didukung berbagai jenis proyek akademik',
        ],
        'reverse' => false,
        'preview' => 'checklist',
    ],
    [
        'number' => '02',
        'title' => 'Pembagian Tugas Berkeadilan',
        'description' => 'Algoritma SELA mendistribusikan beban kerja secara proporsional berdasarkan skill dan ketersediaan masing-masing anggota kelompok.',
        'points' => [
            'Profil skill setiap anggota diperhitungkan otomatis',
            'Beban kerja terdistribusi merata & proporsional',
            'Semua anggota dapat melihat pembagian secara transparan',
        ],
        'reverse' => true,
        'preview' => 'skillbars',
    ],
    [
        'number' => '03',
        'title' => 'Dashboard Pemantauan Dosen',
        'description' => 'Dosen mendapatkan laporan kontribusi real-time setiap anggota kelompok — penilaian objektif berbasis data, bukan asumsi.',
        'points' => [
            'Laporan kontribusi real-time setiap anggota',
            'Grafik progres kemajuan per kelompok',
            'Deteksi otomatis anggota dengan kontribusi rendah',
        ],
        'reverse' => false,
        'preview' => 'analytics',
    ],
]])

<section id="features" class="py-[120px] bg-black text-white border-t-[8px] border-black rounded-t-[60px] -mt-[60px] relative z-20">
    <div class="max-w-[1280px] mx-auto px-10 max-md:px-5">
        <div class="text-center mb-[80px] reveal">
            <div class="inline-block text-[0.78rem] font-bold uppercase tracking-[2px] text-cyan mb-[16px]">Fitur Unggulan</div>
            <h2 class="text-[3.2rem] max-[768px]:text-[2.4rem] mb-[20px] text-cyan">Didesain untuk<br>Kolaborasi Nyata.</h2>
            <p class="text-[1.1rem] max-w-[680px] mx-auto leading-[1.7] text-[#ccc]">Setiap fitur SELA dirancang untuk menghilangkan ketidakadilan dalam kerja kelompok dan memberdayakan setiap anggota tim.</p>
        </div>

        <div class="flex flex-col gap-[100px]">
            @foreach($features as $feature)
                <div class="grid grid-cols-2 max-[992px]:grid-cols-1 gap-[80px] max-[992px]:gap-[40px] items-center {{ $feature['reverse'] ? '[direction:rtl] [&>*]:[direction:ltr] max-[992px]:[direction:ltr]' : '' }} reveal">
                    <div>
                        <div class="inline-flex items-center gap-[8px] bg-[#09637e]/20 border-[1.5px] border-cyan text-cyan text-[0.75rem] font-bold uppercase tracking-[1.5px] py-[6px] px-[14px] rounded-full mb-[20px]"><span class="w-[6px] h-[6px] bg-cyan rounded-full"></span>Fitur {{ $feature['number'] }}</div>
                        <span class="font-mono text-[5rem] leading-none text-transparent [-webkit-text-stroke:2px_#333] mb-[8px] block">{{ $feature['number'] }}</span>
                        <h3 class="text-[2.2rem] text-white mb-[18px] leading-[1.15]">{{ $feature['title'] }}</h3>
                        <p class="text-[1.05rem] text-[#aaa] leading-[1.75] mb-[28px]">{{ $feature['description'] }}</p>
                        <div class="flex flex-col gap-[12px] mb-[32px]">
                            @foreach($feature['points'] as $point)
                                <div class="flex items-start gap-[12px]"><div class="w-[20px] h-[20px] rounded-full bg-gradient-to-r from-cyan to-cyan-bright shrink-0 mt-[2px] flex items-center justify-center after:content-[''] after:w-1.5 after:h-1.5 after:bg-white after:rounded-full"></div><span class="text-[0.95rem] text-[#ccc] leading-[1.6]">{{ $point }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative flex justify-center items-center min-h-[540px] max-[992px]:min-h-[420px]">
                        <div class="absolute w-[300px] h-[300px] bg-cyan rounded-full blur-[80px] opacity-20"></div>
                        <div class="w-[260px] h-[520px] bg-[#111] rounded-[40px] border-[10px] border-[#2a2a2a] shadow-[20px_20px_0_#09637E] relative z-[2] overflow-hidden transition duration-300 hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[24px_24px_0_#09637E]">
                            <div class="h-full flex flex-col items-center justify-center gap-[12px] py-[24px] px-[20px]">
                                <div style="width:100%;padding:10px 4px;">
                                    <div style="height:7px;background:#333;border-radius:6px;width:{{ $feature['preview'] === 'checklist' ? '60' : ($feature['preview'] === 'skillbars' ? '55' : '65') }}%;margin-bottom:14px;"></div>
                                    <div class="w-full p-0 flex flex-col gap-[8px]">
                                        @if($feature['preview'] === 'checklist')
                                            <div class="flex items-center gap-[10px] py-[10px] px-[12px] border-b border-[#222] rounded-[10px] bg-[#1a1a1a] mb-[4px]"><div class="w-[18px] h-[18px] rounded-[6px] border-2 border-cyan shrink-0 bg-cyan"></div><div class="h-[8px] rounded-[8px] flex-1 bg-[#555]" style="width:75%;"></div></div>
                                            <div class="flex items-center gap-[10px] py-[10px] px-[12px] border-b border-[#222] rounded-[10px] bg-[#1a1a1a] mb-[4px]"><div class="w-[18px] h-[18px] rounded-[6px] border-2 border-cyan shrink-0 bg-cyan"></div><div class="h-[8px] rounded-[8px] flex-1 bg-[#555]" style="width:60%;"></div></div>
                                            <div class="flex items-center gap-[10px] py-[10px] px-[12px] border-b border-[#222] rounded-[10px] bg-[#1a1a1a] mb-[4px]"><div class="w-[18px] h-[18px] rounded-[6px] border-2 border-[#444] shrink-0"></div><div class="h-[8px] rounded-[8px] bg-[#333] flex-1" style="width:85%;"></div></div>
                                            <div class="flex items-center gap-[10px] py-[10px] px-[12px] border-b border-[#222] rounded-[10px] bg-[#1a1a1a] mb-[4px]"><div class="w-[18px] h-[18px] rounded-[6px] border-2 border-[#444] shrink-0"></div><div class="h-[8px] rounded-[8px] bg-[#333] flex-1" style="width:50%;"></div></div>
                                            <div class="flex items-center gap-[10px] py-[10px] px-[12px] border-b border-[#222] rounded-[10px] bg-[#1a1a1a] mb-[4px]"><div class="w-[18px] h-[18px] rounded-[6px] border-2 border-[#444] shrink-0"></div><div class="h-[8px] rounded-[8px] bg-[#333] flex-1" style="width:70%;"></div></div>
                                        @elseif($feature['preview'] === 'skillbars')
                                            @php
                                                $skills = [
                                                    ['name' => 'Rafif — Frontend', 'pct' => '85', 'color' => 'bg-gradient-to-r from-cyan to-cyan-bright'],
                                                    ['name' => 'Aldi — Backend', 'pct' => '78', 'color' => 'bg-gradient-to-r from-[#22c55e] to-[#16a34a]'],
                                                    ['name' => 'Sari — Mobile', 'pct' => '70', 'color' => 'bg-gradient-to-r from-[#f97316] to-[#ea580c]'],
                                                    ['name' => 'Dimas — AI', 'pct' => '92', 'color' => 'bg-gradient-to-r from-cyan to-cyan-bright'],
                                                ];
                                            @endphp
                                            @foreach($skills as $skill)
                                                <div class="bg-[#1a1a1a] rounded-[10px] py-[10px] px-[12px] mb-[4px]">
                                                    <div class="flex justify-between mb-[6px]"><span class="text-[0.7rem] text-[#777] font-semibold">{{ $skill['name'] }}</span><span class="text-[0.7rem] text-[#777] font-semibold">{{ $skill['pct'] }}%</span></div>
                                                    <div class="h-[8px] bg-[#2a2a2a] rounded-[10px] overflow-hidden"><div class="h-full rounded-[10px] {{ $skill['color'] }}" style="width:{{ $skill['pct'] }}%;"></div></div>
                                                </div>
                                            @endforeach
                                        @elseif($feature['preview'] === 'analytics')
                                            @php
                                                $analytics = [
                                                    ['bg' => 'var(--color-cyan)', 'pct' => '90', 'color' => 'bg-gradient-to-r from-cyan to-cyan-bright', 'style' => ''],
                                                    ['bg' => '#1d4ed8', 'pct' => '72', 'color' => 'bg-gradient-to-r from-[#22c55e] to-[#16a34a]', 'style' => ''],
                                                    ['bg' => '#7c3aed', 'pct' => '15', 'color' => 'bg-gradient-to-r from-[#f97316] to-[#ea580c]', 'style' => 'color:#f97316;'],
                                                    ['bg' => '#059669', 'pct' => '88', 'color' => 'bg-gradient-to-r from-cyan to-cyan-bright', 'style' => ''],
                                                ];
                                            @endphp
                                            @foreach($analytics as $item)
                                                <div class="flex items-center gap-[10px] py-[8px] px-[12px] bg-[#1a1a1a] rounded-[10px] mb-[4px]">
                                                    <div class="w-[26px] h-[26px] rounded-full shrink-0" style="background:{{ $item['bg'] }};"></div>
                                                    <div class="flex-1 h-[8px] rounded-[10px] overflow-hidden bg-[#2a2a2a]"><div class="h-full rounded-[10px] {{ $item['color'] }}" style="height:100%;width:{{ $item['pct'] }}%;"></div></div>
                                                    <div class="text-[0.7rem] text-[#aaa] font-bold min-w-[28px] text-right" @if($item['style']) style="{{ $item['style'] }}" @endif>{{ $item['pct'] }}%</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div style="margin-top:{{ $feature['preview'] === 'checklist' ? '16' : '12' }}px;padding:10px;background:#1a1a1a;border-radius:12px;border:1px dashed #333;text-align:center;">
                                        <div style="font-size:0.65rem;color:#444;text-transform:uppercase;letter-spacing:1px;">Ganti dengan screenshot app</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
