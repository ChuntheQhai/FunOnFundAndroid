<?php $this->load->view('templates/head');?>

<body>
<?php $this->load->view('templates/header');?>
	<div class="content container">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">User</h3>
		  </div>
		  <div class="panel-body">
			<table id="tableList" class="table table-bordered">
				<thead>
					<tr>
						<th>id</th>
						<th>email</th>
						<th>password</th>
						<th>status</th>
						<th>created_datetime</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			
		  </div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">Edit User</h3>
		  </div>
		  <div class="panel-body">
			  <form id="editForm">
				<input type="text" class="form-control" name="email" placeholder="Enter email">
				<input type="text" class="form-control" name="password" placeholder="Enter password">
				<input type="text" class="form-control" name="status" placeholder="Enter status">
				<br/>
				<button type="button" class="btn btn-primary" onClick="update()">Update</button>
			  </form>
		  </div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">Create New User</h3>
		  </div>
		  <div class="panel-body">
			  <form id="newForm">
				<input type="text" class="form-control" name="email" placeholder="Enter email">
				<input type="text" class="form-control" name="password" placeholder="Enter password">
				<input type="text" class="form-control" name="status" placeholder="Enter status">
				<br/>
				<button type="button" class="btn btn-primary" onClick="addRow()">Add</button>
			  </form>
		  </div>
		</div>
    </div>
    
	
<?php $this->load->view('templates/footer');?>

<script>
	function getAll() {
		$.ajax({
		  type: "POST",
		  url: "<?php echo base_url('users/getAll'); ?>",
		  success: function(data) {
			$.each(data, function(i, entry) {
				appendData(entry);
			});
		  },
		  dataType: 'json'
		});
	}
	
	function appendData(data) {
		var html = "<tr data-id='" + data.id + "'>" +
			"<td>" + data.id + "</td>" +
			"<td>" + data.email + "</td>" +
			"<td>" + data.password + "</td>" +
			"<td>" + data.status + "</td>" +
			"<td>" + data.created_datetime + "</td>" +
			"<td><a href='#' class='btn btn-info' onClick='editRow("+data.id+");'><i class='glyphicon glyphicon-pencil'></i></a> <a class='btn btn-danger' href='#' onClick='deleteRow("+data.id+");'><i class='glyphicon glyphicon-trash'></i></a></td>";
		$("#tableList tbody").append(html);
	}
	
	function editRow(id) {
		
		$.ajax({
		  type: "POST",
		  url: "<?php echo base_url('users/get'); ?>",
		  data: {id:id},
		  success: function(data) {
			console.log(data.length);
			/*
			$('#editForm *').filter(':input').each(function(){
				if($(this).attr('type')=="text") {
					$(this).attr('name');
				}
			});
			*/
		  },
		  dataType: 'json'
		});
		
		
	}
	
	function addRow() {
		var form = $('#newForm');
		$.ajax({
		  type: "POST",
		  url: "<?php echo base_url('users/add'); ?>",
		  data: form.serialize(),
		  success: function(data) {
			$('#newForm')[0].reset();
			appendData(data);
		  },
		  dataType: 'json'
		});
	}
	
	function deleteRow(id) {
		$.ajax({
		  type: "POST",
		  url: "<?php echo base_url('users/delete'); ?>",
		  data: {id:id},
		  success: function(data) {
			$("#tableList tbody tr[data-id="+id+"]").remove();
		  },
		  dataType: 'json'
		});
	}
	
	getAll();
</script>
</body>
</html>