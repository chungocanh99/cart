
<?php
session_start();
require_once ('database.php');
$database = new Database();

echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<?php if(isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) { ?>
    <div class="container">
        <h2>Giỏ hàng</h2>
        <p>Chi tiết giỏ hàng của bạn </p>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Xóa khỏi giỏ hàng</th>

            </tr>
            </thead>
            <tbody>

            <?php
            $total=0;
            foreach ($_SESSION['cart_item'] as $key_cart => $val_cart_item) :?>
            <tr>
                <td><?php echo $val_cart_item['id']?></td>
                <td><?php echo $val_cart_item['product_name']?></td>
                <td>   <img class="card-img-top" style="height: 25px; width:auto;display: block;" src="images/<?php echo $val_cart_item['product_image'];?>">
                </td>
                <td><?php echo $val_cart_item['price']?></td>
                <td><?php echo $val_cart_item['quantity']?></td>
                <td><?php
                    $total_item = ($val_cart_item['price'] * $val_cart_item['quantity']);
                    echo number_format("$total_item",0,",",".") ?>VNĐ</td>
                <td>
                    <form name="remove<?php $val_cart_item['id'] ?>" action="process.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $val_cart_item['id']?>"/>
                        <input type="hidden" name="action" value="remove"/>
                <input type="submit" name="submit" class="btn btn-sm btn-outline-secondary" value="Xóa"/>
                    </form>

            </tr>
            <?php
            $total+=$total_item;
            endforeach;?>

            </tbody>
        </table>
        <div>Tổng hóa đơn thanh toán <strong><?php echo number_format("$total",0,",",".");?>VNĐ</strong></div>
    </div>
<?php } else { ?>
    <div class="container">
        <h2>Giỏ hàng</h2>
        <p>Giỏ hàng của bạn đang rỗng</p>

    </div>
<?php } ?>


<div class="container" style="margin-top: 50px">
    <div class="row">
        <?php
        $sql="SELECT * FROM products";
        $products = $database->runQuery($sql);

        ?>

        <?php if(!empty($products)) : ?>
            <?php foreach ($products as $product) :

                ?>
                <div class="col-sm-6">
                    <form name="product<?php echo $product['id'];?>" action="process.php" method="post">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" style="height: auto; width:100%;display: block;" src="images/<?php echo $product['product_image'];?>">
                            <div class="card-body">
                                <p class="card-text" style="font-weight: bold">Product: <?php echo $product['product_name'];?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-inline">
                                        <input type="text" class="form-control" name="quantity" value="1">
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id'];?>">

                                        <label style="margin-left: 10px;">
                                            <input type="submit" name="submit" class="btn btn-sm btn-outline-secondary" value="Thêm vào giỏ hàng"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            <?php endforeach;?>
        <?php endif; ?>



    </div>




</body>
</html>
