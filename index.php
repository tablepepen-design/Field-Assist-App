<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Field Assist Pro v4</title>
    <!-- Fonts: Inter for that premium commercial look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Main Style -->
    <link rel="stylesheet" href="assets/css/style.css?v=5.0">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div id="app" class="app-layout">
        
        <!-- Sidebar Navigation (Modern Gradient) -->
        <aside id="desktop-sidebar" class="sidebar">
            <div class="sidebar-top">
                 <div class="brand">
                    <img src="https://morarkaorganic.com/img/logo.png" alt="Morarka" style="height: 32px;">
                 </div>
            </div>
            <nav class="nav-links">
                <a href="#" class="active"><i class="ph ph-squares-four"></i> <span>Dashboard</span></a>
                <a href="#"><i class="ph ph-storefront"></i> <span>All Stores</span></a>
                <a href="#"><i class="ph ph-users-three"></i> <span>Field Force</span></a>
                <a href="#"><i class="ph ph-chart-bar"></i> <span>Analytics</span></a>
                <a href="#"><i class="ph ph-receipt"></i> <span>Billing</span></a>
                <a href="#"><i class="ph ph-gear"></i> <span>Settings</span></a>
            </nav>
            <div class="sidebar-footer">
                <button class="btn-switch-view" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); width: 100%; border-radius: 12px; color: white; padding: 12px; cursor: pointer;">
                    <i class="ph ph-device-mobile"></i> Mobile View
                </button>
            </div>
        </aside>

        <main class="content-area">
            <!-- Top Header (Clean Integrated) -->
            <header class="top-header">
                <div class="left-actions">
                    <i class="ph ph-list menu-toggle"></i>
                    <div class="store-selector">
                        Dashboard
                    </div>
                </div>
                <div class="center-actions desktop-only">
                    <div class="header-link"><i class="ph ph-plus"></i> Add Unit</div>
                    <div class="header-link"><i class="ph ph-cooking-pot"></i> Inventory</div>
                    <div class="header-link"><i class="ph ph-users"></i> Management</div>
                </div>
                <div class="right-actions">
                    <button id="btn-sync-now" class="btn-sync">
                        <i class="ph ph-arrows-counter-clockwise"></i> Sync Now
                    </button>
                    <div class="notification-hub">
                        <i class="ph ph-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="user-profile">
                        <div class="profile-avatar"><i class="ph ph-user"></i></div>
                    </div>
                </div>
            </header>

            <div class="scroll-content">
                <!-- ============================================== -->
                <!-- EXECUTIVE DASHBOARD (MODERN STYLE)              -->
                <!-- ============================================== -->
                <section id="executive-view" class="view-section">
                    
                    <!-- KPI Metrics Grid -->
                    <div class="kpi-grid">
                        <div class="kpi-item">
                            <div class="kpi-icon blue">
                                <i class="ph ph-shopping-cart"></i>
                            </div>
                            <div class="kpi-info">
                                <h2 id="metric-orders">0</h2>
                                <p>Total Orders</p>
                            </div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-icon green">
                                <i class="ph ph-currency-inr"></i>
                            </div>
                            <div class="kpi-info">
                                <h2 id="metric-revenue">0</h2>
                                <p>Revenue</p>
                            </div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-icon orange">
                                <i class="ph ph-package"></i>
                            </div>
                            <div class="kpi-info">
                                <h2 id="metric-units">0</h2>
                                <p>Total Units</p>
                            </div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-icon purple">
                                <i class="ph ph-user-check"></i>
                            </div>
                            <div class="kpi-info">
                                <h2 id="metric-visits">0</h2>
                                <p>Field Visits</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Grid -->
                    <div class="dashboard-main-grid">
                        <!-- Revenue Trend Chart -->
                        <div class="analytics-card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3>Sales Revenue Trend</h3>
                                    <p>Daily performance over last 7 days</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="trendChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Person-wise Performance (New) -->
                        <div class="side-panel">
                            <div class="person-card">
                                <div class="card-header">
                                     <div class="card-title">
                                        <h3>Salesman Performance</h3>
                                        <p>Person-wise revenue breakdown</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="height: 350px;">
                                        <canvas id="personChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modern Sales Feed Table -->
                     <div class="data-table-section">
                        <div class="data-table-panel">
                            <div class="table-header">
                                <h3>Detailed Sales Feed</h3>
                                <button class="btn-sync" style="padding: 5px 15px; font-size: 0.8rem;">View All</button>
                            </div>
                            <div class="table-overflow">
                                <table class="proxy-table">
                                    <thead>
                                        <tr>
                                            <th>Salesman</th>
                                            <th>Shop Name</th>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="proxy-feed-body">
                                        <!-- Dynamic Data -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
                </section>

                <!-- ============================================== -->
                <!-- AGENT / CONSUMER APP (LICIOUS STYLE)            -->
                <!-- ============================================== -->
                <section id="agent-view" class="view-section hidden mobile-app-frame">
                    <div class="mobile-container">
                        <!-- Mobile Top Header -->
                        <header class="mobile-header">
                            <div class="location-picker">
                                <h3>Home <i class="ph ph-caret-down"></i></h3>
                                <p>Morarka Tower, Industrial Area, JP</p>
                            </div>
                            <div class="mobile-notif">
                                <i class="ph ph-bell"></i>
                            </div>
                        </header>

                        <!-- Search Bar (Licious Style) -->
                        <div class="search-box">
                            <i class="ph ph-magnifying-glass"></i>
                            <input type="text" placeholder="Search Organic Products/Services...">
                        </div>

                        <!-- Hero Banner (Gradient + Image) -->
                        <div class="hero-banner">
                            <div class="banner-content">
                                <h2>Healthy Lifestyle<br><span>BINGE!</span></h2>
                                <p>Get 20% off on all Organic Spices</p>
                                <button class="shop-now-btn">Book Service</button>
                            </div>
                            <div class="banner-img">
                                <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Organic">
                            </div>
                        </div>

                        <!-- Shop by Categories (Proxy Services) -->
                        <div class="categories-section">
                            <div class="section-header">
                                <h3>Shop by Categories</h3>
                                <p>High Quality Organic Proxy Services</p>
                            </div>
                            <div class="category-grid">
                                <div class="cat-card style-rice">
                                    <h4>Organic Rice</h4>
                                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e8ac?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Rice">
                                </div>
                                <div class="cat-card style-spices">
                                    <h4>Organic Spices</h4>
                                    <img src="https://images.unsplash.com/photo-1506368249639-73a05d6f6488?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Spices">
                                </div>
                                <div class="cat-card style-oil">
                                    <h4>Premium Oils</h4>
                                    <img src="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Oils">
                                </div>
                                <div class="cat-card style-pulses">
                                    <h4>Organic Pulses</h4>
                                    <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc206e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Pulses">
                                </div>
                                <div class="cat-card style-audit">
                                    <h4>Farm Audit</h4>
                                    <img src="https://images.unsplash.com/photo-1471193945509-9ad0617afabf?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Audit">
                                </div>
                                <div class="cat-card style-logistics">
                                    <h4>Proxy Logistics</h4>
                                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" alt="Logistics">
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Nav (Fixed Blurred) -->
                        <nav class="mobile-bottom-nav">
                            <a href="#" class="nav-item active">
                                <i class="ph ph-house"></i>
                                <span>Home</span>
                            </a>
                            <a href="#" class="nav-item">
                                <i class="ph ph-heart"></i>
                                <span>Wishlist</span>
                            </a>
                            <a href="#" class="nav-item">
                                <i class="ph ph-squares-four"></i>
                                <span>Categories</span>
                            </a>
                            <a href="#" class="nav-item">
                                <i class="ph ph-user"></i>
                                <span>Account</span>
                            </a>
                        </nav>
                        
                        <!-- View Switcher (Mini FAB for Mobile mode) -->
                        <div class="view-toggle-mini btn-switch-view">
                            <i class="ph ph-desktop"></i>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="assets/js/app.js?v=5.0"></script>
</body>
</html>
