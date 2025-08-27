<!-- <div class="p-3">
    <div class="text-sm text-gray-500 mb-2">{{ $widget->title }}</div>
    <div id="map-{{ $widget->id }}" style="height: 320px;"></div>
</div>
<script>
(()=> {
    const map = L.map('map-{{ $widget->id }}').setView([20,0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution:'© OpenStreetMap' }).addTo(map);

    // Orders data from backend
    const rows = @json($rows);
    const dataMap = {};
    rows.forEach(p => {
        dataMap[p.country] = parseFloat(p.val) || 0;  // force numeric
    });

    // Color scale
    function getColor(val) {
        return val > 500 ? '#084594' :
               val > 200 ? '#2171b5' :
               val > 100 ? '#4292c6' :
               val > 50  ? '#6baed6' :
               val > 10  ? '#9ecae1' :
               val > 0   ? '#c6dbef' :
                           '#f0f0f0'; // no orders
    }

    fetch("https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json")
        .then(r => r.json())
        .then(geoData => {
            L.geoJson(geoData, {
                style: feature => {
                    const iso = feature.properties.iso_a2?.toUpperCase();
                    const val = dataMap[iso] || 0;
                    return {
                        fillColor: getColor(val),
                        weight: 1,
                        opacity: 1,
                        color: '#ffffff',
                        dashArray: '3',
                        fillOpacity: 0.8
                    };
                },
                onEachFeature: (feature, layer) => {
                    const iso = feature.properties.iso_a2?.toUpperCase();
                    const val = dataMap[iso] || 0;
                    layer.bindPopup(`<b>${feature.properties.name}</b><br/>Orders: ${val}`);
                }
            }).addTo(map);
        });
})();
</script> -->
