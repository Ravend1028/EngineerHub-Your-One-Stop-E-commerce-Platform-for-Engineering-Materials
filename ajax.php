<?php
  // Create connection
  $conn = new mysqli('localhost', 'raven', '123456', 'engineerhub');

  // Check connection
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  // Check if a search query parameter is provided
  if (isset($_GET['search'])) {
      $search = $_GET['search'];
      // Define SQL query with search condition
      $sql = "SELECT * FROM products WHERE prod_name LIKE '%$search%'";
  } else {
      // Define SQL query to fetch all products
      $sql = 'SELECT * FROM products LIMIT 11';
  }
  // Execute the SQL query
  $result = mysqli_query($conn, $sql);
  // Fetch all products based on the query result
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (empty($products)) {
    echo "<p class='mt-3'>No items found matching your search criteria.</p>";
  }
?>

  <div id="products-container" class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
      <?php
      // Function to display products
      function displayProducts($products) {
        foreach ($products as $product):
      ?>

      <div class="col">
        <div class="card my-3" style="height: 95%;" data-product-id="<?php echo $product['id']; ?>">
          <?php
            // Check if product image is availables
            if (!empty($product['prod_img'])) {
              // Convert BLOB data to base64 format
              $imgData = base64_encode($product['prod_img']);
              // Format the image source
              $imgSrc = 'data:image/jpeg;base64,'.$imgData; // Change 'jpeg' based on your image type
            } else {
              // If no image is available, use a placeholder
              $imgSrc = 'placeholder.jpg'; // Change to your placeholder image path
            }
          ?>
          <img src="<?php echo $imgSrc; ?>" class="card-img-top" style="height: 200px;" alt="">
          <div class="card-body text-center">
            <?php echo $product['prod_name']; ?>
            <div class="text-secondary mt-2">Price: <?php echo $product['prod_price']; ?></div>
            <button class="add-to-cart btn btn-dark mt-2">Add to Cart</button>
          </div>
        </div>
      </div>

      <?php
        endforeach;
      }
      displayProducts($products);
      ?>
    </div>

    <?php 
      if (isset($_GET['search'])) {
        if(empty($_GET['search'])) {
          echo '
          <div class="container d-flex justify-content-end mb-3">
            <button class="btn btn-dark btn-md">Next &gt;&gt;</button>
          </div>';
        } else {
          echo '<hr>';
        }
        
      } else {
        echo '
        <div class="container d-flex justify-content-end mb-3">
          <button class="btn btn-dark btn-md">Next &gt;&gt;</button>
        </div>';
      } 
    ?>
  </div>

<script src="scripts/cart_action.js"></script>