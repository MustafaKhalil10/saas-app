# ⚡ إعداد سريع - API Keys

## 🔴 المشكلة الحالية

الأزرار تظهر "Stripe Not Available" و "Mollie Not Available" لأن API keys غير موجودة في ملف `.env`.

---

## ✅ الحل السريع

### 1. افتح ملف `.env` في جذر المشروع

### 2. أضف API Keys التالية:

```env
# Stripe Keys (للخطط USD)
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Mollie Key (للخطط EUR)
MOLLIE_KEY=test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### 3. احصل على API Keys:

#### للـ Stripe:
1. سجل في [Stripe Dashboard](https://dashboard.stripe.com/test/apikeys)
2. انسخ **Publishable key** (يبدأ بـ `pk_test_`)
3. انسخ **Secret key** (يبدأ بـ `sk_test_`)
4. أضفهما في `.env`

#### للـ Mollie:
1. سجل في [Mollie Dashboard](https://www.mollie.com/dashboard/developers/api-keys)
2. انسخ **Test API key** (يبدأ بـ `test_`)
3. أضفه في `.env`

### 4. أعد تحميل Config:

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. حدّث الصفحة:
- اضغط `Ctrl + F5` لتحديث الصفحة
- يجب أن تظهر الأزرار النشطة "Subscribe with Stripe" و "Subscribe with Mollie"

---

## 📋 مثال ملف .env الكامل:

```env
APP_NAME="SaaS App"
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saas_app
DB_USERNAME=root
DB_PASSWORD=

# Stripe
STRIPE_KEY=pk_test_51xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_51xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Mollie
MOLLIE_KEY=test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Twilio (للإشعارات - اختياري)
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_FROM=whatsapp:+14155238886
```

---

## 🎯 بعد الإضافة:

- ✅ الأزرار ستظهر نشطة وقابلة للضغط
- ✅ عند الضغط على "Subscribe with Stripe" → سيتم توجيهك لصفحة الدفع
- ✅ عند الضغط على "Subscribe with Mollie" → سيتم توجيهك لصفحة الدفع

---

## 🔍 ملاحظات:

1. **Test Keys:** استخدم Test keys للتطوير، و Live keys للإنتاج
2. **Security:** لا تشارك ملف `.env` أو ترفعه على Git
3. **Cache:** بعد أي تعديل على `.env`، قم بتشغيل `php artisan config:clear`

---

## ❓ إذا لم تظهر الأزرار النشطة:

1. تأكد من وجود API keys في `.env`
2. تأكد من عدم وجود مسافات إضافية قبل/بعد القيم
3. قم بتشغيل: `php artisan config:clear`
4. حدّث الصفحة: `Ctrl + F5`



