# 🔧 إصلاح الأزرار - دليل سريع

## ❌ المشكلة
الأزرار تظهر "Stripe Not Available" و "Mollie Not Available" ولا تعمل

## ✅ الحل (3 خطوات فقط)

### الخطوة 1: افتح ملف `.env`
افتح ملف `.env` في جذر المشروع: `M:\Laravel\test-app\.env`

### الخطوة 2: أضف API Keys

أضف هذه الأسطر في نهاية ملف `.env`:

```env
# Stripe API Keys (للخطط USD)
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Mollie API Key (للخطط EUR)  
MOLLIE_KEY=test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### الخطوة 3: أعد تحميل Config

شغّل هذه الأوامر في Terminal:

```bash
php artisan config:clear
php artisan cache:clear
```

### الخطوة 4: حدّث الصفحة
- اضغط `Ctrl + F5` في المتصفح
- الأزرار ستكون نشطة الآن! ✅

---

## 📝 كيفية الحصول على API Keys

### للـ Stripe:
1. اذهب إلى: https://dashboard.stripe.com/test/apikeys
2. سجّل الدخول أو أنشئ حساب
3. انسخ **Publishable key** (يبدأ بـ `pk_test_`)
4. انسخ **Secret key** (يبدأ بـ `sk_test_`)
5. أضفهما في `.env`

### للـ Mollie:
1. اذهب إلى: https://www.mollie.com/dashboard/developers/api-keys
2. سجّل الدخول أو أنشئ حساب
3. انسخ **Test API key** (يبدأ بـ `test_`)
4. أضفه في `.env`

---

## 🔍 مثال ملف .env

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

# Stripe (أضف هذه الأسطر)
STRIPE_KEY=pk_test_51xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_51xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Mollie (أضف هذا السطر)
MOLLIE_KEY=test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

---

## ✅ بعد الإصلاح

- ✅ الأزرار ستظهر "Subscribe with Stripe" و "Subscribe with Mollie"
- ✅ الأزرار ستكون قابلة للضغط
- ✅ عند الضغط سيتم توجيهك لصفحة الدفع

---

## ⚠️ ملاحظات مهمة

1. **Test Keys**: استخدم Test keys للتطوير (تبدأ بـ `test_` أو `pk_test_`)
2. **Security**: لا تشارك ملف `.env` أو ترفعه على Git
3. **Cache**: بعد أي تعديل على `.env`، قم بتشغيل `php artisan config:clear`

---

## 🐛 إذا لم تعمل

1. تأكد من عدم وجود مسافات قبل/بعد القيم في `.env`
2. تأكد من عدم وجود علامات اقتباس حول القيم
3. شغّل `php artisan config:clear`
4. حدّث الصفحة بـ `Ctrl + F5`



