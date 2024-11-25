<?php
require "header.php";

// Set the number of results per page
$results_per_page = 5;

// Get the current page number from the URL, default is 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page-1) * $results_per_page;

// Get the search term if it exists
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the query to handle search terms
if ($search_term) {
    $qry = "SELECT * FROM `blog` WHERE `blog_head` LIKE '%$search_term%' OR `blog_text` LIKE '%$search_term%' LIMIT $start_from, $results_per_page";
    $total_qry = "SELECT COUNT(*) AS total FROM `blog` WHERE `blog_head` LIKE '%$search_term%' OR `blog_text` LIKE '%$search_term%'";
} else {
    $qry = "SELECT * FROM `blog` LIMIT $start_from, $results_per_page";
    $total_qry = "SELECT COUNT(*) AS total FROM `blog`";
}

$res = mysqli_query($conn, $qry);
$total_res = mysqli_query($conn, $total_qry);
$total_row = mysqli_fetch_assoc($total_res);
$total_pages = ceil($total_row['total'] / $results_per_page);
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Blog</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Blog</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="search-container">
            <form method="GET" action="" class="search-box">
                <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="row">
            <?php 
            while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <div class="col-md-6 mb-4 pb-2">
                <a href="blog-detail.php?id=<?php echo $row['blog_id']?>" class="blog-item-link">
                    <div class="blog-item">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="../admin/<?php echo $row['blog_img'] ?>" alt="" style="height: 300px; width:400px">
                            <div class="blog-date">
                                <h6 class="font-weight-bold mb-n1"><?php echo $row['blog_date'] ?></h6>
                                <small class="text-white text-uppercase"><?php echo $row['blog_month'] ?></small>
                            </div>
                        </div>
                        <div class="bg-white p-4">
                            <div class="d-flex mb-2">
                                <span class="text-primary text-uppercase text-decoration-none"><?php echo $row['blog_head'] ?></span>
                            </div>
                            <a class="h5 m-0 text-decoration-none"><?php echo $row['blog_text'] ?></a>
                        </div>
                    </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>

        <!-- Pagination -->
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo $search_term; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search_term; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo $search_term; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- Blog End -->

<?php
require "footer.php";
?>

<!-- Embedded CSS for Animations -->
<style>
/* CSS for fade-in effect */
.blog-item {
    opacity: 0;
    animation: fadeIn 1s forwards;
}

/* Keyframes for fade-in animation */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* CSS for zoom-in effect on hover */
.blog-item:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Ensure that images inside blog-item are responsive */
.blog-item img {
    width: 100%;
    height: auto;
}

/* Styling for the clickable blog-item link */
.blog-item-link {
    text-decoration: none;
    color: inherit;
}
</style>
