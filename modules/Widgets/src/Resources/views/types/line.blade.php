<div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-primary-100">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ $widget->title }}</h3>
        </div>
        <div class="bg-indigo-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
        </div>
    </div>
    
    <div class="h-64">
        <canvas id="chart-{{ $widget->id }}"></canvas>
    </div>
    
    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
        <div class="text-sm text-gray-500">Updated: {{ now()->format('M j, Y') }}</div>
    
    </div>
</div>

<script>
(() => {
    const ctx = document.getElementById('chart-{{ $widget->id }}').getContext('2d');
    
    // Generate gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($rows->pluck('grp')),
            datasets: [{
                label: '{{ $widget->title }}',
                data: @json($rows->pluck('val')),
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: gradient,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: 'rgb(79, 70, 229)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1F2937',
                    bodyColor: '#4B5563',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 11
                        },
                        padding: 10
                    }
                }
            }
        }
    });
})();
</script>