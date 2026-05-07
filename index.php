<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content reveal">
            <h1>Save a Life, <span>Donate Blood</span> Today.</h1>
            <p>Every drop counts. Join our network of thousands of donors and help provide critical support to patients in need within your city.</p>
            <div class="hero-btns">
                <a href="register.php" class="btn btn-primary">Start Donating</a>
                <a href="search.php" class="btn btn-outline" style="margin-left: 1rem;">Find Donors</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container">
    <div class="stats-grid reveal">
        <div class="stat-card">
            <i class="fas fa-users fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>2,500+</h3>
            <p>Registered Donors</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-tint fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>1,200+</h3>
            <p>Successful Matches</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-hospital fa-2x" style="color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>50+</h3>
            <p>Connected Cities</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section-padding">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Why Choose LifeStream?</h2>
            <p class="section-subtitle">We make blood donation simple, fast, and secure for everyone.</p>
        </div>
        
        <div class="footer-grid">
            <div class="reveal">
                <i class="fas fa-shield-alt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>Secure Data</h3>
                <p>Your privacy is our priority. We ensure your personal information is protected with industry-standard encryption.</p>
            </div>
            <div class="reveal">
                <i class="fas fa-bolt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>Real-time Alerts</h3>
                <p>Receive instant notifications when someone with your blood type needs urgent help in your area.</p>
            </div>
            <div class="reveal">
                <i class="fas fa-map-marker-alt fa-3x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                <h3>Location Based</h3>
                <p>Find donors and patients within your specific city to minimize travel time during emergencies.</p>
            </div>
        </div>
    </div>
</section>

<!-- Blood Compatibility Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Blood Compatibility</h2>
            <p class="section-subtitle">Understand who can give and receive from whom.</p>
        </div>
        
        <div class="reveal">
            <table class="comp-table">
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Can Donate To</th>
                        <th>Can Receive From</th>
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
                        <td class="can-donate">AB+ Only</td>
                        <td class="can-receive">Universal Recipient</td>
                    </tr>
                    <tr>
                        <td><strong>O-</strong></td>
                        <td class="can-donate">Universal Donor</td>
                        <td class="can-receive">O- Only</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
