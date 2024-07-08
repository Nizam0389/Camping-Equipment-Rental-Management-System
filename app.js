let listProductHTML = document.querySelector('.listProduct');
let listCartHTML = document.querySelector('.listCart');
let iconCart = document.querySelector('.icon-cart');
let iconCartSpan = document.querySelector('.icon-cart span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let modal = document.getElementById('successModal');
let closeModal = document.getElementById('closeModal');
let products = [];
let cart = [];

// Toggle cart display
iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});
closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});

// Show modal
const showModal = () => {
    modal.style.display = "block";
};

// Hide modal
closeModal.addEventListener('click', () => {
    modal.style.display = "none";
});

// Add products to HTML
const addDataToHTML = (filteredProducts) => {
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

// Handle adding product to cart
listProductHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if (positionClick.classList.contains('addCart')) {
        let productElement = positionClick.parentElement;
        let id_product = productElement.dataset.id;
        let item_name = productElement.querySelector('h2').textContent;
        let item_fee = parseFloat(productElement.querySelector('.price').textContent.replace('RM', ''));
        let item_image_url = productElement.querySelector('img').src;
        console.log(`Adding product with ID: ${id_product}`);
        addToCart(id_product, item_name, item_fee, item_image_url);
    }
});

// Add product to cart
const addToCart = (product_id, item_name, item_fee, item_image_url) => {
    let positionThisProductInCart = cart.findIndex((value) => value.product_id == product_id);
    console.log(`Product position in cart: ${positionThisProductInCart}`);
    if (positionThisProductInCart < 0) {
        cart.push({
            product_id: product_id,
            item_name: item_name,
            item_fee: item_fee,
            item_image_url: item_image_url,
            quantity: 1
        });
    } else {
        cart[positionThisProductInCart].quantity += 1;
    }
    console.log(`Updated cart:`, cart);
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to localStorage
    addCartToHTML();
    saveCartToSession();
    showModal(); // Display modal when item is added to cart
};

// Save cart to session
const saveCartToSession = () => {
    fetch('saveCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cart)
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Cart saved successfully');
          } else {
              console.error('Failed to save cart');
          }
      });
};

// Load cart from session
const loadCartFromSession = () => {
    return fetch('loadCart.php')
    .then(response => response.json())
    .then(data => {
        cart = data;
        localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to localStorage
        addCartToHTML();
    });
};

// Display cart items in HTML
const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    if (cart.length > 0) {
        cart.forEach(item => {
            totalQuantity += item.quantity;
            let newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.dataset.id = item.product_id;

            let positionProduct = products.findIndex((value) => value.item_id == item.product_id);
            if (positionProduct === -1) {
                console.error(`Product with ID: ${item.product_id} not found in products array`);
                return; // Skip this item if not found in products array
            }
            let info = products[positionProduct];
            console.log(`Adding to cart HTML:`, info);
            listCartHTML.appendChild(newItem);
            newItem.innerHTML = `
                <div class="image">
                    <img src="${item.item_image_url}">
                </div>
                <div class="name">
                    ${item.item_name}
                </div>
                <div class="totalPrice">RM${(item.item_fee * item.quantity).toFixed(2)}</div>
                <div class="quantity">
                    <span class="minus">-</span>
                    <span>${item.quantity}</span>
                    <span class="plus">+</span>
                </div>`;
        });
    }
    iconCartSpan.innerText = totalQuantity;
};

// Change cart item quantity
listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if (positionClick.classList.contains('minus') || positionClick.classList.contains('plus')) {
        let product_id = positionClick.parentElement.parentElement.dataset.id;
        let type = positionClick.classList.contains('plus') ? 'plus' : 'minus';
        console.log(`Changing quantity for product ID: ${product_id}, Type: ${type}`);
        changeQuantityCart(product_id, type);
    }
});

// Update cart item quantity
const changeQuantityCart = (product_id, type) => {
    let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);
    if (positionItemInCart >= 0) {
        if (type === 'plus') {
            cart[positionItemInCart].quantity += 1;
        } else {
            cart[positionItemInCart].quantity -= 1;
            if (cart[positionItemInCart].quantity <= 0) {
                cart.splice(positionItemInCart, 1);
            }
        }
    }
    localStorage.setItem('cart', JSON.stringify(cart)); // Update cart in localStorage
    console.log(`Updated cart after quantity change:`, cart);
    addCartToHTML();
    saveCartToSession();
};

// Populate cart items on the confirmation/payment page
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
const calculateTotalDays = () => {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    if (!startDateInput || !endDateInput) return 1; // Default to 1 day if inputs are not found

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);
    const timeDiff = endDate - startDate;
    const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
    document.getElementById('num-days').textContent = daysDiff;
    return daysDiff;
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
        
        // Filter products by type
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
