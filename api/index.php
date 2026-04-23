<?php

// Prepare storage directories in /tmp for Vercel
if (isset($_SERVER['VERCEL'])) {
    $storagePaths = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/bootstrap/cache',
    ];

    foreach ($storagePaths as $path) {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    // Tell Laravel to use these paths via Env if possible, 
    // or we can rely on bootstrap/app.php modifications.
}

require __DIR__ . '/../public/index.php';
