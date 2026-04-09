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
        
        <!-- Sidebar Navigation (Petpooja Dark Sidebar) -->
        <aside id="desktop-sidebar" class="sidebar">
            <div class="sidebar-top">
                 <!-- Brand Logo Area -->
                 <div class="brand">
                    <img src="https://morarkaorganic.com/img/logo.png" alt="Morarka" style="height: 40px; filter: brightness(0) invert(1);">
                 </div>
            </div>
            <nav class="nav-links">
                <a href="#" class="active"><i class="ph ph-squares-four"></i> Dashboard</a>
                <a href="#"><i class="ph ph-storefront"></i> All Stores</a>
                <a href="#"><i class="ph ph-users-three"></i> Field Force</a>
                <a href="#"><i class="ph ph-chart-bar"></i> Analytics</a>
                <a href="#"><i class="ph ph-receipt"></i> Billing</a>
                <a href="#"><i class="ph ph-gear"></i> Settings</a>
            </nav>
            <div class="sidebar-footer">
                <button class="btn-switch-view"><i class="ph ph-device-mobile"></i> Mobile View</button>
            </div>
        </aside>

        <main class="content-area">
            <!-- Top Header (Petpooja Red Header) -->
            <header class="top-header">
                <div class="left-actions">
                    <i class="ph ph-list menu-toggle"></i>
                    <div class="store-selector">
                        <span class="selected-store">All Business Units <i class="ph ph-caret-down"></i></span>
                    </div>
                </div>
                <div class="center-actions desktop-only">
                    <div class="header-link"><i class="ph ph-plus"></i> Add Unit</div>
                    <div class="header-link"><i class="ph ph-cooking-pot"></i> Inventory</div>
                    <div class="header-link"><i class="ph ph-users"></i> Management</div>
                </div>
                <div class="right-actions">
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
                <!-- EXECUTIVE DASHBOARD (PETPOOJA STYLE)            -->
                <!-- ============================================== -->
                <section id="executive-view" class="view-section">
                    
                    <!-- KPI Metrics Card (Circular Rings) -->
                    <div class="kpi-grid">
                        <div class="kpi-item">
                            <div class="ring-status green">
                                <i class="ph ph-shopping-cart"></i>
                            </div>
                            <h2 id="metric-orders">125</h2>
                            <p>Orders</p>
                        </div>
                        <div class="kpi-item">
                            <div class="ring-status pink">
                                <i class="ph ph-percent"></i>
                            </div>
                            <h2 id="metric-discount">2050</h2>
                            <p>Discount</p>
                        </div>
                        <div class="kpi-item">
                            <div class="ring-status yellow">
                                <i class="ph ph-receipt"></i>
                            </div>
                            <h2 id="metric-tax">1220</h2>
                            <p>Tax</p>
                        </div>
                        <div class="kpi-item">
                            <div class="ring-status grey">
                                <i class="ph ph-pencil-line"></i>
                            </div>
                            <h2 id="metric-modified">125</h2>
                            <p>Bills modified</p>
                        </div>
                        <div class="kpi-item">
                            <div class="ring-status purple">
                                <i class="ph ph-printer"></i>
                            </div>
                            <h2 id="metric-reprint">100</h2>
                            <p>Bills re-printed</p>
                        </div>
                        <div class="kpi-item">
                            <div class="ring-status teal">
                                <i class="ph ph-currency-inr"></i>
                            </div>
                            <h2 id="metric-expenses">80</h2>
                            <p>Total expenses</p>
                        </div>
                    </div>

                    <!-- Main Chart Area -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <div class="header-title">
                                <span class="header-icon"><i class="ph ph-chart-line-up"></i></span>
                                <h3>Feedback : Satisfaction Score - 4.2</h3>
                            </div>
                            <div class="header-filters">
                                <span>Last 10 days comparison</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Live Feed (Detailed Proxy Services) -->
                     <div class="side-grids mt-4">
                        <div class="data-table-panel">
                            <h3>Live Proxy Operations</h3>
                            <div class="table-overflow">
                                <table class="proxy-table">
                                    <thead>
                                        <tr>
                                            <th>Agent</th>
                                            <th>Location</th>
                                            <th>Service Type</th>
                                            <th>Status</th>
                                            <th>Ping</th>
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
