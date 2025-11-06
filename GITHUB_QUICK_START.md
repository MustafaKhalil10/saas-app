# 🚀 دليل GitHub للمبتدئين - Quick Start

## 📋 ما هو GitHub؟

GitHub هو موقع لتخزين وإدارة الكود البرمجي. يمكنك:
- رفع مشروعك
- مشاركته مع الآخرين
- تتبع التغييرات
- العمل مع الفريق

---

## ✅ خطوات أولية (مرة واحدة فقط)

### 1. تأكد من أنك سجلت على GitHub
- اذهب إلى: https://github.com
- سجل حساب جديد (إذا لم يكن لديك)

### 2. تأكد من أن Git مثبت على جهازك

افتح PowerShell واكتب:
```bash
git --version
```

إذا ظهرت رسالة خطأ، قم بتثبيت Git من: https://git-scm.com/downloads

### 3. إعداد Git (مرة واحدة فقط)

```bash
git config --global user.name "MustafaKhalil10"
git config --global user.email "your-email@example.com"
```

---

## 🔄 خطوات رفع المشروع إلى GitHub

### 1. افتح PowerShell في مجلد المشروع

```bash
cd M:\Laravel\test-app
```

### 2. تحقق من الحالة الحالية

```bash
git status
```

### 3. أضف الملفات للرفع

```bash
git add .
```

### 4. احفظ التغييرات (Commit)

```bash
git commit -m "chore: cleanup project files before interview"
```

### 5. ارفع إلى GitHub

```bash
# إذا كان المستودع موجوداً على GitHub
git push origin dev

# إذا لم يكن موجوداً، أنشئه أولاً على GitHub ثم:
git remote add origin https://github.com/MustafaKhalil10/saas-app.git
git push -u origin dev
```

---

## 📝 أوامر Git الأساسية

### عرض الحالة
```bash
git status
```

### إضافة ملفات
```bash
git add .                    # كل الملفات
git add README.md            # ملف محدد
```

### حفظ التغييرات
```bash
git commit -m "رسالة وصفية"
```

### رفع إلى GitHub
```bash
git push origin dev          # فرع dev
git push origin main         # فرع main
```

### تحديث من GitHub
```bash
git pull origin dev
```

---

## 🎯 ما يجب رفعه قبل المقابلة

### ✅ يجب رفع:
- `README.md`
- `TECHNICAL_DECISIONS.md`
- `QUICK_SETUP.md`
- `GIT_WORKFLOW.md`
- كل ملفات الكود (app/, config/, database/, etc.)
- ملفات التوثيق في `documentation/`

### ❌ لا ترفع:
- `.env` (يحتوي على API keys)
- `node_modules/` (يتم تثبيتها تلقائياً)
- `vendor/` (يتم تثبيتها تلقائياً)
- `storage/logs/*` (ملفات سجلات)

---

## 🔍 التحقق من الرفع

1. اذهب إلى: https://github.com/MustafaKhalil10/saas-app
2. تأكد من أن الملفات موجودة
3. تأكد من أن `README.md` يظهر بشكل صحيح
4. تأكد من أن `TECHNICAL_DECISIONS.md` موجود

---

## 🚨 حل المشاكل الشائعة

### المشكلة: "fatal: not a git repository"
**الحل**: يجب أن تكون في مجلد المشروع
```bash
cd M:\Laravel\test-app
```

### المشكلة: "Permission denied"
**الحل**: تأكد من تسجيل الدخول إلى GitHub
- استخدم GitHub Desktop (أسهل)
- أو استخدم Personal Access Token

### المشكلة: "remote origin already exists"
**الحل**: تحقق من الرابط الحالي
```bash
git remote -v
```

---

## 💡 نصيحة

إذا واجهت مشاكل مع Git، استخدم **GitHub Desktop**:
1. حمّل من: https://desktop.github.com
2. سجل دخول
3. افتح المشروع
4. اضغط "Push" للرفع

---

**جاهز الآن! 🚀**

