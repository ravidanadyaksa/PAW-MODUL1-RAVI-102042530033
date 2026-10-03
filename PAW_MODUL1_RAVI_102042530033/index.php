<?php
session_start();

$stokAwal = [
    5,
    3,
    6,
    7,
    10,
    4
];

if (!isset($_SESSION["produk"])) {
    $_SESSION["produk"] = [
        [
            "nama" => "Laptop ASUS Vivobook",
            "kategori" => "Laptop",
            "harga" => 8500000,
            "stok" => 5
        ],
        [
            "nama" => "iPhone 15",
            "kategori" => "Smartphone",
            "harga" => 12000000,
            "stok" => 3
        ],
        [
            "nama" => "Samsung Galaxy A55",
            "kategori" => "Smartphone",
            "harga" => 6500000,
            "stok" => 0
        ],
        [
            "nama" => "Keyboard Mechanical",
            "kategori" => "Aksesoris",
            "harga" => 750000,
            "stok" => 8
        ],
        [
            "nama" => "Mouse Wireless Logitech",
            "kategori" => "Aksesoris",
            "harga" => 450000,
            "stok" => 10
        ],
        [
            "nama" => "Monitor LG 27 Inch",
            "kategori" => "Monitor",
            "harga" => 3200000,
            "stok" => 4
        ]
    ];
}

if (isset($_POST["beli"])) {
    $index = $_POST["index"];

    if ($_SESSION["produk"][$index]["stok"] > 0) {
        $_SESSION["produk"][$index]["stok"]--;
        $_SESSION["pesan"] = "Produk berhasil dibeli!";
    }
}

if (isset($_POST["reset"])) {
    foreach ($_SESSION["produk"] as $index => $item) {
        $_SESSION["produk"][$index]["stok"] = $stokAwal[$index];
    }

    $_SESSION["pesan"] = "Stok berhasil direset!";
}

function formatRupiah($harga) {
    return "Rp " . number_format($harga, 0, ",", ".");
}

$produk = $_SESSION["produk"];
$jumlahProduk = count($produk);

$pesan = "";

if (isset($_SESSION["pesan"])) {
    $pesan = $_SESSION["pesan"];
    unset($_SESSION["pesan"]);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cia Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="navbar">
    <div class="logo">Cia Store</div>

    <nav>
        <a href="#home">Home</a>
        <a href="#produk">Produk</a>
        <a href="#tentang">Tentang</a>
    </nav>
</header>

<section class="hero" id="home">
    <div>
        <p class="hero-label">SELAMAT DATANG DI</p>

        <h1>Cia Store</h1>

        <p>
            Temukan berbagai perangkat dan aksesoris teknologi
            sesuai kebutuhanmu.
        </p>

        <a href="#produk" class="hero-button">Lihat Produk</a>
    </div>
</section>

<section class="jumlah-produk">
    <div class="jumlah-box">
        <h2><?= $jumlahProduk ?></h2>
        <p>Total Produk</p>
    </div>
</section>

<?php if ($pesan != ""): ?>
    <div class="pesan">
        <?= $pesan ?>
    </div>
<?php endif; ?>

<div class="reset-container">
    <form method="POST">
        <button type="submit" name="reset" class="reset-button">
            Reset Stok
        </button>
    </form>
</div>

<section class="produk" id="produk">

    <div class="judul-section">
        <p>KOLEKSI PRODUK</p>
        <h2>Katalog Produk</h2>
        <span>Pilih produk teknologi favoritmu</span>
    </div>

    <div class="product-grid">

        <?php foreach ($produk as $index => $item): ?>

            <?php
            $hargaNormal = $item["harga"];

            if ($hargaNormal >= 1000000) {
                $persentaseDiskon = 10;
                $hargaDiskon = $hargaNormal * ($persentaseDiskon / 100);
                $hargaSetelahDiskon = $hargaNormal - $hargaDiskon;
            } else {
                $persentaseDiskon = 0;
                $hargaSetelahDiskon = $hargaNormal;
            }
            ?>

            <div class="card">

                <div class="card-header">
                    <span><?= $item["kategori"] ?></span>
                </div>

                <div class="card-body">

                    <h3><?= $item["nama"] ?></h3>

                    <p class="kategori">
                        <?= $item["kategori"] ?>
                    </p>

                    <?php if ($persentaseDiskon > 0): ?>

                        <p class="harga-normal">
                            Harga Normal:
                            <?= formatRupiah($hargaNormal) ?>
                        </p>

                        <p class="diskon">
                            Diskon: <?= $persentaseDiskon ?>%
                        </p>

                        <p class="harga">
                            Harga Setelah Diskon:
                            <?= formatRupiah($hargaSetelahDiskon) ?>
                        </p>

                    <?php else: ?>

                        <p class="harga">
                            <?= formatRupiah($hargaNormal) ?>
                        </p>

                    <?php endif; ?>

                    <p class="stok">
                        Jumlah Stok: <?= $item["stok"] ?>
                    </p>

                    <?php if ($item["stok"] > 0): ?>

                        <p class="status tersedia">
                            Tersedia
                        </p>

                        <form method="POST">
                            <input
                                type="hidden"
                                name="index"
                                value="<?= $index ?>"
                            >

                            <button
                                type="submit"
                                name="beli"
                                class="btn-beli"
                            >
                                Beli Sekarang
                            </button>
                        </form>

                    <?php else: ?>

                        <p class="status habis">
                            Stok Habis
                        </p>

                        <button
                            class="btn-beli disabled"
                            disabled
                        >
                            Stok Habis
                        </button>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>

<section class="tentang" id="tentang">

    <h2>Tentang Cia Store</h2>

    <p>
        Cia Store menyediakan berbagai perangkat dan aksesoris
        teknologi dengan pilihan produk yang beragam.
    </p>

</section>

<footer>
    <p>&copy; 2026 Cia Store. All Rights Reserved.</p>
</footer>

</body>
</html>