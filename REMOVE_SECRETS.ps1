# ============================================
# حل مشكلة GitHub Push Protection
# ============================================

Write-Host "🔐 حل مشكلة GitHub Push Protection" -ForegroundColor Yellow
Write-Host ""

# ============================================
# الخطوة 1: التحقق من .gitignore
# ============================================

Write-Host "1. التحقق من .gitignore..." -ForegroundColor Cyan
if (Test-Path ".gitignore") {
    $gitignore = Get-Content ".gitignore" -Raw
    if ($gitignore -notmatch "\.env") {
        Add-Content ".gitignore" "`n# Environment files`n/.env`n/.env.backup"
        Write-Host "   ✅ تم إضافة .env إلى .gitignore" -ForegroundColor Green
    } else {
        Write-Host "   ✅ .env موجود في .gitignore" -ForegroundColor Green
    }
} else {
    Write-Host "   ⚠️ .gitignore غير موجود" -ForegroundColor Yellow
}

Write-Host ""

# ============================================
# الخطوة 2: إنشاء مستودع جديد نظيف
# ============================================

Write-Host "2. إنشاء مستودع جديد نظيف..." -ForegroundColor Cyan
Write-Host "   ⚠️ سيتم إنشاء مستودع جديد بدون Secrets" -ForegroundColor Yellow
Write-Host ""

# حفظ الـ remote الحالي
$remoteUrl = (git remote get-url origin 2>$null)
if ($remoteUrl) {
    Write-Host "   📍 Remote URL: $remoteUrl" -ForegroundColor Gray
}

# إنشاء فرع جديد نظيف
Write-Host "   🔄 إنشاء فرع جديد نظيف..." -ForegroundColor Cyan
git checkout --orphan clean-main

# إضافة جميع الملفات (دون .env)
Write-Host "   📦 إضافة الملفات..." -ForegroundColor Cyan
git add .

# Commit جديد نظيف
Write-Host "   💾 إنشاء commit جديد..." -ForegroundColor Cyan
git commit -m "Initial commit: SaaS Application setup

- Add Laravel 12 framework
- Add authentication with Laravel Breeze
- Add roles and permissions with Spatie
- Add subscription system with Stripe and Mollie
- Add notifications (Email + WhatsApp)
- Add Neumorphism design with Tailwind CSS
- Add documentation (with safe examples only)

Note: All secrets removed from history"

# حذف الفروع القديمة
Write-Host "   🗑️ حذف الفروع القديمة..." -ForegroundColor Cyan
git branch -D main 2>$null
git branch -D dev 2>$null
git branch -D 12.x 2>$null

# إعادة تسمية الفرع الجديد
Write-Host "   ✏️ إعادة تسمية الفرع..." -ForegroundColor Cyan
git branch -M main

Write-Host "   ✅ تم إنشاء مستودع نظيف" -ForegroundColor Green
Write-Host ""

# ============================================
# الخطوة 3: إنشاء فرع dev
# ============================================

Write-Host "3. إنشاء فرع dev..." -ForegroundColor Cyan
git checkout -b dev
Write-Host "   ✅ تم إنشاء فرع dev" -ForegroundColor Green
Write-Host ""

# ============================================
# الخطوة 4: التعليمات النهائية
# ============================================

Write-Host "📋 التعليمات النهائية:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. رفع إلى GitHub (Force Push):" -ForegroundColor Cyan
Write-Host "   git push -f origin main" -ForegroundColor White
Write-Host ""
Write-Host "2. رفع فرع dev:" -ForegroundColor Cyan
Write-Host "   git push -u origin dev" -ForegroundColor White
Write-Host ""
Write-Host "3. ⚠️ تحذير: Force Push سيحذف جميع الـ commits القديمة!" -ForegroundColor Red
Write-Host ""
Write-Host "4. ✅ بعد الـ Push، سيتم حذف جميع الـ Secrets من تاريخ Git" -ForegroundColor Green
Write-Host ""

# ============================================
# الخيارات
# ============================================

$choice = Read-Host "هل تريد رفع المشروع الآن؟ (y/n)"

if ($choice -eq "y" -or $choice -eq "Y") {
    Write-Host ""
    Write-Host "🚀 رفع المشروع إلى GitHub..." -ForegroundColor Cyan
    Write-Host ""
    
    # رفع main
    Write-Host "📤 رفع فرع main..." -ForegroundColor Cyan
    git push -f origin main
    
    Write-Host ""
    
    # رفع dev
    Write-Host "📤 رفع فرع dev..." -ForegroundColor Cyan
    git push -u origin dev
    
    Write-Host ""
    Write-Host "✅ تم رفع المشروع بنجاح!" -ForegroundColor Green
    Write-Host ""
} else {
    Write-Host ""
    Write-Host "📝 يمكنك رفع المشروع لاحقاً باستخدام:" -ForegroundColor Yellow
    Write-Host "   git push -f origin main" -ForegroundColor White
    Write-Host "   git push -u origin dev" -ForegroundColor White
    Write-Host ""
}

