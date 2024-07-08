<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : 'Guest';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <script src="js/cart.js" defer></script>
    <script src="js/rental-calculator.js" defer></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = localStorage.getItem('start_date');
    const endDate = localStorage.getItem('end_date');

    if (!startDate || !endDate) {
        alert('Start date and end date must be selected.');
        window.location.href = 'confirmation.php';
        return;
    }

    document.getElementById('num-days').textContent = calculateTotalDays();
    populateCartItems();
    
    function calculateTotalDays() {
        const startDate = new Date(localStorage.getItem('start_date'));
        const endDate = new Date(localStorage.getItem('end_date'));
        const timeDiff = endDate - startDate;
        const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        return daysDiff > 0 ? daysDiff : 1;
    }

    function populateCartItems() {
        const cartItemsContainer = document.getElementById('cart-items');
        const items = JSON.parse(localStorage.getItem('cart')) || [];
        const numDays = calculateTotalDays();
        let totalPrice = 0;

        cartItemsContainer.innerHTML = ''; // Clear existing items

        items.forEach(item => {
            const itemTotal = item.item_fee * item.quantity * numDays;
            totalPrice += itemTotal;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${item.item_name}</td>
                <td>RM ${item.item_fee.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>RM ${itemTotal.toFixed(2)}</td>
            `;
            cartItemsContainer.appendChild(newRow);
        });

        document.getElementById('total-price').textContent = `RM ${totalPrice.toFixed(2)}`;
    }

    function saveRentalDetailsAndRedirect() {
        const rent_id = localStorage.getItem('rent_id');
        const items = JSON.parse(localStorage.getItem('cart')) || [];
        const startDate = localStorage.getItem('start_date');
        const endDate = localStorage.getItem('end_date');

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
                  savePaymentDetails(); // Save payment details
              } else {
                  alert('Failed to save rental details: ' + data.message);
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Failed to save rental details.');
          });
    }

    function savePaymentDetails() {
        const rent_id = localStorage.getItem('rent_id');
        const totalPrice = parseFloat(document.getElementById('total-price').textContent.replace('RM ', ''));

        const data = { rent_id: rent_id, total_fee: totalPrice };

        fetch('savePayment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => response.json())
          .then(data => {
              console.log(data); // Log the response data for debugging
              if (data.success) {
                  alert('Payment details saved successfully!');
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
                  alert('Failed to save payment details: ' + data.message);
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Failed to save payment details.');
          });
    }

    document.querySelector('.pay-button').addEventListener('click', saveRentalDetailsAndRedirect);
});
</script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <h2 style="text-align: center; margin-top: 0;font-size: 24px; color: #4F6F52;">- PAYMENT -</h2>
        <div class="cart-container">
            <div class="cart-details">
                <h3 style="margin-top: 0; color: #4F6F52; padding: 5px">Payment</h3>
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
                <br>
                <div class="rental-summary">
                    <p>Number of days: <span id="num-days">0</span></p>
                </div>
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
                    <button type="button" class="pay-button" style="background-color: #34A853;">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
