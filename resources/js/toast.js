
// Modern Toast System
class ModernToast {
    constructor() {
        this.container = document.getElementById('toast-container');
        this.toasts = [];
        this.maxToasts = 5;
    }

    show(message, type = 'info', title = '', duration = 5000) {
        // Remove oldest toast if we have too many
        if (this.toasts.length >= this.maxToasts) {
            this.remove(this.toasts[0]);
        }

        console.log(this.container);
        
        const toast = this.create(message, type, title, duration);
        this.container.appendChild(toast);
        this.toasts.push(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                this.remove(toast);
            }, duration);
        }

        return toast;
    }

    create(message, type, title, duration) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;

        const icons = {
            success: 'check_circle',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };

        const titles = {
            success: title || 'Success',
            error: title || 'Error',
            warning: title || 'Warning',
            info: title || 'Information'
        };

        toast.innerHTML = `
                    <div class="toast-icon">
                        <span class="material-icons-outlined">${icons[type]}</span>
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${titles[type]}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="toastSystem.remove(this.parentElement)">
                        <span class="material-icons-outlined" style="font-size: 16px;">close</span>
                    </button>
                    ${duration > 0 ? `<div class="toast-progress" style="animation-duration: ${duration}ms;"></div>` : ''}
                `;

        // Click to dismiss
        toast.addEventListener('click', (e) => {
            if (!e.target.closest('.toast-close')) {
                this.remove(toast);
            }
        });

        return toast;
    }

    remove(toast) {
        if (!toast || !toast.parentElement) return;

        toast.classList.add('hide');

        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
            this.toasts = this.toasts.filter(t => t !== toast);
        }, 300);
    }

    clear() {
        this.toasts.forEach(toast => this.remove(toast));
    }
}



// Initialize toast system
const toastSystem = new ModernToast();

// Global function for easy use
function showToast(message, type = 'info', title = '', duration = 5000) {
 
    return toastSystem.show(message, type, title, duration);
}

// Additional utility functions
function showSuccess(message, title = 'Success', duration = 4000) {
    return showToast(message, 'success', title, duration);
}

function showError(message, title = 'Error', duration = 6000) {
    return showToast(message, 'error', title, duration);
}

function showWarning(message, title = 'Warning', duration = 5000) {
    return showToast(message, 'warning', title, duration);
}

function showInfo(message, title = 'Information', duration = 4000) {
    return showToast(message, 'info', title, duration);
}

// Clear all toasts
function clearAllToasts() {
    toastSystem.clear();
}