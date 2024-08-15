
$(function(){
	$('#dataTable').DataTable({
		serverSide: true,
		pageLength: 15,  //3, 15
		order: [[ 0, "desc" ]],
		columnDefs: columnDefs, 
		ajax: {
			type: 'POST',  //POST, GET
			url : self.ajaxLink,
		},
		searching: true,
		stateSave: true,
		bLengthChange: false, //thought this line could hide the LengthMenu
		scrollX: true,
	});
});
