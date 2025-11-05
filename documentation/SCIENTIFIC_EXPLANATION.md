# 📚 شرح علمي ومفصل: آلية عمل نظام الاشتراكات

## 🎯 نظرة عامة على النظام

نظام الاشتراكات يعتمد على **تكامل بين ثلاثة مكونات رئيسية**:
1. **Stripe Dashboard** - منصة إدارة الدفع السحابية
2. **Laravel Application** - التطبيق (Backend + Database)
3. **Laravel Cashier** - مكتبة الربط بين Laravel و Stripe

---

## 1️⃣ Stripe Dashboard - ما هو ولماذا استخدمناه؟

### 🔍 ما هو Stripe Dashboard؟

**Stripe** هو منصة دفع إلكتروني (Payment Gateway) توفر:
- **معالجة المدفوعات** بشكل آمن
- **إدارة الاشتراكات** التلقائية
- **تخزين معلومات البطاقات** بشكل مشفر
- **معالجة الفواتير** والمدفوعات المتكررة

**Stripe Dashboard** هو لوحة التحكم الإلكترونية التي تمكنك من:
- إنشاء المنتجات والأسعار (Products & Prices)
- إدارة العملاء (Customers)
- مراقبة المعاملات والاشتراكات
- استقبال إشعارات الأحداث (Webhooks)

### 🏗️ هيكل Stripe: Products & Prices

#### **Product (المنتج)**
- **ما هو**: وصف للمنتج أو الخدمة التي تبيعها
- **مثال**: "Basic Plan", "Pro Plan", "Enterprise Plan"
- **المعلومات**: اسم، وصف، صورة (اختياري)

#### **Price (السعر)**
- **ما هو**: تحديد السعر والفوترة للمنتج
- **مثال**: `$10/month`, `$25/month`, `$50/month`
- **المعلومات**: 
  - المبلغ (Amount)
  - العملة (Currency)
  - الفترة (Interval: month/year)
  - **Price ID**: معرف فريد يبدأ بـ `price_` (مثل `price_1ABC123def456GHI789jkl`)

### 🔑 لماذا Price ID مهم جداً؟

**Price ID** هو **الرابط الوحيد** بين:
- **Stripe** (في السحابة)
- **قاعدة البيانات** (في التطبيق)

**بدون Price ID صحيح**:
- Laravel لا يستطيع إنشاء جلسة الدفع
- Stripe لا يعرف أي خطة المشترك يريد
- النظام لا يعمل

**مع Price ID صحيح**:
- Laravel يرسل Price ID إلى Stripe
- Stripe يعرف السعر والفوترة
- يتم إنشاء جلسة الدفع بنجاح

### 📊 مثال عملي:

```
في Stripe Dashboard:
┌─────────────────────────────────┐
│ Product: "Pro Plan"              │
│ ┌─────────────────────────────┐ │
│ │ Price: $25/month            │ │
│ │ Price ID: price_1ABC123...  │ ← هذا ما نحتاجه!
│ │ Currency: USD                │ │
│ │ Interval: month              │ │
│ └─────────────────────────────┘ │
└─────────────────────────────────┘
```

---

## 2️⃣ Laravel Tinker - ما هو ولماذا استخدمناه؟

### 🔍 ما هو Laravel Tinker?

**Tinker** هو **REPL (Read-Eval-Print Loop)** - أداة تفاعلية لـ Laravel تمكنك من:
- **تشغيل كود PHP** مباشرة من Terminal
- **التفاعل مع قاعدة البيانات** بدون كتابة كود كامل
- **اختبار الكود** بسرعة
- **تحديث البيانات** مباشرة

### 🛠️ كيف يعمل Tinker?

**REPL** يعني:
1. **Read** (قراءة): يقرأ الكود الذي تكتبه
2. **Eval** (تنفيذ): ينفذ الكود
3. **Print** (طباعة): يطبع النتيجة
4. **Loop** (تكرار): يعيد العملية

### 💡 لماذا استخدمنا Tinker لتحديث Price IDs?

#### **البديل 1: كتابة Migration**
```php
// ❌ مشكلة: تحتاج إلى إنشاء ملف migration جديد
// ❌ مشكلة: تحتاج إلى إعادة تشغيل migration
// ❌ مشكلة: لا يمكن تغيير البيانات بسهولة
```

