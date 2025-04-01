# PROMPTS

## Prompt 1

Create development steps in `Scratchpad` or `Cursorrules` to
Write PHP code for a Point of Sale (POS) billing software with an integrated admin panel. The software should include the following features:

**Core Functionality:**

* **POS Interface:**
    * A user-friendly interface for sales transactions.
    * Ability to add products to a cart using product codes or through a product search.
    * Real-time calculation of total bill amount, including taxes and discounts.
    * Support for multiple payment methods (cash, credit card, etc.).
    * Generation of printable or digital receipts.
    * QR code generation for each sale, that when scanned, shows the receipt.
* **Admin Panel:**
    * Secure login for administrators.
    * Product Management:
        * Add, edit, and delete products.
        * Manage product details (name, description, price, stock, etc.).
        * Product image upload.
        * Product code generation and management.
    * Category Management:
        * Add, edit, and delete product categories.
    * Brand Management:
        * Add, edit, and delete product brands.
    * Sales Tracking:
        * View sales history with detailed information (date, time, products sold, total amount, payment method).
        * Generate sales reports (daily, weekly, monthly, custom date ranges).
        * Ability to export the sales reports to CSV or PDF format.
    * User Management (Optional):
        * Add, edit and delete POS users.
        * Assign roles and permissions to users.
* **Database:**
    * Use a relational database (e.g., MySQL) to store product, sales, and user data.

**Technical Requirements:**

* Use PHP for server-side logic.
* Employ a modern PHP framework (e.g., Laravel, Symfony, CodeIgniter) or follow a clean architecture if not using a framework.
* Utilize HTML, CSS, and JavaScript for the front-end interface, focusing on a rich UI/UX.
* Implement AJAX calls for a smooth user experience.
* Implement QR code generation using a suitable PHP library.
* Robust security measures to protect against SQL injection, cross-site scripting (XSS), and other vulnerabilities.
* Implement proper input validation and data sanitization.
* Implement clear error handling and logging.
* Use a version control system (e.g., Git).
* Responsive design for compatibility with various screen sizes.

**Specific Considerations:**

* Provide code examples for key functionalities, such as adding a product to the cart, generating a sales report, and adding a new product through the admin panel.
* Demonstrate database schema design and SQL queries for data retrieval and manipulation.
* Show examples of the UI/UX design, using HTML, CSS, and JavaScript.
* Highlight the QR code generation process and how it links to the sales receipt.
* Document the code with clear comments and explanations.
* Provide instructions on setting up and running the software.

