<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>

    <!-- Google Fonts - Modern Sans Serif -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            /* Modern color palette */
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #c7d2fe;
            --secondary: #10b981;
            --secondary-dark: #059669;
            --secondary-light: #d1fae5;
            --light: #f9fafb;
            --dark: #111827;
            --text-muted: #6b7280;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --success: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Modern Hero Section with Gradient */
        .hero-section {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            padding: 5rem 0;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Grid Pattern Overlay */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3E%3Cpath d='M0 .5H31.5V32'/%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .hero-title {
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-weight: 400;
            opacity: 0.9;
            max-width: 650px;
            margin: 0 auto;
            font-size: 1.125rem;
        }

        .hero-stat {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            display: inline-flex;
            align-items: center;
            margin: 0.5rem;
            font-weight: 500;
        }

        /* Modern Card Styling */
        .section-card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            color: var(--primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Document Item Styling */
        .document-item {
            border-left: 4px solid var(--secondary);
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            transition: all 0.25s ease;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .document-item:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        .file-name {
            font-family: 'SF Mono', 'Cascadia Code', 'Courier New', monospace;
            font-size: 0.875rem;
            color: var(--secondary);
            background-color: var(--secondary-light);
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            display: inline-block;
            font-weight: 500;
        }

        /* Button Styling */
        .btn-download {
            background-color: var(--secondary);
            color: white;
            border-radius: 0.5rem;
            font-weight: 500;
            border: none;
            padding: 0.375rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }

        .btn-download:hover {
            background-color: var(--secondary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-view {
            background-color: var(--primary);
            color: white;
            border-radius: 0.5rem;
            font-weight: 500;
            border: none;
            padding: 0.375rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }

        .btn-view:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        /* Form Controls */
        .form-select,
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 1rem;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 0;
        }

        /* File Container */
        .file-container {
            margin: 1rem 0;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            background-color: var(--gray-50);
            margin-bottom: 0.5rem;
        }

        .file-item:last-child {
            margin-bottom: 0;
        }

        .file-item .file-name {
            flex-grow: 1;
            margin-right: 1rem;
        }

        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Badge Styling */
        .badge {
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
        }

        .badge.bg-success {
            background-color: var(--success) !important;
        }

        .badge.bg-primary {
            background-color: var(--primary) !important;
        }

        /* Search Input Group */
        .input-group-text {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .search-input {
            border-radius: 0 0.75rem 0.75rem 0 !important;
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(135deg, var(--gray-800), var(--gray-900));
            color: white;
            padding: 3rem 0;
            margin-top: 3rem;
        }

        footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: white;
            text-decoration: underline;
        }

        /* Stats Icons */
        .stats-icon {
            font-size: 2rem;
            color: var(--primary);
        }

        /* Loading Spinner */
        .loader {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Filter Summary */
        .filter-summary {
            background-color: var(--gray-100);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin-right: 0.5rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .filter-value {
            font-weight: 500;
        }

        /* Sticky Filters */
        .filters-container {
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 1.5rem;
        }

        /* Recent Updates */
        .update-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .update-item:last-child {
            border-bottom: none;
        }

        .update-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .update-desc {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .update-time {
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 500;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 3rem 0;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-stat {
                margin-bottom: 0.5rem;
            }

            .document-item {
                padding: 1rem;
            }

            .file-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .file-item .file-name {
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .file-item .btn-group {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            body.dark-mode {
                background-color: var(--gray-900);
                color: var(--gray-100);
            }

            body.dark-mode .section-card {
                background-color: var(--gray-800);
                color: var(--gray-100);
            }

            body.dark-mode .document-item {
                background-color: var(--gray-800);
                border-color: var(--secondary);
            }

            body.dark-mode .form-select,
            body.dark-mode .form-control {
                background-color: var(--gray-800);
                border-color: var(--gray-700);
                color: var(--gray-100);
            }

            body.dark-mode .filter-summary {
                background-color: var(--gray-800);
            }

            body.dark-mode .file-item {
                background-color: var(--gray-800);
            }
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: none;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        .toast {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.75rem;
            overflow: hidden;
            width: 350px;
            max-width: 100%;
        }

        .toast-header {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1rem;
        }

        .toast-body {
            padding: 1rem;
        }

        /* Progress bar for downloads */
        .progress {
            height: 0.5rem;
            border-radius: 9999px;
            overflow: hidden;
            background-color: var(--gray-200);
        }

        .progress-bar {
            background-color: var(--primary);
            height: 100%;
            border-radius: 9999px;
            transition: width 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Toast Container for Notifications -->
    <div class="toast-container"></div>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="theme-toggle">
        <i class="bi bi-moon-fill"></i>
    </button>

    <!-- Header Section -->
    <header class="hero-section text-center animate__animated animate__fadeIn">
        <div class="container">
            <h1 class="display-4 hero-title mb-3 animate__animated animate__fadeInDown">Document Management System</h1>
            <p class="lead hero-subtitle mb-4 animate__animated animate__fadeInUp animate__delay-1s">Access, explore,
                and download important documents shared across divisions in one unified platform</p>
            <div
                class="d-flex flex-wrap justify-content-center gap-2 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="hero-stat">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span id="doc-count" class="me-2">{{ $documentsCount }}</span> Documents
                </div>
                <div class="hero-stat">
                    <i class="bi bi-building me-2"></i>
                    <span id="division-count" class="me-2">{{ $divisions->count() }}</span> Divisions
                </div>
                {{-- <div class="hero-stat">
                    <i class="bi bi-download me-2"></i> <span>1.2k+</span> Downloads
                </div> --}}
            </div>
        </div>
    </header>

    <!-- Main Content Section -->
    <div class="container py-5" id="app">
        <div class="row g-4">
            <!-- Document Filter Section -->
            <div class="col-lg-4 mb-4">
                <div class="filters-container">
                    <div class="section-card card mb-4 animate__animated animate__fadeInLeft">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4"><i class="bi bi-funnel me-2"></i>Document Filters</h3>
                            <p class="text-muted mb-4">Select from the options below to find the documents you need</p>

                            <!-- Division Dropdown -->
                            <div class="mb-4">
                                <label for="division_id" class="form-label">
                                    <i class="bi bi-building me-2"></i> Division
                                </label>
                                <select id="division_id" name="division_id" class="form-select">
                                    <option value="">-- Select a Division --</option>
                                    @foreach ($divisions as $division)
                                        @if ($division->documents->count() > 0)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categories Dropdown (initially hidden) -->
                            <div id="category_div" class="mb-4" style="display: none;">
                                <label for="category_id" class="form-label">
                                    <i class="bi bi-folder me-2"></i> Category
                                </label>
                                <select id="category_id" name="category_id" class="form-select">
                                    <option value="">-- Select a Category --</option>
                                </select>
                            </div>

                            <!-- Filter Summary -->
                            <div id="filter_summary" class="filter-summary d-none">
                                <h6 class="mb-3">Current Selection:</h6>
                                <div id="filter_details" class="small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="section-card card mb-4 animate__animated animate__fadeInLeft animate__delay-1s">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3"><i class="bi bi-bar-chart me-2"></i>Quick Stats</h5>
                            <div class="row g-3">
                                <!-- Documents Stat -->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-light p-3 me-3">
                                            <i class="bi bi-file-earmark-text text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Documents</div>
                                            <div class="fw-bold" id="doc-count">{{ $documentsCount }}</div>
                                            <!-- Dynamic Document Count -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Divisions Stat -->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-light p-3 me-3">
                                            <i class="bi bi-building text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Divisions</div>
                                            <div class="fw-bold" id="division-count">{{ $divisions->count() }}</div>
                                            <!-- Dynamic Division Count -->
                                        </div>
                                    </div>
                                </div>

                                {{-- <!-- Recent Downloads Stat -->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-light p-3 me-3">
                                            <i class="bi bi-download text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Downloads</div>
                                            <div class="fw-bold">1.2k+</div> <!-- Static Value, can be dynamic -->
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- System Status Stat -->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-light p-3 me-3">
                                            <i class="bi bi-hdd-network text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">System Status</div>
                                            <div class="badge bg-success">Online</div> <!-- Static Value for now -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Activity Stat -->
                                <div class="col-12 mt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-muted small">Recent Activity</div>
                                        <div class="fw-bold">3 New Documents Uploaded</div>
                                        <!-- Static Value, can be dynamic -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Help Card -->
                    <div class="section-card card animate__animated animate__fadeInLeft animate__delay-2s">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3"><i class="bi bi-question-circle me-2"></i>Need Help?</h5>
                            <p class="text-muted mb-3">If you need assistance with finding documents or have questions
                                about the system, our support team is here to help.</p>
                            <div class="d-grid">
                                <a href="mailto:support@example.com" class="btn btn-outline-primary">
                                    <i class="bi bi-envelope me-2"></i> Contact Support
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Document Display Section -->
            <div class="col-lg-8">
                <!-- Document Details Section (initially hidden) -->
                <div id="document_details" class="animate__animated" style="display: none;">
                    <div class="section-card card mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 card-title"><i class="bi bi-file-earmark-text me-2"></i> Available
                                Documents</h3>
                            <div id="loading_indicator" style="display: none;">
                                <div class="loader"></div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Search Box -->
                            <div class="input-group mb-4">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="document_search" class="form-control search-input"
                                    placeholder="Search in documents...">
                            </div>

                            <div id="documents_list" class="list-group mb-4">
                                <!-- Documents will be loaded here -->
                            </div>

                            <!-- Download Button -->
                            <button id="download_selected" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-download me-2"></i> Download Selected Documents
                            </button>
                        </div>
                    </div>
                </div>

                <!-- No Selection State -->
                <div id="no_selection" class="section-card card empty-state animate__animated animate__fadeIn">
                    <i class="bi bi-archive empty-state-icon"></i>
                    <h3>Welcome to Document Management System</h3>
                    <p class="text-muted mb-4">Select a division and category from the left panel to browse available
                        documents</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <h5 class="fw-bold mb-2">Document Management System</h5>
            <p class="mb-2 opacity-75">Efficient document access for enhanced collaboration.</p>
            <p class="small opacity-75">© 2025 All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal for Viewing File (PDF Preview) -->
    <div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFileModalLabel">View Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="fileViewer" src="" style="width:100%; height:80vh;"
                        frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Theme toggle functionality
            $('#theme-toggle').click(function() {
                $('body').toggleClass('dark-mode');
                const isDarkMode = $('body').hasClass('dark-mode');
                localStorage.setItem('darkMode', isDarkMode);

                // Toggle icon
                if (isDarkMode) {
                    $(this).html('<i class="bi bi-sun-fill"></i>');
                } else {
                    $(this).html('<i class="bi bi-moon-fill"></i>');
                }

                // Show toast notification
                showToast('Theme Changed', `Switched to ${isDarkMode ? 'dark' : 'light'} mode`);
            });

            // Check for saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                $('body').addClass('dark-mode');
                $('#theme-toggle').html('<i class="bi bi-sun-fill"></i>');
            }

            // Toast notification function
            window.showToast = function(title, message) {
                const toastId = 'toast-' + Date.now();
                const toast = `
                    <div class="toast fade show" id="${toastId}">
                        <div class="toast-header">
                            <strong class="me-auto">${title}</strong>
                            <button type="button" class="btn-close" onclick="$('#${toastId}').remove()"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                `;

                $('.toast-container').append(toast);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    $(`#${toastId}`).remove();
                }, 3000);
            };

            // Fetch categories when a division is selected
            $('#division_id').change(function() {
                var divisionId = $(this).val();

                if (divisionId) {
                    var divisionText = $("#division_id option:selected").text();
                    $('#category_div').slideDown();
                    $('#filter_summary').removeClass('d-none');
                    $('#filter_details').html(
                        `<div class="mb-2"><span class="filter-badge">Division</span> <span class="filter-value">${divisionText}</span></div>`
                    );

                    // Hide the no selection state
                    $('#no_selection').hide();

                    // Show loading indicator
                    $('#loading_indicator').show();

                    // Fetch categories for the selected division
                    $.get(`/documents/categories/${divisionId}`, function(categories) {
                        $('#category_id').empty().append(
                            '<option value="">-- Select a Category --</option>');
                        categories.forEach(function(category) {
                            $('#category_id').append(
                                `<option value="${category}">${category}</option>`);
                        });

                        // Hide loading indicator
                        $('#loading_indicator').hide();

                        // Show toast notification
                        showToast('Categories Loaded',
                            `Found ${categories.length} categories for ${divisionText}`);
                    }).fail(function() {
                        $('#loading_indicator').hide();
                        showToast('Error', 'Failed to load categories. Please try again.', 'error');
                    });
                } else {
                    $('#category_div').slideUp();
                    $('#document_details').hide();
                    $('#no_selection').show();
                    $('#filter_summary').addClass('d-none');
                }
            });

            // Fetch document details when a category is selected
            $('#category_id').change(function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    var categoryText = $("#category_id option:selected").text();
                    var divisionText = $("#division_id option:selected").text();

                    // Update filter summary
                    $('#filter_details').html(
                        `<div class="mb-2"><span class="filter-badge">Division</span> <span class="filter-value">${divisionText}</span></div>` +
                        `<div><span class="filter-badge">Category</span> <span class="filter-value">${categoryText}</span></div>`
                    );

                    $('#document_details').fadeIn();
                    $('#loading_indicator').show();

                    // Clear previous documents
                    $('#documents_list').html('');

                    // Fetch documents for the selected category
                    $.get(`/documents/details/${categoryId}`, function(documents) {
                        var documentHtml = '';
                        if (documents.length === 0) {
                            documentHtml =
                                '<div class="alert alert-info">No documents found for this category.</div>';
                        } else {
                            // Update document count
                            $('#doc-count').text(documents.length);

                            documents.forEach(function(document, index) {
                                const delay = index * 100;

                                // Set document details (one document)
                                documentHtml += `
                                    <div class="document-item fade-in-up" style="animation-delay: ${delay}ms">
                                        <div class="d-flex w-100 justify-content-between align-items-start mb-2">
                                            <h5 class="mb-1 fw-bold">${document.document.title}</h5>
                                            <span class="badge bg-success">Document</span>
                                        </div>
                                        <p class="mb-3 text-muted">${document.document.description || 'No description'}</p>
                                        <div class="file-container">
                                            ${document.files.map(function (file, fileIndex) {
                                                return `
                                                                                            <div class="file-item">
                                                                                                <span class="file-name">${file.file_name}</span>
                                                                                                <div class="d-flex gap-2">
                                                                                                    <input type="checkbox" class="file-checkbox" value="${file.file_path}" />
                                                                                                    <a href="${file.file_path}" class="btn btn-sm btn-download" download="${file.file_name}" title="Download">
                                                                                                        <i class="bi bi-download"></i> Download
                                                                                                    </a>
                                                                                                    <button type="button" class="btn btn-sm btn-view" onclick="viewFile('${file.file_path}', '${file.file_name}')" title="View">
                                                                                                        <i class="bi bi-eye"></i> View
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        `;
                                            }).join('')}
                                        </div>
                                    </div>`;
                            });

                            // Show toast notification
                            showToast('Documents Loaded',
                                `Found ${documents.length} documents in ${categoryText}`);
                        }

                        // Hide loading indicator
                        $('#loading_indicator').hide();
                        $('#documents_list').html(documentHtml);
                    }).fail(function() {
                        $('#loading_indicator').hide();
                        $('#documents_list').html(
                            '<div class="alert alert-danger">Error fetching documents. Please try again.</div>'
                        );
                        showToast('Error', 'Failed to load documents. Please try again.', 'error');
                    });
                } else {
                    $('#document_details').hide();
                    var divisionText = $("#division_id option:selected").text();
                    $('#filter_details').html(
                        `<div class="mb-2"><span class="filter-badge">Division</span> <span class="filter-value">${divisionText}</span></div>`
                    );
                }
            });

            // Search functionality for documents
            $('#document_search').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                $('.document-item').each(function() {
                    const documentText = $(this).text().toLowerCase();
                    if (documentText.indexOf(searchText) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Open modal to view file
            window.viewFile = function(filePath, fileName) {
                $('#fileViewer').attr('src', filePath);
                $('#viewFileModalLabel').text(fileName || 'View Document');
                $('#viewFileModal').modal('show');
            };

            // Track downloads
            window.trackDownload = function(fileName) {
                // In a real app, this would send analytics data
                console.log(`Document downloaded: ${fileName}`);
                showToast('Download Started', `Downloading ${fileName}`);
            };

            // Download selected documents
            $('#download_selected').click(function() {
                const selectedFiles = [];
                $('.file-checkbox:checked').each(function() {
                    selectedFiles.push($(this).val()); // Collect selected file paths
                });

                if (selectedFiles.length > 0) {
                    // Show loading or progress bar notification
                    showToast('Bulk Download', `Preparing ${selectedFiles.length} documents for download`);

                    // Send the selected document IDs to the server via AJAX
                    $.ajax({
                        url: '/documents/download-multiple', // Your server route for bulk download
                        type: 'GET',
                        data: {
                            document_ids: selectedFiles // Send selected document IDs to the server
                        },
                        success: function(response) {
                            if (response.success) {
                                // Initiate the download
                                window.location.href = response.downloadUrl;
                                showToast('Download Complete',
                                    `${selectedFiles.length} documents have been downloaded.`
                                );
                            } else {
                                showToast('Download Failed', response.error);
                            }
                        },
                        error: function() {
                            showToast('Error',
                                'An error occurred while preparing the documents for download.'
                            );
                        }
                    });
                } else {
                    showToast('No Documents', 'Please select at least one document to download.');
                }
            });
        });
    </script>

</body>

</html>
