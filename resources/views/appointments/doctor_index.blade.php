@extends('layouts.app')

@section('title', 'Doctor Appointments - R5 Pondok Indah')

@section('content')
<div class="container mx-auto p-6">
    <!-- Doctor Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Patient Appointments</h1>
                <p class="opacity-90 mt-2">Manage and review patient appointments</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="font-semibold">Dr. {{ Auth::user()->name }}</p>
                    <p class="text-sm opacity-75">{{ Auth::user()->doctor->specialization ?? 'General Practitioner' }}</p>
                </div>
                <div class="h-12 w-12 bg-white rounded-full flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-lg p-3">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->where('status', 'approved')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-lg p-3">
                    <i class="fas fa-times-circle text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->where('status', 'cancelled')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $appointments->unique('user_id')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">All Appointments</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Patient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold">
                                        {{ $appointment->patient_initials ?? substr($appointment->user->name ?? 'NA', 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appointment->patient_name ?? $appointment->user->name ?? 'Unknown Patient' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Patient ID: {{ $appointment->user_id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- DATE & TIME CELL - USING MODEL ACCESSORS -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $appointment->formatted_date ?? \Carbon\Carbon::parse($appointment->scheduled_at)->format('d M Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $appointment->formatted_time ?? \Carbon\Carbon::parse($appointment->scheduled_at)->format('h:i A') }}
                            </div>
                            @if($appointment->isRescheduled() && $appointment->rescheduled_at)
                            <div class="text-xs text-yellow-600 mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Rescheduled to: {{ \Carbon\Carbon::parse($appointment->rescheduled_at)->format('d M Y h:i A') }}
                            </div>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $appointment->patient_phone ?? $appointment->user->phone ?? 'No phone' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $appointment->patient_email ?? $appointment->user->email ?? 'No email' }}
                            </div>
                        </td>
                        
                        <!-- STATUS CELL - FIXED: Menggunakan match() expression untuk menghindari nested ternary error -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Use model's getStatusColor() if available, otherwise fallback
                                if (method_exists($appointment, 'getStatusColor')) {
                                    $statusColor = $appointment->getStatusColor();
                                } else {
                                    // Gunakan match expression (PHP 8.0+) untuk menghindari nested ternary
                                    $statusColor = match($appointment->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'rescheduled' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                }
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                <i class="fas {{ method_exists($appointment, 'getStatusIcon') ? $appointment->getStatusIcon() : 'fa-question-circle' }} mr-1"></i>
                                {{ method_exists($appointment, 'getStatusText') ? $appointment->getStatusText() : ucfirst($appointment->status) }}
                            </span>
                        </td>
                        
                        <!-- ACTION BUTTONS CELL - USING MODEL HELPERS -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <!-- PENDING APPOINTMENTS -->
                            @if($appointment->isPending())
                            <!-- APPROVE BUTTON -->
                            <form action="{{ route('appointments.confirm', $appointment->id) }}" method="POST" 
                                  class="inline-block mb-1"
                                  onsubmit="return confirm('Approve appointment for {{ $appointment->patient_name ?? 'patient' }}?')">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium mr-2">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                            </form>
                            
                            <!-- RESCHEDULE BUTTON -->
                            <button type="button" 
                                    onclick="showRescheduleModal({{ $appointment->id }}, '{{ $appointment->patient_name ?? $appointment->user->name }}', '{{ $appointment->scheduled_at }}')"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium mr-2 mb-1">
                                <i class="fas fa-calendar-alt mr-1"></i> Reschedule
                            </button>
                            
                            <!-- CANCEL BUTTON -->
                            <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST" 
                                  class="inline-block mb-1"
                                  onsubmit="return confirm('Cancel appointment for {{ $appointment->patient_name ?? 'patient' }}?')">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                            </form>
                            
                            <!-- APPROVED APPOINTMENTS -->
                            @elseif($appointment->isApproved())
                            <!-- COMPLETE BUTTON -->
                            <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" 
                                  class="inline-block mb-1"
                                  onsubmit="return confirm('Mark appointment as completed?')">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm font-medium mr-2">
                                    <i class="fas fa-check-double mr-1"></i> Complete
                                </button>
                            </form>
                            
                            <!-- RESCHEDULE BUTTON for approved -->
                            <button type="button" 
                                    onclick="showRescheduleModal({{ $appointment->id }}, '{{ $appointment->patient_name ?? $appointment->user->name }}', '{{ $appointment->scheduled_at }}')"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium mb-1">
                                <i class="fas fa-calendar-alt mr-1"></i> Reschedule
                            </button>
                            
                            <!-- RESCHEDULED APPOINTMENTS -->
                            @elseif($appointment->isRescheduled())
                            <!-- CONFIRM RESCHEDULED APPOINTMENT -->
                            <form action="{{ route('appointments.confirm', $appointment->id) }}" method="POST" 
                                  class="inline-block mb-1">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium mr-2">
                                    <i class="fas fa-check mr-1"></i> Confirm
                                </button>
                            </form>
                            
                            <!-- CANCEL RESCHEDULED APPOINTMENT -->
                            <form action="{{ route('appointments.reject', $appointment->id) }}" method="POST" 
                                  class="inline-block mb-1">
                                @csrf
                                <input type="hidden" name="reason" value="Cancelled after reschedule">
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                            </form>
                            
                            <!-- CANCELLED APPOINTMENTS -->
                            @elseif($appointment->isCancelled())
                            <span class="text-gray-500 italic">Cancelled</span>
                            
                            <!-- COMPLETED APPOINTMENTS -->
                            @elseif($appointment->isCompleted())
                            <span class="text-green-600 italic">
                                <i class="fas fa-check-circle mr-1"></i> Completed
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900">No appointments found</h3>
                            <p class="mt-1 text-sm text-gray-500">You don't have any patient appointments yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($appointments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reschedule Modal -->
<div id="rescheduleModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Reschedule Appointment</h3>
                <button type="button" onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="rescheduleForm" method="POST">
                @csrf
                <input type="hidden" id="appointmentId" name="appointment_id">
                
                <div class="mb-4">
                    <p id="patientInfo" class="text-sm text-gray-600 mb-2"></p>
                    <p id="currentTime" class="text-sm text-gray-600 mb-4"></p>
                </div>
                
                <div class="mb-4">
                    <label for="newDateTime" class="block text-sm font-medium text-gray-700 mb-1">
                        New Date & Time
                    </label>
                    <input type="datetime-local" id="newDateTime" name="new_scheduled_at" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
                
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">
                        Reason for Reschedule
                    </label>
                    <textarea id="reason" name="reason" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Explain why you need to reschedule..."
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRescheduleModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        Confirm Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .action-buttons form {
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .action-buttons button {
        transition: all 0.2s ease;
    }
    .action-buttons button:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>

@endsection

@section('scripts')
<script>
    // Reschedule Modal Functions
    function showRescheduleModal(appointmentId, patientName, scheduledAt) {
        // Format the date properly
        let formattedDate, formattedTime;
        
        try {
            // Try to parse the date (could be string or Date object)
            const date = scheduledAt instanceof Date ? scheduledAt : new Date(scheduledAt);
            
            // Check if date is valid
            if (isNaN(date.getTime())) {
                throw new Error('Invalid date');
            }
            
            formattedDate = date.toLocaleDateString('en-GB', {
                day: 'numeric', 
                month: 'short', 
                year: 'numeric'
            });
            formattedTime = date.toLocaleTimeString('en-US', {
                hour: '2-digit', 
                minute: '2-digit'
            });
        } catch (error) {
            // Fallback if date parsing fails
            formattedDate = 'Unknown date';
            formattedTime = 'Unknown time';
        }
        
        document.getElementById('patientInfo').innerText = `Patient: ${patientName}`;
        document.getElementById('currentTime').innerText = `Current: ${formattedDate} at ${formattedTime}`;
        document.getElementById('appointmentId').value = appointmentId;
        
        // Set form action
        document.getElementById('rescheduleForm').action = `/appointments/reschedule/${appointmentId}`;
        
        // Set min date to tomorrow at 9 AM
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(9, 0, 0, 0);
        
        // Format for datetime-local input (YYYY-MM-DDTHH:mm)
        const minDate = tomorrow.toISOString().slice(0, 16);
        
        document.getElementById('newDateTime').min = minDate;
        document.getElementById('newDateTime').value = minDate;
        
        // Clear previous reason
        document.getElementById('reason').value = '';
        
        // Show modal
        document.getElementById('rescheduleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    function closeRescheduleModal() {
        document.getElementById('rescheduleModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
    
    // Handle reschedule form submission
    document.getElementById('rescheduleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newDateTime = document.getElementById('newDateTime').value;
        const reason = document.getElementById('reason').value;
        
        if (!newDateTime || !reason) {
            alert('Please fill all fields');
            return;
        }
        
        // Validate date is in the future
        const selectedDate = new Date(newDateTime);
        const now = new Date();
        if (selectedDate <= now) {
            alert('Please select a future date and time');
            return;
        }
        
        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        const originalWidth = submitBtn.offsetWidth;
        
        submitBtn.style.minWidth = originalWidth + 'px';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        submitBtn.disabled = true;
        
        // Submit form
        this.submit();
    });
    
    // Close modal on outside click or Escape key
    document.getElementById('rescheduleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRescheduleModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('rescheduleModal').classList.contains('hidden')) {
            closeRescheduleModal();
        }
    });
    
    // Toast notification for success/error messages
    @if(session('success'))
    showToast('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
    showToast('{{ session('error') }}', 'error');
    @endif
    
    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Remove after 5 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 5000);
    }
    
    // Initialize date inputs
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date for any datetime-local inputs
        const datetimeInputs = document.querySelectorAll('input[type="datetime-local"]');
        const now = new Date();
        const tomorrow = new Date(now);
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(9, 0, 0, 0);
        const minDate = tomorrow.toISOString().slice(0, 16);
        
        datetimeInputs.forEach(input => {
            if (!input.min) {
                input.min = minDate;
            }
        });
    });
</script>
@endsection