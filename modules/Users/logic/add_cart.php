<?php

if (isset($_POST['addCart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = 1;
    $productInventory = $inventoryController->getProductInventory($id, null, true);
    if ($id && $price) {
        if (isset($cart[$id])) {
            $currentQty = $cart[$id]['quantity'];
            $newQty = $currentQty + $quantity;
            if ($newQty <= $productInventory['stock_quantity']) {
                $cart[$id]['quantity'] = $newQty;
            } else {
                $cart[$id]['quantity'] = $productInventory['stock_quantity'];
            }
        } else {
            $cart[$id] = [
                'id'       => $id,
                'name'     => $name,
                'price'    => $price,
                'image'    => $image,
                'quantity' => $quantity,
            ];
        }
    }
    echo '<meta http-equiv="refresh" content="0">';

    $_SESSION['cart'] = $cart;
}
