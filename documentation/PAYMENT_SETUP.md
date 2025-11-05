# إعداد بوابات الدفع (Payment Gateways Setup)

## 🔧 المشكلة الحالية

عند الضغط على "Subscribe with Mollie" يظهر خطأ:
```
TypeError: Mollie\Api\MollieApiClient::setApiKey(): Argument #1 ($apiKey) must be of type string, null given
```

**السبب:** `MOLLIE_KEY` غير موجود في ملف `.env`

---

## ✅ الحل المطبق

تم إضافة التحقق من وجود API keys في:
1. ✅ `SubscriptionService` - التحقق قبل إنشاء checkout
2. ✅ `MollieWebhookController` - التحقق في webhook handler
3. ✅ `plans.blade.php` - إخفاء الأزرار إذا لم يكن API key موجود

---

## 📝 الخطوات المطلوبة

### 1. إضافة Mollie API Key

افتح ملف `.env` وأضف:

```env
MOLLIE_KEY=test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**للحصول على Mollie API Key:**
1. سجل في [Mollie Dashboard](https://www.mollie.com/dashboard)
2. اذهب إلى Developers > API keys
3. انسخ Test API key
4. أضفه في `.env`

---

### 2. إضافة Stripe API Keys

افتح ملف `.env` وأضف:

```env
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**للحصول على Stripe API Keys:**
1. سجل في [Stripe Dashboard](https://dashboard.stripe.com)
2. اذهب إلى Developers > API keys
3. انسخ Publishable key و Secret key
4. أضفهما في `.env`

---

### 3. إعادة تحميل Config

بعد إضافة API keys، قم بتشغيل:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🎯 السلوك بعد الإصلاح

### إذا كان API Key موجود:
- ✅ زر "Subscribe with Mollie" يظهر ويعمل
- ✅ يمكن إنشاء checkout session بنجاح

### إذا لم يكن API Key موجود:
- ✅ زر "Subscribe with Mollie" يظهر معطل (disabled)
- ✅ رسالة خطأ واضحة: "Mollie payment gateway is not configured"
- ✅ لا يحدث crash في النظام

---

## 🔍 التحقق من الإعداد

### في صفحة Plans:
- إذا كان API key موجود: زر "Subscribe with Mollie" يعمل
- إذا لم يكن موجود: زر "Mollie Not Available" معطل

### في الكود:
```php
// في SubscriptionService.php
$mollieKey = config('services.mollie.key');
if (empty($mollieKey)) {
    throw new \Exception('Mollie payment gateway is not configured. Please contact support.');
}
```

---

## 📋 ملف .env الكامل المطلوب

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

# Twilio (للإشعارات)
TWILIO_ACCOUNT_SID=ACxxx
TWILIO_AUTH_TOKEN=xxx
TWILIO_FROM=whatsapp:+14155238886
```

---

## ⚠️ ملاحظات مهمة

1. **Test vs Live Keys:**
   - استخدم `test_` لـ Mollie في التطوير
   - استخدم `pk_test_` و `sk_test_` لـ Stripe في التطوير
   - في الإنتاج، استخدم Live keys

2. **Security:**
   - ❌ لا تضع API keys في الكود
   - ✅ استخدم `.env` فقط
   - ✅ أضف `.env` إلى `.gitignore`

3. **Webhooks:**
   - بعد إضافة Stripe key، أضف webhook URL في Stripe Dashboard
   - بعد إضافة Mollie key، أضف webhook URL في Mollie Dashboard

---

## 🐛 Troubleshooting

### الخطأ: "Mollie payment gateway is not configured"
**الحل:** أضف `MOLLIE_KEY` في `.env` ثم قم بتشغيل:
```bash
php artisan config:clear
```

### الخطأ: "Stripe payment gateway is not configured"
**الحل:** أضف `STRIPE_KEY` و `STRIPE_SECRET` في `.env` ثم قم بتشغيل:
```bash
php artisan config:clear
```

### الأزرار لا تظهر في صفحة Plans
**الحل:** تأكد من:
1. وجود API keys في `.env`
2. تشغيل `php artisan config:clear`
3. تحديث الصفحة (Ctrl+F5)



