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
                    <div class="bg-orange-100 p-6 rounded-full inline-block mb-4"><svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.75A.75.75 0 013 4.5h.75m0 0h.75a.75.75 0 01.75.75v.75m0 0h-.75a.75.75 0 01-.75-.75V5.25m0 0v-.75A.75.75 0 013 4.5h.75M3 12h18M3 15h18" /></svg></div>
                    <h3 class="text-xl font-bold mb-2">Harga Mahasiswa</h3>
                    <p class="text-slate-500">Nikmati aneka hidangan lezat tanpa membuat kantong Anda kering.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-orange-100 p-6 rounded-full inline-block mb-4"><svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5A.75.75 0 0114.25 12h.01a.75.75 0 01.75.75v7.5m4.138-8.506c-.054.04-.107.081-.16.122l-4.13-1.652a.75.75 0 00-.7.017l-4.13 1.65a.75.75 0 00-.363 1.118l1.972 4.93a.75.75 0 001.275.242l2.36-2.36a.75.75 0 011.06 0l2.36 2.36a.75.75 0 001.275-.242l1.972-4.93a.75.75 0 00-.363-1.118l-4.13-1.652a.75.75 0 00-.7-.017z" /></svg></div>
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
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                @foreach ($featuredProducts as $product)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 + 100 }}" class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    
                    {{-- Gunakan path dari database, pastikan data di database benar --}}
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="w-full h-48 object-cover">
                    
                    <div class="p-6 text-left">
                        <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ $product->description }}</p>
                        <span class="font-bold text-orange-500 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach

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