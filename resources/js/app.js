// Main application JavaScript file
// Import any JavaScript dependencies here
import './bootstrap';
import { initializeSearch } from './search';
import { initializeCart } from './cart';
import { initializeFormValidation } from './validation';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Initialize components when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initializeSearch('#product-search', '.product-card');
    initializeCart();
    initializeFormValidation();
});
