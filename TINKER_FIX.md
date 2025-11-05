# ✅ الأوامر الصحيحة لـ Tinker - انسخ كما هي

## ⚠️ المشكلة
```php
// ❌ خطأ - بدون علامات اقتباس
$plan = \App\Models\Plan::where(name, Pro)->where(provider, stripe)->first();
```

## ✅ الحل - الصيغة الصحيحة

### افتح Tinker:
```bash
php artisan tinker
```

### ثم انسخ الأوامر التالية (كل أمر على سطر منفصل):

```php
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx';
$plan->save();
```

**استبدل `price_xxxxxxxxxxxxx` بـ Price ID الحقيقي من Stripe!**

---

## 📝 الأوامر الكاملة (انسخها كما هي):

```php
// للخطة Basic
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx';
$plan->save();

// للخطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_yyyyyyyyyyyyyy';
$plan->save();

// للخطة Enterprise
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_zzzzzzzzzzzzzz';
$plan->save();
```

---

## 🔑 النقاط المهمة:

1. **علامات الاقتباس مهمة جداً:**
   - ✅ `'name'` (مع علامات اقتباس)
   - ❌ `name` (بدون علامات اقتباس)

2. **Price ID يجب أن يكون:**
   - ✅ بين علامات اقتباس
   - ✅ مثال: `'price_1ABC123def456GHI789jkl'`

3. **بعد كل أمر:**
   - اضغط `Enter`
   - انتظر النتيجة
   - ثم اكتب الأمر التالي

---

## 🎯 مثال عملي:

إذا كان Price ID من Stripe هو: `price_1ABC123def456GHI789jkl`

```php
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_1ABC123def456GHI789jkl';
$plan->save();
```

---

## ✅ للتحقق:

```php
\App\Models\Plan::where('provider', 'stripe')->get(['name', 'provider_id']);
```

---

## 🚪 للخروج:

```php
exit
```



