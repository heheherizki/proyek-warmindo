<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WarmindoKu - Kehangatan Rasa, Harga Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Quicksand', sans-serif; }
    </style>
</head>
<body class="bg-cream-100 text-slate-800">

    @include('layouts.public-navigation')

    <header 
        class="relative h-screen" 
        x-data="{
            images: [
                '/images/slide/slide1-mie-goreng.png',
                '/images/slide/slide2-es-teh.png',
                '/images/slide/slide3-suasana-warmindo.png',
                '/images/slide/slide4-mie-karie.png',
                '/images/slide/slide5-pelanggan-makan.png'
            ],
            activeIndex: 0
        }"
        x-init="setInterval(() => { activeIndex = (activeIndex + 1) % images.length }, 5000)"
    >
        <template x-for="(image, index) in images" :key="index">
            <div 
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                :style="{ 'background-image': `url(${image})` }"
                x-show="activeIndex === index"
                x-transition:enter="ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
        </template>
        
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <div class="relative h-full flex flex-col justify-center items-center text-center text-white p-4">
            <h1 data-aos="fade-up" class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Kehangatan Rasa, Harga Mahasiswa</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-lg md:text-xl mb-8 max-w-2xl drop-shadow-md">Dari Indomie klasik hingga kreasi unik, kami siap memanjakan lidah Anda 24 jam!</p>
            <a data-aos="zoom-in" data-aos-delay="400" href="/menu" class="bg-orange-500 text-white font-bold py-3 px-8 rounded-full text-lg hover:bg-orange-600 transition duration-300 transform hover:scale-110 flex items-center space-x-2">
                <span>Lihat Semua Menu</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </a>
        </div>
    </header>

    <section id="keunggulan" class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 data-aos="fade-up" class="text-3xl font-bold mb-2">Kenapa Memilih WarmindoKu?</h2>
            <p data-aos="fade-up" data-aos-delay="100" class="text-slate-500 mb-12">Kami bukan sekadar warung Indomie biasa.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-orange-100 p-6 rounded-full inline-block mb-4"><svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <h3 class="text-xl font-bold mb-2">Buka 24 Jam</h3>
                    <p class="text-slate-500">Lapar tengah malam? Kami siap melayani Anda kapan saja, tanpa henti.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-orange-100 p-6 rounded-full inline-block mb-4"><svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div>
                    <h3 class="text-xl font-bold mb-2">Harga Mahasiswa</h3>
                    <p class="text-slate-500">Nikmati aneka hidangan lezat tanpa membuat kantong Anda kering.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-orange-100 p-6 rounded-full inline-block mb-4"><svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" /></svg></div>
                    <h3 class="text-xl font-bold mb-2">Varian Unik</h3>
                    <p class="text-slate-500">Mulai dari Indomie Bangladesh hingga Carbonara, kami punya rasa yang tak terduga.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="menu" class="py-20 bg-cream-100">
        <div class="container mx-auto px-6 text-center">
            <h2 data-aos="fade-up" class="text-3xl font-bold mb-2">Menu Andalan Kami</h2>
            <p data-aos="fade-up" data-aos-delay="100" class="text-slate-500 mb-12">Beberapa pilihan favorit pelanggan setia kami.</p>

            <div 
                x-data="{
                    scroller: null,
                    animationFrameId: null,
                    speed: 0.5, // Atur kecepatan di sini (misal: 0.5 untuk pelan, 1 untuk lebih cepat)

                    init() {
                        this.scroller = this.$refs.scroller;
                        this.startScrolling();
                    },

                    animateScroll() {
                        this.scroller.scrollLeft += this.speed;
                        if (this.scroller.scrollLeft >= this.scroller.scrollWidth / 2) {
                            this.scroller.scrollLeft = 0;
                        }
                        this.animationFrameId = requestAnimationFrame(this.animateScroll.bind(this));
                    },

                    startScrolling() {
                        // Hentikan dulu jika sedang berjalan, untuk mencegah duplikasi
                        cancelAnimationFrame(this.animationFrameId);
                        // Mulai loop animasi baru
                        this.animationFrameId = requestAnimationFrame(this.animateScroll.bind(this));
                    },

                    stopScrolling() {
                        cancelAnimationFrame(this.animationFrameId);
                    }
                }"
                class="relative w-full overflow-hidden"
                @mouseover="stopScrolling()"
                @mouseleave="startScrolling()"
            >
                <div x-ref="scroller" class="flex overflow-x-auto scrollbar-hide">
                    @foreach ($featuredProducts as $product)
                        <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 p-4">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                <div class="p-6 text-left">
                                    <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                                    <p class="text-slate-500 text-sm mb-4">{{ Str::limit($product->description, 50) }}</p>
                                    <span class="font-bold text-orange-500 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($featuredProducts as $product)
                        <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 p-4">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                <div class="p-6 text-left">
                                    <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                                    <p class="text-slate-500 text-sm mb-4">{{ Str::limit($product->description, 50) }}</p>
                                    <span class="font-bold text-orange-500 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="lokasi" class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 data-aos="fade-up" class="text-3xl font-bold mb-2">Temukan Kami</h2>
            <p data-aos="fade-up" data-aos-delay="100" class="text-slate-500 mb-8">Kami tunggu kedatangan Anda!</p>
            <p data-aos="fade-up" data-aos-delay="200" class="text-lg">Jl. Kenangan Indah No. 123, Kecamatan Rindu, Kota Kangen</p>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true, 
        });
    </script>
</body>
</html>