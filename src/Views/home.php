<?php
$title = 'Thế giới điện thoại - Home Page';
ob_start();
?>

<!-- thêm top_nav.php -->
<?php include 'top_nav.php'; ?>
<!-- thêm header.html -->
<?php include 'header.php'; ?>
<!-- thêm banner -->
<?php include 'banner.php'; ?>
<!-- thêm filter -->
<?php include 'filter.php'; ?>

<script>
    // Load brands when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadBrands();
    });

    // Function to load brands
    async function loadBrands() {
        try {
            const response = await fetch('/api/brands');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            console.log('Brands data:', result); // Debug log
            
            if (result.status === 'success' && Array.isArray(result.data)) {
                const companyMenu = document.querySelector('.companyMenu');
                result.data.forEach(function(brand) {
                    let img = document.createElement('img');
                    img.src = brand.image_url;
                    img.alt = brand.name;
                    img.title = brand.name;
                    
                    // Add click event listener
                    img.addEventListener('click', function() {
                        displayProducts(brand.name);
                    });
                    
                    companyMenu.appendChild(img);
                });
            } else {
                console.error('Invalid brands data:', result);
            }
        } catch (error) {
            console.error('Error loading brands:', error);
        }
    }
</script>

<!-- thêm contain_product -->
<?php include 'contain_product.php'; ?>
<!-- thêm footer -->
<?php include 'footer.php'; ?>

<?php
$content = ob_get_clean();
include 'base.php';
?>
