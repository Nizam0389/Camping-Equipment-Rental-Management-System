<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <script src="js/cart.js" defer></script>
    <script src="js/rental-calculator.js" defer></script>
    <script>
function saveRentDetails() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    
    const items = JSON.parse(localStorage.getItem('cart')) || [];
    const data = { start_date: startDate, end_date: endDate, items: items };
    
    fetch('saveRent.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
      .then(data => {
          console.log(data); // Log the response data for debugging
          if (data.success) {
              alert('Rent details saved successfully!');
              // Store rent details in session and show confirmation modal
              localStorage.setItem('rent_id', data.rent_id);
              showConfirmationModal();
          } else {
              alert('Failed to save rent: ' + data.message);
          }
      }).catch(error => {
          console.error('Error:', error);
          alert('Failed to save rent.');
      });
}

function showConfirmationModal() {
    const confirmationModal = document.getElementById('confirmationModal');
    const cartItemsContainer = document.getElementById('confirmation-cart-items');
    cartItemsContainer.innerHTML = ''; // Clear existing items

    const items = JSON.parse(localStorage.getItem('cart')) || [];

    items.forEach(item => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${item.item_name}</td>
            <td>${item.item_fee}</td>
            <td>${item.quantity}</td>
            <td>${(item.item_fee * item.quantity).toFixed(2)}</td>
        `;
        cartItemsContainer.appendChild(newRow);
    });

    confirmationModal.style.display = 'block';
}

function confirmAndSaveRentalDetails() {
    const rent_id = localStorage.getItem('rent_id');
    const items = JSON.parse(localStorage.getItem('cart')) || [];
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    const data = { rent_id: rent_id, items: items, start_date: startDate, end_date: endDate };

    fetch('saveRentalDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
      .then(data => {
          console.log(data); // Log the response data for debugging
          if (data.success) {
              alert('Rental details saved successfully!');
              // Redirect to the selected bank URL
              const radios = document.getElementsByName('bank');
              let selectedValue;
              for (let i = 0; i < radios.length; i++) {
                  if (radios[i].checked) {
                      selectedValue = radios[i].value;
                      break;
                  }
              }
              if (selectedValue) {
                  window.location.href = selectedValue;
              } else {
                  alert("Please select a bank.");
              }
          } else {
              alert('Failed to save rental details: ' + data.message);
          }
      }).catch(error => {
          console.error('Error:', error);
          alert('Failed to save rental details.');
      });
}
</script>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="homepage.php">HOMEPAGE</a></li>
            <li><a href="category.php">RENTAL</a></li>
            <li class="logo"><img src="image/logo.png" alt="logo"></li>
            <li class="right"><a href="contactus.php">CONTACT US</a></li>
            <li class="right"><a href="login.php"><img src="image/profilebg.png" alt="Login" style="height:20%; width:30px;"></a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2 class="title-page">- CART -</h2>
        <div class="cart-container">
            <div class="cart-details">
                <h3>Payment</h3>
                <div class="rental-dates">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                    
                    <label for="end-date">Return Date:</label>
                    <input type="date" id="end-date" name="end-date" required>
                </div>
                <div class="rental-summary">
                    <p>Number of days: <span id="num-days">0</span></p>
                </div>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE PER DAY</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <!-- Cart items will be populated here -->
                    </tbody>
                </table>
                <button type="button" class="save-rent-button" onclick="saveRentDetails()">Save Rent Details</button>
            </div>
            <div class="payment-details">
                <h3>Payment</h3>
                <div class="total">
                    <span>Total</span>
                    <span id="total-price">RM 0.00</span>
                </div>
                <h4>Online Banking</h4>
                <form>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://www.maybank2u.com.my/mbb/m2u/common/M2ULogin.do?action=Login" required>
                        <img src="image/bank/maybank.png" alt="Maybank">
                    </label><br>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://www.bankislam.biz/rib/" required>
                        <img src="image/bank/bank-islam.png" alt="Bank Islam">
                    </label><br>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://www.cimbclicks.com.my/clicks/" required>
                        <img src="image/bank/cimb.png" alt="CIMB">
                    </label><br>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://onlinebanking.rhbgroup.com/my/login" required>
                        <img src="image/bank/rhb.png" alt="RHB">
                    </label><br>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://www.pbebank.com/" required>
                        <img src="image/bank/public-bank.png" alt="Public Bank">
                    </label><br>
                    <label class="radio-container">
                        <input type="radio" name="bank" value="https://www.ambank.com.my/eng/online-banking/faq-get-started-Log-In-to-AmOnline" required>
                        <img src="image/bank/ambank.png" alt="AmBank">
                    </label><br>
                    <button type="button" class="pay-button" onclick="saveRentDetails()">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('confirmationModal').style.display='none'">&times;</span>
            <h2>Confirm Rental Details</h2>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>PRICE PER DAY</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody id="confirmation-cart-items">
                    <!-- Confirmation cart items will be populated here -->
                </tbody>
            </table>
            <button type="button" class="confirm-rent-button" onclick="confirmAndSaveRentalDetails()">Confirm and Save Rental Details</button>
        </div>
    </div>
</body>
</html>
