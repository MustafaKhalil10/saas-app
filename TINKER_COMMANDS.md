# 🔧 أوامر Tinker الصحيحة - تحديث Price IDs

## ⚠️ الخطأ الشائع

```php
// ❌ خطأ - بدون علامات اقتباس
$plan = \App\Models\Plan::where(name, Pro)->where(provider, stripe)->first();
```

## ✅ الصيغة الصحيحة

```php
// ✅ صحيح - مع علامات اقتباس
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
```

---

## 📝 الأوامر الصحيحة الكاملة

### افتح Tinker:
```bash
php artisan tinker
```

### ثم اكتب الأوامر التالية (استبدل `price_xxxxxxxxxxxxx` بـ Price ID الحقيقي):

```php
// للخطة Basic
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx'; // الصق Price ID هنا
$plan->save();
echo "✅ Basic Plan updated!\n";

// للخطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_yyyyyyyyyyyyyy'; // Price ID الخاص بـ Pro
$plan->save();
echo "✅ Pro Plan updated!\n";

// للخطة Enterprise
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_zzzzzzzzzzzzzz'; // Price ID الخاص بـ Enterprise
$plan->save();
echo "✅ Enterprise Plan updated!\n";
```

---

## 🔍 التحقق من التحديث

```php
// عرض جميع الخطط مع Price IDs
\App\Models\Plan::where('provider', 'stripe')->get(['id', 'name', 'provider_id']);
```

---

## 🚪 للخروج من Tinker

```php
exit
```

---

## ⚠️ ملاحظات مهمة

1. **يجب وضع علامات اقتباس** حول القيم:
   - ✅ `'name'` وليس `name`
   - ✅ `'Basic'` وليس `Basic`
   - ✅ `'provider'` وليس `provider`
   - ✅ `'stripe'` وليس `stripe`

2. **Price ID يجب أن يكون:**
   - ✅ سلسلة نصية بين علامات اقتباس
   - ✅ مثال: `'price_1ABC123def456GHI789jkl'`

3. **بعد كل أمر:**
   - اضغط `Enter`
   - انتظر النتيجة
   - ثم اكتب الأمر التالي



