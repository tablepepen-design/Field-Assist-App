const DOM = {
    // Layout Toggling
    executiveView: document.getElementById('executive-view'),
    agentView: document.getElementById('agent-view'),
    switchViewBtns: document.querySelectorAll('.btn-switch-view'),
    
    // Executive Metrics
    proxyFeedBody: document.getElementById('proxy-feed-body'),
    
    // Charts
    trendChart: document.getElementById('trendChart'),
};

let currentView = 'executive'; 
let trendChartInstance = null;
let analyticsInterval = null;

// Mock Agent/Proxy Data for detailed commercial look
const MOCK_PROXIES = [
    { agent: 'Rajesh Kumar', loc: 'Downtown Jaipur', type: 'Soil Testing', status: 'In Transit', ping: '2m ago' },
    { agent: 'Anita Sharma', loc: 'Mandawa Farm', type: 'Certification', status: 'On Site', ping: 'Just now' },
    { agent: 'Vikram Singh', loc: 'Sikar Hub', type: 'Logistics', status: 'Loading', ping: '15m ago' },
    { agent: 'Suresh Raina', loc: 'Kota Storage', type: 'Farm Audit', status: 'Completed', ping: '1h ago' },
    { agent: 'Meena Devi', loc: 'Udaipur Sector 5', type: 'Training', status: 'On Site', ping: '5m ago' }
];

function init() {
    setupEventListeners();
    updateView();
}

function setupEventListeners() {
    DOM.switchViewBtns.forEach(btn => {
        btn.addEventListener('click', toggleView);
    });
}

function toggleView() {
    currentView = currentView === 'executive' ? 'agent' : 'executive';
    updateView();
}

function updateView() {
    if (currentView === 'executive') {
        DOM.executiveView.classList.remove('hidden');
        DOM.agentView.classList.add('hidden');
        initExecutiveAnalytics();
        renderProxyFeed();
    } else {
        DOM.executiveView.classList.add('hidden');
        DOM.agentView.classList.remove('hidden');
        if (analyticsInterval) clearInterval(analyticsInterval);
    }
}

/** ----------------------------------------------------
 * EXECUTIVE ANALYTICS: PETPOOJA STYLE
 * ---------------------------------------------------*/
function initExecutiveAnalytics() {
    fetchAnalyticsData();
    if (!analyticsInterval) {
        analyticsInterval = setInterval(fetchAnalyticsData, 30000); 
    }
}

async function fetchAnalyticsData() {
    try {
        const res = await fetch('api/analytics.php');
        const data = await res.json();
        renderTrendChart(data.trend);
    } catch(e) { console.error("Analytics fetch failed"); }
}

function renderProxyFeed() {
    if (!DOM.proxyFeedBody) return;
    let html = '';
    MOCK_PROXIES.forEach(p => {
        const statusClass = p.status === 'On Site' ? 'text-success' : (p.status === 'In Transit' ? 'text-info' : '');
        html += `
            <tr>
                <td style="font-weight: 600;">${p.agent}</td>
                <td>${p.loc}</td>
                <td><span class="badge-type">${p.type}</span></td>
                <td><span class="${statusClass}">${p.status}</span></td>
                <td class="text-muted" style="font-size: 0.8rem;">${p.ping}</td>
            </tr>
        `;
    });
    DOM.proxyFeedBody.innerHTML = html;
}

function renderTrendChart(trendData) {
    const ctx = DOM.trendChart;
    if(!ctx) return;
    
    const labels = trendData.map(d => {
        let date = new Date(d.date);
        return date.toLocaleDateString('en-US', {day: 'numeric', month: 'short'});
    });
    
    // Scale existing data for visual density
    const salesData = trendData.map(d => d.count * 12);
    const orderData = trendData.map(d => d.count * 8);
    const reviewData = trendData.map(d => d.count * 6);
    
    if (trendChartInstance) {
        trendChartInstance.data.labels = labels;
        trendChartInstance.data.datasets[0].data = salesData;
        trendChartInstance.data.datasets[1].data = orderData;
        trendChartInstance.data.datasets[2].data = reviewData;
        trendChartInstance.update();
        return;
    }
    
    // Petpooja Multi-Overlay Style
    trendChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sale (Revenue)',
                    data: salesData,
                    backgroundColor: '#22C55E',
                    borderRadius: 4,
                    barThickness: 10,
                    order: 3
                },
                {
                    label: 'Orders',
                    type: 'line',
                    data: orderData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 3,
                    order: 1
                },
                {
                    label: 'Review (Feedback)',
                    type: 'line',
                    data: reviewData,
                    borderColor: '#F59E0B',
                    borderDash: [5, 5],
                    borderWidth: 1.5,
                    tension: 0.4,
                    pointRadius: 0,
                    order: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, family: "'Inter', sans-serif" }
                    }
                },
                tooltip: { backgroundColor: '#1F2937', padding: 12 }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: '#F3F4F6' },
                    ticks: { font: { size: 11 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
}

// Global scope for mobile card clicks if needed
window.toggleView = toggleView;

init();
