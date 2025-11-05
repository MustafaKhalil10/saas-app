# 🚀 Git Quick Start - دليل سريع

## 📋 الخطوات الأساسية (5 دقائق)

### **1. إعداد Git في المشروع**

```bash
cd M:\Laravel\test-app
git init
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### **2. إنشاء المستودع على GitHub**

1. اذهب إلى [GitHub](https://github.com)
2. اضغط **"New repository"**
3. املأ:
   - **Name**: `saas-app`
   - **Visibility**: Public أو Private
   - ⚠️ **لا تضع علامة على "Initialize this repository"**
4. اضغط **"Create repository"**

### **3. ربط المشروع بـ GitHub**

```bash
# استبدل الرابط برابطك من GitHub
git remote add origin https://github.com/your-username/saas-app.git

# التحقق
git remote -v
```

### **4. إعداد الفروع**

```bash
# إضافة جميع الملفات
git add .

# عمل commit أولي
git commit -m "Initial commit: SaaS Application setup"

# إنشاء فرع main
git branch -M main

# رفع إلى GitHub
git push -u origin main

# إنشاء فرع dev
git checkout -b dev
git push -u origin dev
```

### **5. العمل على ميزة جديدة**

```bash
# الانتقال إلى dev
git checkout dev

# سحب آخر التحديثات
git pull origin dev

# إنشاء فرع ميزة جديد
git checkout -b feature/subscription-system

# ... عملك على الميزة ...

# إضافة التغييرات
git add .

# عمل commit
git commit -m "feat(subscriptions): add Stripe checkout integration"

# رفع إلى GitHub
git push -u origin feature/subscription-system
```

### **6. فتح Pull Request**

1. اذهب إلى GitHub
2. اضغط **"Compare & pull request"**
3. اختر:
   - **Base**: `dev`
   - **Compare**: `feature/subscription-system`
4. املأ Title و Description
5. اضغط **"Create pull request"**

---

## 📝 أمثلة على رسائل Commit

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

## 🌳 هيكل الفروع

```
main (النسخة المستقرة)
  ↑
  └── dev (النسخة التطويرية)
       ↑
       ├── feature/subscription-system
       ├── feature/multi-tenancy
       └── feature/...
```

---

## ✅ Checklist

- [ ] Git مثبت ومهيأ
- [ ] المستودع تم إنشاؤه على GitHub
- [ ] Remote تم إضافته
- [ ] فرع `main` تم إنشاؤه ورفعه
- [ ] فرع `dev` تم إنشاؤه ورفعه
- [ ] فرع ميزة تم إنشاؤه
- [ ] Pull Request تم فتحه

---

**للمزيد من التفاصيل**: راجع `GIT_SETUP_GUIDE.md`

