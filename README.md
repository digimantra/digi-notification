# Laravel FCM Notifications Package

![Packagist Version](https://img.shields.io/packagist/v/legacy-fcm/laravel-fcm-notifications)
![Packagist Downloads](https://img.shields.io/packagist/dt/legacy-fcm/laravel-fcm-notifications)
![GitHub License](https://img.shields.io/github/license/legacy-fcm/laravel-fcm-notifications)

This package provides an easy way to send Firebase Cloud Messaging (FCM) push notifications in Laravel applications using Google's Firebase API.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Logging](#logging)
- [Known Issues](#known-issues)
- [License](#license)
- [Contribution](#contribution)
- [Support](#support)

## Requirements

- Laravel 8, 9, or 10
- PHP 8.0 or higher
- Google API Client (installed automatically via composer)
- Firebase account with Cloud Messaging API enabled

## Installation

1. **Install via Composer**

    ```bash
    composer require legacy-fcm/laravel-fcm-notifications
    ```

2. **Publish Configuration**

    ```bash
    php artisan vendor:publish --tag=config --provider="LegacyFcm\FcmHelper\FcmServiceProvider"
    ```

3. **Set Up Environment Variables**

    Add the following to your `.env` file:

    ```env
    FIREBASE_PROJECT_ID=your-firebase-project-id
    FIREBASE_CREDENTIALS=path/to/your/credentials.json
    ```

    You can generate the credentials file from the [Firebase Console](https://console.firebase.google.com/).

## Usage

### Sending FCM Notifications

```php
use LegacyFcm\FcmHelper\FcmHelper;

$tokens = ['device_token_1', 'device_token_2'];
$title = 'New Notification';
$body = 'This is the body of the notification';
$data = ['key' => 'value']; // Optional custom data
 
FcmHelper::sendFcmNotification($tokens, $title, $body, $data);

// $tokens: Array of device tokens to which the notification will be sent.
// $title: The title of the notification.
// $body: The body content of the notification.
// $data: (Optional) Additional custom data.

The notifications will be sent in the background using Laravel queues.

### Example Job Dispatch

use LegacyFcm\FcmHelper\Jobs\SendFcmNotificationJob;

SendFcmNotificationJob::dispatch($tokens, $title, $body, $data);

## Configuration

### Queue Configuration

Ensure your queue system is set up properly by adding the following to your `.env` file:

### env
QUEUE_CONNECTION=database

# Then, create the `jobs` table and run the migration:
php artisan queue:table
php artisan migrate

# Logging

# To enable logging, add this to your `.env` file:
FCM_LOGGING=true

Set to false to disable logging.

Known Issues
Ensure FCM tokens are valid, as invalid tokens might cause delivery failures.
Invalid service account credentials will cause the package to fail to obtain an access token from Firebase.

License
This package is open-sourced under the MIT license.

Contribution
Feel free to contribute by opening issues or submitting pull requests for new features or bug fixes.

Support
For support or more details, you can reach out at onkar.soni@digimantra.com.