<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>SERENDIB international</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">

    <!-- Vendor CSS from old header -->
    <link rel="stylesheet" href="assets_2/css/vendor/bootstrap.min.css">

    <!-- New header-related CSS -->
    <link rel="stylesheet" href="newAssets/css/style.css">
    <link rel="stylesheet" href="newAssets/css/header.css">
    <link rel="stylesheet" href="newAssets/css/button.css">
    <link rel="stylesheet" href="newAssets/css/footer.css">
    <link rel="stylesheet" href="newAssets/css/cart-drawer.css">
    <link rel="stylesheet" href="newAssets/css/serendib-hero.css">
    <link rel="stylesheet" href="newAssets/css/custom-home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="main-header" id="mainHeader">
        <!-- Top Banner Bar -->
        <!-- <div class="header-top">
            <div class="container">
                <div class="header-contact">
                    <span><i class="fas fa-phone"></i> <span class="contact-text">+94 123 456 789</span></span>
                    <span><i class="fas fa-envelope"></i> <span class="contact-text">info@storyclothing.com</span></span>
                </div>
                <div class="promo-text">
                    <i class="fas fa-gift"></i>
                    <span>Free Shipping on Orders Over $50!</span>
                </div>
                <div class="header-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div> -->

        <!-- Main Navigation -->
        <nav class="main-nav">
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php">
                            <img src="assets/img/favicon.png" alt="Admin" style="width:70px; vertical-align:middle; margin-right:10px;">
                            <div class="logo-text">
                                <h1>SERENDIB</h1>
                                <span class="logo-tagline"> SCHOOL</span>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="nav-links" id="navLinks">
                        <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><span>Home</span></a>
                        <a href="aboutUs.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'aboutUs.php' ? 'active' : ''; ?>"><span>About</span></a>
                        <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><span>Contact Us</span></a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="nav-actions">
                        <!-- <button class="icon-btn search-btn" aria-label="Search"><i class="fas fa-search"></i></button>
                        <a href="#" class="icon-btn cart-btn" aria-label="Shopping Cart"><i class="fas fa-shopping-cart"></i><span class="badge pulse">3</span></a> -->
                        <!-- <a href="#" class="icon-btn wishlist-btn" aria-label="Wishlist"><i class="fas fa-heart"></i><span class="badge">5</span></a> -->

                        <!-- User Profile Dropdown (Show when logged in) -->
                        
                            <a href="login.php" class="login-btn"><i class="fas fa-user"></i><span>Login</span></a>
                  
                    </div>

                    <!-- Mobile Toggle -->
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <div class="mobile-logo">
            <i class="fas fa-tshirt"></i>
            <span>SERENDIB</span>
        </div>
        <button class="mobile-close" id="mobileClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Mobile User Info (Show when logged in) -->
    <?php if ($isLoggedIn): ?>
        <div class="mobile-user-info">
            <div class="mobile-user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="mobile-user-details">
                <h4><?php echo $userName; ?></h4>
                <p>arun@example.com</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="mobile-menu-content">
        <a href="index.php" 
           class="mobile-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i><span>Home</span>
        </a>

        <a href="aboutUs.php" 
           class="mobile-link <?php echo basename($_SERVER['PHP_SELF']) == 'aboutUs.php' ? 'active' : ''; ?>">
            <i class="fas fa-calendar-alt"></i><span>About</span>
        </a>

        <a href="contact.php" 
           class="mobile-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i><span>Contact</span>
        </a>

        <!-- Login/Logout moved directly under Contact -->
        <?php if ($isLoggedIn): ?>
            <a href="logout.php" class="mobile-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        <?php else: ?>
            <a href="login.php" class="mobile-login-btn">
                <i class="fas fa-user"></i>
                <span>Login / Register</span>
            </a>
        <?php endif; ?>

    </div>
