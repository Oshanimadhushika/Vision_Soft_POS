<?php

function addItem($itemCode, $barcode, $description, $department, $category, $supplier, $cost, $profit, $salesPrice, $discountRs, $wholesale, $location, $maxStockQty, $minStockQty)
{
    require_once "database.php";
    $sql = "INSERT INTO item (item_code, barcode, description, department, category, supplier, cost, profit, sale_price, discount, wholesale, location, max_qty, min_qty) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
    if ($stmt) {
        $stmt->bind_param("ssssssssssssss", $itemCode, $barcode, $description, $department, $category, $supplier, $cost, $profit, $salesPrice, $discountRs, $wholesale, $location, $maxStockQty, $minStockQty);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        return "Error: " . $conn->error;
    }
}
?>
