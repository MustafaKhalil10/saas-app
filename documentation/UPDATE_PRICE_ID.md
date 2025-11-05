# 🔄 كيفية تحديث Price ID لأي خطة

## ✅ تحديث خطة Pro فقط

### الخطوة 1: افتح Tinker
```bash
php artisan tinker
```

### الخطوة 2: حدّث Price ID لخطة Pro
```php
// ابحث عن خطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();

// تأكد من وجود الخطة
if ($plan) {
    // ضع Price ID الجديد هنا (انسخه من Stripe Dashboard)
    $plan->provider_id = 'price_xxxxxxxxxxxxx'; // استبدل بـ Price ID الحقيقي
    $plan->save();
    echo "✅ Pro Plan updated! New Price ID: " . $plan->provider_id . "\n";
} else {
    echo "❌ Pro Plan not found!\n";
}
```

### الخطوة 3: التحقق من التحديث
```php
// عرض خطة Pro مع Price ID الجديد
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first(['name', 'provider_id']);
echo "Plan: " . $plan->name . "\n";
echo "Price ID: " . $plan->provider_id . "\n";
```

### الخطوة 4: للخروج من Tinker
```php
exit
```

---

## 📝 تحديث أي خطة أخرى

### لتحديث خطة Basic:
```php
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx';
$plan->save();
```

### لتحديث خطة Enterprise:
```php
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx';
$plan->save();
```

### لتحديث خطة Mollie:
```php
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'mollie')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx';
$plan->save();
```

---

## 🔍 عرض جميع الخطط مع Price IDs

```php
\App\Models\Plan::all(['id', 'name', 'provider', 'provider_id'])->each(function($plan) {
    echo $plan->id . '. ' . $plan->name . ' (' . $plan->provider . ') -> ' . $plan->provider_id . "\n";
});
```

---

## ⚠️ ملاحظات مهمة

1. **Price ID يجب أن يكون من Stripe Dashboard:**
   - يبدأ بـ `price_`
   - مثال: `price_1ABC123def456GHI789jkl`

2. **تأكد من استخدام الـ Test Mode أو Live Mode:**
   - إذا كنت تستخدم Stripe Test Mode، استخدم Price IDs من Test Mode
   - إذا كنت تستخدم Stripe Live Mode، استخدم Price IDs من Live Mode

3. **بعد التحديث:**
   - جرب الضغط على زر "Subscribe with Stripe" للخطة Pro
   - يجب أن يوجهك إلى صفحة الدفع في Stripe

---

## 🎯 مثال عملي كامل

```php
// 1. افتح Tinker
php artisan tinker

// 2. ابحث عن خطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();

// 3. عرض Price ID الحالي
echo "Current Price ID: " . $plan->provider_id . "\n";

// 4. حدّث Price ID
$plan->provider_id = 'price_1ABC123def456GHI789jkl'; // Price ID الجديد
$plan->save();

// 5. تأكد من التحديث
echo "✅ Updated! New Price ID: " . $plan->fresh()->provider_id . "\n";

// 6. اخرج من Tinker
exit
```



