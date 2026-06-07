<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "database.php";

$user_id = $_SESSION['user_id'];
$user = null;
$profile_photo = $_SESSION['profile_photo'] ?? '';
$profile_bio = $_SESSION['profile_bio'] ?? '';
$profile_birth_place = $_SESSION['profile_birth_place'] ?? '';
$profile_birth_date = $_SESSION['profile_birth_date'] ?? '';

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if ($user_query) {
    $user = mysqli_fetch_assoc($user_query);
}

$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Pagination config
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Total items count query
$countSql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
if ($category) {
    $countSql .= " AND category='" . mysqli_real_escape_string($conn, $category) . "'";
}
if ($search) {
    $searchValue = mysqli_real_escape_string($conn, $search);
    $countSql .= " AND (name LIKE '%$searchValue%' OR description LIKE '%$searchValue%')";
}
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$totalPages = ceil($total / $limit);

// Paginated query
$sql = "SELECT * FROM products WHERE 1=1";
if ($category) {
    $sql .= " AND category='" . mysqli_real_escape_string($conn, $category) . "'";
}
if ($search) {
    $searchValue = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (name LIKE '%$searchValue%' OR description LIKE '%$searchValue%')";
}
$sql .= " ORDER BY id DESC LIMIT $offset, $limit";
$data = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Raya</title>
    <link rel="stylesheet" href="style.css?v=10">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>RAYA</h2>
    <div class="menu">
        <a href="dashboard_customer.php" class="<?= !$category ? 'active' : '' ?>">All Product</a>
        <a href="dashboard_customer.php?category=digital#products" class="<?= $category == 'digital' ? 'active' : '' ?>">Digital Product</a>
        <a href="dashboard_customer.php?category=course#products" class="<?= $category == 'course' ? 'active' : '' ?>">Course</a>
        <a href="dashboard_customer.php?category=setup#products" class="<?= $category == 'setup' ? 'active' : '' ?>">Setup</a>
        <a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>">Profil</a>
        <a href="logout.php" onclick="triggerLogout(event)" style="color: #ff4d4d; font-weight: bold;">Logout</a>
    </div>
    <a href="profile.php" class="profile" title="Profil" style="display:inline-block">
        <?php if ($profile_photo): ?>
            <img src="assets/uploads/<?= htmlspecialchars($profile_photo) ?>" alt="Profile" style="width:100%; height:100%; border-radius:50%; object-fit:cover; display:block;">
        <?php else: ?>
            👤
        <?php endif; ?>
    </a>
</div>

<!-- STATS -->
<div class="stats">
    <div>237<br>Account</div>
    <div>5<br>Years</div>
    <div>150<br>Product</div>
    <div>527<br>Visitor</div>
</div>

<!-- PRODUCTS -->
<div class="products" id="products">
    <h2>Our Product</h2>
    <div style="margin-bottom: 30px; display: flex; justify-content: center;">
    <form action="dashboard_customer.php#products" method="GET" style="width: 100%; max-width: 500px; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Cari overlay, course, atau teknisi..." 
               value="<?= htmlspecialchars($search) ?>"
               style="flex: 1; padding: 12px 20px; border-radius: 30px; border: 2px solid #9d4edd; outline: none;">
        <button type="submit" style="padding: 10px 25px; background: #9d4edd; color: white; border: none; border-radius: 30px; cursor: pointer; font-weight: bold;">
            Cari
        </button>
    </form>
</div>

    <!-- FILTER -->
    <div class="filter">
        <a href="dashboard_customer.php" class="<?= !$category ? 'active' : '' ?>">All</a>
        <a href="dashboard_customer.php?category=course" class="<?= $category=='course' ? 'active' : '' ?>">Course</a>
        <a href="dashboard_customer.php?category=digital" class="<?= $category=='digital' ? 'active' : '' ?>">Digital</a>
        <a href="dashboard_customer.php?category=setup" class="<?= $category=='setup' ? 'active' : '' ?>">Setup</a>
    </div>

    <div class="product-list">

       <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <div class="card" data-category="<?= htmlspecialchars($row['category']) ?>">
                
                <?php if (!empty($row['image'])): ?>
                    <img src="assets/uploads/<?= htmlspecialchars($row['image']) ?>" alt="Product" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;">
                <?php else: ?>
                    <img src="assets/lucu.jpg" alt="Default" style="width: 100%; height: 160px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;">
                <?php endif; ?>

                <h3><?= $row['name']; ?></h3>
                <p>Kategori: <?= $row['category']; ?></p>
                <p>Rp <?= $row['price']; ?></p>

            <a href="detail_product.php?id=<?= $row['id']; ?>">
                <button>Beli</button>
            </a>
            </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <?php if ($page <= 1): ?>
                        <span>&lsaquo;</span>
                    <?php else: ?>
                        <a class="page-link" href="?page=<?= $page - 1 ?><?= $category ? '&category='.urlencode($category) : '' ?><?= $search ? '&search='.urlencode($search) : '' ?>#products">&lsaquo;</a>
                    <?php endif; ?>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= $category ? '&category='.urlencode($category) : '' ?><?= $search ? '&search='.urlencode($search) : '' ?>#products"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <?php if ($page >= $totalPages): ?>
                        <span>&rsaquo;</span>
                    <?php else: ?>
                        <a class="page-link" href="?page=<?= $page + 1 ?><?= $category ? '&category='.urlencode($category) : '' ?><?= $search ? '&search='.urlencode($search) : '' ?>#products">&rsaquo;</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<script>
