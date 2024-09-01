<div class="container">
    <div class="d-flex justify-content-between flex-wrap gap-2">
        <div class="row">
            <div class="col-sm-12 ">
                <button type="button" class="btn color-utama" style="border-color: var(--warna-utama)">Makanan</button>
                <button type="button" class="btn color-utama" style="border-color: var(--warna-utama)">Minuman</button>
                <button type="button" class="btn color-utama" style="border-color: var(--warna-utama)">Recomended</button>
                <button type="button" class="btn color-utama" style="border-color: var(--warna-utama)">Best Seller</button>
                <button type="button" class="btn color-utama" style="border-color: var(--warna-utama)">Popular</button>
            </div>
        </div>
        <form class="d-flex" role="search" id="searchForm">
            <input class="form-control me-2 color-utama" id="searchInput" type="search" placeholder="Search" aria-label="Search"  style="border-color: var(--warna-utama)">
            <button class="btn color-keempat bg-kedua" type="submit">Search</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let query = document.getElementById('searchInput').value;

        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let product = data.product;
                    document.getElementById('productModalLabel').textContent = product.name;
                    document.getElementById('productImage').src = product.image_url;
                    document.getElementById('productDescription').textContent = product.description;
                    new bootstrap.Modal(document.getElementById('productModal')).show();
                } else {
                    alert(data.message);
                }
            });
    });
</script>