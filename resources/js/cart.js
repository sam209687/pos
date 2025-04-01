export function initializeCart() {
    const cart = {
        items: [],
        taxRate: 0.10,

        init() {
            this.bindEvents();
            this.updateDisplay();
        },

        bindEvents() {
            // Add to cart buttons
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', (e) => {
                    const productData = JSON.parse(e.target.dataset.product);
                    this.addItem(productData);
                });
            });

            // Quantity change events
            document.getElementById('cart-items').addEventListener('change', (e) => {
                if (e.target.classList.contains('item-quantity')) {
                    const index = e.target.dataset.index;
                    this.updateQuantity(index, parseInt(e.target.value));
                }
            });

            // Discount input
            document.getElementById('discount').addEventListener('input', () => {
                this.updateTotals();
            });

            // Amount paid input
            document.getElementById('amount-paid').addEventListener('input', () => {
                this.calculateChange();
            });
        },

        addItem(product) {
            const existingItem = this.items.find(item => item.id === product.id);

            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity++;
                } else {
                    this.showError('Not enough stock available');
                    return;
                }
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    stock: product.stock
                });
            }

            this.updateDisplay();
        },

        updateQuantity(index, quantity) {
            const item = this.items[index];
            if (quantity > item.stock) {
                this.showError('Not enough stock available');
                return;
            }
            
            if (quantity < 1) {
                this.items.splice(index, 1);
            } else {
                item.quantity = quantity;
            }

            this.updateDisplay();
        },

        calculateSubtotal() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        calculateTax(subtotal) {
            return subtotal * this.taxRate;
        },

        getDiscount() {
            return parseFloat(document.getElementById('discount').value) || 0;
        },

        calculateTotal(subtotal, tax) {
            return subtotal + tax - this.getDiscount();
        },

        calculateChange() {
            const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));
            const amountPaid = parseFloat(document.getElementById('amount-paid').value) || 0;
            const change = amountPaid - total;
            
            document.getElementById('change-amount').textContent = 
                `$${Math.max(0, change).toFixed(2)}`;
        },

        updateDisplay() {
            const subtotal = this.calculateSubtotal();
            const tax = this.calculateTax(subtotal);
            const total = this.calculateTotal(subtotal, tax);

            // Update cart items display
            const tbody = document.querySelector('#cart-items tbody');
            tbody.innerHTML = this.items.map((item, index) => `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="number" 
                               class="item-quantity" 
                               data-index="${index}"
                               value="${item.quantity}" 
                               min="1" 
                               max="${item.stock}">
                    </td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>$${(item.price * item.quantity).toFixed(2)}</td>
                    <td>
                        <button onclick="cart.removeItem(${index})" 
                                class="text-red-500 hover:text-red-700">×</button>
                    </td>
                </tr>
            `).join('');

            // Update totals
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;

            this.calculateChange();
        },

        showError(message) {
            const alert = document.createElement('div');
            alert.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in';
            alert.textContent = message;
            
            document.querySelector('main').prepend(alert);
            setTimeout(() => alert.remove(), 3000);
        }
    };

    window.cart = cart;
    cart.init();
}
