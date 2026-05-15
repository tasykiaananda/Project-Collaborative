<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Collaborative Notes Tasykia') }}</h2>
            <div class="flex items-center gap-4">
                <div class="relative flex items-center">
                    <button onclick="document.getElementById('calendar-input').showPicker()" class="flex items-center gap-2 bg-white border border-gray-300 px-4 py-2 rounded-xl shadow-sm hover:border-blue-400 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span id="calendar-text" class="text-sm font-semibold text-gray-700">Pilih Tanggal</span>
                    </button>
                    <input type="date" id="calendar-input" onchange="filterByDate(this.value)" class="absolute opacity-0 pointer-events-none">
                </div>

                <div class="relative w-64 radar-area" data-note-id="search-box" style="position: relative;">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                    <input type="text" id="search-input" onkeyup="searchNotes()" placeholder="Cari catatan..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 sm:text-sm">
                    <div id="cursor-search-box" class="remote-cursor hidden" style="position: absolute; pointer-events: none; z-index: 50; transition: transform 0.04s linear; top: 0; left: 0;">
                        <div class="w-4 h-4 bg-orange-500 rounded-full shadow-md"></div>
                        <span class="cursor-label bg-orange-500 text-white text-xs px-2 py-0.5 rounded shadow-sm ml-2 whitespace-nowrap"></span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6 radar-area" data-note-id="new" style="position: relative;">
                <div class="flex gap-4">
                    <input type="text" id="new-note-title" placeholder="Judul Catatan Baru..." class="flex-1 border-gray-300 rounded-lg focus:ring-blue-500" oninput="sendWhisper('new', this.value)">
                    <button type="button" onclick="addNote()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">Tambah</button>
                </div>
                <div id="cursor-new" class="remote-cursor hidden" style="position: absolute; pointer-events: none; z-index: 50; transition: transform 0.04s linear; top: 0; left: 0;">
                    <div class="w-4 h-4 bg-orange-500 rounded-full shadow-md"></div>
                    <span class="cursor-label bg-orange-500 text-white text-xs px-2 py-0.5 rounded shadow-sm ml-2 whitespace-nowrap"></span>
                </div>
            </div>

            <div id="notes-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($notes as $note)
                    @include('notes.partials.note-card', ['note' => $note])
                @endforeach
            </div>
        </div>
    </div>

    <script type="module">
        window.filterByDate = (val) => {
            document.getElementById('calendar-text').innerText = new Date(val).toLocaleDateString('id-ID', {day:'numeric', month:'short', year:'numeric'});
            document.querySelectorAll('.note-card').forEach(c => c.style.display = c.getAttribute('data-date') === val ? "" : "none");
            if (window.notesChannel) window.notesChannel.whisper('typing-sync', { id: 'calendar-input', content: val });
        };

        window.searchNotes = () => {
            let q = document.getElementById('search-input').value.toLowerCase();
            document.querySelectorAll('.note-card').forEach(c => c.style.display = c.innerText.toLowerCase().includes(q) ? "" : "none");
            if (window.notesChannel) window.notesChannel.whisper('typing-sync', { id: 'search-box', content: q });
        };

        window.addNote = function() {
            const input = document.getElementById('new-note-title');
            if(!input.value) return;
            fetch("{{ route('notes.store') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ title: input.value })
            })
            .then(res => res.json())
            .then(data => {
                input.value = '';
                document.getElementById('notes-container').insertAdjacentHTML('afterbegin', data.html);
                window.notesChannel.whisper('note-added', { html: data.html });
            });
        };

        window.updateDatabase = (id, content) => {
            fetch(`/notes/${id}`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ content }) });
        };

        window.deleteNote = (id) => {
            if(!confirm('Hapus?')) return;
            fetch(`/notes/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(() => {
                document.getElementById(`note-card-${id}`).remove();
                window.notesChannel.whisper('note-deleted', { id });
            });
        };

        if (window.Echo) {
            window.notesChannel = window.Echo.join('notes-channel');
            window.sendWhisper = (id, content) => window.notesChannel.whisper('typing-sync', { id, content });

            let throttle = false;
            document.addEventListener('mousemove', (e) => {
                if (!throttle) {
                    const radar = e.target.closest('.radar-area');
                    if (radar) {
                        let rect = radar.getBoundingClientRect();
                        window.notesChannel.whisper('moving-cursor', { 
                            x: e.clientX - rect.left, 
                            y: e.clientY - rect.top, 
                            noteId: radar.getAttribute('data-note-id'), 
                            userName: "{{ Auth::user()->name }}" 
                        });
                    }
                    throttle = true;
                    setTimeout(() => throttle = false, 40);
                }
            });

            window.notesChannel.listenForWhisper('moving-cursor', (e) => {
                const c = document.getElementById(`cursor-${e.noteId}`);
                if (c) { 
                    c.classList.remove('hidden'); 
                    c.style.transform = `translate(${e.x}px, ${e.y}px)`; 
                    c.querySelector('.cursor-label').innerText = e.userName;
                }
            });

            window.notesChannel.listenForWhisper('note-added', (e) => document.getElementById('notes-container').insertAdjacentHTML('afterbegin', e.html));
            window.notesChannel.listenForWhisper('note-deleted', (e) => document.getElementById(`note-card-${e.id}`)?.remove());
            window.notesChannel.listenForWhisper('typing-sync', (e) => {
                const el = document.getElementById(e.id === 'search-box' ? 'search-input' : (e.id === 'calendar-input' ? 'calendar-input' : (e.id === 'new' ? 'new-note-title' : `note-${e.id}`)));
                if (el && document.activeElement !== el) {
                    el.value = e.content;
                    if(e.id === 'search-box') searchNotes();
                    if(e.id === 'calendar-input') filterByDate(e.content);
                }
            });
        }
    </script>
</x-app-layout>