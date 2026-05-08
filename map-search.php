<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 15px;
        box-shadow: var(--shadow);
        z-index: 1;
    }
    .map-container {
        padding: 2rem 0;
    }
    .map-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    .blood-marker {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
        border: 2px solid #ccc;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .blood-marker.request {
        border-color: var(--primary);
        color: var(--primary);
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(229, 57, 53, 0); }
        100% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0); }
    }
    .legend {
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: var(--shadow);
        font-size: 0.9rem;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .legend-color {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-right: 8px;
    }
</style>

<div class="container map-container">
    <div class="map-header reveal">
        <h2 class="section-title">Blood Request Map</h2>
        <p class="section-subtitle">Visualizing urgent hospital needs. Donor locations are kept private.</p>
    </div>

    <div id="map" class="reveal"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // ... (cityCoords remains the same)
    const cityCoords = {
        'Cairo': [30.0444, 31.2357],
        'Alexandria': [31.2001, 29.9187],
        'Giza': [30.0131, 31.2089],
        'Mansoura': [31.0409, 31.3785],
        'Tanta': [30.7865, 31.0004],
        'Asyut': [27.1783, 31.1859],
        'Suez': [29.9668, 32.5498],
        'Port Said': [31.2653, 32.3019],
        'Luxor': [25.6872, 32.6396],
        'Aswan': [24.0889, 32.8998],
        'Zagazig': [30.5877, 31.5020],
        'Fayoum': [29.3094, 30.8418],
        'Ismailia': [30.5965, 32.2715],
        'Minya': [28.0991, 30.7503],
        'Damietta': [31.4175, 31.8144],
        'Beni Suef': [29.0744, 31.0979],
        'Sohag': [26.5570, 31.6948],
        'Hurghada': [27.2579, 33.8116],
        'Sharm El Sheikh': [27.9158, 34.3299]
    };

    const map = L.map('map').setView([30.0444, 31.2357], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add Legend
    const legend = L.control({position: 'bottomright'});
    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'legend');
        div.innerHTML = `
            <div class="legend-item"><div class="legend-color" style="background: var(--primary)"></div> Urgent Request (Hospital)</div>
            <div class="legend-item"><div class="legend-color" style="background: #2196F3"></div> Your Location</div>
        `;
        return div;
    };
    legend.addTo(map);

    // Geolocation code... (Find user's location)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            map.setView([userLat, userLng], 12);
            const userIcon = L.divIcon({
                className: 'user-location-icon',
                html: `<div style="background: #2196F3; width: 15px; height: 15px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(33, 150, 243, 0.5);"></div>`,
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
            L.marker([userLat, userLng], { icon: userIcon }).addTo(map).bindPopup("<b>You are here</b>");
        });
    }

    // Function to add markers (Requests only)
    function addMarker(item) {
        let lat, lng;

        if (item.latitude && item.longitude && item.latitude != 0) {
            lat = parseFloat(item.latitude);
            lng = parseFloat(item.longitude);
            lat += (Math.random() - 0.5) * 0.001;
            lng += (Math.random() - 0.5) * 0.001;
        } else {
            const coords = cityCoords[item.city];
            if (!coords) return;
            lat = coords[0] + (Math.random() - 0.5) * 0.05;
            lng = coords[1] + (Math.random() - 0.5) * 0.05;
        }

        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="blood-marker request">${item.blood_type}</div>`,
            iconSize: [35, 35],
            iconAnchor: [17, 35]
        });

        const popupContent = `
            <div class="popup-content">
                <h4 style="color: var(--primary)">Urgent Request: ${item.blood_type}</h4>
                <p><strong>Hospital:</strong> ${item.hospital_name}</p>
                <p><strong>City:</strong> ${item.city}</p>
                <p><strong>Status:</strong> ${item.status || 'Pending'}</p>
                <p><strong>Notes:</strong> ${item.message || 'No additional info'}</p>
                <a href="login.php" class="popup-btn">Donate for this case</a>
            </div>
        `;

        L.marker([lat, lng], {icon: customIcon}).addTo(map).bindPopup(popupContent);
    }

    fetch('includes/map-data.php')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                res.requests.forEach(req => addMarker(req));
            }
        });
</script>
</script>

<?php include 'includes/footer.php'; ?>
