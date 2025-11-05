# 🔄 Git Workflow - دليل العمل مع Git

## 📍 الوضع الحالي

✅ **المشروع موجود على GitHub**: `https://github.com/MustafaKhalil10/saas-app.git`

✅ **الفروع المتوفرة**:
- `main` - النسخة المستقرة
- `dev` - النسخة التطويرية

---

## 🎯 هيكل الفروع المطلوب

```
main          ← النسخة المستقرة (Production)
│
dev           ← النسخة التطويرية (Development)
│
feature/*     ← فروع الميزات الجديدة
└─ feature/subscription-system
└─ feature/multi-tenancy
└─ feature/notifications
```

---

## 📝 خطوات العمل اليومية

### **1. إنشاء فرع ميزة جديدة (Feature Branch)**

```bash
# التأكد من أنك في فرع dev
git checkout dev

# تحديث فرع dev من GitHub
git pull origin dev

# إنشاء فرع جديد للميزة
git checkout -b feature/your-feature-name

# مثال:
git checkout -b feature/multi-tenancy-complete
git checkout -b feature/testing-setup
git checkout -b feature/admin-dashboard
```

### **2. العمل على الميزة**

```bash
# قم بتعديل الملفات
# أضف الملفات
git add .

# أو أضف ملفات محددة
git add app/Models/Organization.php
git add database/migrations/xxx_create_organizations_table.php
```

### **3. Commit مع رسائل واضحة**

```bash
# صيغة رسائل Commit:
# <type>(<scope>): <subject>
#
# <body>
#
# <footer>

# أمثلة:
git commit -m "feat(subscription): add Stripe checkout integration"
git commit -m "fix(webhook): handle duplicate events idempotently"
git commit -m "docs(readme): update setup instructions"
git commit -m "refactor(service): extract subscription logic to service"
```

#### **أنواع Commit (Types):**
- `feat`: ميزة جديدة
- `fix`: إصلاح خطأ
- `docs`: تحديث التوثيق
- `style`: تغييرات في التنسيق (لا تؤثر على الكود)
- `refactor`: إعادة هيكلة الكود
- `test`: إضافة أو تعديل الاختبارات
- `chore`: مهام صيانة (مثل تحديث dependencies)

#### **أمثلة رسائل Commit جيدة:**

```bash
# مثال 1: ميزة جديدة
git commit -m "feat(subscription): add Mollie payment integration

- Add Mollie checkout session creation
- Add Mollie webhook handler
- Update subscription service to support Mollie
- Add Mollie configuration to services.php"

# مثال 2: إصلاح
git commit -m "fix(webhook): handle duplicate webhook events

Prevent processing the same webhook event multiple times
by checking event ID before processing."

# مثال 3: توثيق
git commit -m "docs(setup): add payment gateway setup guide

- Add Stripe setup instructions
- Add Mollie setup instructions
- Add webhook configuration guide"

# مثال 4: إعادة هيكلة
git commit -m "refactor(service): extract subscription logic to SubscriptionService

Move subscription business logic from controller to service
for better separation of concerns and testability."
```

### **4. رفع التغييرات إلى GitHub**

```bash
# رفع الفرع الجديد إلى GitHub
git push origin feature/your-feature-name

# مثال:
git push origin feature/multi-tenancy-complete
```

### **5. إنشاء Pull Request**

#### **على GitHub:**
1. اذهب إلى: `https://github.com/MustafaKhalil10/saas-app`
2. اضغط على **"Compare & pull request"**
3. أو اضغط على **"Pull requests"** → **"New pull request"**
4. اختر:
   - **Base**: `dev` ← (الفرع الذي تريد الدمج فيه)
   - **Compare**: `feature/your-feature-name` ← (فرعك)
5. املأ معلومات PR:
   - **Title**: وصف مختصر
   - **Description**: شرح تفصيلي للميزة
6. اضغط **"Create pull request"**

#### **نموذج Pull Request:**

**Title:**
```
feat(multi-tenancy): complete multi-tenant system implementation
```

