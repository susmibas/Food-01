
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                    	<h3 class="text-white">Welcome to Food Ordering System</h3>
                        <h3 style="color:tomato;">Good Food = Good Mood</h3>
                        <hr class="divider my-4" />
                        <a class="btn btn-primary btn-xl js-scroll-trigger" href="#menu">Order Now</a>

                    </div>
                    
                </div>
            </div>
            
        </header>
	<section class="page-section" id="menu">
        <div id="menu-field" class="card-deck">
                <?php 
                    include'admin/db_connect.php';
                    $qry = $conn->query("SELECT * FROM  product_list order by rand() ");
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <div class="col-lg-3">
                     <div class="card menu-item ">
                        <img src="assets/img/<?php echo $row['img_path'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $row['name'] ?></h5>
                          <p class="card-text truncate"><?php echo "Rs. ", $row['price'],"-  ", $row['description'] ?></p>

                          <?php 
                            $qryy = $conn->query("SELECT * FROM  product_list where id = ".$row['id'])->fetch_array();
			                $result2 = $conn->query("SELECT * FROM  category_list where id =".$qryy['category_id'])->fetch_array(); ?>
		                 <h6 class="card-title" ><?php echo $result2['name'] ?></h6>
          
          
                          <div class="text-center">
                              <button class="btn btn-sm btn-outline-primary view_prod btn-block" data-id=<?php echo $row['id'] ?>><i class="fa fa-eye"></i> View</button>
                              
                          </div>
                        </div>
                        
                      </div>
                      </div>
                    <?php endwhile; ?>
        </div>
    </section>
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product','view_prod.php?id='+$(this).attr('data-id'))
        })
    </script>
	
