<div id="note-card-{{ $note->id }}" class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-blue-500 radar-area note-card" 
     data-note-id="{{ $note->id }}" data-date="{{ $note->created_at->format('Y-m-d') }}" style="position: relative;">
    
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-bold text-lg text-gray-700 note-title">{{ $note->title }}</h3>
        <div class="flex gap-3">
            <button onclick="document.getElementById('note-{{ $note->id }}').focus()" class="text-blue-500 hover:text-blue-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </button>
            <button type="button" onclick="deleteNote('{{ $note->id }}')" class="text-red-500 hover:text-red-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        </div>
    </div>

    <textarea id="note-{{ $note->id }}" class="w-full border-gray-200 rounded-lg focus:ring-blue-500 note-content" rows="5" oninput="updateDatabase('{{ $note->id }}', this.value); sendWhisper('{{ $note->id }}', this.value)">{{ $note->content }}</textarea>

    <div id="cursor-{{ $note->id }}" class="remote-cursor hidden" style="position: absolute; pointer-events: none; z-index: 50; transition: transform 0.04s linear; top: 0; left: 0;">
        <div class="w-4 h-4 bg-orange-500 rounded-full shadow-md"></div>
        <span class="cursor-label bg-orange-500 text-white text-xs px-2 py-0.5 rounded shadow-sm ml-2 whitespace-nowrap"></span>
    </div>
</div>