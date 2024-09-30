<div class="container">
    <div class="d-flex justify-content-between flex-wrap gap-2">
        <div class="row">
            <div class="col-sm-12">
                <button type="button" class="btn color-keempat" style="border-color: var(--warna-kedua)" data-category="Makanan">Makanan</button>
                <button type="button" class="btn color-keempat" style="border-color: var(--warna-kedua)" data-category="Minuman">Minuman</button>
                <button type="button" class="btn color-keempat" style="border-color: var(--warna-kedua)" data-category="Recomended">Recomended</button>
                <button type="button" class="btn color-keempat" style="border-color: var(--warna-kedua)" data-category="Best Seller">Best Seller</button>
                <button type="button" class="btn color-keempat" style="border-color: var(--warna-kedua)" data-category="Popular">Popular</button>
            </div>
        </div>
        <form class="d-flex" role="search" id="searchForm">
            <input class="form-control me-2 color-keempat" id="searchInput" type="search" placeholder="Search" aria-label="Search">
            <button class="btn color-utama bg-kedua" type="submit">Search</button>
        </form>
    </div>
</div>

<script>
    // Search form submission handler
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let query = document.getElementById('searchInput').value;

        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                displayProducts(data);
            });
    });

    // Add click event listeners to category buttons
    const categoryButtons = document.querySelectorAll('.btn[data-category]');
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            fetch(`/category/${category}`)
                .then(response => response.json())
                .then(data => {
                    displayProducts(data);
                });
        });
    });

    // Function to display products
    function displayProducts(data) {
        const productContainer = document.querySelector('.container'); // Update with your actual container selector
        productContainer.innerHTML = ''; // Clear previous items

        if (data.status === 'success') {
            // Check if there are any products
            if (data.products.length === 0) {
                alert('Menu yang dicari tidak ada. Silakan coba lagi.');
                return; // Exit the function if no products found
            }

            // Loop through the products and display them
            data.products.forEach(product => {
                const productCard = `
                    <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                        <div class="card p-2">
                            <img src="${product.foto}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="${product.nama}">
                            <div class="card-body p-0 mt-2">
                                <h2 class="card-title fw-bold">${product.nama}</h2>
                                <h3 class="card-title fw-medium">${product.kategori.nama}</h3>
                                <p class="card-text text-success"><strong>Rp. ${new Intl.NumberFormat('id-ID').format(product.harga * (1 - product.diskon / 100))}</strong></p>
                                <p class="card-text text-danger"><small><del>Rp. ${new Intl.NumberFormat('id-ID').format(product.harga)}</del></small></p>
                                <button class="btn bg-kedua color-utama fs-5 col-10" data-id="${product.id}">Pesan</button>
                            </div>
                        </div>
                    </div>
                `;
                productContainer.innerHTML += productCard; // Append new product card to the container
            });
        } else {
            alert(data.message);
        }
    }
</script>