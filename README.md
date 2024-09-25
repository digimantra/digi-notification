# Laravel FCM Notifications Package

![Packagist Version](https://img.shields.io/packagist/v/digimantra/digi-notification)
![Packagist Downloads](https://img.shields.io/packagist/dt/digimantra/digi-notification)
![GitHub License](https://img.shields.io/github/license/digimantra/digi-notification?style=flat-square)

This package provides an easy way to send Firebase Cloud Messaging (FCM) push notifications in Laravel applications using Google's Firebase API.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Logging](#logging)
- [Known Issues](#known-issues)
- [License](#license)
- [Support](#support)

## Requirements

- Laravel 8, 9, or 10
- PHP 8.0 or higher
- Google API Client (installed automatically via composer)
- Firebase account with Cloud Messaging API enabled

## Installation

1. **Install via Composer**

    ```bash
    composer require digimantra/digi-notification
    ```

2. **Publish Configuration and Run Migration**

    ```bash
    php artisan vendor:publish --tag=config --provider="DigiNotification\FcmHelper\FcmServiceProvider"
    ```

    ```bash
    php artisan migrate
    ```

3. **Set Up Environment Variables**

    Add the following to your `.env` file:

    ```env
    FIREBASE_PROJECT_ID=your-firebase-project-id
    FIREBASE_CREDENTIALS=path/to/your/credentials.json
    ```

    You can generate the credentials file from the [Firebase Console](https://console.firebase.google.com/).

## Usage

### Sending FCM Notifications:

```php

<<<<<<< HEAD
    $tokens = ['device_token_1', 'device_token_2'];
    $title = 'New Notification';
    $body = 'This is the body of the notification';
    $data = ['key' => 'value']; // Optional custom data
    $type = 'sent to';
    
    FcmHelper::sendFcmNotification($tokens, $title, $body, $data);
=======
### Use Namespaces
use DigiNotification\FcmHelper\FcmHelper; 
>>>>>>> 46f93f51ffba71aab9aabf380a9b8a1f678e797e

### Assigning variables 
$tokens = ['device_token_1', 'device_token_2']; // Array of device tokens to which the notification will be sent.
$title = 'New Notification'; // The title of the notification.
$body = 'This is the body of the notification'; // The body content of the notification.
$data = ['key' => 'value']; // (Optional) Additional custom data.

### Example Send FCM notificaiton Dispatch
FcmHelper::sendFcmNotification($tokens, $title, $body, $data);  

```

## Configuration

### Queue Configuration

    Ensure your queue system is set up properly by adding the following to your `.env` file:

### env
    QUEUE_CONNECTION=database

### Then, create the `jobs` table and run the migration:
    php artisan queue:table
    php artisan migrate


## Logging

### To enable logging, add this to your `.env` file:
    FCM_LOGGING=true
    Set to false to disable logging.


## Known Issues
    Ensure FCM tokens are valid, as invalid tokens might cause delivery failures.
    Invalid service account credentials will cause the package to fail to obtain an access token from Firebase.


## License
    This package is open-sourced under the MIT license.


## Support
    For support or more details you can reach out at it@digimantra.com.