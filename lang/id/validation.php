<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    */

    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'required'  => 'Kolom :attribute wajib diisi.',
    'min'       => [
        'string' => ':attribute minimal harus berisi :min karakter.',
    ],
    
    // Mengganti nama atribut agar lebih luwes (password -> kata sandi)
    'attributes' => [
        'email'    => 'alamat email',
        'password' => 'kata sandi',
    ],

];