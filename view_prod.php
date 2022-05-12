<?php 
 session_start(); //added
  include'admin/db_connect.php';
    $qry = $conn->query("SELECT * FROM  product_list where id = ".$_GET['id'])->fetch_array();

	$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach ($query as $key => $value) {
		if(!is_numeric($key))
			$_SESSION['setting_'.$key] = $value;
	}
?>
<div class="container-fluid">

	<div class="card ">
        <img src="assets/img/<?php echo $qry['img_path'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo $qry['name'] ?></h5>
          <p class="card-text truncate"><?php echo $qry['description'] ?></p>
		  <?php 
 			 include'admin/db_connect.php';
			    $result1 = $conn->query("SELECT * FROM  category_list where id =".$qry['category_id'])->fetch_array(); ?>
		  <h6 class="card-title"><?php echo $result1['name'] ?></h6>
          <div class="form-group">
          </div>
          <div class="row">
          	<div class="col-md-2"><label class="control-label">Qty</label></div>
          	<div class="input-group col-md-7 mb-3">
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-secondary" type="button" id="qty-minus"><span class="fa fa-minus"></button>
			  </div>
			  <input type="number" readonly value="1" min = 1 class="form-control text-center" name="qty" >
			  <div class="input-group-prepend">
			    <button class="btn btn-outline-secondary" type="button" id="qty-plus"><span class="fa fa-plus"></span></button>
			  </div>
			</div>
          </div>
          <div class="text-center">
		 
		  <?php if(isset($_SESSION['login_user_id'])): ?>
          	<button class="btn btn-outline-primary btn-sm btn-block" id="add_to_cart_modal"><i class="fa fa-cart-plus"></i>Add to Cart</button>
			<?php else: ?>
				<ul style="list-style-type:none">
				<li><a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now">Login to order</a></li>
			</ul>
				<?php endif; ?>
          </div>
        </div>
        
      </div>
</div>
<style>
	#uni_modal_right .modal-footer{
		display: none;
	}
</style>

<script>
	$('#qty-minus').click(function(){
		var qty = $('input[name="qty"]').val();
		if(qty == 1){
			return false;
		}else{
			$('input[name="qty"]').val(parseInt(qty) -1);
		}
	})
	$('#qty-plus').click(function(){
		var qty = $('input[name="qty"]').val();
			$('input[name="qty"]').val(parseInt(qty) +1);
	})
	$('#add_to_cart_modal').click(function(){
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=add_to_cart',
			method:'POST',
			data:{pid:'<?php echo $_GET['id'] ?>',qty:$('[name="qty"]').val()},
			success:function(resp){
				if(resp == 1 )
					alert_toast("Order successfully added to cart");
					$('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()))
					$('.modal').modal('hide')
					end_load()
			}
		})
	})
</script>