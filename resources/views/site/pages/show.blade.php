@extends('layouts.site')

@section('title', $page?->meta_title ?: $pageTitle)
@section('meta_description', $page?->meta_description ?: Str::limit(strip_tags($page?->content ?? ''), 150))

@section('content')
    @php
        // Mengambil logo dari pengaturan admin
        $logo = \App\Models\SiteSetting::get('logo_path');
    @endphp

    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-ntt-gold p-8 md:p-12 relative overflow-hidden">
            
            {{-- WATERMARK LOGO DI LATAR BELAKANG --}}
            @if ($logo)
                <div class="absolute inset-0 z-0 opacity-[0.04] pointer-events-none bg-center bg-no-repeat" 
                     style="background-image: url('{{ asset('storage/' . $logo) }}'); background-size: 70%;">
                </div>
            @endif

            {{-- KONTEN UTAMA (Z-10 agar berada di atas watermark) --}}
            <div class="relative z-10">
                
                {{-- HEADER: KOTAK LOGO & JUDUL --}}
                <div class="flex items-center gap-5 md:gap-6 mb-10 pb-6 border-b border-gray-200">
                    
                    {{-- Kotak Logo --}}
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white border-2 border-gray-100 rounded-xl flex items-center justify-center p-2 shadow-sm shrink-0">
                        @if ($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Dinas" class="w-full h-full object-contain">
                        @else
                            <span class="text-[10px] text-gray-400 text-center leading-tight">Belum ada<br>logo</span>
                        @endif
                    </div>
                    
                    {{-- Judul Halaman --}}
                    <h1 class="text-3xl md:text-4xl font-bold text-ntt-red font-serif leading-tight">
                        {{ $page->title ?? $pageTitle }}
                    </h1>
                </div>

                {{-- ISI KONTEN --}}
                @if ($page)
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed 
                                prose-headings:text-ntt-red prose-headings:font-serif 
                                prose-hr:border-ntt-gold">
                        {!! $page->content !!}
                    </div>

                    {{-- GAMBAR STRUKTUR (JIKA ADA) --}}
                    @if ($page->image)
                        <div class="mt-10 pt-8 border-t-2 border-dashed border-gray-200">
                            <img src="{{ asset('storage/' . $page->image) }}" alt="Struktur Organisasi" class="w-full rounded-lg shadow-md">
                        </div>
                    @endif

                    <p class="text-xs text-gray-400 mt-12 pt-4 border-t border-gray-100">
                        Terakhir diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }}
                    </p>
                @else
                    <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded p-4">
                        Konten halaman belum tersedia.
                    </div>
                @endif

                
                    {{-- Tambahkan kode ini di bawah konten profil (di dalam div penampung) --}}
                    @if(isset($structures) && $structures->count() > 0)
                        <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Struktur Organisasi</h3>
                            <button type="button" onclick="openStructureModal()" class="inline-flex items-center px-6 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-full transition shadow-lg">
                                Lihat Struktur Dinas Terbaru
                            </button>
                        </div>

                        {{-- MODAL STRUKTUR --}}
                        <div id="structureModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen px-4 py-10">
                                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeStructureModal()"></div>

                                <div class="relative bg-white rounded-3xl w-full max-w-4xl shadow-2xl z-10 overflow-hidden flex flex-col max-h-[90vh]">
                                    <!-- Header Modal -->
                                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                                        <h3 class="text-xl font-extrabold text-[#112F28]">Struktur Kedinasan</h3>
                                        <button type="button" onclick="closeStructureModal()" class="text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
                                    </div>

                                    <!-- Body Modal -->
                                    <div class="p-6 overflow-y-auto">
                                        <!-- Pilihan Tahun -->
                                        <div class="flex gap-2 mb-6 border-b pb-4 overflow-x-auto">
                                            @foreach($structures as $index => $struct)
                                                <button type="button" onclick="switchStructure({{ $index }})" 
                                                        class="year-tab px-4 py-2 text-sm font-bold rounded-full transition whitespace-nowrap {{ $index === 0 ? 'bg-[#112F28] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                                    {{ $struct->year }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <!-- Konten per Tahun -->
                                        @foreach($structures as $index => $struct)
                                            <div id="structure-content-{{ $index }}" class="structure-content {{ $index !== 0 ? 'hidden' : '' }}">
                                                <div class="text-center mb-6">
                                                    <h4 class="text-2xl font-bold text-gray-900">{{ $struct->title }} {{ $struct->year }}</h4>
                                                    @if($struct->description)
                                                        <p class="text-sm text-gray-500 mt-1">{{ $struct->description }}</p>
                                                    @endif
                                                </div>

                                                <!-- Foto Kepala & Sekretaris (Jika ada) -->
                                                <div class="flex justify-center gap-10 mb-8">
                                                    @if($struct->head_photo || $struct->head_name)
                                                        <div class="text-center">
                                                            @if($struct->head_photo)
                                                                <img src="{{ asset('storage/'.$struct->head_photo) }}" class="w-24 h-24 object-cover rounded-full mx-auto border-4 border-[#E3EAE5] shadow-sm">
                                                            @else
                                                                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto"></div>
                                                            @endif
                                                            <p class="mt-2 font-bold text-gray-900">{{ $struct->head_name }}</p>
                                                            <p class="text-xs text-gray-500">Kepala Dinas</p>
                                                        </div>
                                                    @endif

                                                    @if($struct->secretary_photo || $struct->secretary_name)
                                                        <div class="text-center">
                                                            @if($struct->secretary_photo)
                                                                <img src="{{ asset('storage/'.$struct->secretary_photo) }}" class="w-24 h-24 object-cover rounded-full mx-auto border-4 border-[#E3EAE5] shadow-sm">
                                                            @else
                                                                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto"></div>
                                                            @endif
                                                            <p class="mt-2 font-bold text-gray-900">{{ $struct->secretary_name }}</p>
                                                            <p class="text-xs text-gray-500">Sekretaris</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Bagan Utama -->
                                                @if($struct->chart_image)
                                                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 p-2">
                                                        <img src="{{ asset('storage/'.$struct->chart_image) }}" class="w-full h-auto rounded-lg" alt="Bagan Struktur">
                                                    </div>
                                                @else
                                                    <p class="text-center text-gray-400 py-10">Gambar bagan belum diunggah oleh admin.</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @push('scripts')
                    <script>
                        function openStructureModal() {
                            document.getElementById('structureModal').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        function closeStructureModal() {
                            document.getElementById('structureModal').classList.add('hidden');
                            document.body.style.overflow = '';
                        }

                        function switchStructure(index) {
                            // Sembunyikan semua konten
                            document.querySelectorAll('.structure-content').forEach(el => el.classList.add('hidden'));
                            // Tampilkan yang dipilih
                            document.getElementById('structure-content-' + index).classList.remove('hidden');

                            // Ubah warna tab
                            document.querySelectorAll('.year-tab').forEach(el => {
                                el.classList.remove('bg-[#112F28]', 'text-white');
                                el.classList.add('bg-gray-100', 'text-gray-600');
                            });
                            const activeTab = document.querySelectorAll('.year-tab')[index];
                            activeTab.classList.remove('bg-gray-100', 'text-gray-600');
                            activeTab.classList.add('bg-[#112F28]', 'text-white');
                        }
                    </script>
                    @endpush
                
            </div>

            
            
        </div>
    </div>
@endsection