#### **البديل 2: استخدام Database مباشرة**
```sql
-- ❌ مشكلة: تحتاج إلى الاتصال بقاعدة البيانات
-- ❌ مشكلة: لا يمكن استخدام Eloquent Models
-- ❌ مشكلة: لا يمكن التحقق من البيانات
```

#### **البديل 3: استخدام Tinker** ✅
```php
// ✅ سهولة: كود PHP مباشر
// ✅ آمن: يستخدم Eloquent ORM
// ✅ سريع: تحديث فوري
// ✅ مرن: يمكن التحقق من النتائج
```

### 📝 مثال عملي: كيف يعمل Tinker

```php
// 1. افتح Tinker
php artisan tinker

// 2. استخدم Eloquent ORM للبحث عن الخطة
$plan = \App\Models\Plan::where('name', 'Pro')->where('provider', 'stripe')->first();

// 3. حدّث Price ID
$plan->provider_id = 'price_1ABC123def456GHI789jkl';

// 4. احفظ التغييرات
$plan->save();

// 5. تحقق من النتيجة
echo $plan->provider_id; // price_1ABC123def456GHI789jkl
```

### 🔬 التحليل العلمي:

**Tinker** يستخدم:
- **PHP Reflection API**: لتحليل الكود
- **PsySH**: مكتبة REPL لـ PHP
- **Laravel Service Container**: لحل الاعتمادات (Dependency Injection)
- **Eloquent ORM**: للتفاعل مع قاعدة البيانات

---

## 3️⃣ قاعدة البيانات - الهيكل والعلاقات

### 🗄️ هيكل قاعدة البيانات

