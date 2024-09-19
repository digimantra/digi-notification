# Laravel FCM Notifications

A Laravel package to send Firebase Cloud Messaging (FCM) push notifications.

## Requirements

- Laravel 10.x
- PHP 8.0 or higher

## Installation

You can install this package via Composer:

```bash
composer require legacy-fcm/laravel-fcm-notifications

## Configuration

After installing the package, you need to configure your environment variables. Follow these steps:
FIREBASE_PROJECT_ID=your_firebase_project_id
FIREBASE_CREDENTIALS=/path/to/your/firebase-server-file.json 

### Step 1: Publish Configuration

Publish the package configuration file:

```bash
php artisan vendor:publish --provider="LegacyFcm\FcmHelper\FcmServiceProvider"