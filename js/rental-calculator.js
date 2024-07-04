document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const totalDaysSpan = document.getElementById('num-days');

    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    startDateInput.value = today;
    endDateInput.value = tomorrow;

    // Calculate total days
    const calculateTotalDays = () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const timeDiff = endDate - startDate;
        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        totalDaysSpan.textContent = daysDiff;
    };

    startDateInput.addEventListener('change', calculateTotalDays);
    endDateInput.addEventListener('change', calculateTotalDays);
    calculateTotalDays(); // Initial calculation
});