// Scroll-spy: detect most visible category and mark menu link active
function updateActiveCategory() {
    const cards = document.querySelectorAll('.card');
    const counts = {};
    const vh = window.innerHeight || document.documentElement.clientHeight;

    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const visible = Math.max(0, Math.min(rect.bottom, vh) - Math.max(rect.top, 0));
        if (visible > 0) {
            const cat = card.getAttribute('data-category') || 'all';
            counts[cat] = (counts[cat] || 0) + visible;
        }
    });

    // choose category with highest visible area
    let topCat = '';
    let topVal = 0;
    for (const k in counts) {
        if (counts[k] > topVal) { topVal = counts[k]; topCat = k; }
    }

    // update menu links
    document.querySelectorAll('.menu a, .filter a').forEach(a => {
        a.classList.remove('active');
        const href = a.getAttribute('href') || '';
        if (topCat && href.indexOf('category=' + topCat) !== -1) {
            a.classList.add('active');
        }
        if (!topCat && href.indexOf('dashboard_customer.php') !== -1 && href.indexOf('category=') === -1) {
            a.classList.add('active');
        }
    });
}

let scrollTimeout;
window.addEventListener('scroll', function(){
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(updateActiveCategory, 80);
});
window.addEventListener('resize', updateActiveCategory);
// initial
updateActiveCategory();
</script>

<?php if (isset($_GET['success'])) { ?>
<div class="popup">
    <div class="popup-box">
        <h2>🎉 Payment Successful!</h2>
        <p>Your order has been processed</p>
        <a href="dashboard_customer.php" class="popup-btn">OK</a>
    </div>
</div>
<?php } ?>

<script>
function goCategory(cat) {
    let url = "dashboard_customer.php";

    if (cat !== '') {
        url += "?category=" + cat;
    }

    window.location.href = url + "#products";
}
</script>

<div class="footer" id="footer">

    <div class="footer-content">

        <div class="footer-col">
            <h3>Raya Creative Studio</h3>
            <p>Helper for your streaming needs</p>
        </div>

        <div class="footer-col">
            <h4>Address</h4>
            <p>Jl. Kenangan No.123</p>
            <p>Surabaya, Indonesia</p>
        </div>

        <div class="footer-col">
            <h4>Contact</h4>
            <p>Phone: 0812-3456-7890</p>
            <p>Email: rayastudio@gmail.com</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 Raya Creative Studio. All rights reserved.</p>
    </div>

</div>

    <!-- Logout Overlay -->
    <div id="logoutOverlay" class="logout-overlay">
        <div class="logout-box">
            <div class="logout-spinner"></div>
            <h3>Logging Out</h3>
            <p>Leaving the space, please wait...</p>
        </div>
    </div>

    <script>
    function triggerLogout(event) {
        event.preventDefault();
        if (confirm("Apakah Anda yakin ingin logout?")) {
            var overlay = document.getElementById('logoutOverlay');
            if (overlay) {
                overlay.classList.add('visible');
            }
            setTimeout(function() {
                window.location.href = 'logout.php';
            }, 1200);
        }
    }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initSlidingPill(containerSelector, itemSelector) {
        const containers = document.querySelectorAll(containerSelector);
        containers.forEach(container => {
            const computedStyle = window.getComputedStyle(container);
            if (computedStyle.position === 'static') {
                container.style.position = 'relative';
            }

            let pill = container.querySelector('.sliding-pill-indicator');
            if (!pill) {
                pill = document.createElement('div');
                pill.className = 'sliding-pill-indicator';
                container.appendChild(pill);
            }

            const items = container.querySelectorAll(itemSelector);
            
            function updatePill(target) {
                if (!target) {
                    pill.style.opacity = '0';
                    return;
                }
                pill.style.opacity = '1';
                
                const containerRect = container.getBoundingClientRect();
                const targetRect = target.getBoundingClientRect();
                
                const left = targetRect.left - containerRect.left + container.scrollLeft;
                const top = targetRect.top - containerRect.top + container.scrollTop;
                
                pill.style.left = left + 'px';
                pill.style.width = targetRect.width + 'px';
                pill.style.top = top + 'px';
                pill.style.height = targetRect.height + 'px';
                
                const targetStyle = window.getComputedStyle(target);
                pill.style.borderRadius = targetStyle.borderRadius;
            }

            function getActive() {
                return container.querySelector(itemSelector + '.active') || container.querySelector('li.active');
            }

            // Initial positioning
            setTimeout(() => {
                updatePill(getActive());
            }, 200);

            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    updatePill(item);
                });
            });

            container.addEventListener('mouseleave', () => {
                updatePill(getActive());
            });

            window.addEventListener('resize', () => {
                updatePill(getActive());
            });

            // Handle dynamically updated active states (e.g. scrollspy or tab clicks)
            const observer = new MutationObserver(() => {
                updatePill(getActive());
            });
            observer.observe(container, { attributes: true, subtree: true, attributeFilter: ['class'] });
        });
    }

    initSlidingPill('.navbar .menu', 'a, button');
    initSlidingPill('.tabs-container', '.tab-btn');
    initSlidingPill('.mitra-nav-list', 'li, a');
    initSlidingPill('.menu', 'a');
    initSlidingPill('.filter-container', '.filter-chip');
});
</script>

</body>
</html>
