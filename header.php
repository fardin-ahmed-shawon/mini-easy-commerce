<!--==================================-->
<!--========== START NAVBAR ==========-->
<!--==================================-->
<nav id="home">
    <div class="container">
        <!-- Middle -->
        <div class="inner">
            <!-- Mobile Menu Button -->
            <div class="mobile-menu" id="mobile-menu-btn">
                <a href="#" onclick="openMenuBtn()">
                    <i class="ri-menu-2-line"></i>
                </a>
            </div>

            <div class="logo">
                <a href="index.php"><span>
                    <?php include 'logo.php'; ?>
                </span></a>
            </div>

            <div class="search-area">
                <div class="search-row dropdown">
                    <i class="ri-search-line"></i>
                    <input id="input-box" type="text" autofocus required placeholder="Search Your Product Here" autocomplete="off">
                    <div class="search-suggestions">
                        <!-- Suggested Product List -->
                    </div>
                </div>
                <div class="mobile-search-area">
                    <i class="ri-search-line search-icon"></i>
                    <i class="ri-close-fill search-close-icon"></i>
                </div>
            </div>

            <div class="btn-area">

                <div class="call">
                    <i class="ri-whatsapp-line"></i>
                    <div class="txt-area">
                        <p class="bold-title">Online Shopping</p>
                        <p class="gray-title">019XXXXX</p>
                    </div>
                </div>

                <div class="cart-btn">
                    
                    <div class="cart-container">
                        <div onclick="openCartBar()" class="cart-icon"><i class="ri-shopping-cart-2-line"></i></div>
                        <div class="cart-counter top-cart-counter">0</div>
                    </div>
                    
                    <!-- <div class="txt-area">
                        <p class="bold-title">Cart</p>
                        <p class="gray-title"><span class="top-total-price">Tk 0.00</span></p>
                    </div> -->
                </div>

                <div class="login-btn" onclick="window.location.href='registration.php'">
                    <i class="ri-user-line"></i>
                    <div class="txt-area">
                        <p class="bold-title">Account</p>
                        <p class="gray-title">Login/Signup</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="pages" id="pages">
            <div>
                <div class="hide-menu" id="mobile-menu-btn">
                    <br>
                    <div class="close-mobile-menu-btn">
                        <a href="#" onclick="closeMenuBtn()">
                            <i class="ri-menu-3-line"></i>
                        </a>
                    </div>

                    <!-- Logo -->
                    <div>
                    <?php include 'logo.php'; ?>
                    </div> 
                    
                </div>
                <hr>
                <ul style="font-weight: 500;">
                    <li style="padding: 20px;"><a href="index.php">Home</a></li>
                    <li style="padding: 20px;"><a href="shop.php">Shop</a></li>
                    <?php
                        include 'database/dbConnection.php';

                        // Fetch main categories
                        $mainCategoriesSql = "SELECT * FROM main_category";
                        $mainCategoriesResult = $conn->query($mainCategoriesSql);

                        if ($mainCategoriesResult->num_rows > 0) {
                            $index = 0;
                            while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
                                $index++;
                                $mainCtgName = $mainCategory['main_ctg_name'];

                                // Prepare statement for subcategories
                                $subCategoriesStmt = $conn->prepare("SELECT * FROM sub_category WHERE main_ctg_name = ?");
                                $subCategoriesStmt->bind_param("s", $mainCtgName);
                                $subCategoriesStmt->execute();
                                $subCategoriesResult = $subCategoriesStmt->get_result();
                                if ($subCategoriesResult->num_rows <= 0) {
                                    ?>
                                        <li style="padding: 20px;"><a href="category.php?main_ctg_id=<?php echo $mainCategory['main_ctg_id']; ?>"><?php echo $mainCtgName; ?></a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li style="padding: 20px;">
                                        <div class="dropdown">
                                            
                                            <button style="font-weight: 500;" onclick="dropdownBtn(<?php echo $index; ?>)" class="dropdown-btn"><?php echo $mainCtgName; ?><i class="ri-arrow-down-s-line"></i></button>
                                        
                                            <div class="content content<?php echo $index; ?>">
                                                <?php
                                                    while ($subCategory = $subCategoriesResult->fetch_assoc()) {
                                                        echo '<a href="subCategory.php?sub_ctg_id=' . $subCategory['sub_ctg_id'] . '">' . $subCategory['sub_ctg_name'] . '</a>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                                }
                                $subCategoriesStmt->close();
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <!-- Search Bar For Mobile -->
        <div class="mobile-search-box">
            <input id="input-box-mobile" type="text" autofocus required placeholder="Search Your Product Here" autocomplete="off">
            <div class="search-suggestions-mobile">
                <!-- Suggested Product List -->
            </div>
        </div>
    </div>
</nav>
<!--==================================-->
<!--============ END NAVBAR ==========-->
<!--==================================-->