<?php
define('ROOT_DIR', dirname(__DIR__));

spl_autoload_register(function ($class) {
    // Convert class name to file path
    $path = str_replace('\\', '/', $class);

    // Define possible paths for the class file
    $possible_paths = [
        ROOT_DIR . '/src/Config/' . $class . '.php',
        ROOT_DIR . '/src/Models/' . $class . '.php',
        ROOT_DIR . '/src/Controllers/' . $class . '.php',
        ROOT_DIR . '/src/Helpers/' . $class . '.php'
    ];

    // Try each possible path
    foreach ($possible_paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Log error if class file not found
    error_log("Could not find class file for: " . $class);
});

// Load config file
require_once ROOT_DIR . '/src/Config/config.php';