</div>


        <!-- Cart Overlay -->
        <div class="cart-overlay" id="cartOverlay"></div>

        <!-- Cart Drawer -->
        <div class="cart-drawer" id="cartDrawer">
            <!-- Cart Header -->
            <div class="cart-header">
                <div class="cart-title">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>My Cart</h2>
                    <span class="cart-count" id="cartItemCount">3</span>
                </div>
                <button class="cart-close" id="cartClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Cart Content -->
            <div class="cart-content" id="cartContent">
                <!-- Cart Items (Dynamic) -->
                <div class="cart-items" id="cartItems">
                    <!-- Sample Cart Item 1 -->
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/product/product-01.jpg" alt="Product">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">Premium Cotton T-Shirt</h3>
                            <div class="item-attributes">
                                <span class="item-attribute">
                                    <i class="fas fa-palette"></i> Blue
                                </span>
                                <span class="item-attribute">
                                    <i class="fas fa-ruler"></i> Large
                                </span>
                            </div>
                            <div class="item-price-row">
                                <span class="item-price">$29.99</span>
                                <div class="quantity-controls">
                                    <button class="qty-btn qty-decrease">−</button>
                                    <span class="qty-value">1</span>
                                    <button class="qty-btn qty-increase">+</button>
                                </div>
                            </div>
                        </div>
                        <button class="remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <!-- Sample Cart Item 2 -->
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/product/product-02.jpg" alt="Product">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">Slim Fit Jeans</h3>
                            <div class="item-attributes">
                                <span class="item-attribute">
                                    <i class="fas fa-palette"></i> Dark Blue
                                </span>
                                <span class="item-attribute">
                                    <i class="fas fa-ruler"></i> 32
                                </span>
                            </div>
                            <div class="item-price-row">
                                <span class="item-price">$49.99</span>
                                <div class="quantity-controls">
                                    <button class="qty-btn qty-decrease">−</button>
                                    <span class="qty-value">2</span>
                                    <button class="qty-btn qty-increase">+</button>
                                </div>
                            </div>
                        </div>
                        <button class="remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <!-- Sample Cart Item 3 -->
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="assets/images/product/product-03.jpg" alt="Product">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">Classic Hoodie</h3>
                            <div class="item-attributes">
                                <span class="item-attribute">
                                    <i class="fas fa-palette"></i> Black
                                </span>
                                <span class="item-attribute">
                                    <i class="fas fa-ruler"></i> Medium
                                </span>
                            </div>
                            <div class="item-price-row">
                                <span class="item-price">$39.99</span>
                                <div class="quantity-controls">
                                    <button class="qty-btn qty-decrease">−</button>
                                    <span class="qty-value">1</span>
                                    <button class="qty-btn qty-increase">+</button>
                                </div>
                            </div>
                        </div>
                        <button class="remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Empty Cart State (Hidden by default) -->
                <div class="cart-empty" id="cartEmpty" style="display: none;">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>Add some items to get started</p>
                    <a href="shop.php" class="shop-now-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Shop Now</span>
                    </a>
                </div>
            </div>

            <!-- Cart Footer -->
            <div class="cart-footer">
                <div class="cart-summary">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="cartSubtotal">$119.97</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value" id="cartShipping">Free</span>
                    </div>
                    <div class="summary-row total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="cartTotal">$119.97</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <button class="checkout-btn" onclick="window.location.href='checkout.php'">
                        <i class="fas fa-lock"></i>
                        <span>Proceed to Checkout</span>
                    </button>
                    <a href="profile.php?view=cart" class="view-cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span>View Full Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ======== SCRIPTS FOR NEW HEADER ======== -->
    <script>
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 100) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        });

        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileClose = document.getElementById('mobileClose');
        const body = document.body;

        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            body.style.overflow = 'hidden';
        });

        mobileClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            body.style.overflow = '';
        });

        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                mobileMenu.classList.remove('active');
                body.style.overflow = '';
            }
        });

        // UPDATED: Search Button - Redirect to Shop Page
        document.querySelector('.search-btn').addEventListener('click', () => {
            // Store trigger in sessionStorage
            sessionStorage.setItem('shopSearchTrigger', 'true');
            // Redirect to shop page
            window.location.href = 'shop.php';
        });

        // User Dropdown Toggle
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdownBtn && userDropdownMenu) {
            userDropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userDropdownBtn.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.remove('active');
                }
            });

            // Prevent dropdown from closing when clicking inside
            userDropdownMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
    </script>

    <script>
        // Cart Drawer Elements
        const cartBtn = document.querySelector('.cart-btn');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartDrawer = document.getElementById('cartDrawer');
        const cartClose = document.getElementById('cartClose');

        // Open Cart Drawer
        cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openCart();
        });

        // Close Cart Drawer - Close Button
        cartClose.addEventListener('click', () => {
            closeCart();
        });

        // Close Cart Drawer - Overlay Click
        cartOverlay.addEventListener('click', () => {
            closeCart();
        });

        // Open Cart Function
        function openCart() {
            cartOverlay.classList.add('active');
            cartDrawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close Cart Function
        function closeCart() {
            cartOverlay.classList.remove('active');
            cartDrawer.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Quantity Controls
        document.addEventListener('click', (e) => {
            // Increase Quantity
            if (e.target.classList.contains('qty-increase') || e.target.parentElement.classList.contains('qty-increase')) {
                const button = e.target.classList.contains('qty-increase') ? e.target : e.target.parentElement;
                const qtyValue = button.previousElementSibling;
                let currentQty = parseInt(qtyValue.textContent);
                qtyValue.textContent = currentQty + 1;
                updateCartTotals();
            }

            // Decrease Quantity
            if (e.target.classList.contains('qty-decrease') || e.target.parentElement.classList.contains('qty-decrease')) {
                const button = e.target.classList.contains('qty-decrease') ? e.target : e.target.parentElement;
                const qtyValue = button.nextElementSibling;
                let currentQty = parseInt(qtyValue.textContent);
                if (currentQty > 1) {
                    qtyValue.textContent = currentQty - 1;
                    updateCartTotals();
                }
            }

            // Remove Item
            if (e.target.classList.contains('remove-item') || e.target.parentElement.classList.contains('remove-item')) {
                const button = e.target.classList.contains('remove-item') ? e.target : e.target.parentElement;
                const cartItem = button.closest('.cart-item');

                // Confirmation dialog
                Swal.fire({
                    title: 'Remove Item?',
                    text: 'Are you sure you want to remove this item from your cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6abeb6',
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cartItem.style.animation = 'slideOutRight 0.3s ease forwards';
                        setTimeout(() => {
                            cartItem.remove();
                            updateCartTotals();
                            checkEmptyCart();
                            Swal.fire({
                                title: 'Removed!',
                                text: 'Item has been removed from your cart.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }, 300);
                    }
                });
            }
        });

        // Update Cart Totals
        function updateCartTotals() {
            const cartItems = document.querySelectorAll('.cart-item');
            let subtotal = 0;
            let totalItems = 0;

            cartItems.forEach(item => {
                const price = parseFloat(item.querySelector('.item-price').textContent.replace('$', ''));
                const quantity = parseInt(item.querySelector('.qty-value').textContent);
                subtotal += price * quantity;
                totalItems += quantity;
            });

            // Update UI
            document.getElementById('cartSubtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('cartTotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('cartItemCount').textContent = totalItems;

            // Update badge on cart button
            const cartBadge = document.querySelector('.cart-btn .badge');
            if (cartBadge) {
                cartBadge.textContent = totalItems;
            }
        }

        // Check if Cart is Empty
        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartItemsContainer = document.getElementById('cartItems');

            if (cartItems.length === 0) {
                cartItemsContainer.style.display = 'none';
                cartEmpty.style.display = 'flex';
                document.querySelector('.cart-footer').style.display = 'none';
            }
        }

        // Slide Out Animation
        const style = document.createElement('style');
        style.textContent = `
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
        document.head.appendChild(style);

        // Prevent body scroll when cart is open
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && cartDrawer.classList.contains('active')) {
                closeCart();
            }
        });
    </script>