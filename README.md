# SaaS Application - Laravel 12

A modern SaaS mini-application built with Laravel 12, Blade, and Tailwind CSS featuring a beautiful Neumorphism design.

## Features

### Phase 1 ✅
- **Authentication**: Laravel Breeze with Blade + Tailwind
- **Roles & Permissions**: Spatie Laravel Permission (Admin, Owner, User)
- **Clean Architecture**: Service/Repository pattern
- **Neumorphism Design**: Soft minimal design with custom Tailwind theme
- **Dashboard & Plans Pages**: Beautiful UI with custom Blade components

### Phase 2 ✅
- **Subscription System**: Laravel Cashier (Stripe) + Mollie integration
- **Recurring Subscriptions**: Automatic renewal with hosted checkout
- **Webhooks**: Stripe and Mollie webhook handlers for payment events
- **Notifications**: Email + WhatsApp notifications (Twilio)
- **Payment Retry**: Smart retry logic for failed payments
- **Subscription Reminders**: Daily scheduler for expiring subscriptions

## Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js & NPM
- Stripe Account (for Stripe payments)
- Mollie Account (for Mollie payments)
- Twilio Account (for WhatsApp notifications)

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd test-app
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy `.env.example` to `.env` and configure:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saas_app
DB_USERNAME=root
DB_PASSWORD=

# Stripe
STRIPE_KEY=pk_test_xxx
STRIPE_SECRET=sk_test_xxx
STRIPE_WEBHOOK_SECRET=whsec_xxx

# Mollie
MOLLIE_KEY=test_xxx

# Twilio (for WhatsApp notifications)
TWILIO_ACCOUNT_SID=ACxxx
TWILIO_AUTH_TOKEN=xxx
TWILIO_FROM=whatsapp:+14155238886

# Queue Configuration
QUEUE_CONNECTION=database

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Seed database

```bash
php artisan db:seed
```

This will create:
- Roles: Admin, Owner, User
- Default test user

### 7. Build assets

```bash
npm run build
# or for development
npm run dev
```

### 8. Start development server

```bash
php artisan serve
php artisan queue:work
```

## Webhook Setup

### Stripe Webhooks

1. **Local Testing (ngrok)**:
   ```bash
   ngrok http 8000
   ```

2. **Register Webhook in Stripe Dashboard**:
   - Go to Developers > Webhooks
   - Add endpoint: `https://your-domain.com/webhook/stripe`
   - Select events:
     - `invoice.payment_succeeded`
     - `invoice.payment_failed`
     - `customer.subscription.deleted`
     - `customer.subscription.updated`
   - Copy webhook signing secret to `.env` as `STRIPE_WEBHOOK_SECRET`

### Mollie Webhooks

1. **Register Webhook in Mollie Dashboard**:
   - Go to Developers > Webhooks
   - Add endpoint: `https://your-domain.com/webhook/mollie`
   - Select events:
     - `payment.paid`
     - `payment.failed`
     - `payment.canceled`

## Creating Plans

Plans can be created via database seeder or manually:

```php
Plan::create([
    'provider_id' => 'price_stripe_123', // Stripe Price ID
    'provider' => 'stripe',
    'name' => 'Basic Plan',
    'interval' => 'month',
    'amount' => 1000, // $10.00 in cents
    'currency' => 'usd',
    'features' => ['Feature 1', 'Feature 2'],
    'is_active' => true,
]);
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Project Structure

```
app/
├── Actions/              # Action classes
├── Http/
│   ├── Controllers/
│   │   ├── SubscriptionController.php
│   │   ├── StripeWebhookController.php
│   │   └── MollieWebhookController.php
│   ├── Requests/         # Form requests
│   ├── Resources/        # API resources
│   └── Middleware/        # Custom middleware
├── Jobs/
│   └── RetryFailedPaymentsJob.php
├── Models/
│   ├── User.php
│   └── Plan.php
├── Notifications/
│   ├── PaymentSucceededNotification.php
│   └── SubscriptionExpiringNotification.php
├── Repositories/         # Repository pattern
└── Services/
    ├── SubscriptionService.php
    └── RoleService.php
```

## Architecture

### Clean Architecture Principles

- **SOLID Principles**: Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion
- **Service Layer**: Business logic in services, not controllers
- **Repository Pattern**: Data access abstraction
- **Dependency Injection**: Controllers depend on service interfaces

### Code Style

- **PSR-12**: PHP coding standard
- **Laravel Conventions**: Follow Laravel best practices
- **Documentation**: PHPDoc comments for all classes and methods

## Scheduled Tasks

The application includes a daily scheduler for subscription reminders:

```bash
# Add to crontab (production)
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Queue Workers

Process background jobs:

```bash
php artisan queue:work
```

## Development Workflow

### Git Branches

- `main` → Stable release
- `dev` → Integration branch
- `feature/*` → Feature branches

### Commit Style

```
feat(billing): add stripe checkout and webhook handler
fix(webhook): handle duplicate events idempotently
docs(readme): update setup instructions
```

## Troubleshooting

### Webhook Not Working

1. Check webhook URL is accessible (use ngrok for local)
2. Verify webhook secret in `.env`
3. Check logs: `storage/logs/laravel.log`
4. Ensure CSRF protection is excluded for webhook routes

### Payment Not Processing

1. Verify Stripe/Mollie API keys in `.env`
2. Check queue worker is running: `php artisan queue:work`
3. Review webhook logs for errors

### Notifications Not Sending

1. Verify Twilio credentials in `.env`
2. Check queue worker is running
3. Ensure phone number format is correct (E.164 format)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
