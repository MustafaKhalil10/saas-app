# ⚡ إعداد Git سريع - Quick Git Setup

## ✅ الوضع الحالي

✅ **المشروع موجود على GitHub**: `https://github.com/MustafaKhalil10/saas-app.git`

✅ **الفروع المتوفرة**:
- `main` - النسخة المستقرة
- `dev` - النسخة التطويرية

---

## 🎯 الخطوات المتبقية

### **1. حفظ التغييرات الحالية**

```bash
# حفظ جميع التغييرات
git add -A
git commit -m "chore: cleanup and organize project files

- Remove unnecessary git guide files
- Update documentation files
- Add technical decisions documentation
- Add interview preparation materials"
```

### **2. رفع التغييرات إلى GitHub**

```bash
# رفع فرع dev إلى GitHub
git push origin dev

# إذا كان هناك تغييرات في main أيضاً
git checkout main
git merge dev
git push origin main
```

### **3. إنشاء فرع ميزة جديد (للمستقبل)**

```bash
# الانتقال إلى dev
git checkout dev

# تحديث dev من GitHub
git pull origin dev

# إنشاء فرع ميزة جديد
git checkout -b feature/your-feature-name

# مثال:
git checkout -b feature/multi-tenancy-complete
```

### **4. العمل على الميزة**

```bash
# قم بتعديل الملفات
# ثم حفظ التغييرات
git add .
git commit -m "feat(multi-tenancy): add SetTenant middleware"
```

### **5. رفع فرع الميزة**

```bash
git push origin feature/your-feature-name
```

### **6. فتح Pull Request**

1. اذهب إلى: `https://github.com/MustafaKhalil10/saas-app`
2. اضغط **"Pull requests"** → **"New pull request"**
3. اختر:
   - **Base**: `dev`
   - **Compare**: `feature/your-feature-name`
4. املأ المعلومات واضغط **"Create pull request"**

---

## 📋 رسائل Commit الصحيحة

### ✅ جيدة:
```bash
git commit -m "feat(subscription): add Stripe checkout integration"
git commit -m "fix(webhook): handle duplicate events"
git commit -m "docs(readme): update setup instructions"
git commit -m "refactor(service): extract subscription logic"
```

### ❌ سيئة:
```bash
git commit -m "update"
git commit -m "fix"
git commit -m "changes"
```

---

## 🔗 رابط GitHub للمقابلة

**Repository**: `https://github.com/MustafaKhalil10/saas-app`

**الفروع**:
- `main`: `https://github.com/MustafaKhalil10/saas-app/tree/main`
- `dev`: `https://github.com/MustafaKhalil10/saas-app/tree/dev`

---

## ✅ Checklist قبل المقابلة

- [x] المشروع موجود على GitHub
- [x] الفروع `main` و `dev` موجودة
- [ ] حفظ التغييرات الحالية
- [ ] رفع التغييرات إلى GitHub
- [ ] مراجعة `GIT_WORKFLOW.md` للعمل المستقبلي

