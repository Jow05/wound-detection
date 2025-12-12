@extends('layouts.app')

@section('title', 'Doctor Dashboard - R5 Pondok Indah')

@section('styles')
<style>
    /* ===== CSS DOCTOR DASHBOARD ===== */
    :root {
        --primary: #0d6efd;
        --primary-dark: #0a58ca;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --border: #dee2e6;
    }

    .doctor-dashboard {
        background-color: #f5f7fb;
        min-height: 100vh;
    }

    /* Header */
    .header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 15px 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo h1 {
        font-size: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo .tagline {
        font-size: 14px;
        opacity: 0.9;
    }

    .doctor-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.1);
        padding: 10px 20px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
    }

    .doctor-avatar {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 20px;
    }

    /* Dashboard Layout */
    .dashboard {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 25px;
        margin-top: 30px;
    }

    /* Sidebar Menu */
    .sidebar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        margin-bottom: 8px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--gray);
        text-decoration: none;
    }

    .menu-item:hover, .menu-item.active {
        background-color: #e3f2fd;
        color: var(--primary);
    }

    .menu-item i {
        width: 20px;
        text-align: center;
    }

    /* Main Content */
    .main-content {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 24px;
        color: var(--primary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Appointment Table */
    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .appointments-table th {
        background-color: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid var(--border);
    }

    .appointments-table td {
        padding: 20px 15px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .appointments-table tr:hover {
        background-color: #f8f9fa;
    }

    /* Patient Info Cell */
    .patient-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .patient-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6f86d6 0%, #48c6ef 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    .patient-info h4 {
        font-size: 16px;
        margin-bottom: 5px;
        color: var(--dark);
    }

    .patient-meta {
        font-size: 14px;
        color: var(--gray);
    }

    .patient-meta i {
        margin-right: 5px;
        width: 15px;
    }

    /* Time Cell */
    .time-cell {
        font-weight: 600;
        color: var(--dark);
    }

    .date {
        font-size: 14px;
        color: var(--gray);
    }

    /* Status Badges */
    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-approved {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-rescheduled {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .status-completed {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-approve {
        background-color: var(--success);
        color: white;
    }

    .btn-reschedule {
        background-color: var(--warning);
        color: #212529;
    }

    .btn-cancel {
        background-color: var(--danger);
        color: white;
    }

    .btn-complete {
        background-color: var(--info);
        color: white;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-left: 5px solid var(--primary);
    }

    .stat-card.pending {
        border-left-color: #ffc107;
    }

    .stat-card.approved {
        border-left-color: #28a745;
    }

    .stat-card.cancelled {
        border-left-color: #dc3545;
    }

    .stat-card.rescheduled {
        border-left-color: #17a2b8;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
    }

    .stat-label {
        font-size: 14px;
        color: var(--gray);
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        color: var(--primary);
        font-size: 22px;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        color: var(--gray);
        cursor: pointer;
        padding: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 16px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        background-color: var(--gray);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    /* Hospital Info */
    .hospital-info {
        margin-top: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .service-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin: 25px 0;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray);
    }

    .app-download {
        text-align: center;
        padding: 25px;
        background: white;
        border-radius: 12px;
        margin-top: 25px;
    }

    .store-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .store-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: var(--dark);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
    }

    /* Footer */
    .footer {
        text-align: center;
        padding: 25px;
        color: var(--gray);
        font-size: 14px;
        margin-top: 40px;
        border-top: 1px solid var(--border);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .dashboard {
            grid-template-columns: 1fr;
        }
        
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .appointments-table {
            display: block;
            overflow-x: auto;
        }
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="doctor-dashboard">
    <!-- Header -->
    <div class="header">
        <div class="container header-content">
            <div class="logo">
                <h1><i class="fas fa-hospital"></i> R5 Pondok Indah</h1>
                <p class="tagline">Healthcare Excellence</p>
            </div>
            
            <div class="doctor-profile">
                <div class="doctor-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <h3>Dr. {{ $doctor->full_name ?? 'Doctor Name' }}</h3>
                    <p style="font-size: 14px; opacity: 0.9;">{{ $doctor->specialization ?? 'Specialization' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dashboard">
            <!-- Sidebar Menu -->
            <div class="sidebar">
                <a href="{{ route('doctor.dashboard') }}" class="menu-item active">
                    <i class="fas fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
                <a href="{{ route('doctor.patients') }}" class="menu-item">
                    <i class="fas fa-user-injured"></i>
                    <span>My Patients</span>
                </a>
                <a href="{{ route('doctor.schedule') }}" class="menu-item">
                    <i class="fas fa-clock"></i>
                    <span>Schedule</span>
                </a>
                <a href="{{ route('doctor.profile') }}" class="menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
                <a href="{{ route('logout') }}" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <h2 class="page-title">
                    <i class="fas fa-calendar-alt"></i> Patient Appointments
                </h2>

                <!-- Stats Overview -->
                <div class="stats-container">
                    <div class="stat-card pending">
                        <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-clock"></i> Pending Approval
                        </div>
                    </div>
                    <div class="stat-card approved">
                        <div class="stat-number">{{ $stats['approved'] ?? 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-check-circle"></i> Approved
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $stats['total_patients'] ?? 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-users"></i> Total Patients
                        </div>
                    </div>
                    <div class="stat-card cancelled">
                        <div class="stat-number">{{ $stats['cancelled'] ?? 0 }}</div>
                        <div class="stat-label">
                            <i class="fas fa-times-circle"></i> Cancelled
                        </div>
                    </div>
                </div>

                <!-- Appointments Table -->
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Pasien</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr data-appointment-id="{{ $appointment->id }}">
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar">
                                        {{ optional($appointment->user)->initials ?? 'NA' }}
                                    </div>
                                    <div class="patient-info">
                                        <h4>{{ optional($appointment->user)->name ?? 'Unknown Patient' }}</h4>
                                        <div class="patient-meta">
                                            <i class="fas fa-user"></i> Patient ID: {{ $appointment->user_id }}<br>
                                            <i class="fas fa-phone"></i> {{ optional($appointment->user)->phone ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="time-cell">
                                <div class="date">{{ $appointment->formatted_date }}</div>
                                <div>{{ $appointment->formatted_time }}</div>
                                @if($appointment->isRescheduled())
                                <small style="color: #ffc107; font-size: 12px;">
                                    <i class="fas fa-exclamation-triangle"></i> Rescheduled
                                </small>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $appointment->status }}" id="status-{{ $appointment->id }}">
                                    <i class="fas {{ $appointment->getStatusIcon() }}"></i> 
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($appointment->isPending())
                                    <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="action-btn btn-approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    
                                    <button class="action-btn btn-reschedule" onclick="showRescheduleModal({{ $appointment->id }}, '{{ optional($appointment->user)->name }}', '{{ $appointment->formatted_date }}', '{{ $appointment->formatted_time }}')">
                                        <i class="fas fa-calendar-alt"></i> Reschedule
                                    </button>
                                    
                                    <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="action-btn btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                    
                                    @elseif($appointment->isApproved())
                                    <button class="action-btn btn-reschedule" onclick="showRescheduleModal({{ $appointment->id }}, '{{ optional($appointment->user)->name }}', '{{ $appointment->formatted_date }}', '{{ $appointment->formatted_time }}')">
                                        <i class="fas fa-calendar-alt"></i> Reschedule
                                    </button>
                                    
                                    <form action="{{ route('doctor.appointments.complete', $appointment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="action-btn btn-complete">
                                            <i class="fas fa-check-double"></i> Complete
                                        </button>
                                    </form>
                                    
                                    @elseif($appointment->isRescheduled())
                                    <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="action-btn btn-approve">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="action-btn btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px;">
                                <i class="fas fa-calendar-times" style="font-size: 48px; color: #6c757d; margin-bottom: 20px;"></i>
                                <h3>No appointments found</h3>
                                <p>You don't have any appointments scheduled.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Hospital Information -->
        <div class="hospital-info">
            <h2 style="color: var(--primary); margin-bottom: 20px;">
                <i class="fas fa-hospital"></i> R5 Pondok Indah
            </h2>
            <p style="margin-bottom: 25px; font-size: 16px;">
                <strong>Misi:</strong> Memberikan pelayanan kesehatan terbaik dengan standar global.
            </p>

            <h3 style="color: var(--primary); margin-bottom: 15px;">
                <i class="fas fa-concierge-bell"></i> Layanan
            </h3>
            <div class="services-grid">
                <div class="service-item">
                    <i class="fas fa-ambulance" style="color: #dc3545;"></i>
                    <span>Emergency Care</span>
                </div>
                <div class="service-item">
                    <i class="fas fa-heartbeat" style="color: #28a745;"></i>
                    <span>Medical Check-up</span>
                </div>
                <div class="service-item">
                    <i class="fas fa-video" style="color: #0d6efd;"></i>
                    <span>Telemedicine</span>
                </div>
                <div class="service-item">
                    <i class="fas fa-flask" style="color: #6f42c1;"></i>
                    <span>Laboratorium</span>
                </div>
            </div>

            <h3 style="color: var(--primary); margin: 25px 0 15px;">
                <i class="fas fa-address-book"></i> Kontak
            </h3>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>1500-123</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@r5pondokindah.co.id</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Metro Duta Kav. UE, Jakarta</span>
                </div>
            </div>

            <div class="app-download">
                <h3 style="margin-bottom: 15px;">Download App</h3>
                <div class="store-buttons">
                    <a href="#" class="store-btn">
                        <i class="fab fa-apple"></i> App Store
                    </a>
                    <a href="#" class="store-btn">
                        <i class="fab fa-google-play"></i> Google Play
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2025 R5 Pondok Indah Group. All rights reserved.</p>
            <p style="margin-top: 10px; font-size: 13px;">Sistem Manajemen Appointment Dokter v2.0</p>
        </div>
    </div>
</div>

<!-- Modals -->
@include('doctors.modals.reschedule')
@include('doctors.modals.cancel')
@endsection

@section('scripts')
<script>
    // Global variables
    let currentAppointmentId = null;
    
    // Show Reschedule Modal
    function showRescheduleModal(id, patientName, currentDate, currentTime) {
        currentAppointmentId = id;
        
        document.getElementById('reschedulePatientInfo').innerHTML = 
            `<strong>Pasien:</strong> ${patientName}<br>
             <strong>Jadwal saat ini:</strong> ${currentDate}, ${currentTime}`;
        
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('newDate').min = today;
        document.getElementById('newDate').value = '';
        document.getElementById('newTime').value = '';
        document.getElementById('rescheduleReason').value = '';
        document.getElementById('rescheduleNotes').value = '';
        
        document.getElementById('rescheduleModal').style.display = 'flex';
    }

    // Show Cancel Modal
    function showCancelModal(id, patientName) {
        currentAppointmentId = id;
        
        document.getElementById('cancelPatientInfo').innerHTML = 
            `Anda yakin ingin membatalkan appointment dengan <strong>${patientName}</strong>?`;
        
        document.getElementById('cancelReason').value = '';
        document.getElementById('cancelNotes').value = '';
        
        document.getElementById('cancelModal').style.display = 'flex';
    }

    // Confirm Reschedule
    function confirmReschedule() {
        const newDate = document.getElementById('newDate').value;
        const newTime = document.getElementById('newTime').value;
        const reason = document.getElementById('rescheduleReason').value;
        
        if (!newDate || !newTime || !reason) {
            alert('Harap isi semua field yang diperlukan');
            return;
        }
        
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/doctor/appointments/${currentAppointmentId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = 'rescheduled';
        form.appendChild(statusField);
        
        const dateTime = new Date(`${newDate}T${newTime}`);
        const scheduledAtField = document.createElement('input');
        scheduledAtField.type = 'hidden';
        scheduledAtField.name = 'scheduled_at';
        scheduledAtField.value = dateTime.toISOString();
        form.appendChild(scheduledAtField);
        
        const reasonField = document.createElement('input');
        reasonField.type = 'hidden';
        reasonField.name = 'reason';
        reasonField.value = reason;
        form.appendChild(reasonField);
        
        document.body.appendChild(form);
        form.submit();
    }

    // Confirm Cancel
    function confirmCancel() {
        const reason = document.getElementById('cancelReason').value;
        const notes = document.getElementById('cancelNotes').value;
        
        if (!reason) {
            alert('Harap pilih alasan pembatalan');
            return;
        }
        
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/doctor/appointments/${currentAppointmentId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = 'cancelled';
        form.appendChild(statusField);
        
        const reasonField = document.createElement('input');
        reasonField.type = 'hidden';
        reasonField.name = 'reason';
        reasonField.value = reason + (notes ? ` - ${notes}` : '');
        form.appendChild(reasonField);
        
        document.body.appendChild(form);
        form.submit();
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        currentAppointmentId = null;
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
            currentAppointmentId = null;
        }
    };

    // Show notification
    function showNotification(message, type = 'success') {
        // You can implement toast notification here
        console.log(`${type}: ${message}`);
        alert(message);
    }

    // Initialize date pickers
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            if (!input.min) {
                input.min = today;
            }
        });
    });
</script>
@endsection