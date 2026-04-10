const DOM = {
    // Layout Toggling
    executiveView: document.getElementById('executive-view'),
    agentView: document.getElementById('agent-view'),
    switchViewBtns: document.querySelectorAll('.btn-switch-view'),
    
    // Executive Metrics
    proxyFeedBody: document.getElementById('proxy-feed-body'),
    metricOrders: document.getElementById('metric-orders'),
    metricRevenue: document.getElementById('metric-revenue'),
    metricUnits: document.getElementById('metric-units'),
    metricVisits: document.getElementById('metric-visits'),
    
    // Sync Button
    btnSyncNow: document.getElementById('btn-sync-now'),
    
    // Charts
    trendChart: document.getElementById('trendChart'),
    personChart: document.getElementById('personChart'),
};

let currentView = 'executive'; 
let trendChartInstance = null;
let personChartInstance = null;
let analyticsInterval = null;

const COLORS = ['#6366F1', '#8B5CF6', '#F43F5E', '#10B981', '#F59E0B', '#3B82F6', '#EC4899', '#8B5CF6'];

function init() {
    setupEventListeners();
    updateView();
}

function setupEventListeners() {
    DOM.switchViewBtns.forEach(btn => {
        btn.addEventListener('click', toggleView);
    });

    if (DOM.btnSyncNow) {
        DOM.btnSyncNow.addEventListener('click', runManualSync);
    }
}

async function runManualSync() {
    const btn = DOM.btnSyncNow;
    const originalHtml = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="ph ph-circle-notch ph-spin"></i> Syncing...';
    
    try {
        const res = await fetch('api/pull_sync.php');
        const data = await res.json();
        
        if (data.status === 'success') {
            alert(data.message);
            fetchAnalyticsData(); // Refresh UI
        } else {
            alert('Sync Failed: ' + (data.error || 'Unknown error'));
        }
    } catch (e) {
        alert('Sync Request Failed');
        console.error(e);
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    }
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
    } else {
        DOM.executiveView.classList.add('hidden');
        DOM.agentView.classList.remove('hidden');
        if (analyticsInterval) clearInterval(analyticsInterval);
    }
}

function initExecutiveAnalytics() {
    fetchAnalyticsData();
    if (!analyticsInterval) {
        analyticsInterval = setInterval(fetchAnalyticsData, 60000); 
    }
}

async function fetchAnalyticsData() {
    try {
        const res = await fetch('api/analytics.php');
        const data = await res.json();
        
        updateKPIMetrics(data);
        renderSalesFeed(data.salesFeed);
        renderTrendChart(data.salesTrend);
        renderPersonChart(data.salesmanPerformance);
        
    } catch(e) { 
        console.error("Analytics fetch failed", e); 
    }
}

function updateKPIMetrics(data) {
    if (DOM.metricOrders) DOM.metricOrders.textContent = data.salesStats.orders.toLocaleString();
    if (DOM.metricRevenue) DOM.metricRevenue.textContent = "₹" + Math.round(data.salesStats.revenue).toLocaleString();
    if (DOM.metricUnits) DOM.metricUnits.textContent = data.salesStats.units.toLocaleString();
    if (DOM.metricVisits) DOM.metricVisits.textContent = data.liveOutput.toLocaleString();
}

function renderSalesFeed(feed) {
    if (!DOM.proxyFeedBody || !feed) return;
    let html = '';
    feed.forEach(s => {
        html += `
            <tr>
                <td style="font-weight: 700; color: var(--primary-dark);">${s.salesman}</td>
                <td>${s.shop_name}</td>
                <td><span class="badge-type">${s.product}</span></td>
                <td style="font-weight: 700; color: var(--success);">₹${parseFloat(s.amount).toLocaleString()}</td>
                <td class="text-secondary" style="font-size: 0.8rem;">${s.date}</td>
            </tr>
        `;
    });
    DOM.proxyFeedBody.innerHTML = html;
}

function renderTrendChart(salesTrend) {
    const ctx = DOM.trendChart;
    if(!ctx || !salesTrend) return;
    
    const labels = salesTrend.map(d => {
        let date = new Date(d.date);
        return date.toLocaleDateString('en-US', {day: 'numeric', month: 'short'});
    });
    
    const revenueData = salesTrend.map(d => d.revenue);
    
    if (trendChartInstance) {
        trendChartInstance.data.labels = labels;
        trendChartInstance.data.datasets[0].data = revenueData;
        trendChartInstance.update();
        return;
    }
    
    trendChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Daily Revenue',
                data: revenueData,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: { 
                    backgroundColor: '#1E293B', 
                    padding: 12,
                    callbacks: {
                        label: (c) => '₹' + c.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                y: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
}

function renderPersonChart(personData) {
    const ctx = DOM.personChart;
    if (!ctx || !personData) return;

    const labels = personData.map(d => d.salesman);
    const revData = personData.map(d => d.revenue);

    if (personChartInstance) {
        personChartInstance.data.labels = labels;
        personChartInstance.data.datasets[0].data = revData;
        personChartInstance.update();
        return;
    }

    personChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: revData,
                backgroundColor: COLORS,
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 11, family: "'Inter', sans-serif", weight: '600' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (c) => ` ${c.label}: ₹${c.parsed.toLocaleString()}`
                    }
                }
            }
        }
    });
}

init();