**Description:**
```markdown
## 🎯 الهدف
إكمال نظام Multi-Tenancy بإضافة Middleware و Relationships

## 📋 التغييرات
- ✅ Add SetTenant middleware
- ✅ Add Organization relationships to User and Subscription models
- ✅ Add data scoping by organization
- ✅ Update migrations

## 🧪 الاختبارات
- [ ] Test tenant isolation
- [ ] Test data scoping
- [ ] Test user access across organizations

## 📸 Screenshots
(إذا لزم الأمر)

## 🔗 Related Issues
Closes #123
```

### **6. بعد الموافقة على PR**

```bash
# بعد الموافقة ودمج PR في dev:

# انتقل إلى فرع dev
git checkout dev

# احذف فرع الميزة المحلي (اختياري)
git branch -d feature/your-feature-name

# احذف فرع الميزة من GitHub (بعد الدمج)
git push origin --delete feature/your-feature-name
```

---

## 🔄 سيناريو عمل كامل

### **مثال: إضافة ميزة Multi-Tenancy**

```bash
# 1. التأكد من أنك في dev وحديث
git checkout dev
git pull origin dev

# 2. إنشاء فرع جديد
git checkout -b feature/multi-tenancy-complete

# 3. العمل على الميزة
# - تعديل الملفات
# - إضافة كود جديد

# 4. حفظ التغييرات
git add .
git commit -m "feat(multi-tenancy): add SetTenant middleware

- Create SetTenant middleware for organization scoping
- Add organization relationships to models
- Update routes to use tenant middleware"

# 5. رفع إلى GitHub
git push origin feature/multi-tenancy-complete

# 6. إنشاء Pull Request على GitHub
# (من واجهة GitHub)

# 7. بعد الموافقة والدمج
git checkout dev
git pull origin dev
git branch -d feature/multi-tenancy-complete
```

---

## 📋 قواعد العمل

### **1. Commit Messages**
- ✅ استخدم رسائل واضحة ووصفية
- ✅ اتبع صيغة: `type(scope): subject`
- ✅ اكتب body مفصل إذا لزم الأمر
- ❌ لا تستخدم رسائل عامة مثل "update" أو "fix"

### **2. Branch Names**
- ✅ استخدم: `feature/feature-name`
- ✅ استخدم أسماء وصفية: `feature/multi-tenancy`
- ❌ لا تستخدم: `feature/123` أو `feature/new`

### **3. Pull Requests**
- ✅ افتح PR من `feature/*` إلى `dev`
- ✅ اكتب وصف واضح للميزة
- ✅ اذكر التغييرات المهمة
- ✅ أضف screenshots إذا لزم الأمر

### **4. Code Review**
- ✅ انتظر الموافقة قبل الدمج
- ✅ استجب للتعليقات
- ✅ أصلح أي مشاكل قبل الدمج

---

## 🚨 حالات طوارئ

### **إذا أردت إلغاء تغييرات محلية:**

```bash
# إلغاء جميع التغييرات غير المحفوظة
git checkout .

# إلغاء تغييرات ملف محدد
git checkout -- path/to/file.php
```

### **إذا أردت تغيير آخر commit:**

```bash
# تعديل آخر commit
git commit --amend -m "رسالة جديدة"

# احذر: لا تعدل commit بعد push إذا كان هناك من يعمل عليه!
```

### **إذا أردت دمج dev في فرعك:**

```bash
# في فرع الميزة
git checkout feature/your-feature-name
git merge dev

# أو
git rebase dev
```

---

## 📚 موارد إضافية

- [Git Flow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [GitHub Pull Requests](https://docs.github.com/en/pull-requests)

---

## ✅ Checklist قبل فتح PR

- [ ] الكود يعمل بشكل صحيح
- [ ] لا توجد أخطاء في الاختبارات
- [ ] رسائل Commit واضحة ومنظمة
- [ ] التغييرات موثقة
- [ ] لا توجد ملفات غير ضرورية (مثل `.env`)
- [ ] PR Description مكتمل
- [ ] تم تحديث Documentation إذا لزم الأمر

---

**تم إعداد هذا الدليل للمشروع**  
**GitHub Repository**: `https://github.com/MustafaKhalil10/saas-app.git`

