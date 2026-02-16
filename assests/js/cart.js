document.getElementById("btnOrder").addEventListener("click", function (e) {
    e.preventDefault();

    let bookId = this.dataset.bookId;
    let title = this.dataset.title;
    let price = this.dataset.price;
    let format = this.dataset.format;
    let image = this.dataset.image;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `bookId=${bookId}&title=${title}&price=${price}&format=${format}&image=${image}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            window.location.href = "cart.php"; // redirect to cart
        }
    });
});
document.querySelectorAll(".delete-item").forEach(btn => {
    btn.addEventListener("click", function(){
        let id = this.dataset.id;

        fetch("delete_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded"},
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                location.reload();
            }
        });
    });
});
document.querySelectorAll(".qty-btn").forEach(btn => {
    btn.addEventListener("click", function(){
        let id = this.dataset.id;
        let action = this.classList.contains("plus") ? "plus" : "minus";

        fetch("update_qty.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded"},
            body: `id=${id}&action=${action}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                location.reload();
            }
        });
    });
});
