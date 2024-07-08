let products = [];
let cart = [];

// Load cart from session
const loadCartFromSession = () => {
    return fetch('loadCart.php')
    .then(response => response.json())
    .then(data => {
        cart = data;
        addCartToHTML();
        populateCartItems(); // Call this after loading the cart
    });
};

// Display cart items in HTML
const addCartToHTML = () => {
    const listCartHTML = document.querySelector('.listCart');
    const iconCartSpan = document.querySelector('.icon-cart span');
    const totalPriceElement = document.getElementById('total-price');
    const cartItemsContainer = document.getElementById('cart-items');
    if (listCartHTML) {
        listCartHTML.innerHTML = '';
    }
    if (cartItemsContainer) {
        cartItemsContainer.innerHTML = '';
    }
    let totalQuantity = 0;
    let totalPrice = 0;
    const numDays = calculateTotalDays(); // Calculate the total number of days
    if (cart.length > 0) {
        cart.forEach(item => {
            totalQuantity += item.quantity;
            const positionProduct = products.findIndex(value => value.item_id == item.product_id);
            if (positionProduct === -1) {
                console.error(`Product with ID: ${item.product_id} not found in products array`);
                return;
            }
            const info = products[positionProduct];
            info.item_fee = parseFloat(info.item_fee); // Ensure item_fee is a number
            if (isNaN(info.item_fee)) {
                console.error('Invalid item_fee:', info.item_fee);
                return;
            }
            const totalItemPrice = info.item_fee * item.quantity * numDays;
            totalPrice += totalItemPrice;

            if (listCartHTML) {
                const newItem = document.createElement('div');
                newItem.classList.add('item');
                newItem.dataset.id = item.product_id;
                newItem.innerHTML = `
                    <div class="image">
                        <img src="${info.item_image_url}">
                    </div>
                    <div class="name">
                        ${info.item_name}
                    </div>
                    <div class="totalPrice">RM${totalItemPrice.toFixed(2)}</div>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <span>${item.quantity}</span>
                        <span class="plus">+</span>
                    </div>`;
                listCartHTML.appendChild(newItem);
            }
            if (cartItemsContainer) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${info.item_name}</td>
                    <td>RM ${info.item_fee.toFixed(2)}</td>
                    <td>${item.quantity}</td>
                    <td>RM ${totalItemPrice.toFixed(2)}</td>
                `;
                cartItemsContainer.appendChild(newRow);
            }
        });
    }
    if (iconCartSpan) {
        iconCartSpan.innerText = totalQuantity;
    }
    if (totalPriceElement) {
        totalPriceElement.innerText = `RM ${totalPrice.toFixed(2)}`;
    }
};

// Add products to HTML
const addDataToHTML = (filteredProducts) => {
    const listProductHTML = document.querySelector('.listProduct');
    if (!listProductHTML) return;
    listProductHTML.innerHTML = ''; // Clear existing items
    if (filteredProducts.length > 0) { // if has data
        filteredProducts.forEach(product => {
            let newProduct = document.createElement('div');
            newProduct.dataset.id = product.item_id;
            newProduct.classList.add('item');
            newProduct.innerHTML = `
                <img src="${product.item_image_url}" alt="${product.item_name}">
                <h2>${product.item_name}</h2>
                <div class="price">RM${product.item_fee}</div>
                <button class="addCart">Add To Cart</button>`;
            listProductHTML.appendChild(newProduct);
        });
    }
};

// Populate cart items on the payment page
const populateCartItems = () => {
    const cartItemsContainer = document.getElementById('cart-items');
    if (!cartItemsContainer) return; // Exit if we're not on the payment page

    cartItemsContainer.innerHTML = ''; // Clear existing items
    let totalPrice = 0;
    const numDays = calculateTotalDays(); // Calculate the total number of days

    cart.forEach(item => {
        let positionProduct = products.findIndex((value) => value.item_id == item.product_id);
        if (positionProduct !== -1) {
            let product = products[positionProduct];
            product.item_fee = parseFloat(product.item_fee); // Ensure item_fee is a number
            if (isNaN(product.item_fee)) {
                console.error('Invalid item_fee:', product.item_fee);
                return;
            }
            let itemTotal = product.item_fee * item.quantity * numDays;
            totalPrice += itemTotal;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${product.item_name}</td>
                <td>RM ${product.item_fee.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>RM ${itemTotal.toFixed(2)}</td>
            `;
            cartItemsContainer.appendChild(newRow);
        }
    });

    // Update total price
    const totalElement = document.querySelector('.total span:last-child');
    if (totalElement) {
        totalElement.textContent = `RM ${totalPrice.toFixed(2)}`;
    }

    // Update daily rate
    const dailyRateElement = document.getElementById('daily-rate');
    if (dailyRateElement) {
        dailyRateElement.textContent = totalPrice.toFixed(2);
    }
};

// Calculate total days based on start and end date
// Add this function to your app.js file

const calculateTotalDays = () => {
    const startDate = new Date(localStorage.getItem('start_date'));
    const endDate = new Date(localStorage.getItem('end_date'));
    if (endDate < startDate) {
        alert("Return date cannot be before the start date.");
        localStorage.setItem('end_date', localStorage.getItem('start_date')); // Reset the return date to start date
        return 1;
    }
    const timeDiff = endDate - startDate;
    const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
    return daysDiff > 0 ? daysDiff : 1;
};


// Initialize app
const initApp = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const itemType = urlParams.get('type');
    console.log(`Fetching items of type: ${itemType}`);

    fetch('fetchItems.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        products = data;
        console.log(`Fetched products:`, products);

        const filteredProducts = itemType ? products.filter(product => product.item_type === itemType) : products;
        addDataToHTML(filteredProducts);

        loadCartFromSession().then(() => {
            populateCartItems(); // Call this after loading the cart
        });
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
};

initApp();

// Add event listeners for date inputs
const startDateInput = document.getElementById('start-date');
const endDateInput = document.getElementById('end-date');
if (startDateInput && endDateInput) {
    startDateInput.addEventListener('change', () => {
        calculateTotalDays();
        addCartToHTML();
        populateCartItems();
    });
    endDateInput.addEventListener('change', () => {
        calculateTotalDays();
        addCartToHTML();
        populateCartItems();
    });
}

function saveRent() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const rentStatus = 1; // Assume rentStatus is true for active rent

    fetch('saveRent.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ startDate, endDate, rentStatus, cart })
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('paymentModal').style.display = 'block';
        } else {
            alert('Failed to save rent: ' + data.error);
        }
    }).catch(error => {
        alert('Error: ' + error);
    });
}

// Redirect to confirmation page
const redirectToConfirmation = () => {
    window.location.href = 'confirmation.php';
};

// Existing checkout button functionality
const checkoutButton = document.querySelector('.checkOut');
if (checkoutButton) {
    checkoutButton.addEventListener('click', redirectToConfirmation);
}
