<?php

return [
    'project_id' => env('FIREBASE_PROJECT_ID', 'default-project-id'),
    'credentials_path' => env('FIREBASE_CREDENTIALS', base_path('firebase-adminsdk.json')),
];
