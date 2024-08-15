
<a href="submitApproval_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back To Approval List</a>
<input type="hidden" name="approval_publish" value="views/submitApproval_save.php?">
<input type="hidden" name="approval_id" value="<?php echo $approval_id;?>">

<?php
$approval_msg = $model->getApprovalMsg($id);
if($approval_msg){
?>

<!--div class="card" >
	<div class="card-header dropdown-toggle" data-toggle="collapse" href="#approvalHistoryList" role="button" aria-expanded="false" aria-controls="approvalHistoryList"><strong>Approval History</strong></div>
	<div class="card-body collapse" id="approvalHistoryList">
			<table class="table table-bordered" >
				<tr>
					<th>Date</th>
					<th>Submitted By</th>
					<th>Message</th>
					<th>Status</th>
				</tr>
				<?php foreach ($approval_msg as $key => $value) {?>
					<tr>
						<td><?php echo $approval_msg[$key]['createDateTime']; ?></td>
						<td><?php echo $approval_msg[$key]['createBy']; ?></td>
						<td><?php echo $approval_msg[$key]['msg']; ?></td>
						<td><?php echo $approval_msg[$key]['approve']; ?></td>
					</tr>
				<?php  } ?>
			</table>
	</div>
</div-->
<?php } ?>
