<section class="mx-auto max-w-7xl px-6 py-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div id="slider" class="flex transition-transform duration-700 ease-in-out">
            <div class="min-w-full">
                <img src="assets/images/sliderimg2.webp.webp" alt="Lifestyle products" class="h-[320px] w-full object-cover md:h-[380px]">
            </div>
            <div class="min-w-full">
                <img src="assets/images/sliderimg3.webp.webp" alt="New arrivals" class="h-[320px] w-full object-cover md:h-[380px]">
            </div>
            <div class="min-w-full">
                <img src="assets/images/sliderimg4.webp.webp" alt="Featured categories" class="h-[320px] w-full object-cover md:h-[380px]">
            </div>
        </div>

        <button id="prevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-1.5 text-lg font-semibold text-slate-900 shadow">
            &#10094;
        </button>
        <button id="nextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 px-3 py-1.5 text-lg font-semibold text-slate-900 shadow">
            &#10095;
        </button>

        <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
            <button class="dot h-2.5 w-2.5 rounded-full bg-white/70" aria-label="Slide 1"></button>
            <button class="dot h-2.5 w-2.5 rounded-full bg-white/70" aria-label="Slide 2"></button>
            <button class="dot h-2.5 w-2.5 rounded-full bg-white/70" aria-label="Slide 3"></button>
        </div>
    </div>
</section>

<script>
    const slider = document.getElementById('slider');
    const slides = document.querySelectorAll('#slider > div');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;
    const totalSlides = slides.length;

    function updateSlider() {
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;

        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-white', index === currentIndex);
            dot.classList.toggle('bg-white/70', index !== currentIndex);
        });
    }

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlider();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateSlider();
        });
    });

    setInterval(() => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlider();
    }, 4500);

    updateSlider();
</script>
