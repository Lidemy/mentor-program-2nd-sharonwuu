<?php //前置連線
  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if($conn->connect_error){
    die("連線失敗：" . $conn->connect_error);
  }

  $conn->query("SET NAMES 'UTF8' ");
  $conn->query(" SET time_zone= '+08:00' ");



  $conn->autocommit(FALSE);
  $conn->begin_transaction();

  $stmt = $conn->prepare("SELECT amount FROM products WHERE id = 1 for update");
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows >= 0){
  	$row = $result->fetch_assoc();
  	echo '商品數量：' . $row['amount'] . '<br>';

  	if($row['amount'] > 0){
  	  $stmt = $conn->prepare("UPDATE products SET amount = amount-1  WHERE id = 1");
  	  if($stmt->execute()){
  	  	echo "購買成功";
  	  }
  	}else{
  	  	echo "已售完";
  	  }
  }

  $conn->commit();
  $conn->close();  

?>