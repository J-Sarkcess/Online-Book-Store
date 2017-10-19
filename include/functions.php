<?php 
    $con = mysqli_connect("localhost","test","pass123","hasstore");
    function display(){
				global $con;
				$get_prod = "select * from products";
 				$run_prod = mysqli_query($con,$get_prod);
  			while($row_prod = mysqli_fetch_array($run_prod)){
    	    	$id = $row_prod['id'];
        		$year = $row_prod['year'];
        		$semester = $row_prod['semester'];
       	 		$department = $row_prod['department'];
 	    		  $university = $row_prod['university'];
 	        	$subject = $row_prod['subject'];
 		        $name = $row_prod['name'];
        		$author = $row_prod['author'];
    	    	$cost = $row_prod['cost'];
       			$publisher = $row_prod['publisher'];
       			$imgurl = $row_prod['imgurl'];
      			$edition = $row_prod['edition'];
        		$description = $row_prod['description'];
        		$imgurl = "images/final/t/".$imgurl;
        			echo '<div class="col-sm-4">';
                           echo' <div class="product-image-wrapper">';
                                echo '<div class="single-products">';
                                    echo '<div class="productinfo text-center">';
                                        echo '<img height = "300px" src="'.$imgurl.'" alt="" />';
                                        echo '<h2>'.$cost.'</h2>';
                                        echo '<p>'.$name.'</p>';
										echo '<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>';
									echo '</div>';
									echo '<div class="product-overlay">';
										echo '<div class="overlay-content">';
											echo '<p>'.$name.'</p>';
											echo '<h2>Author : '.$author.'</h2>';
											echo '<h2>'.$cost.'</h2>';
                    echo "<a href='product-details.php?id=$id' class='btn btn-default add-to-cart'><i class='fa'></i>View Details</a>";
										echo "<a href='shop.php?id=$id' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Add to cart</a>";
									echo	'</div>';
								echo	'</div>';
								echo '</div>';
						echo	'</div>';
						echo '</div>';
          }
                                        
    }

    function displayCat(){
      global $con;
      $get_prod = "select * from maincateg";
      $run_prod = mysqli_query($con,$get_prod);
      while($row_prod = mysqli_fetch_array($run_prod)){
        $id = $row_prod['id'];
        $name = $row_prod['name'];
        echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">';
                  echo '<h4 class="panel-title">';
                    echo '<a data-toggle="collapse" data-parent="#accordian" href="#'.$name.'">';
                      echo '<span class="badge pull-right"><i class="fa fa-plus"></i></span>';
                      echo $name;
                    echo '</a>';
                  echo '</h4>';
                echo '</div>';
                echo '<div id="'.$name.'" class="panel-collapse collapse">';
                  echo '<div class="panel-body">';
                    echo '<ul>';
                      echo '<li><a href="#" id="s3">Sem 3</a></li>';
                      echo '<li><a href="#" id="s4">Sem 4</a></li>';
                      echo '<li><a href="#" id="s5">Sem 5</a></li>';
                      echo '<li><a href="#" id="s6">Sem 6</a></li>';
                      echo '<li><a href="#" id="s7">Sem 7</a></li>';
                      echo '<li><a href="#" id="s8">Sem 8</a></li>';
                    echo '</ul>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
      }
    }
      
    function cart(){
        if(isset($_GET['id'])){
            global $con;
            $ip_add = getIp();
            $id = $_GET['id'];
            $check_pro = "select * from cart where ipadd = '$ip_add' and pid = '$id'";
            $run_check = mysqli_query($con, $check_pro);
            if(mysqli_num_rows($run_check)>0){
              echo '<script>alert("added")</script>';
            }
            else{
              $insert_pro = "insert into cart(pid,ipadd,qty) values('$id','$ip_add','1')";
              $run_pro = mysqli_query($con, $insert_pro);
              echo "<script>window.open('shop.php','_self')</script>";
            }
        }
    }



    function getIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
   
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
   
        return $ip;
    }

    function displayCartItems(){
      global $con;
      $ip_add = getIp();
      $check_pro = "select * from cart where ipadd = '$ip_add'";
      $run_check = mysqli_query($con, $check_pro);
      if(mysqli_num_rows($run_check)==0){
        echo '<div class="heading">';
        echo '<h3>No items added into the cart!!! Would you like to continue to shop</h3>';
        echo '<a class="btn btn-default update" href="shop.php">Continue Shopping</a>';
      echo '</div>';
      }
      else{
        global $con;
        $ip_add = getIp();
        $check_pro = "select * from cart where ipadd = '$ip_add'";
        $run_check = mysqli_query($con, $check_pro);
        while($row_pro = mysqli_fetch_array($run_check)){
          $pid = $row_pro['pid'];
          $qty = $row_pro['qty'];
          $disp_pro = "select * from products where id = '$pid'";
          $run_disp = mysqli_query($con,$disp_pro);
          while($run_disp_pro = mysqli_fetch_array($run_disp)){
            $id = $run_disp_pro['id']; 
            $name = $run_disp_pro['name'];
            $cost = $run_disp_pro['cost']; 
            $imgurl = $run_disp_pro['imgurl'];
            $imgurl = "images/final/t/".$imgurl;
            $total = $qty * $cost;
            echo '<tr>';
                echo '<td class="cart_product">';
                  echo '<a href=""><img  height = "100px"src="'.$imgurl.'" alt=""></a>';
                echo '</td>';
                echo '<td class="cart_description">';
                  echo '<h4><a href="">'.$name.'</a></h4>';
                  echo "<p>Web ID: HAS$id</p>";
                echo '</td>';
                echo '<td class="cart_price">';
                  echo '<p>'.$cost.'</p>';
                echo '</td>';
                echo '<td class="cart_quantity">';
                  echo '<div class="cart_quantity_button">';
                    echo '<a class="cart_quantity_up" href=""> + </a>';
                    echo '<input class="cart_quantity_input" type="text" name="quantity" value="'.$qty.'" autocomplete="off" size="2">';
                    echo '<a class="cart_quantity_down" href=""> - </a>';
                  echo '</div>';
                echo '</td>';
                echo '<td class="cart_total">';
                  echo '<p class="cart_total_price">'.$total.'</p>';
                echo '</td>';
                echo '<td class="cart_delete">';
                  echo '<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>';
                echo '</td>';
              echo '</tr>';
          }
          
        }
      }
    }

    function cartTotalDisplay(){
      global $con;
      $ip_add = getIp();
      $check_pro = "select * from cart where ipadd = '$ip_add'";
      $run_check = mysqli_query($con, $check_pro);
      if(mysqli_num_rows($run_check)==0){
      }
      else{
        global $con;
        $ip_add = getIp();
        $check_pro = "select * from cart where ipadd = '$ip_add'";
        $run_check = mysqli_query($con, $check_pro);
        $total = 0;
        $tax = 0;
        $total_cost = 0;
        while($row_pro = mysqli_fetch_array($run_check)){
          $pid = $row_pro['pid'];
          $qty = $row_pro['qty'];
          $disp_pro = "select * from products where id = '$pid'";
          $run_disp = mysqli_query($con,$disp_pro);
          while($run_disp_pro = mysqli_fetch_array($run_disp)){
            $id = $run_disp_pro['id']; 
            $name = $run_disp_pro['name'];
            $cost = $run_disp_pro['cost']; 
            $imgurl = $run_disp_pro['imgurl'];
            $imgurl = "images/final/t/".$imgurl;
            $total += $qty * $cost;
          }
        }
        $tax += $total * 0.28;
        $total_cost += $total + $tax;
            echo '<section id="do_action">
            <div class="container">
              <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="chose_area">
                    <ul class="user_option">
                      <li>
                        <input type="checkbox">
                        <label>Use Coupon Code</label>
                      </li>
                      <li>
                        <input type="checkbox">
                        <label>Use Gift Voucher</label>
                      </li>
                      <li>
                        <input type="checkbox">
                        <label>Estimate Shipping & Taxes</label>
                      </li>
                    </ul>
                    <ul class="user_info">
                      <li class="single_field">
                        <label>Country:</label>
                        <select>
                          <option>United States</option>
                          <option>Bangladesh</option>
                          <option>UK</option>
                          <option>India</option>
                          <option>Pakistan</option>
                          <option>Ucrane</option>
                          <option>Canada</option>
                          <option>Dubai</option>
                        </select>
                        
                      </li>
                      <li class="single_field">
                        <label>Region / State:</label>
                        <select>
                          <option>Select</option>
                          <option>Dhaka</option>
                          <option>London</option>
                          <option>Dillih</option>
                          <option>Lahore</option>
                          <option>Alaska</option>
                          <option>Canada</option>
                          <option>Dubai</option>
                        </select>
                      
                      </li>
                      <li class="single_field zip-field">
                        <label>Zip Code:</label>
                        <input type="text">
                      </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="total_area">
                    <ul>
                      <li>Cart Sub Total <span>'.$total.'</span></li>
                      <li>GST (28%) <span>'.$total_cost.'</span></li>
                      <li>Shipping Cost <span>Free</span></li>
                      <li>Total <span>'.$total_cost.'</span></li>
                    </ul>
                      <a class="btn btn-default update" href="shop.php">Continue Shopping</a>
                      <a class="btn btn-default update" href="">Update</a>
                      <a class="btn btn-default check_out" href="">Check Out</a>
                  </div>
                </div>
              </div>
            </div>
          </section><!--/#do_action-->';
      }
    }
?>