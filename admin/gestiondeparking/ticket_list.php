<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>name</th>
						<th>Fname</th>
						<th>Age</th>
						<th>telNumber</th>
						<th>appDate</th>
						<th>appTime</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM appointment ORDER BY id_appointment DESC");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo ucwords($row['name']) ?></b></td>
						<td class=""><b><?php echo ucwords($row['Fname']) ?></b></td>
						<td class=""><b><?php echo $row['Age'] ?></b></td>

						<td class=""><b><?php echo $row['telNumber'] ?></b></td>
						<td class=""><b><?php echo date("M d, Y",strtotime($row['appDate'])) ?></b></td>
						<td class=""><b><?php echo date("h:i A",strtotime($row['appTime'])) ?></b></td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_tickets').click(function(){
			uni_modal("tickets's Details","view_ticket.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_ticket').click(function(){
		_conf("Are you sure to delete this tickets?","delete_ticket",[$(this).attr('data-id')])
	})
	})
	function delete_ticket($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_ticket',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
