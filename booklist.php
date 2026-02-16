<?php
$title = "Books | BOOKHUB";
include("header.php");

// Fetch all books with categories
$allbooksquery = "SELECT * FROM `book` 
                  INNER JOIN `bookcategory` ON book.category_id = bookcategory.category_id";
$allbooksdata = mysqli_query($conn, $allbooksquery);

// Fetch unique categories and authors for filters
$categoryQuery = "SELECT DISTINCT category_name FROM bookcategory";
$categoryData = mysqli_query($conn, $categoryQuery);

$authorQuery = "SELECT DISTINCT book_author FROM book";
$authorData = mysqli_query($conn, $authorQuery);
?>

<div class="container-fluid">
  <div class="booklist-banner">
    <div class="booklist-banner-content">
      <h1>Your Library, Your Choice</h1>
      <p class="text-center">Our complete catalog is here — organize your reading experience your way</p>
    </div>
  </div>



  <div class="search-wrapper mb-3 position-relative">
    <span class="search-icon">
      <i class="fa-solid fa-magnifying-glass"></i>
    </span>
    <input type="text" id="search-input" class="form-control" placeholder="Search by title, author, or category">
  </div>


  <!-- Filters Row -->
  <div class="d-flex gap-2 mb-4">
    <select id="filter-category" class="form-select">
      <option value="">All Categories</option>
      <?php
      mysqli_data_seek($categoryData, 0); // reset pointer
      while ($cat = mysqli_fetch_assoc($categoryData)): ?>
        <option value="<?php echo strtolower($cat['category_name']); ?>"><?php echo $cat['category_name']; ?></option>
      <?php endwhile; ?>
    </select>

    <select id="filter-author" class="form-select">
      <option value="">All Authors</option>
      <?php while ($auth = mysqli_fetch_assoc($authorData)): ?>
        <option value="<?php echo strtolower($auth['book_author']); ?>"><?php echo $auth['book_author']; ?></option>
      <?php endwhile; ?>
    </select>

    <select id="filter-price" class="form-select">
      <option value="">All Prices</option>
      <option value="low">Low (0 - 500)</option>
      <option value="mid">Mid (500 - 1000)</option>
      <option value="high">High (1000+)</option>
    </select>

    <div class="col-md-3">
      <select id="filter-type" class="form-select">
        <option value="">All Books</option>
        <option value="free">Free Books</option>
      </select>
    </div>
  </div>
  <!-- Books Grid -->

  <div class="container-fluid my-5">
    <div class="row">
      <?php foreach ($allbooksdata as $book): ?>
        <div class="col-md-4 book-item" data-book-id="<?php echo $book['book_id']; ?>"
          data-title="<?php echo strtolower($book['book_title']); ?>"
          data-author="<?php echo strtolower($book['book_author']); ?>"
          data-category="<?php echo strtolower($book['category_name']); ?>" data-price="<?php echo $book['pdf_price']; ?>"
          data-type="<?php echo strtolower($book['pdf_type']); ?>">


          <div class="book-card2 mb-4">
            <div class="book-left my-5">
              <img src="./admin/bookimages/<?php echo $book['book_cover'] ?>" alt="Book Cover">
            </div>

            <div class="book-right mt-3">
              <h2 class="book-title2"><?php echo $book['book_title']; ?></h2>

              <p class="book-desc">
                <?php echo $book['short_description']; ?>
              </p>

              <div class="cat-rating">
                <p class="book-author2 my-2">
                  <span><?php echo $book['book_author']; ?></span>
                </p>
                <span class="category me-1"><?php echo $book['category_name']; ?></span>
              </div>

              <hr>
              <?php if (isset($_SESSION["username"])): ?>

                <div class="format-price d-flex gap-1">
                  <div class="price d-flex gap-2">
                    <span><i class="fa-regular fa-file-pdf"></i></span>
                    <?php if ($book['pdf_type'] == "free"): ?>
                      <p class="text-success">Free</p>
                    <?php else: ?>
                      <p>Rs.<?php echo $book['pdf_price']; ?></p>
                    <?php endif; ?>
                  </div>

                  <div class="price d-flex gap-2">
                    <span><i class="fa-solid fa-book"></i></span>
                    <p>Rs.<?php echo $book['hardcopy_price']; ?></p>
                  </div>

                  <div class="price d-flex gap-2">
                    <span><i class="fa-solid fa-compact-disc"></i></span>
                    <p>Rs.<?php echo $book['cd_price']; ?></p>
                  </div>
                </div>

                <div class="book-buttons">
                  <button class="btn-cart">
                    <span><i class="fa-solid fa-eye"></i></span>
                    <a href="booksdetailpages.php?id=<?php echo $book['book_id']; ?>">View Detail</a>
                  </button>

                  <div id="toast" class="custom-toast">This format is currently unavailable.</div>
                <?php else: ?>
                  <div class="format-price d-flex gap-1">
                    <div class="price d-flex gap-2">
                      <span><i class="fa-regular fa-file-pdf"></i></span>
                      <?php if ($book['pdf_type'] == "free"): ?>
                        <p class="text-success">Free</p>
                      <?php else: ?>
                        <p>Rs.<?php echo $book['pdf_price']; ?></p>
                      <?php endif; ?>
                    </div>

                    <div class="price d-flex gap-2">
                      <span><i class="fa-solid fa-book"></i></span>
                      <p>Rs.<?php echo $book['hardcopy_price']; ?></p>
                    </div>

                    <div class="price d-flex gap-2">
                      <span><i class="fa-solid fa-compact-disc"></i></span>
                      <p>Rs.<?php echo $book['cd_price']; ?></p>
                    </div>
                  </div>
                  <div class="book-buttons">
                    <button class="btn-cart">
                      <span><i class="fa-solid fa-eye"></i></span>
                      <a href="./auth/login.php">View Detail</a>
                    </button>


                  <?php endif; ?>
                </div>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>



  <?php include("footer.php"); ?>