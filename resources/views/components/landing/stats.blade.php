<section class="bg-[#13889B] py-16 border-y-[6px] border-black relative overflow-hidden z-10">
    <div class="max-w-[1280px] mx-auto px-10 max-md:px-5 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            
            <div class="p-8 bg-white rounded-[24px] border-[4px] border-black shadow-[8px_8px_0px_#000] hover:-translate-y-2 hover:shadow-[12px_12px_0px_#000] transition-all duration-300">
                <h3 class="text-6xl font-black text-[#13889B] mb-2 font-mono counter" data-target="{{ $totalUsers }}">0</h3>
                <p class="text-xl text-black font-bold uppercase tracking-wider">Mahasiswa<br>Bergabung</p>
            </div>
            
            <div class="p-8 bg-white rounded-[24px] border-[4px] border-black shadow-[8px_8px_0px_#000] hover:-translate-y-2 hover:shadow-[12px_12px_0px_#000] transition-all duration-300">
                <h3 class="text-6xl font-black text-[#13889B] mb-2 font-mono counter" data-target="{{ $totalTasks }}">0</h3>
                <p class="text-xl text-black font-bold uppercase tracking-wider">Tugas<br>Terkelola</p>
            </div>
            
            <div class="p-8 bg-white rounded-[24px] border-[4px] border-black shadow-[8px_8px_0px_#000] hover:-translate-y-2 hover:shadow-[12px_12px_0px_#000] transition-all duration-300">
                <h3 class="text-6xl font-black text-[#13889B] mb-2 font-mono counter" data-target="{{ $totalGroups }}">0</h3>
                <p class="text-xl text-black font-bold uppercase tracking-wider">Grup<br>Aktif</p>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach(counter => {
                        const updateCounter = () => {
                            const target = +counter.getAttribute('data-target');
                            const c = +counter.innerText;
                            // Menghindari target bernilai 0
                            if(target === 0) {
                                counter.innerText = 0;
                                return;
                            }
                            
                            const increment = target / 50; 

                            if (c < target) {
                                counter.innerText = `${Math.ceil(c + increment)}`;
                                setTimeout(updateCounter, 30);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCounter();
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.bg-[#13889B]');
        if (statsSection) {
            observer.observe(statsSection);
        }
    });
</script>