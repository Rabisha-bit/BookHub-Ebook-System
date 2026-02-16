<?php

include("includes/header.php");

if(isset($_POST["btncategory"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to add category
    $category_name = $_POST["category_name"];
    
    
     $query = "INSERT INTO bookcategory(category_name) VALUES ('$category_name')";
     $result=mysqli_query($conn, $query);
     if($result){
        echo "<script>alert('Category added successfully');
        window.location.href='allbookcategories.php';
        </script>";
     } else {
        echo "<script>alert('Error adding category');</script>";
     }
}


?>


<div class="container-fluid">

<!-- Category Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h1 class="m-0 text-center font-weight-bold text-gray">Add / Manage Book Categories</h1>
    </div>

    <div class="card-body">

        <!-- Add Category Form -->
        <form  method="POST" class="mb-4">
            
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-secondary btn-block" name="btncategory">Add Category</button>
        </form>

</div>

<?php include("includes/footer.php"); ?>