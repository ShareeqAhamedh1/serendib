

			<!-- Header -->
			<?php include './layouts/header.php'; ?>
			<!-- Header -->

           <!-- Sidebar -->
			<?php include './layouts/sidebar.php'; ?>
			<!-- /Sidebar -->

			<div class="page-wrapper">
				<div class="content">
					<div class="page-header">
						<div class="page-title">
							<h4>Confirmation Center All Orders</h4>
						</div>
					</div>


					<!-- /product list -->
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-4">
									<input type="text"class="form-control" id="search_key" onkeyup="search_orders(this.value)" value="" placeholder="Search By Order Number,Name,Phone,Description"> <hr>
									<label for="">From</label>
                                    <input type="date" class="form-control" id="from_date">
                                    <label for="">To</label>
                                    <input type="date" class="form-control" id="to_date" onchange="selectDateRange()">
                                    <hr>
                                    <a href="#" onclick="deleteBulkOrders()"><img src="assets/img/icons/delete.svg" alt="img"></a>
								</div>
								<div class="col-8">
                                <?php if(isset($_SESSION['page_id_sel'])){
                                                    $page_id = $_SESSION['page_id_sel'];

                                                    $pageName = getDataBack($conn,'tbl_pages','page_id',$page_id,'page_name');
                                                ?>
                                                    <h3 > Selected Page  <span style="color:#b247ff;"><?= $pageName ?></span>  </h3> <hr>
                                                <?php } ?>
									<h3>Total Orders: <span style="color:orange;" id="Total_Orders">   </span>  </h3>
                                    <br>
                                    <form action="backend/sel_page.php" method="post">
                                        <input type="hidden" name="back_link" value="1" id="">
                                    <div class="form-group">
                                        <select name="page_id" id="" class="form-control" required>
                                            <option value="">Select Page</option>
                                            <option value="0">Remove Selected Page</option>
                                            <?php
									      $sql_pages ="SELECT * FROM tbl_pages";
									      $rs_pages = $conn->query($sql_pages);

									      if($rs_pages->num_rows > 0){
									        while($row_pages = $rs_pages->fetch_assoc()){
									     ?>
                                                <option value="<?= $row_pages['page_id'] ?>"><?= $row_pages['page_name'] ?></option>
                                         <?php } } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Select Page</button>
                                    </form>
                                    <hr>
                                    <form action="backend/sel_item.php" method="post">
                                        <input type="hidden" name="back_link" value="1" id="">
                                    <div class="form-group">
                                        <select name="item_id" id="" class="form-control" required>
                                            <option value="">Select Item</option>
                                            <option value="0">Remove Selected Item</option>
                                            <?php
									      $sql_pages ="SELECT * FROM tbl_items";
									      $rs_pages = $conn->query($sql_pages);

									      if($rs_pages->num_rows > 0){
									        while($row_pages = $rs_pages->fetch_assoc()){
									     ?>
                                                <option value="<?= $row_pages['item_name'] ?>"><?= $row_pages['item_name'] ?></option>
                                         <?php } } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-sm">Select Item</button>
                                    </form>
								</div>
							</div>
							<div id="all_orders" class="table-responsive">

							</div>
						</div>
					</div>
					<!-- /product list -->
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		<div class="modal fade" style="" id="mark_orders" tabindex="-1" aria-labelledby="mark_orders"  aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Mark Orders</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<a onclick="confirmOrder()" class="btn btn-success w-100">Confirm</a> <br><br>
					  <a onclick="markOrderSt(3)" class="btn btn-warning w-100">No Answer</a> <br><br>
					  <a onclick="markOrderSt(2)" class="btn btn-danger w-100">Canceled</a> <br><br>
					  <a onclick="markOrderSt(4)" class="btn btn-secondary w-100">Phone Off</a>  <br><br>
					  <a onclick="markOrderSt(5)" class="btn btn-info w-100">Call Back</a> <br><br>
					  <a onclick="markOrderSt(6)" class="btn btn-dark w-100">Wrong Number</a><br>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" style="" id="fill_orders" tabindex="-1" aria-labelledby="fill_orders"  aria-hidden="true">
			<div class="modal-dialog" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Mark Orders</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form  action="backend/confirm_complete.php" method="post">
							<input type="hidden" name="id" value="" id="order_id_confirm">
							<div class="form-group">
								<label for="">Specified Date</label>
								<input type="date" class="form-control" name="confirmed_date_value" value="">
							</div>
							<div class="form-group">
								<label for="">Address</label>
								<textarea name="add" id="address" class="form-control" rows="8" cols="80" required></textarea>
							</div>
							<div class="form-group">
								<label for="">COD Amount</label>
								<input name="cod_amount" id="cod" class="form-control" placeholder="Rs.00" required>
							</div>
                            <div class="form-group">
								<label for="">Payment Type</label>
								<select class="form-control js-example-basic-single select2" name="pay_type" id="pay_type">

									<option value="1">COD</option>
                                    <option value="2">Bank Transfer</option>
                                    <option value="3">Other Payment Method</option>

								</select> <br>
								<label for="">Delivery Method</label>
								<select class="form-control" name="del_method" id="del_method">
									<option value="0">Post Office</option>
									<option value="1">Self Delivery</option>
								</select>
							</div>
              <div class="form-group">
                <select class="form-control js-example-basic-single select2" name="item" id="item" onchange="fetchSubItems()">
                <option value="">Select Item (Only If you want to change)</option>
                <?php
                $sql_items = "SELECT * FROM tbl_items";
                $rs_items = $conn->query($sql_items);
                if ($rs_items->num_rows > 0) {
                while ($row_items = $rs_items->fetch_assoc()) {
                    $item_id = $row_items['item_id']; // Assuming there's an `item_id` column
                    $item_name = $row_items['item_name'];
                ?>
                <option value="<?= $item_id ?>"><?= $item_name ?></option>
                <?php
                }
                }
                ?>
                </select>
                </div>

                <!-- Second Dropdown (Sub Items) -->
                <div class="form-group">
                <select class="form-control js-example-basic-single select2" name="sub_item" id="sub_item">
                <option value="">Select Sub Item</option>
                </select>
                </div>


							<div class="form-group">
								<label for="">Select a District</label>
								<select class="js-states form-control" name="dis" onchange="selectCity(this.value)" id="district">
									<?php
										$sqlDistric = "SELECT * FROM districts";
										$rsDistric = $conn->query($sqlDistric);
										?>
										<option selected="selected">Selected Distric</option>
										<?php
										if($rsDistric->num_rows > 0){
											while($rowDist = $rsDistric->fetch_assoc()){
									 ?>
									<option value="<?= $rowDist['id'] ?>"><?= $rowDist['name_en'] ?></option>
								<?php } } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Select a City</label>
								<select class="js-states form-control" name="city" id="loadCities">
								</select>
							</div><hr>
                            <h5 onclick="getHowToSearchVideo()" style="cursor:pointer;border:1px solid #000;padding:5px 5px 5px 5px;border-radius:5px;"> How To Search?  </h5> <hr>
							<div class="form-group">
								<label for="">Re Mark</label>
								<textarea name="remark" id="remark" class="form-control" rows="4" cols="80"></textarea>
							</div>
							<button type="submit" class="btn btn-success" name="button">Complete Order</button>

						</form>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" style="" id="how_to_search" tabindex="-1" aria-labelledby="how_to_search"  aria-hidden="true">
			<div class="modal-dialog" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >How To Search?</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
                    <div style="position: relative; width: 100%; height: 0; padding-top: 56.2500%;
 padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
 border-radius: 8px; will-change: transform;">
  <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;"
    src="https:&#x2F;&#x2F;www.canva.com&#x2F;design&#x2F;DAFpGbJ3BCk&#x2F;watch?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
  </iframe>
