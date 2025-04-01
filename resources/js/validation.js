export function initializeFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });

        // Real-time validation
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', () => {
                validateField(field);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const fields = form.querySelectorAll('input, select, textarea');

    fields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });

    return isValid;
}

function validateField(field) {
    const rules = field.dataset.rules ? JSON.parse(field.dataset.rules) : {};
    let isValid = true;
    let errorMessage = '';

    // Required validation
    if (rules.required && !field.value.trim()) {
        isValid = false;
        errorMessage = 'This field is required';
    }

    // Email validation
    if (rules.email && !validateEmail(field.value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
    }

    // Minimum length validation
    if (rules.minLength && field.value.length < rules.minLength) {
        isValid = false;
        errorMessage = `Minimum length is ${rules.minLength} characters`;
    }

    // Number validation
    if (rules.number && !validateNumber(field.value)) {
        isValid = false;
        errorMessage = 'Please enter a valid number';
    }

    // Display error message
    const errorElement = field.nextElementSibling;
    if (errorElement && errorElement.classList.contains('error-message')) {
        errorElement.textContent = errorMessage;
        errorElement.style.display = isValid ? 'none' : 'block';
    }

    // Update field styling
    field.classList.toggle('border-red-500', !isValid);

    return isValid;
}

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validateNumber(value) {
    return !isNaN(parseFloat(value)) && isFinite(value);
}
