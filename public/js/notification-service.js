// Centralized notification management

const NotificationService = (function() {
    let pollingInterval = null;
    let callbacks = [];
    let lastCount = 0;

    function init() {
        // Only initialize once
        if (pollingInterval) return;
        
        // Start polling
        startPolling();
        
        // Listen for page unload to clean up
        window.addEventListener('beforeunload', function() {
            stopPolling();
        });
    }

    function startPolling() {
        // Poll every 30 seconds
        pollingInterval = setInterval(checkCount, 30000);
        
        // Check immediately on init
        setTimeout(checkCount, 1000);
    }

    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }

    function checkCount() {
        fetch('/api/notifications/count', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.count !== undefined && data.count !== lastCount) {
                lastCount = data.count;
                // Notify all registered callbacks
                callbacks.forEach(callback => callback(data.count));
            }
        })
        .catch(error => {
            console.error('Error fetching notification count:', error);
        });
    }

    function onCountChange(callback) {
        if (typeof callback === 'function') {
            callbacks.push(callback);
            // Immediately call with current count if available
            if (lastCount > 0) {
                callback(lastCount);
            }
        }
    }

    function getCurrentCount() {
        return lastCount;
    }

    // Public API
    return {
        init: init,
        onCountChange: onCountChange,
        getCurrentCount: getCurrentCount,
        stopPolling: stopPolling
    };
})();

// Auto-initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    NotificationService.init();
});