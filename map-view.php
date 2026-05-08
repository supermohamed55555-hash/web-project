<?php include 'includes/header.php'; ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .map-wrapper {
        padding: 2rem 0;
    }
    #mainMap {
        height: 600px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 2px solid var(--white);
        z-index: 1;
    }
    /* Pulse Marker Style */
    .blood-marker {
        width: 30px;
        height: 30px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        box-shadow: 0 0 15px rgba(229, 57, 53, 0.5);
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(229, 57, 53, 0); }
        100% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0); }
    }
</style>

<div class="container map-wrapper">
    <div class="map-card reveal">
        <h2 style="color: var(--primary); margin-bottom: 0.5rem;">خريطة استغاثات الدم</h2>
        <p style="color: var(--text-muted);">هذه الخريطة تعرض أماكن المستشفيات التي تحتاج لتبرع عاجل حالياً.</p>
    </div>

    <!-- Map Container -->
    <div id="mainMap" class="reveal"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Initialize the map centered on Egypt
    const map = L.map('mainMap').setView([26.8206, 30.8025], 6);

    // Add OpenStreetMap Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Fetch and Display Requests
    fetch('includes/get-map-data.php')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                res.data.forEach(req => {
                    const icon = L.divIcon({
                        className: 'custom-icon',
                        html: `<div class="blood-marker">${req.blood_type}</div>`,
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });

                    const popup = `
                        <div style="text-align: right; font-family: 'Inter', sans-serif;">
                            <h4 style="color: var(--primary); margin: 0;">طلب فصيلة ${req.blood_type}</h4>
                            <p style="margin: 5px 0;"><b>المستشفى:</b> ${req.hospital_name}</p>
                            <p style="margin: 5px 0;"><b>باسم:</b> ${req.full_name}</p>
                            <p style="font-size: 0.9rem; color: #666;">${req.message || ''}</p>
                            <a href="login.php" style="display: block; background: var(--primary); color: white; text-align: center; padding: 5px; border-radius: 5px; text-decoration: none; margin-top: 10px;">تبرع الآن</a>
                        </div>
                    `;

                    L.marker([req.latitude, req.longitude], { icon: icon })
                        .addTo(map)
                        .bindPopup(popup);
                });
            }
        });
</script>

<?php include 'includes/footer.php'; ?>
