let listProductHTML = document.querySelector('.listProduct');
let listCartHTML = document.querySelector('.listCart');
let iconCart = document.querySelector('.icon-cart');
let iconCartSpan = document.querySelector('.icon-cart span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let products = [];
let cart = [];

// Toggle cart display
iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});
closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
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
        let id_product = positionClick.parentElement.dataset.id;
        console.log(`Adding product with ID: ${id_product}`);
        addToCart(id_product);
    }
});

// Add product to cart
const addToCart = (product_id) => {
    let positionThisProductInCart = cart.findIndex((value) => value.product_id == product_id);
    console.log(`Product position in cart: ${positionThisProductInCart}`);
    if (cart.length <= 0) {
        cart = [{
            product_id: product_id,
            quantity: 1
        }];
    } else if (positionThisProductInCart < 0) {
        cart.push({
            product_id: product_id,
            quantity: 1
        });
    } else {
        cart[positionThisProductInCart].quantity = cart[positionThisProductInCart].quantity + 1;
    }
    console.log(`Updated cart:`, cart);
    addCartToHTML();
    saveCartToSession();
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
    fetch('loadCart.php')
    .then(response => response.json())
    .then(data => {
        cart = data;
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
                    <img src="${info.item_image_url}">
                </div>
                <div class="name">
                    ${info.item_name}
                </div>
                <div class="totalPrice">RM${info.item_fee * item.quantity}</div>
                <div class="quantity">
                    <span class="minus">
                        -
                    </span>
                    <span>${item.quantity}</span>
                    <span class="plus">
                        +
                    </span>
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
        let info = cart[positionItemInCart];
        if (type === 'plus') {
            cart[positionItemInCart].quantity += 1;
        } else {
            cart[positionItemInCart].quantity -= 1;
            if (cart[positionItemInCart].quantity <= 0) {
                cart.splice(positionItemInCart, 1);
            }
        }
    }
    console.log(`Updated cart after quantity change:`, cart);
    addCartToHTML();
    saveCartToSession();
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
        
        loadCartFromSession();
    })
    .catch(error => {
        console.error('Fetch error:', error); // Log any fetch errors to the console
    });
};
initApp();