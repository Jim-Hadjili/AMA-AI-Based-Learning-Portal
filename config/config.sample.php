<?php
// Sample configuration file
// Copy this to config.php and fill in your actual values

return [
    'openrouter' => [
        'api_key' => 'your_openrouter_api_key_here',
        'api_url' => 'https://openrouter.ai/api/v1/chat/completions',
        'model' => 'mistralai/mistral-7b-instruct'
    ],
    'database' => [
        // Add your database credentials here if needed
        // 'host' => 'localhost',
        // 'username' => 'your_db_user',
        // 'password' => 'your_db_password',
        // 'database' => 'your_db_name'
    ]
];
?>