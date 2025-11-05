# 🔧 إعداد Stripe Prices - حل مشكلة "لا يحدث شيء"

## ❌ المشكلة

عند الضغط على زر "Subscribe with Stripe" يتم التحميل ثم لا يحدث شيء ويبقى في صفحة Plans.

### السبب:
الـ `provider_id` في الخطط ليس Price ID حقيقي من Stripe. Stripe يحتاج Price ID حقيقي (مثل `price_1234567890abcdef`) وليس اسم وهمي.

---

## ✅ الحل (خطوتين)

### الخطوة 1: إنشاء Prices في Stripe Dashboard

1. اذهب إلى [Stripe Dashboard](https://dashboard.stripe.com/test/products)
2. اضغط على **"Products"** في القائمة الجانبية
3. اضغط **"+ Add product"**
4. املأ البيانات:

**للخطة Basic:**
- Name: `Basic Plan`
- Price: `$10.00`
- Billing period: `Monthly`
- Currency: `USD`
- اضغط **"Save product"**
- **انسخ Price ID** (يبدأ بـ `price_...`) ← هذا ما نحتاجه!

**كرر العملية للخطط الأخرى:**
- Pro Plan: $25/month
- Enterprise Plan: $50/month

---

### الخطوة 2: تحديث Plans في قاعدة البيانات

#### طريقة 1: عبر Tinker (الأسهل)

```bash
php artisan tinker
```

ثم:

```php
// للخطة Basic
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx'; // الصق Price ID من Stripe
$plan->save();

// للخطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx'; // Price ID الخاص بها
$plan->save();

// للخطة Enterprise
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx'; // Price ID الخاص بها
$plan->save();
```

#### طريقة 2: تحديث PlanSeeder وإعادة التشغيل

عدّل `database/seeders/PlanSeeder.php` وأضف Price IDs الحقيقية:

```php
'provider_id' => 'price_xxxxxxxxxxxxx', // Price ID الحقيقي من Stripe
```

ثم شغّل:
```bash
php artisan db:seed --class=PlanSeeder
```

---

## 🔍 التحقق من Price ID

### في Stripe Dashboard:
1. اذهب إلى Products
2. اختر المنتج
3. انسخ **Price ID** من جدول Prices
4. يجب أن يكون بالشكل: `price_1234567890abcdef`

### في قاعدة البيانات:
```bash
php artisan tinker
```

```php
\App\Models\Plan::where('provider', 'stripe')->get(['id', 'name', 'provider_id']);
```

---

## ✅ بعد التحديث

1. ✅ تأكد من أن Price IDs حقيقية في قاعدة البيانات
2. ✅ حدّث الصفحة: `Ctrl + F5`
3. ✅ اضغط على "Subscribe with Stripe"
4. ✅ يجب أن يتم توجيهك لصفحة Stripe Checkout! 🎉

---

## 📝 ملاحظات مهمة

1. **Test vs Live:**
   - في التطوير: استخدم Test Price IDs
   - في الإنتاج: استخدم Live Price IDs

2. **Price ID Format:**
   - يجب أن يبدأ بـ `price_`
   - مثال: `price_1ABC123def456GHI789jkl`

3. **أخطاء شائعة:**
   - ❌ استخدام اسم وهمي: `price_basic_monthly`
   - ✅ استخدام Price ID حقيقي: `price_1234567890abcdef`

---

## 🐛 إذا لم يعمل بعد التحديث

1. تحقق من Price ID في Stripe Dashboard
2. تحقق من Price ID في قاعدة البيانات
3. تحقق من رسائل الخطأ في صفحة Plans (تم إضافتها الآن)
4. تحقق من `storage/logs/laravel.log` للأخطاء التفصيلية



