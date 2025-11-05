# 📚 دليل إعداد Git و GitHub - خطوة بخطوة

## 🎯 نظرة عامة

هذا الدليل يشرح كيفية:
1. ✅ رفع المشروع على GitHub
2. ✅ إعداد هيكل الفروع (Branches)
3. ✅ استخدام رسائل commit واضحة
4. ✅ فتح Pull Request

---

## 📋 المتطلبات الأساسية

- ✅ حساب GitHub
- ✅ Git مثبت على الجهاز
- ✅ المشروع جاهز

---

## 🔧 الخطوة 1: إعداد Git في المشروع

### **1.1 التحقق من Git**

```bash
# التحقق من وجود Git
git --version
```

إذا لم يكن مثبتاً، قم بتثبيته من: https://git-scm.com/

### **1.2 تهيئة Git في المشروع**

```bash
# الانتقال إلى مجلد المشروع
cd M:\Laravel\test-app

# تهيئة Git
git init

# إعداد معلومات المستخدم (إذا لم تكن موجودة)
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### **1.3 إنشاء .gitignore**

تحقق من وجود ملف `.gitignore`. إذا لم يكن موجوداً، أنشئه:

```bash
# إنشاء .gitignore
touch .gitignore
```

أضف المحتوى التالي:

```gitignore
# Laravel
/vendor/
/node_modules/
/public/hot
/public/storage
/storage/*.key
/.env
/.env.backup
/.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode

# OS
.DS_Store
Thumbs.db

# Logs
*.log
storage/logs/*.log

# Cache
/bootstrap/cache/*
/storage/framework/cache/*
/storage/framework/sessions/*
/storage/framework/views/*

# Compiled assets
/public/build
/public/mix-manifest.json
```

---

## 🚀 الخطوة 2: إنشاء المستودع على GitHub

### **2.1 إنشاء مستودع جديد**

1. اذهب إلى [GitHub](https://github.com)
2. اضغط على **"New"** أو **"+"** في الزاوية العلوية
3. اختر **"New repository"**
4. املأ المعلومات:
   - **Repository name**: `saas-app` أو أي اسم مناسب
   - **Description**: "SaaS Application - Laravel 12 with Subscription System"
   - **Visibility**: 
     - **Public** (عام) - إذا أردت أن يكون مرئياً للجميع
     - **Private** (خاص) - إذا أردت أن يكون خاصاً
   - **⚠️ لا تضع علامة على "Initialize this repository with a README"**
   - **⚠️ لا تختار .gitignore أو license**
5. اضغط **"Create repository"**

### **2.2 الحصول على رابط المستودع**

بعد إنشاء المستودع، ستحصل على رابط مثل:
```
https://github.com/your-username/saas-app.git
```

**احفظ هذا الرابط!** ستحتاجه لاحقاً.

---

## 🔗 الخطوة 3: ربط المشروع المحلي بـ GitHub

### **3.1 إضافة Remote Repository**

```bash
# في مجلد المشروع
cd M:\Laravel\test-app

# إضافة GitHub كـ remote (استبدل الرابط برابطك)
git remote add origin https://github.com/your-username/saas-app.git

# التحقق من الـ remote
git remote -v
```

يجب أن ترى:
```
origin  https://github.com/your-username/saas-app.git (fetch)
origin  https://github.com/your-username/saas-app.git (push)
```

---

## 🌳 الخطوة 4: إعداد هيكل الفروع

### **4.1 إنشاء فرع main (النسخة المستقرة)**

```bash
# إضافة جميع الملفات
git add .

# عمل commit أولي
git commit -m "Initial commit: SaaS Application setup"

# إنشاء فرع main
git branch -M main

# رفع إلى GitHub
git push -u origin main
```

### **4.2 إنشاء فرع dev (النسخة التطويرية)**

```bash
# إنشاء فرع dev من main
git checkout -b dev

# رفع فرع dev إلى GitHub
git push -u origin dev
```

### **4.3 التحقق من الفروع**

```bash
# عرض جميع الفروع
git branch -a
```

يجب أن ترى:
```
* dev
  main
```

---

## 📝 الخطوة 5: العمل على ميزة جديدة (Feature Branch)

### **5.1 إنشاء فرع ميزة جديد**

```bash
# التأكد من أنك في فرع dev
git checkout dev

# سحب آخر التحديثات
git pull origin dev

# إنشاء فرع ميزة جديد
git checkout -b feature/subscription-system

# أو لميزة أخرى:
git checkout -b feature/multi-tenancy
git checkout -b feature/notifications
```

### **5.2 العمل على الميزة**

```bash
# قم بالتعديلات المطلوبة
# ... تعديل الكود ...

# إضافة الملفات المعدلة
git add .

# أو إضافة ملفات محددة
git add app/Services/SubscriptionService.php
git add routes/web.php
```

### **5.3 عمل Commit مع رسالة واضحة**

```bash
# رسالة commit واضحة ومنظمة
git commit -m "feat(subscriptions): add Stripe checkout integration

- Add SubscriptionService with createStripeCheckout method
- Add SubscriptionController with checkout flow
- Add webhook handling for payment events
- Add error handling and logging

Related to: #issue-number"
```

#### **📋 صيغة رسائل Commit:**

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: ميزة جديدة
- `fix`: إصلاح خطأ
- `docs`: تحديث التوثيق
- `style`: تغييرات في التنسيق (لا تؤثر على الكود)
- `refactor`: إعادة هيكلة الكود
- `test`: إضافة أو تعديل الاختبارات
- `chore`: مهام صيانة

**Examples:**
```bash
# ميزة جديدة
git commit -m "feat(subscriptions): add Stripe checkout integration"

# إصلاح خطأ
git commit -m "fix(webhook): handle duplicate webhook events"

# تحديث التوثيق
git commit -m "docs(readme): update installation instructions"

# إعادة هيكلة
git commit -m "refactor(services): extract subscription logic to service layer"
```

---

## 🔄 الخطوة 6: رفع التغييرات

### **6.1 رفع فرع الميزة إلى GitHub**

```bash
# التأكد من أنك في فرع الميزة
git checkout feature/subscription-system

# رفع الفرع إلى GitHub
git push -u origin feature/subscription-system
```

---

## 🔀 الخطوة 7: فتح Pull Request

### **7.1 من GitHub Website**

1. اذهب إلى المستودع على GitHub
2. سترى رسالة: **"Compare & pull request"** - اضغط عليها
3. أو اضغط **"Pull requests"** → **"New pull request"**
4. اختر:
   - **Base**: `dev` (الفرع الذي تريد الدمج فيه)
   - **Compare**: `feature/subscription-system` (الفرع الذي تريد دمجه)
5. املأ المعلومات:
   - **Title**: `feat: Add Stripe checkout integration`
   - **Description**:
     ```markdown
     ## Changes
     - Add SubscriptionService with Stripe checkout
     - Add SubscriptionController for checkout flow
     - Add webhook handling for payment events
     
     ## Testing
     - [ ] Tested checkout flow
     - [ ] Tested webhook handling
     - [ ] Tested error scenarios
     
     ## Related Issues
     - Closes #123
     ```
6. اضغط **"Create pull request"**

### **7.2 من Command Line (GitHub CLI)**

إذا كان لديك GitHub CLI مثبت:

```bash
gh pr create --base dev --head feature/subscription-system --title "feat: Add Stripe checkout integration" --body "Description here"
```

---

## 📋 الخطوة 8: دمج Pull Request

### **8.1 مراجعة Pull Request**

1. **Reviewers** سيراجعون الكود
2. قد يطلبون **تغييرات** (Changes requested)
3. قم بالتعديلات المطلوبة
4. ارفع التغييرات مرة أخرى:

```bash
# في فرع الميزة
git add .
git commit -m "fix(subscriptions): address review comments"
git push origin feature/subscription-system
```

### **8.2 دمج Pull Request**

بعد الموافقة على Pull Request:

1. اضغط **"Merge pull request"**
2. اختر نوع الدمج:
   - **"Create a merge commit"** (موصى به)
   - **"Squash and merge"** (دمج جميع commits في واحد)
   - **"Rebase and merge"** (إعادة تطبيق commits)
3. اضغط **"Confirm merge"**
4. **حذف فرع الميزة** (اختياري)

---

## 🔄 الخطوة 9: المزامنة بعد الدمج

### **9.1 سحب آخر التحديثات**

```bash
# الانتقال إلى فرع dev
git checkout dev

# سحب آخر التحديثات من GitHub
git pull origin dev

# إذا كنت تريد حذف فرع الميزة المحلي
git branch -d feature/subscription-system
```

---

## 📊 هيكل الفروع النهائي

```
main (النسخة المستقرة)
  ↑
  └── dev (النسخة التطويرية)
       ↑
       ├── feature/subscription-system
       ├── feature/multi-tenancy
       ├── feature/notifications
       └── feature/...
```

---

## 🎯 سير العمل اليومي (Daily Workflow)

### **1. بدء العمل على ميزة جديدة**

```bash
# 1. الانتقال إلى dev
git checkout dev

# 2. سحب آخر التحديثات
git pull origin dev

# 3. إنشاء فرع ميزة جديد
git checkout -b feature/new-feature
```

### **2. العمل على الميزة**

```bash
# 1. تعديل الكود
# ... عملك ...

# 2. إضافة التغييرات
git add .

# 3. عمل commit
git commit -m "feat: add new feature"

# 4. رفع التغييرات
git push origin feature/new-feature
```

### **3. فتح Pull Request**

- اذهب إلى GitHub
- افتح Pull Request من `feature/new-feature` إلى `dev`

---

## 📝 أمثلة على رسائل Commit

### **✅ جيد:**

```bash
feat(subscriptions): add Stripe checkout integration

- Add SubscriptionService with createStripeCheckout method
- Add SubscriptionController with checkout flow
- Add webhook handling for payment events
- Add error handling and logging

Closes #123
```

```bash
fix(webhook): handle duplicate webhook events

- Add idempotency check for webhook events
- Prevent duplicate processing
- Add logging for duplicate events

Fixes #456
```

```bash
docs(readme): update installation instructions

- Add Stripe API key setup
- Add Mollie API key setup
- Add webhook configuration steps
```

### **❌ سيء:**

```bash
# ❌ سيء - رسالة غير واضحة
git commit -m "update"
git commit -m "fix"
git commit -m "changes"
```

---

## 🔐 إعدادات الأمان (للـ Private Repository)

### **إضافة Collaborators (المشاركين)**

1. اذهب إلى المستودع على GitHub
2. اضغط **"Settings"**
3. اضغط **"Collaborators"**
4. اضغط **"Add people"**
5. أدخل اسم المستخدم أو البريد الإلكتروني
6. اختر الصلاحية:
   - **Read** (قراءة فقط)
   - **Write** (قراءة وكتابة)
   - **Admin** (إدارة كاملة)
7. اضغط **"Add [username] to this repository"**

---

## 🚨 حل المشاكل الشائعة

### **1. رفض Push (Push Rejected)**

```bash
# سحب آخر التحديثات أولاً
git pull origin dev

# حل التعارضات (إن وجدت)
# ... حل التعارضات ...

# رفع مرة أخرى
git push origin feature/your-feature
```

### **2. نسيت فرع الميزة**

```bash
# عرض جميع الفروع
git branch -a

# الانتقال إلى فرع
git checkout feature/your-feature
```

### **3. حذف فرع محلي**

```bash
# حذف فرع محلي
git branch -d feature/old-feature

# حذف فرع قسرياً (إذا لم يكن مدمجاً)
git branch -D feature/old-feature
```

### **4. حذف فرع على GitHub**

```bash
# حذف فرع على GitHub
git push origin --delete feature/old-feature
```

---

## 📚 موارد إضافية

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Conventional Commits](https://www.conventionalcommits.org/)

---

## ✅ Checklist النهائي

- [ ] Git مثبت ومهيأ
- [ ] `.gitignore` موجود وصحيح
- [ ] المستودع تم إنشاؤه على GitHub
- [ ] Remote تم إضافته
- [ ] فرع `main` تم إنشاؤه ورفعه
- [ ] فرع `dev` تم إنشاؤه ورفعه
- [ ] فرع ميزة تم إنشاؤه
- [ ] Commit تم بعمل رسالة واضحة
- [ ] Pull Request تم فتحه

---

**Good Luck! 🚀**

