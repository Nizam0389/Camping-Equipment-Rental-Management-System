document.addEventListener('DOMContentLoaded', function() {
    const cartItemsContainer = document.getElementById('cart-items');
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const totalDaysSpan = document.getElementById('num-days');
    const totalPriceElement = document.getElementById('total-price');

    function updateAll() {
        calculateTotalDays();
        populateCartItems();
    }

    startDateInput.addEventListener('change', updateAll);
    endDateInput.addEventListener('change', updateAll);

    // Load cart items from localStorage
    const items = JSON.parse(localStorage.getItem('cart')) || [];

    const calculateTotalDays = () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const timeDiff = endDate - startDate;
        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        totalDaysSpan.textContent = daysDiff;
        return daysDiff > 0 ? daysDiff : 1;
    };

    const populateCartItems = () => {
        const numDays = calculateTotalDays();
        let totalPrice = 0;

        // Clear existing cart items
        if (cartItemsContainer) {
            cartItemsContainer.innerHTML = '';
        } else {
            console.error("Cart items container not found");
            return;
        }

        items.forEach(item => {
            console.log(item); // Debug: Log the item

            // Ensure all necessary properties are present
            if (!item.item_name || !item.item_fee || !item.quantity) {
                console.error("Missing item properties", item);
                return;
            }

            let itemTotal = item.item_fee * item.quantity * numDays;
            totalPrice += itemTotal;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${item.item_name}</td>
                <td>RM ${item.item_fee.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>RM ${itemTotal.toFixed(2)}</td>
            `;
            cartItemsContainer.appendChild(newRow);
        });

        if (totalPriceElement) {
            totalPriceElement.textContent = `RM ${totalPrice.toFixed(2)}`;
        } else {
            console.error("Element with id 'total-price' not found");
        }
    };

    // Call the function after ensuring DOM is loaded
    populateCartItems();

    // Update the number of days and total price when dates are changed
    startDateInput.addEventListener('change', () => {
        calculateTotalDays();
        populateCartItems();
    });
    endDateInput.addEventListener('change', () => {
        calculateTotalDays();
        populateCartItems();
    });

    // Set initial dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    startDateInput.value = today;
    endDateInput.value = tomorrow;
    calculateTotalDays();
    populateCartItems();
});

function confirmAndProceed() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const items = JSON.parse(localStorage.getItem('cart')) || [];

    // Save dates to localStorage
    localStorage.setItem('start_date', startDate);
    localStorage.setItem('end_date', endDate);

    const data = { start_date: startDate, end_date: endDate, items: items };

    fetch('saverent.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
      .then(data => {
          console.log(data); // Log the response data for debugging
          if (data.success) {
              alert('rent details saved successfully!');
              // Store rent details in session and redirect to payment page
              localStorage.setItem('rent_id', data.rent_id);
              window.location.href = 'payment.php';
          } else {
              alert('Failed to save rent: ' + data.message);
          }
      }).catch(error => {
          console.error('Error:', error);
          alert('Failed to save rent.');
      });
}