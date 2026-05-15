<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Perbaikan: Gunakan 'notes-channel' agar sesuai dengan kode di index.blade.php
Broadcast::channel('notes-channel', function ($user) {
    // Return array data user agar fitur Presence (kursor) aktif
    return [
        'id' => $user->id, 
        'name' => $user->name
    ];
});