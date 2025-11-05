# 📝 دليل إعداد Stripe Products - ملء الحقول

## 🎯 الهدف
إنشاء 3 منتجات في Stripe Dashboard للحصول على Price IDs الحقيقية.

---

## 📋 المنتجات المطلوبة

### 1️⃣ Basic Plan
### 2️⃣ Pro Plan  
### 3️⃣ Enterprise Plan

---

## 🔧 خطوات ملء الحقول

### لكل منتج، املأ الحقول التالية:

#### 1. **الاسم (Name)** - مطلوب
```
Basic Plan
```
أو
```
Pro Plan
```
أو
```
Enterprise Plan
```

#### 2. **الوصف (Description)** - اختياري
```
Basic Plan - Perfect for individuals getting started
```
أو
```
Pro Plan - For growing teams and businesses
```
أو
```
Enterprise Plan - For large organizations with unlimited needs
```

#### 3. **الصورة (Image)** - اختياري
- يمكنك تركها فارغة للاختبار
- أو رفع صورة (JPEG, PNG, WEBP أقل من 2MB)

#### 4. **نموذج التسعير (Pricing model)**
- ✅ اختر: **"Recurring"** (متكرر)
- ❌ لا تختار: "One-off" (مرة واحدة)

#### 5. **المبلغ (Amount)** - مطلوب

**للخطة Basic:**
```
10.00
```

**للخطة Pro:**
```
25.00
```

**للخطة Enterprise:**
```
50.00
```

#### 6. **العملة (Currency)**
- اختر: **USD** (الدولار الأمريكي)

#### 7. **فترة الفوترة (Billing period)**
- اختر: **"Monthly"** (شهريًا)

---

## 📊 ملخص القيم لكل خطة

### ✅ Basic Plan:
| الحقل | القيمة |
|------|--------|
| Name | `Basic Plan` |
| Description | `Basic Plan - Perfect for individuals` |
| Pricing model | `Recurring` |
| Amount | `10.00` |
| Currency | `USD` |
| Billing period | `Monthly` |

### ✅ Pro Plan:
| الحقل | القيمة |
|------|--------|
| Name | `Pro Plan` |
| Description | `Pro Plan - For growing teams` |
| Pricing model | `Recurring` |
| Amount | `25.00` |
| Currency | `USD` |
| Billing period | `Monthly` |

### ✅ Enterprise Plan:
| الحقل | القيمة |
|------|--------|
| Name | `Enterprise Plan` |
| Description | `Enterprise Plan - For large organizations` |
| Pricing model | `Recurring` |
| Amount | `50.00` |
| Currency | `USD` |
| Billing period | `Monthly` |

---

## 🔍 بعد الحفظ

1. بعد الضغط على **"Add product"** (إضافة منتج)
2. ستظهر صفحة المنتج
3. في قسم **"Pricing"** ستجد **Price ID**
4. انسخ Price ID (يبدأ بـ `price_...`)
5. مثال: `price_1ABC123def456GHI789jkl`

---

## ⚠️ ملاحظات مهمة

1. **Pricing model:**
   - ✅ يجب أن يكون **"Recurring"** (متكرر)
   - ❌ لا تختار "One-off"

2. **Billing period:**
   - ✅ اختر **"Monthly"** (شهريًا)

3. **Amount:**
   - ✅ أدخل المبلغ بدون رمز العملة (مثل: `10.00` وليس `$10.00`)

4. **Currency:**
   - ✅ اختر **USD** للخطط الأمريكية

---

## 📝 مثال كامل لخطة Basic:

```
Name: Basic Plan
Description: Basic Plan - Perfect for individuals getting started
Pricing model: Recurring ✓
Amount: 10.00
Currency: USD
Billing period: Monthly
```

بعد الحفظ، انسخ **Price ID** من صفحة المنتج!



