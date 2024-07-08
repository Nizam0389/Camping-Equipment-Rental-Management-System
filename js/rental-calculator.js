document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const totalDaysSpan = document.getElementById('num-days');

    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    startDateInput.value = today;
    endDateInput.value = tomorrow;

    // Set min attributes to prevent selecting dates before today
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', tomorrow);

    // Calculate total days
    const calculateTotalDays = () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const timeDiff = endDate - startDate;
        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        totalDaysSpan.textContent = daysDiff;
    };

    // Ensure end date is not before start date
    const validateEndDate = () => {
        const startDate = new Date(startDateInput.value);
        const minEndDate = new Date(startDate);
        minEndDate.setDate(startDate.getDate() + 1);
        const minEndDateString = minEndDate.toISOString().split('T')[0];
        endDateInput.setAttribute('min', minEndDateString);
        if (new Date(endDateInput.value) < minEndDate) {
            endDateInput.value = minEndDateString;
        }
        calculateTotalDays();
    };

    startDateInput.addEventListener('change', () => {
        validateEndDate();
        calculateTotalDays();
    });
    endDateInput.addEventListener('change', calculateTotalDays);
    calculateTotalDays(); // Initial calculation
});