</div>
                    </div>
				</div>
			</div>
		</div>


		<?php include 'layouts/footer.php' ?>

		<script type="text/javascript">
        jQuery(document).ready(function($) {
            // Your code using $ as a shortcut for jQuery
            $('.js-states').select2();
        });

        function selectDateRange() {
            var fromDate = document.getElementById('from_date').value;
            var toDate = document.getElementById('to_date').value;

            if (fromDate === "" || toDate === "") {
                alert('Please select both From Date and To Date.');
                document.getElementById('to_date').value = "";
                return;
            }

            var fromDateObj = new Date(fromDate);
            var toDateObj = new Date(toDate);

            if (toDateObj < fromDateObj) {
                alert('To Date cannot be earlier than From Date.');
                document.getElementById('to_date').value = "";
                return;
            }
            $('#all_orders').load('ajax_pages/load_sent_orders.php',{
                from_date:fromDate,
                to_date:toDate
				});
                document.getElementById('from_date').value = "";
                document.getElementById('to_date').value = "";
        }

        function getHowToSearchVideo(){
            $('#how_to_search').modal('show');
        }
			function markOrder(or_id){
				document.getElementById('order_id_confirm').value = or_id;
				$('#mark_orders').modal('show');
			}
			//end
			function confirmOrder(){
				$('#mark_orders').modal('hide');
				$('#fill_orders').modal('show');
			}
			//end
			function selectCity(dist_id){
				$('#loadCities').load('ajax_pages/loadCities.php',{
					d_id:dist_id
				});
			}
			function selectCityEdit(dist_id){
				$('#loadCitiesEdit').load('ajax_pages/loadCities.php',{
					d_id:dist_id
				});
			}
			//end
			function loadAllOrders(){
				$('#all_orders').load('ajax_pages/load_sent_orders.php');
			}
			//end
			function search_orders(search_key){
				$('#all_orders').load('ajax_pages/load_sent_orders.php',{
					skey:search_key
				});
			}
			//end
			window.addEventListener('load', function() {
			  loadAllOrders();
				<?php if(isset($_REQUEST['eid'])){
					$orid = $_REQUEST['eid'];
					 ?>
					editOrder(<?= $orid ?>);
					<?php } ?>
			});
			//end
			function editOrder(or_id){
				$('#edit_order').modal('show');
				$('#load_edit').load('ajax_pages/edit_order.php',{
					order_id:or_id
				});
			}
			//end
			function deleteOrder(or_id){

				if(confirm('Are you sure you want to delete this order')){
					$.ajax({
						url: "backend/del_order.php",
						method: "POST",
						data: { id: or_id	},
						success: function(response) {
							if(response == "sucess"){
								$('#all_orders').load('ajax_pages/load_sent_orders.php');
								alert('successfully deleted');
							}
						}
					});
				}

			}

			function markOrderSt(status){
				var oid = document.getElementById('order_id_confirm').value;
				$.ajax({
					url: "backend/status.php",
					method: "POST",
					data: { st:status,or_id:oid	},
					success: function(response) {
						if(response == "success"){
							$('#all_orders').load('ajax_pages/load_sent_orders.php');
							$('#mark_orders').modal('hide');
						}
						else if (response =="error_login") {
							alert('Please Refresh Your page since you got some break from your work');
						}
					}
				});
			}


			  function deleteBulkOrders() {
                var checkboxes = document.querySelectorAll('input[type="checkbox"][id="checkBoxSet"]:checked');
                    var selectedValues = [];

                    checkboxes.forEach(function(checkbox) {
                    selectedValues.push(checkbox.value);
                    });

                    if (selectedValues.length === 0) {
                    alert('You have to select at least one order');
                    return;
                    }

			    if(confirm("Are you you want to delete all the selected data?")){


                    $.ajax({
                    url: "backend/delete_bulk_orders.php",
                    method: "POST",
                    data: {
                    or_ids: selectedValues
                    },
                    success: function(response) {
                    if(response == "success"){
                                alert('successfully deleted the selected orders');
                                $('#all_orders').load('ajax_pages/load_sent_orders.php');
                            }
                    }
                    });
                    }
			  }



		</script>
    <script>
    function fetchSubItems() {
  const itemId = document.getElementById("item").value; // Get selected item ID
  const subItemDropdown = document.getElementById("sub_item");

  // Show "Loading..." while fetching data
  subItemDropdown.innerHTML = '<option value="">Loading...</option>';

  // Check if an item is selected
  if (!itemId) {
      subItemDropdown.innerHTML = '<option value="">Select Sub Item</option>';
      return;
  }

  // AJAX request to fetch sub-items
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax_pages/fetch_sub_items.php", true); // Create a new file for backend processing
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
      if (xhr.status === 200) {
          subItemDropdown.innerHTML = xhr.responseText; // Update with fetched data
      } else {
          subItemDropdown.innerHTML = '<option value="">Failed to load sub-items</option>';
      }
  };
  xhr.send("item_id=" + itemId); // Send the selected item ID to the server
}

    </script>
    </body>
</html>
