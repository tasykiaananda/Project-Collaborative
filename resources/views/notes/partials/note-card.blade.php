<div id="note-card-{{ $note->id }}" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 note-card" data-note-id="{{ $note->id }}" data-date="{{ $note->created_at->format('Y-m-d') }}">
    
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-bold text-gray-800 note-title">{{ $note->title }}</h3>
        
        <div class="flex gap-1">
            <button type="button" onclick="document.getElementById('note-{{ $note->id }}').focus()" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition" title="Edit Catatan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </button>
            
            <button type="button" onclick="deleteNote('{{ $note->id }}')" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Hapus Catatan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        </div>
    </div>

    <textarea id="note-{{ $note->id }}" class="w-full text-sm text-gray-700 border border-gray-200 bg-gray-50 rounded-xl focus:border-blue-400 focus:ring focus:ring-blue-100 focus:ring-opacity-50 resize-none note-content p-3" rows="4" placeholder="Tulis catatan di sini..." oninput="updateDatabase('{{ $note->id }}', this.value); sendWhisper('{{ $note->id }}', this.value)">{{ $note->content }}</textarea>

    <div class="mt-3 inline-flex items-center text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
        <svg class="w-4 h-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span id="history-{{ $note->id }}">Terakhir diedit: {{ $note->updated_at->diffForHumans() }}</span>
    </div>
</div>