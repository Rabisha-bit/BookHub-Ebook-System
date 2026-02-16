document.addEventListener("DOMContentLoaded", function() {
    const priceTags = document.querySelectorAll(".price-tag");
    const btnAction = document.getElementById("btnAction"); // Add to Cart button
    const toast = document.getElementById("toast"); // toast element
    const bookId = btnAction.dataset.bookId;

    // Default select PDF or first available format
    let defaultTag = Array.from(priceTags).find(tag => tag.dataset.format === "pdf" && tag.dataset.available==="1");
    if (!defaultTag) defaultTag = Array.from(priceTags).find(tag => tag.dataset.available==="1");

    selectFormat(defaultTag);

    priceTags.forEach(tag => {
        tag.addEventListener("click", function() {
            selectFormat(tag);

            // If unavailable → show toast
            if (tag.dataset.available === "0") {
                showToast("This format is currently unavailable.");
            }
        });
    });

    function selectFormat(tag) {
        const format = tag.dataset.format;
        const type = tag.dataset.type;
        const price = tag.dataset.price;
        const available = tag.dataset.available;

        // Remove active/tick from all
        priceTags.forEach(t => {
            t.classList.remove("active");
            const tick = t.querySelector(".tick");
            if (tick) tick.style.display = "none";
        });

        // Set active/tick on selected
        tag.classList.add("active");
        const tick = tag.querySelector(".tick");
        if (tick) tick.style.display = "inline";

        if (available === "0") {
            btnAction.classList.add("disabled");
            btnAction.innerHTML = '<i class="fa-solid fa-ban"></i> Unavailable';
            btnAction.removeAttribute("data-format");
            return;
        }

        btnAction.classList.remove("disabled");
        btnAction.dataset.format = format; // store selected format
        btnAction.dataset.price = price;   // store selected price

        if (format === "pdf" && type === "free") {
            btnAction.href = "admin/pdf/book.pdf";
            btnAction.innerHTML = '<i class="fa-solid fa-download"></i> Download PDF';
            btnAction.removeEventListener("click", addToCartHandler); // remove Add to Cart for free PDF
        } else {
            btnAction.href = "#"; // prevent default link
            btnAction.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> Add to Cart';
            btnAction.addEventListener("click", addToCartHandler); // enable Add to Cart
        }
    }

    function addToCartHandler(e) {
        e.preventDefault();
        const format = btnAction.dataset.format;
        const price = btnAction.dataset.price;

        // AJAX request to add-to-cart.php
        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `book_id=${bookId}&format=${format}&price=${price}`
        })
        .then(res => res.text())
        .then(res => {
            showToast("Book added to cart!");
            // Optionally redirect to cart page
            // window.location.href = "cart.php";
        })
        .catch(err => showToast("Failed to add to cart."));
    }

    function showToast(message) {
        if (!toast) return;
        toast.innerText = message;
        toast.classList.add("show");
        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000); // hide after 3 seconds
    }
});


