@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">Statistik dan Ikhtisar Dashboard</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    </nav>
                </div>
            </div>
        </div>

        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <!-- Key Overview Cards -->
                    <div class="row mb-4">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm h-100 border-start border-primary border-3">
                                <div class="card-body px-4 py-4-5 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stats-icon blue mb-2 d-flex justify-content-center align-items-center">
                                            <i
                                                class="bi bi-person-workspace fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-semibold">Total Pengguna</h6>
                                    <h2 class="font-extrabold mb-0">{{ $totalUsers }}</h2>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-light-primary px-2 rounded-pill">
                                            <i class="bi bi-activity me-1"></i>
                                            {{ $userActivityPercentage }}% aktif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm h-100 border-start border-purple border-3">
                                <div class="card-body px-4 py-4-5 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="stats-icon purple mb-2 d-flex justify-content-center align-items-center">
                                            <i
                                                class="bi bi-shield-lock fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-semibold">Total Risiko</h6>
                                    <h2 class="font-extrabold mb-0">{{ $totalRisks }}</h2>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-light-success px-2 rounded-pill">
                                            <i class="bi bi-check2-circle me-1"></i>
                                            {{ $riskResolutionRate }}% diselesaikan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm h-100 border-start border-success border-3">
                                <div class="card-body px-4 py-4-5 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stats-icon green mb-2 d-flex justify-content-center align-items-center">
                                            <i
                                                class="bi bi-file-earmark-check fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-semibold">Risiko Tertutup</h6>
                                    <h2 class="font-extrabold mb-0">{{ $closedRisks }}</h2>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-light-success px-2 rounded-pill">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            {{ round(($closedRisks / ($totalRisks ?: 1)) * 100) }}% dari total
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm h-100 border-start border-danger border-3">
                                <div class="card-body px-4 py-4-5 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stats-icon red mb-2 d-flex justify-content-center align-items-center">
                                            <i
                                                class="bi bi-clipboard-data fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-semibold">Review Tertunda</h6>
                                    <h2 class="font-extrabold mb-0">{{ $pendingReviews }}</h2>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-light-danger px-2 rounded-pill">
                                            <i class="bi bi-stopwatch me-1"></i> Perlu tindakan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Statistics Cards -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4><i class="bi bi-people-fill me-2"></i> Statistik Pengguna</h4>
                                    <div class="badge bg-primary rounded-pill">
                                        <i class="bi bi-graph-up-arrow me-1"></i> {{ $userActivityPercentage }}% aktif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Active Users -->
                                        <div class="col-6 col-lg-4 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon blue mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-person-check-fill fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Pengguna Aktif</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $activeUsers }}</h2>
                                                <span class="badge bg-light-success px-2 rounded-pill">
                                                    {{ round(($activeUsers / ($totalUsers ?: 1)) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ round(($activeUsers / ($totalUsers ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($activeUsers / ($totalUsers ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Inactive Users -->
                                        <div class="col-6 col-lg-4 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon red mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-person-dash-fill fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Pengguna Tidak Aktif</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $inactiveUsers }}</h2>
                                                <span class="badge bg-light-danger px-2 rounded-pill">
                                                    {{ round(($inactiveUsers / ($totalUsers ?: 1)) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: {{ round(($inactiveUsers / ($totalUsers ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($inactiveUsers / ($totalUsers ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Total Users -->
                                        <div class="col-6 col-lg-4 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon purple mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-people-fill fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Total Pengguna</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $totalUsers }}</h2>
                                                <span class="badge bg-light-primary px-2 rounded-pill">
                                                    <i class="bi bi-check2-all"></i>
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Statistics Cards -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4><i class="bi bi-shield-fill-exclamation me-2"></i> Statistik Risiko</h4>
                                    <div class="badge bg-success rounded-pill">
                                        <i class="bi bi-check2-all me-1"></i> {{ $riskResolutionRate }}% terselesaikan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Open Risks -->
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon blue mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-file-earmark-text fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Risiko Terbuka</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $openRisks }}</h2>
                                                <span class="badge bg-light-primary px-2 rounded-pill">
                                                    {{ round(($openRisks / ($totalRisks ?: 1)) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ round(($openRisks / ($totalRisks ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($openRisks / ($totalRisks ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Closed Risks -->
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon green mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-file-earmark-check-fill fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Risiko Tertutup</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $closedRisks }}</h2>
                                                <span class="badge bg-light-success px-2 rounded-pill">
                                                    {{ round(($closedRisks / ($totalRisks ?: 1)) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ round(($closedRisks / ($totalRisks ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($closedRisks / ($totalRisks ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Pending Reviews -->
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon red mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-hourglass-split fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Menunggu Review</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $pendingReviews }}</h2>
                                                <span class="badge bg-light-danger px-2 rounded-pill">
                                                    {{ round(($pendingReviews / ($totalRisks ?: 1)) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: {{ round(($pendingReviews / ($totalRisks ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($pendingReviews / ($totalRisks ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Recent Risks (30 days) -->
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="stats-icon purple mb-2 d-flex justify-content-center align-items-center">
                                                    <i
                                                        class="bi bi-calendar-event-fill fs-4 d-flex justify-content-center align-items-center w-100 h-100"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted font-semibold">Risiko 30 Hari Terakhir</h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-extrabold mb-0">{{ $recentRisks }}</h2>
                                                <span class="badge bg-light-info px-2 rounded-pill">
                                                    <i class="bi bi-check2"></i> {{ $recentClosedRisks }}
                                                </span>
                                            </div>
                                            <div class="progress progress-sm mt-3">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ round(($recentClosedRisks / ($recentRisks ?: 1)) * 100) }}%"
                                                    aria-valuenow="{{ round(($recentClosedRisks / ($recentRisks ?: 1)) * 100) }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Analytics Dashboard -->
                    <div class="row mt-4">
                        <div class="col-12 col-lg-6">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4><i class="bi bi-graph-up-arrow me-2"></i> Distribusi Status Risiko</h4>
                                    <div class="badge bg-primary px-3 py-2 rounded-pill d-flex align-items-center">
                                        <i class="bi bi-database-fill me-2"></i>
                                        <span>{{ $totalRisks }} Total Risiko</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="risk-status-chart"></div>
                                    <div class="alert alert-light-info mt-3 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                                            <span>
                                                <strong>Insight:</strong>
                                                {{ $openRisks > $closedRisks ? 'Perlu perhatian pada risiko terbuka yang signifikan.' : 'Tingkat penyelesaian risiko dalam kondisi baik.' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center gap-4 flex-wrap mt-3">
                                        <div class="d-flex align-items-center p-2 border rounded bg-light-primary">
                                            <div class="avatar avatar-sm bg-primary me-2">
                                                <i class="bi bi-file-earmark text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $openRisks }}</h6>
                                                <small>Risiko Terbuka</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center p-2 border rounded bg-light-success">
                                            <div class="avatar avatar-sm bg-success me-2">
                                                <i class="bi bi-check2-circle text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $closedRisks }}</h6>
                                                <small>Risiko Tertutup</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center p-2 border rounded bg-light-danger">
                                            <div class="avatar avatar-sm bg-danger me-2">
                                                <i class="bi bi-hourglass-split text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $pendingReviews }}</h6>
                                                <small>Menunggu Review</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4><i class="bi bi-shield-lock-fill me-2"></i> Efektivitas Kontrol</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-funnel-fill me-1"></i> Filter
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Semua Kontrol</a></li>
                                            <li><a class="dropdown-item" href="#">Hanya Kritikal</a></li>
                                            <li><a class="dropdown-item" href="#">Hanya Major</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="control-effectiveness-chart"></div>
                                    <div class="alert alert-light-info mt-3 mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-lightbulb-fill fs-5 me-2"></i>
                                            <span>
                                                <strong>Insight:</strong>
                                                {{ count($controlEffectiveness) > 0 ? $controlEffectiveness[0]->control : 'N/A' }}
                                                controls memiliki konsentrasi risiko tertinggi.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Risks -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4><i class="bi bi-clock-history me-2"></i> Risiko Terbaru</h4>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye-fill me-1"></i> Lihat Semua
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><i class="bi bi-hash me-1"></i> ID</th>
                                                    <th><i class="bi bi-building me-1"></i> Divisi</th>
                                                    <th><i class="bi bi-tag-fill me-1"></i> Status</th>
                                                    <th><i class="bi bi-shield-fill me-1"></i> Kontrol</th>
                                                    <th><i class="bi bi-calendar2-check me-1"></i> Dibuat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($latestRisks as $risk)
                                                    <tr>
                                                        <td>{{ $risk->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm me-2">
                                                                    <div class="avatar-content">
                                                                        {{ substr($risk->division->name ?? 'UN', 0, 2) }}
                                                                    </div>
                                                                </div>
                                                                {{ $risk->division->name ?? 'Unassigned' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-light-{{ $risk->risk_status == 'Open' ? 'primary' : 'success' }} px-3 py-1 rounded-pill">
                                                                <i
                                                                    class="bi bi-{{ $risk->risk_status == 'Open' ? 'file-earmark' : 'check-circle' }} me-1"></i>
                                                                {{ $risk->risk_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-light-{{ in_array($risk->control, ['Major', 'Serious']) ? 'danger' : 'info' }} px-3 py-1 rounded-pill">
                                                                <i
                                                                    class="bi bi-shield-{{ in_array($risk->control, ['Major', 'Serious']) ? 'exclamation' : 'check' }} me-1"></i>
                                                                {{ $risk->control }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $risk->created_at->format('d M Y') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-3">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                                                                <p>Tidak ada data risiko terbaru</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <!-- User Activity Summary -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary bg-gradient text-white">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-graph-up-arrow me-2"></i>
                                <h4 class="text-white mb-0">User Activity</h4>
                            </div>
                        </div>
                        <div class="card-body py-4">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="avatar avatar-xl bg-light-primary p-2">
                                    <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                    <h1 class="display-5 font-bold mb-0">{{ $activeUsers }}</h1>
                                    <span class="badge bg-success fs-6 d-flex align-items-center">
                                        <i class="bi bi-arrow-up-circle-fill me-1"></i> Active
                                    </span>
                                </div>
                                <p class="text-muted"><i class="bi bi-people me-1"></i> dari {{ $totalUsers }} total
                                    pengguna</p>
                            </div>

                            <div class="activity-gauge mb-3">
                                <div class="d-flex justify-content-between text-small mb-1">
                                    <span><i class="bi bi-reception-4 me-1"></i> Aktivitas</span>
                                    <span class="fw-bold">{{ $userActivityPercentage }}%</span>
                                </div>
                                <div class="progress progress-sm" style="height: 8px;">
                                    <div class="progress-bar bg-gradient-primary" role="progressbar"
                                        style="width: {{ $userActivityPercentage }}%; border-radius: 8px;"
                                        aria-valuenow="{{ $userActivityPercentage }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <div class="text-center">
                                    <i class="bi bi-person-check-fill text-success fs-4"></i>
                                    <h6 class="mt-2 mb-0">{{ $activeUsers }}</h6>
                                    <small class="text-muted">Aktif</small>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-person-dash-fill text-danger fs-4"></i>
                                    <h6 class="mt-2 mb-0">{{ $inactiveUsers }}</h6>
                                    <small class="text-muted">Non-aktif</small>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-calendar-check-fill text-primary fs-4"></i>
                                    <h6 class="mt-2 mb-0">{{ round($userActivityPercentage) }}%</h6>
                                    <small class="text-muted">Engagement</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User by Division -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light-primary d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-primary me-2">
                                    <i class="bi bi-diagram-3 text-white"></i>
                                </div>
                                <h4 class="mb-0">Distribusi Pengguna</h4>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                <i class="bi bi-people-fill me-1"></i>
                                {{ array_sum(array_column($usersByDivision->toArray(), 'total')) }} users
                            </span>
                        </div>
                        <div class="card-body">
                            <div id="users-by-division-chart" class="mb-3"></div>
                            <div class="mt-4">
                                @foreach ($usersByDivision as $index => $division)
                                    <div
                                        class="d-flex justify-content-between align-items-center mb-3 p-2 rounded
                                        {{ $index % 2 == 0 ? 'bg-light-primary' : '' }}">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <div class="avatar-content rounded-circle bg-primary bg-opacity-25">
                                                        {{ substr($division->division_name, 0, 2) }}
                                                    </div>
                                                </div>
                                                <span>{{ $division->division_name }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="badge bg-primary rounded-pill">
                                                    <i class="bi bi-people-fill me-1"></i>
                                                    {{ $division->total }}
                                                </div>
                                                <div class="progress progress-sm" style="width: 60px; height: 6px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $division->active_percentage }}%"
                                                        aria-valuenow="{{ $division->active_percentage }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small
                                                    class="text-success fw-bold">{{ $division->active_percentage }}%</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer bg-light-primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-info-circle-fill me-1"></i> Distribusi pengguna
                                    per divisi</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Resolution Rate -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-success text-white d-flex align-items-center">
                            <div class="avatar avatar-sm bg-white me-2">
                                <i class="bi bi-shield-check text-success"></i>
                            </div>
                            <h4 class="text-white mb-0">Tingkat Resolusi Risiko</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div id="resolution-rate-chart"></div>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h2 class="display-6 fw-bold mb-0 me-2">{{ $riskResolutionRate }}%</h2>
                                    <div class="badge bg-success p-2 d-flex align-items-center">
                                        <i class="bi bi-arrow-up-circle-fill me-1"></i> Completed
                                    </div>
                                </div>
                                <p class="text-muted"><i class="bi bi-shield-fill-check me-1"></i> Risiko Terselesaikan
                                </p>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between mt-4">
                                <div class="text-center">
                                    <div class="avatar avatar-md bg-light-primary mb-2">
                                        <i class="bi bi-calendar-event-fill text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $recentRisks }}</h5>
                                    <small class="text-muted">Risiko 30 Hari</small>
                                </div>
                                <div class="text-center">
                                    <div class="avatar avatar-md bg-light-success mb-2">
                                        <i class="bi bi-check2-all text-success"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $recentClosedRisks }}</h5>
                                    <small class="text-muted">Tertutup 30 Hari</small>
                                </div>
                                <div class="text-center">
                                    <div class="avatar avatar-md bg-light-warning mb-2">
                                        <i class="bi bi-hourglass-split text-warning"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">{{ $pendingReviews }}</h5>
                                    <small class="text-muted">Review Tertunda</small>
                                </div>
                            </div>

                            <div class="alert alert-light-success mt-4 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-lightning-charge-fill fs-5 me-2"></i>
                                    <span>
                                        <strong>Insight:</strong>
                                        {{ $riskResolutionRate > 75 ? 'Tingkat resolusi sangat baik!' : 'Perlu peningkatan resolusi risiko.' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('mazer/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        // Risk Status Chart
        var riskStatusChart = new ApexCharts(document.querySelector("#risk-status-chart"), {
            chart: {
                type: 'donut',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [
                {{ $openRisks }},
                {{ $closedRisks }},
                {{ $pendingReviews }}
            ],
            labels: ['Terbuka', 'Tertutup', 'Menunggu Review'],
            colors: ['#435ebe', '#55c6e8', '#ff7976'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true
                            },
                            value: {
                                show: true
                            },
                            total: {
                                show: true,
                                label: 'Total Risiko',
                                formatter: function(w) {
                                    return {{ $totalRisks }};
                                }
                            }
                        }
                    }
                }
            }
        });
        riskStatusChart.render();

        // Control Effectiveness Chart
        var controlEffectivenessChart = new ApexCharts(document.querySelector("#control-effectiveness-chart"), {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Jumlah Risiko',
                data: [
                    @foreach ($controlEffectiveness as $control)
                        {{ $control->total }},
                    @endforeach
                ]
            }],
            colors: ['#435ebe', '#55c6e8', '#ffc107', '#ff7976', '#dc3545'],
            xaxis: {
                categories: [
                    @foreach ($controlEffectiveness as $control)
                        '{{ $control->control }}',
                    @endforeach
                ]
            },
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 5
                }
            }
        });
        controlEffectivenessChart.render();

        // Users by Division Chart
        var usersByDivisionChart = new ApexCharts(document.querySelector("#users-by-division-chart"), {
            chart: {
                type: 'pie',
                height: 200,
                toolbar: {
                    show: false
                }
            },
            series: [
                @foreach ($usersByDivision as $division)
                    {{ $division->total }},
                @endforeach
            ],
            labels: [
                @foreach ($usersByDivision as $division)
                    '{{ $division->division_name }}',
                @endforeach
            ],
            legend: {
                show: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 200
                    }
                }
            }]
        });
        usersByDivisionChart.render();

        // Resolution Rate Chart
        var resolutionRateChart = new ApexCharts(document.querySelector("#resolution-rate-chart"), {
            chart: {
                height: 150,
                type: "radialBar",
            },
            series: [{{ $riskResolutionRate }}],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "60%",
                    },
                    track: {
                        background: "#e7f0fd",
                    },
                    dataLabels: {
                        showOn: "always",
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: "20px",
                            show: true,
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    }
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "dark",
                    type: "horizontal",
                    gradientToColors: ["#0ba360"],
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: "round",
            }
        });
        resolutionRateChart.render();
    </script>
@endpush
