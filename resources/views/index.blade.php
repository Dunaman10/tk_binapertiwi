<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK Bina Pertiwi - Monitoring Perkembangan Edukasi Anak Usia Dini</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .font-sans { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-linear-to-br from-blue-500 to-pink-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        BP
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">TK Bina Pertiwi</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#beranda" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                    <a href="#profil" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Profil</a>
                    <a href="#gallery" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Galeri</a>
                    <a href="#kontak" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Kontak</a>
                    <a href="/auth" class="px-6 py-2.5 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:scale-105 transition-all duration-300">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-blue-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-br from-blue-50 via-white to-pink-50 -z-10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-pink-100/50 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left space-y-8">
                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight text-slate-900">
                        Sistem Monitoring <br>
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-pink-500">
                            Perkembangan Anak
                        </span>
                        <br> Usia Dini
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Pantau perkembangan edukasi anak secara terstruktur dan terukur melalui platform berbasis web dengan dukungan fuzzy logic. Pendidikan terbaik untuk masa depan buah hati Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#profil" class="px-8 py-4 rounded-full bg-blue-600 text-white font-bold text-lg shadow-xl shadow-blue-500/30 hover:bg-blue-700 hover:scale-105 transition-all duration-300">
                            Pelajari lebih lanjut
                        </a>
                    </div>
                </div>

                <!-- Hero Image/Visual -->
                <div class="relative lg:h-125 w-full flex items-center justify-center">
                   <div class="relative w-full aspect-video rounded-3xl overflow-hidden shadow-2xl shadow-blue-900/10 border-4 border-white transform rotate-2 hover:rotate-0 transition-all duration-500">
                        <!-- Placeholder for Hero Image -->
                        <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?q=80&w=2070&auto=format&fit=crop"
                             alt="Anak-anak belajar"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-linear-to-t from-black/30 to-transparent"></div>
                   </div>
                   <!-- Floating Badge -->
                   <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 animate-bounce cursor-default hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 p-2 rounded-full text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">Terakreditasi A</p>
                                <p class="text-xs text-slate-500">Pendidikan Berkualitas</p>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile & Info Section -->
    <section id="profil" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- Profile Content -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">Profil {{ $profile->name ?? 'TK Bina Pertiwi' }}</h2>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $profile->description ?? 'TK Bina Pertiwi adalah lembaga PAUD yang berfokus pada keceriaan dan karakter anak.' }}
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100 hover:shadow-lg transition-all duration-300">
                            <h3 class="text-xl font-bold text-blue-700 mb-3">Visi</h3>
                            <p class="text-slate-600 text-sm">{{ $profile->vision ?? 'Menjadi TK unggulan...' }}</p>
                        </div>
                        <div class="bg-pink-50 p-6 rounded-3xl border border-pink-100 hover:shadow-lg transition-all duration-300">
                            <h3 class="text-xl font-bold text-pink-700 mb-3">Misi</h3>
                            <p class="text-slate-600 text-sm">{{ $profile->mission ?? 'Menyelenggarakan kegiatan pembelajaran...' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Informasi TK</h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-white p-3 rounded-full shadow-sm text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Alamat</p>
                                <p class="text-slate-600">{{ $profile->address ?? 'Alamat belum diisi' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-white p-3 rounded-full shadow-sm text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Telepon</p>
                                <p class="text-slate-600">{{ $profile->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-white p-3 rounded-full shadow-sm text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Email</p>
                                <p class="text-slate-600">{{ $profile->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-slate-50 relative overflow-hidden">
         <!-- Decorative Blobs -->
         <div class="absolute top-0 left-0 -ml-20 -mt-20 w-80 h-80 rounded-full bg-blue-200/30 blur-3xl"></div>
         <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-80 h-80 rounded-full bg-pink-200/30 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Fitur Utama Sistem</h2>
                <p class="text-slate-600">Dirancang khusus untuk mendukung kolaborasi sinergis antara Admin, Guru, dan Orang Tua demi perkembangan anak yang optimal.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 cursor-default group">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Admin</h3>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div> Kelola profil TK, user, guru, & anak</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div> Kelola arsip & data perkembangan</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div> Generate laporan otomatis</li>
                    </ul>
                </div>

                <!-- Feature Card 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 cursor-default group">
                    <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Guru</h3>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pink-400"></div> Input perkembangan (Fuzzy Logic)</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pink-400"></div> Kelola arsip kelas</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-pink-400"></div> Cetak laporan perkembangan</li>
                    </ul>
                </div>

                <!-- Feature Card 3 -->
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 cursor-default group">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Orang Tua</h3>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-purple-400"></div> Melihat ringkasan grafik anak</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-purple-400"></div> Download / cetak laporan</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-purple-400"></div> Memantau kolaborasi dengan guru</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Gallery Kegiatan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Momen-momen ceria dan kegiatan edukatif yang terekam dalam keseharian anak-anak di TK Bina Pertiwi.</p>
            </div>

            <!-- Bento Grid Gallery -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 auto-rows-[200px]">
                @forelse($galleries as $gallery)
                    <div class="relative rounded-3xl overflow-hidden group shadow-lg {{ $loop->first ? 'col-span-2 row-span-2' : '' }}">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $gallery->title }}">
                        <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <p class="text-white font-medium">{{ $gallery->title }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-12 text-center text-slate-500 bg-slate-50 rounded-3xl border border-slate-100 border-dashed">
                        <svg class="w-12 h-12 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p>Belum ada galeri kegiatan yang diupload.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-slate-900 text-white pt-20 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-linear-to-br from-blue-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            BP
                        </div>
                        <span class="font-bold text-xl tracking-tight">TK Bina Pertiwi</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed max-w-sm">
                        Membangun generasi cerdas, ceria, dan berkarakter melalui pendidikan inklusif dan berkualitas tinggi dengan metode pembelajaran modern.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Tautan Cepat</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li><a href="#beranda" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#profil" class="hover:text-white transition-colors">Profil TK</a></li>
                        <li><a href="#gallery" class="hover:text-white transition-colors">Gallery</a></li>
                        <li><a href="/admin/login" class="hover:text-white transition-colors">Login Admin</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Kontak</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li class="flex items-start gap-3">
                            <span class="text-blue-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </span>
                            Jl. Contoh No. 1, Kota Anda
                        </li>
                        <li class="flex items-start gap-3">
                             <span class="text-blue-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                             {{ $profile->email ?? 'info@binapertiwi.sch.id' }}
                        </li>
                        <li class="flex items-start gap-3">
                             <span class="text-blue-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </span>
                             {{ $profile->phone ?? '(022) 123-456' }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© 2025 TK Bina Pertiwi. All rights reserved.</p>
                <div class="flex gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simple Mobile Menu Script -->
    <script>
        document.querySelector('button.focus\\:outline-none').addEventListener('click', function() {
            const nav = document.querySelector('nav');
            const mobileMenu = document.createElement('div');
            mobileMenu.className = 'md:hidden absolute top-20 left-0 w-full bg-white border-b border-slate-100 shadow-xl p-4 flex flex-col gap-4 animate-fade-in-down';
            mobileMenu.innerHTML = `
                <a href="#beranda" class="text-slate-600 hover:text-blue-600 font-medium p-2 block">Beranda</a>
                <a href="#profil" class="text-slate-600 hover:text-blue-600 font-medium p-2 block">Profil TK</a>
                <a href="#gallery" class="text-slate-600 hover:text-blue-600 font-medium p-2 block">Gallery</a>
                <a href="#kontak" class="text-slate-600 hover:text-blue-600 font-medium p-2 block">Kontak</a>
                <a href="/admin/login" class="text-center w-full px-6 py-2.5 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700">Login</a>
            `;

            // Check if already open
            const existingMenu = nav.querySelector('.md\\:hidden.absolute');
            if (existingMenu) {
                existingMenu.remove();
            } else {
                nav.appendChild(mobileMenu);
            }
        });
    </script>
</body>
</html>
