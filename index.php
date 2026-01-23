<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Kigali Marriott Hotel | Dining</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
:root{
    --kfc-red:#E4002B;
    --gray:#f6f6f6;
    --white:#fff;
}

body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:var(--gray);
    padding-bottom:200px;
}

header{
    background:var(--kfc-red);
    color:white;
    padding:18px;
    text-align:center;
    position:sticky;
    top:0;
    z-index:100;
}

header h1{
    margin:0;
    font-size:1.4rem;
    font-weight:900;
}

.lang-switch{
    position:absolute;
    right:15px;
    top:15px;
    display:flex;
    gap:8px;
}

.lang-btn{
    background:white;
    border:none;
    padding:6px 14px;
    border-radius:20px;
    font-weight:bold;
    cursor:pointer;
}

.container{
    max-width:900px;
    margin:auto;
    padding:20px;
}

#menuSearch{
    width:100%;
    padding:14px;
    border-radius:30px;
    border:1px solid #ddd;
    font-size:1rem;
    margin-bottom:30px;
}

.category-title{
    font-size:1.3rem;
    font-weight:900;
    margin:40px 0 20px;
    padding-left:12px;
    border-left:6px solid var(--kfc-red);
}

.item-card{
    background:white;
    display:flex;
    align-items:center;
    gap:15px;
    padding:16px;
    margin-bottom:16px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.1);
}

.item-card img{
    width:90px;
    height:90px;
    border-radius:12px;
    object-fit:cover;
    background:#eee;
}

.item-info{
    flex:1;
}

.item-info h3{
    margin:0;
    font-size:1.1rem;
    font-weight:900;
}

.price-tag{
    margin-top:6px;
    color:var(--kfc-red);
    font-weight:900;
}

.add-btn{
    background:var(--kfc-red);
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:30px;
    font-weight:900;
    cursor:pointer;
}

.sold-out{
    opacity:.4;
    pointer-events:none;
}

#cart-panel{
    position:fixed;
    bottom:20px;
    right:20px;
    width:320px;
    background:white;
    padding:20px;
    border-radius:16px;
    box-shadow:0 12px 30px rgba(0,0,0,.25);
    border-top:6px solid var(--kfc-red);
}

#cart-summary span{
    display:flex;
    justify-content:space-between;
    font-weight:bold;
    margin-bottom:8px;
}

.panel-inputs{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.panel-inputs input,
.panel-inputs select{
    padding:12px;
    border-radius:20px;
    border:1px solid #ccc;
}

#ui-order-btn{
    margin-top:16px;
    width:100%;
    background:var(--kfc-red);
    color:white;
    border:none;
    padding:14px;
    border-radius:30px;
    font-size:1rem;
    font-weight:900;
}
</style>
</head>

<body>

<header>
<h1 id="ui-title">KIGALI MARRIOTT HOTEL</h1>
<div class="lang-switch">
<button class="lang-btn" onclick="changeLang('en')">EN</button>
<button class="lang-btn" onclick="changeLang('rw')">RW</button>
</div>
</header>

<div class="container">

<input type="text" id="menuSearch" placeholder="Search our menu..." onkeyup="filterMenu()">

<div class="category-title" id="ui-food-head">All-Day Dining</div>

<?php
$food = $conn->query("SELECT * FROM resto_bar_items WHERE category='Food'");
while($row = $food->fetch_assoc()):
?>
<div class="item-card <?php echo ($row['is_available']==0)?'sold-out':''; ?>" data-name="<?php echo strtolower($row['name']); ?>">

<!-- FOOD IMAGE GOES HERE (fried chicken / burger / combo) -->
<img src="grillide_tilapia" alt="Food image">

<div class="item-info">
<h3><?php echo $row['name']; ?></h3>
<div class="price-tag"><?php echo number_format($row['price']); ?> RWF</div>
</div>

<button class="add-btn ui-add-btn"
onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">
Order
</button>

</div>
<?php endwhile; ?>

<div class="category-title" id="ui-drink-head">Beverages</div>

<?php
$drinks = $conn->query("SELECT * FROM resto_bar_items WHERE category='Drink'");
while($row = $drinks->fetch_assoc()):
?>
<div class="item-card <?php echo ($row['is_available']==0)?'sold-out':''; ?>" data-name="<?php echo strtolower($row['name']); ?>">

<!-- DRINK IMAGE GOES HERE (soda / juice / water) -->
<img src="" alt="Drink image">

<div class="item-info">
<h3><?php echo $row['name']; ?></h3>
<div class="price-tag"><?php echo number_format($row['price']); ?> RWF</div>

<select id="temp-<?php echo $row['id']; ?>">
<option value="Chilled">Chilled</option>
<option value="Warm">Warm</option>
</select>
</div>

<button class="add-btn ui-add-btn"
onclick="addToCartWithTemp(<?php echo $row['id']; ?>,'<?php echo $row['name']; ?>',<?php echo $row['price']; ?>)">
Order
</button>

</div>
<?php endwhile; ?>

</div>

<div id="cart-panel">
<div id="cart-summary">
<span>Items <b id="item-count">0</b></span>
<span>Total <b id="total-val">0</b> RWF</span>
</div>

<div class="panel-inputs">
<input type="number" id="table-no" placeholder="Table #">
<select id="pay-method" onchange="toggleMomo(this.value)">
<option value="Cash">Cash</option>
<option value="MoMo">MoMo</option>
</select>
<input type="text" id="momo-num" style="display:none" placeholder="MoMo Number">
</div>

<button id="ui-order-btn" onclick="sendOrder()">Submit Order</button>
</div>

<script>
/* ORIGINAL JAVASCRIPT REMAINS EXACTLY THE SAME */
</script>

</body>
</html>