#### **جدول `plans`**
```sql
CREATE TABLE plans (
    id BIGINT PRIMARY KEY,
    provider_id VARCHAR(255),      -- Price ID من Stripe
    provider VARCHAR(50),          -- 'stripe' أو 'mollie'
    name VARCHAR(255),             -- 'Basic', 'Pro', 'Enterprise'
    interval VARCHAR(50),         -- 'month' أو 'year'
    amount INTEGER,               -- السعر بالـ cents (1000 = $10.00)
    currency VARCHAR(10),         -- 'usd', 'eur'
    features TEXT,                -- JSON array
    is_active BOOLEAN,            -- true/false
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**العلاقة:**
- `plans.provider_id` → **يربط** → `Stripe Price ID`
- هذا هو **الرابط الوحيد** بين قاعدة البيانات و Stripe

#### **جدول `users`**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    stripe_id VARCHAR(255),        -- Stripe Customer ID
    mollie_customer_id VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**العلاقة:**
- `users.stripe_id` → **يربط** → `Stripe Customer ID`
- عندما ينشئ المستخدم اشتراك، Stripe يربطه بـ `stripe_id`

#### **جدول `subscriptions`** (من Laravel Cashier)
```sql
CREATE TABLE subscriptions (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,               -- Foreign Key → users.id
    type VARCHAR(255),            -- 'default'
    stripe_id VARCHAR(255),       -- Stripe Subscription ID
    stripe_status VARCHAR(255),   -- 'active', 'canceled', 'past_due'
    stripe_price VARCHAR(255),   -- Price ID من Stripe
    quantity INTEGER,             -- عدد الاشتراكات
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**العلاقات:**
- `subscriptions.user_id` → **يربط** → `users.id`
- `subscriptions.stripe_price` → **يربط** → `plans.provider_id`
- `subscriptions.stripe_id` → **يربط** → `Stripe Subscription ID`

### 🔗 الرسم التخطيطي للعلاقات:

```
┌─────────────────┐
│   Stripe Cloud   │
│                  │
│  Product: "Pro"  │
│  Price ID:       │
│  price_1ABC...   │
└────────┬─────────┘
         │
         │ (provider_id)
         │
         ▼
┌─────────────────┐
│   plans Table   │
│                 │
│  provider_id:   │
│  price_1ABC...  │
│  name: "Pro"    │
└────────┬────────┘
         │
         │ (stripe_price)
         │
         ▼
┌─────────────────┐
│ subscriptions   │
│                 │
│  user_id: 1     │
│  stripe_price:  │
│  price_1ABC...  │
└────────┬────────┘
         │
         │ (user_id)
         │
         ▼
┌─────────────────┐
│   users Table   │
│                 │
│  id: 1          │
│  name: "John"   │
│  stripe_id:     │
│  cus_123...     │
└─────────────────┘
```

---

## 4️⃣ Laravel Cashier - آلية العمل

### 🔍 ما هو Laravel Cashier?

**Laravel Cashier** هو **مكتبة رسمية** من Laravel تقدم:
- **واجهة برمجية** للتفاعل مع Stripe
- **إدارة الاشتراكات** التلقائية
- **معالجة Webhooks** تلقائياً
- **تزامن البيانات** بين Laravel و Stripe

### 🏗️ كيف يعمل Cashier؟

#### **1. Billable Trait**

```43:43:app/Services/SubscriptionService.php
            $checkout = $user->newSubscription('default', $plan->provider_id)
```

**`Billable` trait** يضيف إلى `User` model:
- `newSubscription()`: إنشاء اشتراك جديد
- `subscription()`: الحصول على الاشتراك الحالي
- `createOrGetStripeCustomer()`: إنشاء/الحصول على Stripe Customer

#### **2. إنشاء Checkout Session**

```43:47:app/Services/SubscriptionService.php
            $checkout = $user->newSubscription('default', $plan->provider_id)
                ->checkout([
                    'success_url' => route('billing.success', ['provider' => 'stripe']),
                    'cancel_url' => route('plans'),
                ]);
```

**ما يحدث هنا:**

1. **`$user->newSubscription('default', $plan->provider_id)`**
   - ينشئ كائن `SubscriptionBuilder`
   - يحدد اسم الاشتراك: `'default'`
   - يحدد Price ID: `$plan->provider_id`

2. **`->checkout([...])`**
   - ينشئ **Stripe Checkout Session** عبر Stripe API
   - يرسل `provider_id` إلى Stripe
   - Stripe يتحقق من Price ID
   - إذا كان صحيحاً: ينشئ Checkout Session
   - إذا كان خطأ: يرمي خطأ `InvalidRequestException`

3. **النتيجة:**
   - كائن `Checkout` يحتوي على `url`
   - هذا الـ URL هو رابط صفحة الدفع في Stripe

#### **3. الحصول على Checkout URL**

```49:62:app/Services/SubscriptionService.php
            // Get checkout URL - Laravel Cashier returns CheckoutSession object
            $checkoutUrl = $checkout->url ?? null;
            
            if (empty($checkoutUrl)) {
                Log::error('Checkout URL is empty', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'provider_id' => $plan->provider_id,
                    'checkout_object' => get_class($checkout),
                ]);
                throw new \Exception('Failed to create checkout session. Please check your Stripe configuration and Price ID.');
            }

            return $checkoutUrl;
```

**ما يحدث:**
- `Checkout` object يستخدم **Magic Method `__get`**
- عند الوصول إلى `$checkout->url`، يسترجع `$this->session->url`
- `$this->session` هو كائن `Stripe\Checkout\Session`
- يحتوي على `url` الذي يوجه المستخدم إلى صفحة الدفع

### 🔄 التدفق الكامل للعملية:

```
1. المستخدم يضغط "Subscribe with Stripe"
   ↓
2. SubscriptionController@checkout()
   ↓
3. SubscriptionService@createStripeCheckout()
   ↓
4. $user->newSubscription('default', $plan->provider_id)
   ↓
5. Cashier يرسل طلب HTTP إلى Stripe API
   ↓
6. Stripe يتحقق من Price ID
   ↓
7. إذا كان صحيحاً: ينشئ Checkout Session
   ↓
8. Cashier يعيد Checkout object مع URL
   ↓
9. Controller يعيد redirect($checkoutUrl)
   ↓
10. المستخدم ينتقل إلى صفحة الدفع في Stripe
```

---

## 5️⃣ لماذا Price ID مهم جداً؟

### ❌ بدون Price ID صحيح:

```php
// في قاعدة البيانات
$plan->provider_id = 'invalid_price_id';

// عند محاولة إنشاء Checkout
$checkout = $user->newSubscription('default', 'invalid_price_id')
    ->checkout([...]);

// Stripe API يرمي خطأ:
// "No such price: 'invalid_price_id'"
```

**النتيجة:**
- ❌ لا يتم إنشاء Checkout Session
- ❌ لا يتم توجيه المستخدم إلى صفحة الدفع
- ❌ يظهر خطأ: "Failed to create checkout session"

### ✅ مع Price ID صحيح:

```php
// في قاعدة البيانات
$plan->provider_id = 'price_1ABC123def456GHI789jkl';

// عند محاولة إنشاء Checkout
$checkout = $user->newSubscription('default', 'price_1ABC123def456GHI789jkl')
    ->checkout([...]);

// Stripe API يتحقق من Price ID
// ✅ Price ID موجود في Stripe
// ✅ ينشئ Checkout Session
// ✅ يعيد URL
```

**النتيجة:**
- ✅ يتم إنشاء Checkout Session
- ✅ يتم توجيه المستخدم إلى صفحة الدفع
- ✅ المستخدم يمكنه إتمام الدفع

---

## 6️⃣ التكامل الكامل: Stripe ↔ Laravel

### 🔄 التزامن بين Stripe و Laravel:

#### **1. عند إنشاء الاشتراك:**

```
Laravel Application:
├─ User clicks "Subscribe"
├─ SubscriptionController@checkout()
├─ SubscriptionService@createStripeCheckout()
├─ Cashier sends request to Stripe API
│
Stripe Cloud:
├─ Receives request with Price ID
├─ Validates Price ID
├─ Creates Checkout Session
├─ Returns Checkout URL
│
Laravel Application:
├─ Receives Checkout URL
├─ Redirects user to Stripe Checkout
│
Stripe Checkout:
├─ User enters payment details
├─ User completes payment
├─ Stripe creates Subscription
├─ Stripe sends Webhook to Laravel
│
Laravel Application:
├─ StripeWebhookController@handle()
├─ Updates subscription in database
└─ Sends notification to user
```

#### **2. عند تحديث Price ID:**

```
في Stripe Dashboard:
├─ Update Product/Price
├─ Get new Price ID
│
في Laravel (Tinker):
├─ $plan = Plan::where('name', 'Pro')->first();
├─ $plan->provider_id = 'new_price_id';
├─ $plan->save();
│
في قاعدة البيانات:
├─ plans.provider_id = 'new_price_id'
│
في Laravel Application:
├─ Next checkout uses new Price ID
└─ Works with new Stripe Price
```

---

## 7️⃣ الخلاصة العلمية

### 🎓 المفاهيم الأساسية:

1. **Stripe Dashboard**:
   - منصة إدارة المدفوعات السحابية
   - تخزن Products و Prices
   - Price ID هو المعرف الفريد

2. **Laravel Tinker**:
   - أداة REPL للتفاعل مع Laravel
   - يستخدم Eloquent ORM
   - سهل وسريع لتحديث البيانات

3. **قاعدة البيانات**:
   - تخزن `provider_id` (Price ID)
   - تربط بين Laravel و Stripe
   - `plans.provider_id` → `Stripe Price ID`

4. **Laravel Cashier**:
   - مكتبة الربط بين Laravel و Stripe
   - `newSubscription()` ينشئ Checkout Session
   - يحتاج Price ID صحيح للعمل

### 🔗 العلاقة بين المكونات:

```
Stripe Dashboard (Cloud)
    ↑
    │ (Price ID)
    │
Database (plans.provider_id)
    ↑
    │ (Eloquent ORM)
    │
Laravel Application
    ↑
    │ (Cashier)
    │
Stripe API
    ↑
    │ (Webhooks)
    │
Laravel Webhook Controller
```

### ✅ لماذا النظام يعمل الآن:

1. ✅ **Price IDs موجودة في Stripe Dashboard**
2. ✅ **Price IDs محدثة في قاعدة البيانات** (عبر Tinker)
3. ✅ **Stripe API Keys موجودة** في `.env`
4. ✅ **Laravel Cashier مرتبط** بـ Stripe
5. ✅ **التدفق الكامل يعمل** من الاشتراك إلى الدفع

---

## 📚 مراجع إضافية

- [Laravel Cashier Documentation](https://laravel.com/docs/cashier)
- [Stripe API Documentation](https://stripe.com/docs/api)
- [Eloquent ORM Documentation](https://laravel.com/docs/eloquent)
- [Laravel Tinker Documentation](https://laravel.com/docs/artisan#tinker)