document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const filterCategory = document.getElementById("filter-category");
  const filterAuthor = document.getElementById("filter-author");
  const filterPrice = document.getElementById("filter-price");
  const filterType = document.getElementById("filter-type");

  const books = document.querySelectorAll(".book-item");

  function applyFilters() {
    const searchText = searchInput.value.toLowerCase();
    const categoryValue = filterCategory.value.toLowerCase();
    const authorValue = filterAuthor.value.toLowerCase();
    const priceValue = filterPrice.value;
    const typeValue = filterType.value.toLowerCase();

    books.forEach((book) => {
      const title = book.dataset.title.toLowerCase();
      const author = book.dataset.author.toLowerCase();
      const category = book.dataset.category.toLowerCase();
      const price = parseInt(book.dataset.price);
      const pdfType = book.dataset.type.toLowerCase();

      let show = true;

      // SEARCH FILTER – fixed!
      if (
        searchText &&
        !title.includes(searchText) &&
        !author.includes(searchText) &&
        !category.includes(searchText)
      ) {
        show = false;
      }

      // CATEGORY
      if (categoryValue && category !== categoryValue) {
        show = false;
      }

      // AUTHOR
      if (authorValue && author !== authorValue) {
        show = false;
      }

      // PRICE FILTER
      let priceMatch = false;

      if (priceValue === "") priceMatch = true;
      else if (priceValue === "low") priceMatch = price >= 0 && price <= 500;
      else if (priceValue === "mid") priceMatch = price >= 500 && price <= 1000;
      else if (priceValue === "high") priceMatch = price > 1000;

      if (!priceMatch) show = false;

      // TYPE (Free only)
      if (typeValue === "free" && pdfType !== "free") {
        show = false;
      }

      book.style.display = show ? "block" : "none";
    });
  }

  searchInput.addEventListener("input", applyFilters);
  filterCategory.addEventListener("change", applyFilters);
  filterAuthor.addEventListener("change", applyFilters);
  filterPrice.addEventListener("change", applyFilters);
  filterType.addEventListener("change", applyFilters);
});

// booklist filters js
document.querySelectorAll(".book-item").forEach((card) => {
  const priceTags = card.querySelectorAll(".price-tag");
  const buyBtn = card.querySelector(".btn-buy a");

  if (!priceTags.length || !buyBtn) return;

  buyBtn.innerText = "Select Format";

  priceTags.forEach((tag) => {
    tag.addEventListener("click", function () {
      // Remove active from all tags inside this card
      priceTags.forEach((t) => t.classList.remove("active"));
      this.classList.add("active");

      const format = this.dataset.format;
      const type = this.dataset.type || ""; // free / paid / undefined
      const priceText = this.innerText.trim();

      // =============================
      // 🚫 UNAVAILABLE FORMAT
      // =============================
      if (this.classList.contains("unavailable")) {
        buyBtn.innerText = "Unavailable";
        buyBtn.style.pointerEvents = "none";
        buyBtn.style.opacity = "0.5";
        return;
      }

      // Enable again
      buyBtn.style.pointerEvents = "auto";
      buyBtn.style.opacity = "1";

      // =============================
      // 📥 FREE PDF  → Download
      // =============================
      if (format === "pdf" && type === "free") {
        let pdfLink = this.dataset.pdfUrl;

        buyBtn.innerHTML = `<i class="fa-solid fa-download"></i> PDF`;
        buyBtn.setAttribute("href", pdfLink);
        buyBtn.setAttribute("download", "");
        return;
      }

      // =============================
      // 💰 PAID PDF / HARDCOPY / CD
      // =============================
      let price = priceText.replace("Rs.", "").trim();
      buyBtn.innerHTML = `<i class="fa-solid fa-bag-shopping"></i>  Rs.${price}`;
      buyBtn.removeAttribute("download");
      // =============================
      // 🛒 ADD TO CART
      // =============================
      buyBtn.onclick = function (e) {
        e.preventDefault();

        const bookId = card.dataset.bookId;
        const format = card.querySelector(".price-tag.active").dataset.format;
        const priceText = card
          .querySelector(".price-tag.active")
          .innerText.trim();
        const price = parseFloat(priceText.replace("Rs.", ""));

        // Check if format is selected
        if (!format) {
          alert("Please select a format!");
          return;
        }

        fetch("order.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `bookId=${bookId}&format=${format}&price=${price}`,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              alert(data.message);
              // Optional: redirect to cart
              window.location.href = "cart.php";
            } else {
              alert(data.error || "Something went wrong");
            }
          });
      };
    });
  });
});

// booklist format selection toast alert js
function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
  }, 2500);
}

document.querySelectorAll(".price-tag.unavailable").forEach((tag) => {
  tag.addEventListener("click", function () {
    showToast("This format is currently unavailable.");
  });
});
// end of booklist format selection toast alert js
