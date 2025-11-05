#!/bin/bash

# ============================================
# دليل أوامر Git - خطوة بخطوة
# ============================================

# ============================================
# الخطوة 1: إعداد Git في المشروع
# ============================================

# 1.1 التحقق من Git
git --version

# 1.2 تهيئة Git في المشروع
cd M:\Laravel\test-app
git init

# 1.3 إعداد معلومات المستخدم (إذا لم تكن موجودة)
git config user.name "Your Name"
git config user.email "your.email@example.com"

# ============================================
# الخطوة 2: إضافة Remote Repository
# ============================================

# 2.1 إضافة GitHub كـ remote (استبدل الرابط برابطك)
git remote add origin https://github.com/your-username/saas-app.git

# 2.2 التحقق من الـ remote
git remote -v

# ============================================
# الخطوة 3: إعداد الفروع
# ============================================

# 3.1 إضافة جميع الملفات
git add .

# 3.2 عمل commit أولي
git commit -m "Initial commit: SaaS Application setup

- Add Laravel 12 framework
- Add authentication with Laravel Breeze
- Add roles and permissions with Spatie
- Add subscription system with Stripe and Mollie
- Add notifications (Email + WhatsApp)
- Add Neumorphism design with Tailwind CSS"

# 3.3 إنشاء فرع main
git branch -M main

# 3.4 رفع إلى GitHub
git push -u origin main

# ============================================
# الخطوة 4: إنشاء فرع dev
# ============================================

# 4.1 إنشاء فرع dev من main
git checkout -b dev

# 4.2 رفع فرع dev إلى GitHub
git push -u origin dev

# ============================================
# الخطوة 5: العمل على ميزة جديدة
# ============================================

# 5.1 الانتقال إلى dev
git checkout dev

# 5.2 سحب آخر التحديثات
git pull origin dev

# 5.3 إنشاء فرع ميزة جديد
git checkout -b feature/subscription-system

# 5.4 العمل على الميزة
# ... تعديل الكود ...

# 5.5 إضافة التغييرات
git add .

# 5.6 عمل commit مع رسالة واضحة
git commit -m "feat(subscriptions): add Stripe checkout integration

- Add SubscriptionService with createStripeCheckout method
- Add SubscriptionController with checkout flow
- Add webhook handling for payment events
- Add error handling and logging"

# 5.7 رفع فرع الميزة إلى GitHub
git push -u origin feature/subscription-system

# ============================================
# الخطوة 6: بعد فتح Pull Request ودمجه
# ============================================

# 6.1 الانتقال إلى dev
git checkout dev

# 6.2 سحب آخر التحديثات
git pull origin dev

# 6.3 حذف فرع الميزة المحلي (اختياري)
git branch -d feature/subscription-system

# ============================================
# أوامر مفيدة
# ============================================

# عرض جميع الفروع
git branch -a

# عرض حالة Git
git status

# عرض آخر commits
git log --oneline -10

# عرض التغييرات
git diff

# عرض التغييرات في ملف معين
git diff app/Services/SubscriptionService.php

# إلغاء التغييرات غير المحفوظة
git checkout -- filename

# إلغاء التغييرات المحفوظة (لم يتم push)
git reset --soft HEAD~1

# ============================================
# أمثلة على رسائل Commit
# ============================================

# ميزة جديدة
git commit -m "feat(subscriptions): add Stripe checkout integration"

# إصلاح خطأ
git commit -m "fix(webhook): handle duplicate webhook events"

# تحديث التوثيق
git commit -m "docs(readme): update installation instructions"

# إعادة هيكلة
git commit -m "refactor(services): extract subscription logic to service layer"

# إضافة اختبارات
git commit -m "test(subscriptions): add feature tests for checkout flow"

