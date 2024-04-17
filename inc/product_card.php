<?php
foreach ($filteredProducts as $product) {
    echo '<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">';
    echo '<a class="product-item mb-3" href="product.html">';
    echo '<img src="../images/product-1.png"  class="img-fluid product-thumbnail">';
    echo '<h3 class="product-title">' . $product['product_name'] . '</h3>';
    echo '<strong class="product-price">$' . $product['price'] . '</strong>';
    echo '</a>';
    echo '<form method="post" class="quantity-form" id="form_' . $product['product_id'] . '">';
    echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
    echo '<div class="product-home text-center mb-5">';
    echo '<div style="display: inline-block;">';
    echo '<select class="mb-3 form-select" aria-label="Default select example" name="selected_quantity">';
    for ($i = 1; $i <= $product['quantity']; $i++) {
        echo '<option value="' . $i . '">' . $i . '</option>';
    }
    echo '</select>';
    echo '<button class="btn btn-secondary mb-4" type="submit" name="add_to_cart">Add to Cart</button>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}
?>
