<!-- app/Views/product/search_results.php -->
<?php if (!empty($products)): ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <h4><?= esc($product['name']); ?></h4>
                <p><?= esc($product['description']); ?></p>
                <p>Price: <?= esc($product['price']); ?> VND</p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
