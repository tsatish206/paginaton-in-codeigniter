<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
	<div class="container">
		
		<br><br>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
		  Add Record
		</button><br><br>


	    <form id="createForm">
		<!-- Modal -->
		<div class="modal fade" id="createModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Add Record</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">

		        
		        	<div class="form-group">
					    <label>Name</label>
					    <input type="text" class="form-control" placeholder="Name here" name="first_name" required>
					 </div>
					 <div class="form-group">
					    <label>Email</label>
					    <input type="email" class="form-control" placeholder="Email Here" name="email" required>
					 </div>
					 <div class="form-group">
					    <label>Mobile</label>
					    <input type="number" class="form-control" placeholder="Mobile Here" name="mobile" required>
					 </div>
		       
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save</button>
		      </div>
		    </div>
		  </div>
		</div>
		</form>
		<!--edit!-->
		
		<!-- Modal -->
		<div class="modal fade" id="editModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Add Record</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
			  
		    <form id="frm_contact_edit"> 
		      <div class="modal-body" id="edit_model">		        
		        	
		      </div>
            </form>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
		        <button type="submit" id="frm_edit" class="btn btn-primary">Save</button>
		      </div>
		    </div>
		  </div>
		</div>

		<table id="example1" class="display table">
		    <thead>
		        <tr>
		            <th>S.No</th>
		            <th>Name</th>
		            <th>Email</th>
		            <th>Mobile</th>
		            <th>Created By</th>
		            <th>Action</th>
		        </tr>
		    </thead>

		</table>
	</div>


	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


	<script type="text/javascript">
		function remove(id){
        jQuery.ajax({
                url: "<?= base_url('contact/delete') ?>",
                dataType: 'JSON',
                method: 'POST',
                data: {'id': id},
                success: function(data) {
                    jQuery.noConflict()
	                jQuery('#example1').DataTable().ajax.reload();    
                    alert('Contact Deleted Succesfully');                
                }
          });
  
       }

  function edit(mod){
    jQuery.ajax({
                url: "<?= base_url('contact/view') ?>",
                dataType: 'JSON',
                method: 'POST',
                data: {'id': mod},
                success: function(data) {
                    jQuery.noConflict()
                    jQuery('#editModal').modal('show');
	                jQuery('#example1').DataTable().ajax.reload();
                    jQuery('#edit_model').html('<div class="form-group"><input type="hidden" id="id" value="'+data['id']+'"><label>Name</label><input type="text" class="form-control" placeholder="Name here" name="first_name" id="first_name" value="'+data['first_name']+'"></div><div class="form-group"><label>Email</label><input type="email" class="form-control" placeholder="Email Here" name="email" id="email" value="'+data['email']+'"></div><div class="form-group"><label>Mobile</label><input type="number" class="form-control" value="'+data['mobile']+'" placeholder="Mobile Here" name="mobile" id="mobile"></div>');
                    
                }
          });
  }
	
		//inserting data into database code start here

		$("#createForm").submit(function(event) {
			event.preventDefault();
			$.ajax({
	            url: "<?php echo base_url('contact/create'); ?>",
	            data: $("#createForm").serialize(),
	            type: "post",
	            async: false,
	            dataType: 'json',
	            success: function(response){
	              
	                $('#createModal').modal('hide');
	                $('#createForm')[0].reset();
	                alert('Successfully inserted');
	               $('#example1').DataTable().ajax.reload();
	              },
	           error: function()
	           {
	            alert("error");
	           }
          });
		});

		//inserting data into database code end here


		//displaying data on page start here
		jQuery(document).ready(function(){
			jQuery('#example1').DataTable({
				"ajax" : "<?php echo base_url('contact/fetchData'); ?>",
				"order": [],
			});
			

			jQuery('#frm_edit').click(function(){
				var name = jQuery('#first_name').val();
				var email = jQuery('#email').val();
				var mobile = jQuery('#mobile').val();   
				var id = jQuery('#id').val();    
					jQuery.ajax({
					url:'<?php echo base_url();?>contact/edit',
					type:"POST",
					data:{'name': name, 'email':email, 'mobile':mobile,'id':id},
					
					success: function(data){
						var resp = data.split('::');
						if(resp[0]==200)
						{ 
							jQuery('#editModal').modal('hide');							
							jQuery('#example1').DataTable().ajax.reload();
						}else if(resp[0]==305){
							alert('something went wrong');
						}    
					}
					});
				});
		});
		//displaying data on page end here
	</script>


</body>
</html>