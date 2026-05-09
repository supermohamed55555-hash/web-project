<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content reveal">
            <h1>أنقذ حياة، <span>تبرع بالدم</span> اليوم.</h1>
            <p>كل قطرة تفرق. انضم إلى شبكتنا التي تضم آلاف المتبرعين وساعد في تقديم الدعم الحيوي للمرضى المحتاجين داخل مدينتك.</p>
            <div class="hero-btns">
                <a href="register.php" class="btn btn-primary">ابدأ التبرع الآن</a>
                <a href="search.php" class="btn btn-outline" style="margin-right: 1rem;">ابحث عن متبرعين</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container">
    <div class="stats-grid reveal">
        <div class="stat-card">
            <i class="fas fa-users fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>+2,500</h3>
            <p>متبرع مسجل</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-tint fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>+1,200</h3>
            <p>عملية مطابقة ناجحة</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-hospital fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>+50</h3>
            <p>مدينة مغطاة</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section-padding">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">لماذا تختار لايف ستريم؟</h2>
            <p class="section-subtitle">نجعل عملية التبرع بالدم بسيطة، سريعة، وآمنة للجميع.</p>
        </div>
        
        <div class="footer-grid">
            <div class="reveal">
                <i class="fas fa-shield-alt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>بيانات آمنة</h3>
                <p>خصوصيتك هي أولويتنا. نحن نضمن حماية معلوماتك الشخصية بأحدث تقنيات التشفير.</p>
            </div>
            <div class="reveal">
                <i class="fas fa-bolt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>تنبيهات فورية</h3>
                <p>احصل على إشعارات فورية عندما يحتاج شخص من نفس فصيلة دمك إلى مساعدة عاجلة في منطقتك.</p>
            </div>
            <div class="reveal">
                <i class="fas fa-map-marker-alt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>مبني على الموقع</h3>
                <p>ابحث عن المتبرعين والمرضى داخل مدينتك لتقليل وقت السفر أثناء حالات الطوارئ.</p>
            </div>
        </div>
    </div>
</section>

<!-- Blood Compatibility Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">توافق فصائل الدم</h2>
            <p class="section-subtitle">افهم من يمكنه التبرع لمن ومن يمكنه الاستقبال.</p>
        </div>
        
        <div class="reveal">
            <table class="comp-table">
                <thead>
                    <tr>
                        <th>فصيلة الدم</th>
                        <th>يمكنه التبرع لـ</th>
                        <th>يمكنه الاستقبال من</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>A+</strong></td>
                        <td class="can-donate">A+, AB+</td>
                        <td class="can-receive">A+, A-, O+, O-</td>
                    </tr>
                    <tr>
                        <td><strong>O+</strong></td>
                        <td class="can-donate">O+, A+, B+, AB+</td>
                        <td class="can-receive">O+, O-</td>
                    </tr>
                    <tr>
                        <td><strong>B+</strong></td>
                        <td class="can-donate">B+, AB+</td>
                        <td class="can-receive">B+, B-, O+, O-</td>
                    </tr>
                    <tr>
                        <td><strong>AB+</strong></td>
                        <td class="can-donate">AB+ فقط</td>
                        <td class="can-receive">مستقبل عام (الجميع)</td>
                    </tr>
                    <tr>
                        <td><strong>O-</strong></td>
                        <td class="can-donate">متبرع عام (الجميع)</td>
                        <td class="can-receive">O- فقط</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
