# 🔍 كيفية الحصول على Price ID ووضعه في قاعدة البيانات

## 📍 الخطوة 1: الحصول على Price ID من Stripe

### بعد إنشاء المنتج في Stripe Dashboard:

1. **بعد الضغط على "Add product"** (إضافة منتج)
2. ستنتقل إلى **صفحة المنتج** (Product page)
3. في الصفحة، ابحث عن قسم **"Pricing"** أو **"Prices"**
4. ستجد **Price ID** بجانب السعر

### مثال على Price ID:
```
price_1ABC123def456GHI789jkl
```

**يبدأ دائماً بـ `price_` متبوعاً بأرقام وحروف**

---

## 📋 الخطوة 2: نسخ Price ID

### في صفحة المنتج:
1. ابحث عن **Price ID** (عادة أسفل أو بجانب السعر)
2. **انسخ Price ID** (Copy)
3. احفظه في مكان مؤقت (مثل Notepad)

---

## 💾 الخطوة 3: وضع Price ID في قاعدة البيانات

### الطريقة 1: استخدام Tinker (الأسهل)

#### 1. افتح Terminal في مجلد المشروع:
```bash
cd M:\Laravel\test-app
```

#### 2. شغّل Tinker:
```bash
php artisan tinker
```

#### 3. اكتب الأوامر التالية (استبدل `price_xxxxxxxxxxxxx` بـ Price ID الحقيقي):

```php
// للخطة Basic
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_xxxxxxxxxxxxx'; // الصق Price ID هنا
$plan->save();
echo "Basic Plan updated!\n";

// للخطة Pro
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_yyyyyyyyyyyyyy'; // Price ID الخاص بـ Pro
$plan->save();
echo "Pro Plan updated!\n";

// للخطة Enterprise
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_zzzzzzzzzzzzzz'; // Price ID الخاص بـ Enterprise
$plan->save();
echo "Enterprise Plan updated!\n";
```

#### 4. للخروج من Tinker:
```php
exit
```

---

### الطريقة 2: استخدام Database مباشرة

#### 1. افتح MySQL:
```bash
mysql -u root -p
```

#### 2. اختر قاعدة البيانات:
```sql
USE saas_app;
```

#### 3. حدّث الخطط:
```sql
-- للخطة Basic
UPDATE plans SET provider_id = 'price_xxxxxxxxxxxxx' WHERE name = 'Basic' AND provider = 'stripe';

-- للخطة Pro
UPDATE plans SET provider_id = 'price_yyyyyyyyyyyyyy' WHERE name = 'Pro' AND provider = 'stripe';

-- للخطة Enterprise
UPDATE plans SET provider_id = 'price_zzzzzzzzzzzzzz' WHERE name = 'Enterprise' AND provider = 'stripe';
```

---

## 📝 مثال عملي خطوة بخطوة

### افترض أنك أنشأت المنتجات وحصلت على Price IDs:

```
Basic Plan    → price_1ABC123def456GHI789jkl
Pro Plan      → price_1XYZ789ghi012JKL345mno
Enterprise    → price_1DEF456jkl789MNO012pqr
```

### في Tinker:

```php
// 1. افتح Tinker
php artisan tinker

// 2. حدّث Basic Plan
$plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_1ABC123def456GHI789jkl';
$plan->save();

// 3. حدّث Pro Plan
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_1XYZ789ghi012JKL345mno';
$plan->save();

// 4. حدّث Enterprise Plan
$plan = \App\Models\Plan::where('name', 'Enterprise')->where('provider', 'stripe')->first();
$plan->provider_id = 'price_1DEF456jkl789MNO012pqr';
$plan->save();

// 5. تأكد من التحديث
\App\Models\Plan::where('provider', 'stripe')->get(['name', 'provider_id']);
```

---

## ✅ التحقق من التحديث

### بعد التحديث، تحقق من أن Price IDs موجودة:

```bash
php artisan tinker
```

```php
// عرض جميع الخطط مع Price IDs
\App\Models\Plan::where('provider', 'stripe')->get(['id', 'name', 'provider_id']);
```

**يجب أن ترى Price IDs الحقيقية بدلاً من القيم الوهمية!**

---

## 🎯 ملخص سريع

1. **في Stripe Dashboard:**
   - أنشئ المنتج
   - انسخ **Price ID** من صفحة المنتج

2. **في Terminal:**
   ```bash
   php artisan tinker
   ```

3. **في Tinker:**
   ```php
   $plan = \App\Models\Plan::where('name', 'Basic')->where('provider', 'stripe')->first();
   $plan->provider_id = 'price_xxxxxxxxxxxxx'; // الصق Price ID هنا
   $plan->save();
   ```

4. **كرر للخطط الأخرى**

5. **حدّث الصفحة:**
   - `Ctrl + F5` في المتصفح
   - الأزرار ستعمل الآن! ✅

---

## ⚠️ ملاحظات مهمة

1. **Price ID Format:**
   - يجب أن يبدأ بـ `price_`
   - مثال: `price_1ABC123def456GHI789jkl`

2. **لا تنس:**
   - استبدل `price_xxxxxxxxxxxxx` بـ Price ID الحقيقي من Stripe
   - كرر العملية للخطط الثلاثة

3. **بعد التحديث:**
   - حدّث الصفحة: `Ctrl + F5`
   - جرب الضغط على "Subscribe with Stripe"



