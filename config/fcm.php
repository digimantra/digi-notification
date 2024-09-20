<?php
return [
    'project_id' => env('FIREBASE_PROJECT_ID', 'default-project-id'),
    'credentials_path' => base_path(env('FIREBASE_CREDENTIALS', 'default_path/to/credentials.json')),
];
