<?php
session_start();
require_once ('database.php');
$database = new Database();


if(isset($_POST) && !empty($_POST)) {
    /*
     * check xem $-post có tồn tại tức là có dữ liệu được gửi đi đông thời
     * !empty tức là nó sẽ có dữ liệu được gửi đi
     */
    if(isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['quantity']) && isset($_POST['product_id'])) {
                    $sql = "SELECT * FROM products where id=" . (int)$_POST['product_id'];
                    $product = $database->runQuery($sql);
                    $product = current($product);//để lấy được dữ liệu bên trong mảng,ép về 1 phần tử duy nhất

                    $product_id = $product['id'];

                    if (isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) {
                        //!empty trả về true tuwscc là nó đang có dữ liệu,

                        /*
                         * khi giỏ hàng có tồn tại và không rỗng
                         * check tiếp xem cái sản phẩm ta add đã tồn tại trong giỏ hàng chưa bằng câu if
                         * các thứ các thứ xong update lại giỏ hàng
                         */
                        if (isset($_SESSION['cart_item']['product_id'])) {
                            $exist_cart_item = $_SESSION['cart_item'][$product_id];
                            $exist_quantity = $exist_cart_item['quantity'];
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $exist_quantity + $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;
                        } else {
                            /*
                             * đây là lúc sản phẩm chưa tồn tại trong giỏ hàng
                             */
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;
                        }


                    } else {
                        //false:không dữ liệu, bị rỗng
                        //cần key để gán vào và nó là duy nhất
                        $_SESSION['cart_item'] = array();
                        $cart_item = array();
                        $cart_item['id'] = $product['id'];
                        $cart_item['product_name'] = $product['product_name'];
                        $cart_item['product_image'] = $product['product_image'];
                        $cart_item['price'] = $product['price'];
                        $cart_item['quantity'] = $_POST['quantity'];
                        $_SESSION['cart_item'][$product_id] = $cart_item;


                    }
                }
                break;
            case 'remove':
                echo '<br> $_POST';
                echo '<pre>';
                print_r($_POST);
                echo '</pre>';
                echo 'remove';
                if (isset($_POST['product_id'])) {
                    $product_id = $_POST['product_id'];

                    if (isset($_SESSION['cart_item'][$product_id])) {
                        unset($_SESSION['cart_item'][$product_id]);
                    }
                }

                break;
            default:
                echo 'action không tồn tại';


                die;
        }
    }
}



header("Location:http://localhost:8080/cart/index.php");
die();