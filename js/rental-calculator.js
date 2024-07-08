document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const totalDaysSpan = document.getElementById('num-days');

    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    startDateInput.value = today;
    endDateInput.value = tomorrow;

    // Disable past dates for start date
    startDateInput.setAttribute('min', today);

    // Calculate total days
    const calculateTotalDays = () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        // Check if return date is before start date
        if (endDate < startDate) {
            alert("Return date cannot be before the start date.");
            endDateInput.value = startDateInput.value; // Reset the return date to start date
            totalDaysSpan.textContent = 1;
            return 1;
        }

        const timeDiff = endDate - startDate;
        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        totalDaysSpan.textContent = daysDiff;
        return daysDiff;
    };

    startDateInput.addEventListener('change', () => {
        const selectedStartDate = new Date(startDateInput.value);
        if (selectedStartDate < new Date(today)) {
            alert("Start date cannot be in the past.");
            startDateInput.value = today; // Reset the start date to today
        }
        calculateTotalDays();
        updateCartItems(); // Update cart items on date change
    });

    endDateInput.addEventListener('change', () => {
        calculateTotalDays();
        updateCartItems(); // Update cart items on date change
    });

    calculateTotalDays(); // Initial calculation
});
