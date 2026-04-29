@props([
    'row1' => [
        ['initial' => 'D', 'name' => 'Dino Ariel Ihsan Saputra', 'role' => 'Product Owner', 'sub' => 'Jira & Notion', 'gradient' => 'linear-gradient(135deg, var(--color-cyan), var(--color-cyan-bright))', 'links' => ['LN' => '#', 'GH' => '#']],
        ['initial' => 'H', 'name' => 'Havid Rosihandanu', 'role' => 'Backend Developer', 'sub' => 'PostgreSQL & Node.js', 'gradient' => 'linear-gradient(135deg, #1d4ed8, #3b82f6)', 'links' => ['LN' => 'https://www.linkedin.com/in/havid-rosihandanu-538653325/', 'GH' => 'https://github.com/Havidrosihandanu']],
        ['initial' => 'S', 'name' => 'Syahrul Ardi Prasetiyo', 'role' => 'Mobile Developer', 'sub' => 'Flutter & Dart', 'gradient' => 'linear-gradient(135deg, #7c3aed, #a78bfa)', 'links' => ['LN' => '#', 'GH' => 'https://github.com/dardcor/']],
        ['initial' => 'F', 'name' => 'Fahroldhi Sukirno', 'role' => 'DevOps', 'sub' => 'Docker & CI/CD', 'gradient' => 'linear-gradient(135deg, #059669, #34d399)', 'links' => ['LN' => 'https://www.linkedin.com/in/fahroldhi/', 'GH' => 'https://github.com/acalypha9']],
    ],
    'row2' => [
        ['initial' => 'M', 'name' => 'Musthofa Agung Distyawan', 'role' => 'UI/UX Designer', 'sub' => 'Figma & Prototyping', 'gradient' => 'linear-gradient(135deg,#0f766e,#14b8a6)', 'links' => ['LN' => 'https://www.linkedin.com/in/musthofaagungdistyawan/', 'GH' => 'https://github.com/Msthfaa']],
        ['initial' => 'R', 'name' => 'Rafif Ahmad Yudhistira', 'role' => 'Frontend Developer', 'sub' => 'Laravel & Tailwind CSS', 'gradient' => 'linear-gradient(135deg,#b45309,#f59e0b)', 'links' => ['LN' => 'https://www.linkedin.com/in/rafif-ahmad-yudhistira-04836331b/', 'GH' => 'https://github.com/lionz-it']],
        ['initial' => 'Y', 'name' => 'Yosiyanti Cendekia Sari', 'role' => 'QA Engineer', 'sub' => 'Testing & Automation', 'gradient' => 'linear-gradient(135deg,#be185d,#f472b6)', 'links' => ['LN' => '#', 'GH' => '#']],
    ],
])

<section id="team" class="py-[130px] bg-white">
    <div class="max-w-[1280px] mx-auto px-10 max-md:px-5">
        <div class="text-center mb-[80px] reveal">
            <div class="inline-block text-[0.78rem] font-bold uppercase tracking-[2px] text-cyan mb-4">Tim Pengembang</div>
            <h2 class="font-mono uppercase leading-[1.1] text-[3.2rem] mb-[20px] text-black md:text-[3.2rem] text-[2.4rem]">Dibangun oleh<br>Tim yang Berdedikasi.</h2>
            <p class="text-[1.1rem] max-w-[680px] mx-auto leading-[1.7] text-muted">Kami adalah tim mahasiswa yang merasakan langsung masalah free-rider dan bertekad membangun solusinya.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-[28px]">
            @foreach($row1 as $index => $member)
                <div class="border-[4px] border-black rounded-[28px] py-[36px] px-[24px] text-center bg-white shadow-neo transition-all duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] hover:-translate-x-1 hover:-translate-y-1 {{ $index % 2 === 0 ? 'hover:shadow-[10px_10px_0px_var(--color-cyan)]' : 'hover:shadow-neo-hover' }} reveal d{{ $index + 1 }}">
                    <div class="w-[90px] h-[90px] rounded-full flex items-center justify-center text-[2rem] font-mono text-white mx-auto mb-[20px] border-[4px] border-black shadow-[4px_4px_0px_#000]" style="background: {{ $member['gradient'] }};">{{ $member['initial'] }}</div>
                    <div class="font-mono text-[1rem] text-black mb-[6px] uppercase">{{ $member['name'] }}</div>
                    <div class="text-[0.85rem] font-bold text-cyan mb-[4px] uppercase tracking-[0.5px]">{{ $member['role'] }}</div>
                    <div class="text-[0.8rem] text-muted mb-[20px]">{{ $member['sub'] }}</div>
                    <div class="flex justify-center gap-[12px]">
                        @foreach($member['links'] as $label => $url)
                            <a href="{{ $url }}" class="w-[38px] h-[38px] rounded-[10px] border-[2.5px] border-black flex items-center justify-center text-[1rem] transition-all duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] bg-white shadow-[3px_3px_0_#000] hover:bg-black hover:text-white hover:-translate-x-[2px] hover:-translate-y-[2px] hover:shadow-[5px_5px_0_var(--color-cyan)]" title="{{ $label }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[28px] mt-[28px] lg:max-w-[calc(75%+14px)] mx-auto">
            @foreach($row2 as $index => $member)
                <div class="border-[4px] border-black rounded-[28px] py-[36px] px-[24px] text-center bg-white shadow-neo transition-all duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] hover:-translate-x-1 hover:-translate-y-1 {{ $index % 2 === 0 ? 'hover:shadow-[10px_10px_0px_var(--color-cyan)]' : 'hover:shadow-neo-hover' }} reveal d{{ $index + 1 }}">
                    <div class="w-[90px] h-[90px] rounded-full flex items-center justify-center text-[2rem] font-mono text-white mx-auto mb-[20px] border-[4px] border-black shadow-[4px_4px_0px_#000]" style="background:{{ $member['gradient'] }};">{{ $member['initial'] }}</div>
                    <div class="font-mono text-[1rem] text-black mb-[6px] uppercase">{{ $member['name'] }}</div>
                    <div class="text-[0.85rem] font-bold text-cyan mb-[4px] uppercase tracking-[0.5px]">{{ $member['role'] }}</div>
                    <div class="text-[0.8rem] text-muted mb-[20px]">{{ $member['sub'] }}</div>
                    <div class="flex justify-center gap-[12px]">
                        @foreach($member['links'] as $label => $url)
                            <a href="{{ $url }}" class="w-[38px] h-[38px] rounded-[10px] border-[2.5px] border-black flex items-center justify-center text-[1rem] transition-all duration-200 ease-[cubic-bezier(0.19,1,0.22,1)] bg-white shadow-[3px_3px_0_#000] hover:bg-black hover:text-white hover:-translate-x-[2px] hover:-translate-y-[2px] hover:shadow-[5px_5px_0_var(--color-cyan)]" title="{{ $label }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
