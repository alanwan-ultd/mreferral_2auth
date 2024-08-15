var listTable;

$(function(){
	//table = $('#table_id').DataTable();
	//table.state.clear();
	//table.destroy();
	listTable = $('#dataTable').DataTable({
		"serverSide": true,
		"pageLength": 20,
		//columns: (self.columns)?self.columns:null, 
		columnDefs: (self.columnDefs)?self.columnDefs:null, 
		order: (self.order)?self.order:[[ 0, "desc" ]], 
		//"order": [[ 0, "desc" ]],
		dom: (self.dom)?self.dom:'<"toolbar">frtip', 
		ajax: {
			type: 'GET',
			url :self.ajaxLink,
		},
		searching: true,
		"bLengthChange" : false, //thought this line could hide the LengthMenu
		scrollX: true,
		stateSave: true, 
		"initComplete": function () {
			$('tbody', $('#dataTable')).on( 'click', 'tr', function () {
				$(this).toggleClass('selected');
			});

			if(callBack){
				callBack();
			}
		}, 
	});
});

publishUpdate = (approval=false)=>{
	const idCol = 0;
	const urlCol = 14;
	var rows = listTable.rows('.selected');
	var ids = [];
	var titles = [];
	var urls = [];
	if(approval){
		var url = 'views/submitApproval_save.php?action=submitAllItems';
	}else{
		var url = publishLink;
	}
	var section = $('.c-sidebar-nav-link.c-active').text();

	if(rows[0].length > 0){
		loadingModalOpen();
			//console.log(rows);
			$.each(rows.data(), function(index, value){
				ids.push($(this)[idCol]);
				if($(this)[urlCol]) urls.push($(this)[urlCol]);
			});

			if(approval){
				var data = {
					'ids':ids,
					'pid':approval_pid,
					'section': section_name,
					'section_name': section,
				};
			}else{
				var data = {
					'ids':ids,
					'pid':approval_pid,
					'section': section,
				};
			}
			$.ajax({
				type: "POST",
				url: url,
				data: data,
				success: function(data){
					//console.log(data);
					setTimeout(function(){
						loadingModalClose();
							if(data == 't'){
								if(urls !== undefined && urls.length > 0) {
									bulk_crawler(crawler_link, urls);
								}
								listTable.ajax.reload();
								listTable.ajax.reload(function(){}, false);  //not change page
							successModalOpen();
							}else{
								warningModalOpen();
							}
					}, 500);
					clearCache();
				},
				error: function(data){
					//console.log('error'+data);
					setTimeout(function(){
						loadingModalClose();
						warningModalOpen();
					}, 500);
				},
				dataType: 'html'  //xml, json, script, or html
			});
	}else{
	//  warningModalOpen();
	}
}

statusUpdate = (value) => {
	//  var self = this;
	var rows = listTable.rows('.selected');
	
	var ids = [];
	var section = $('.c-sidebar-nav-link.c-active').text();

	if(rows[0].length > 0){
		loadingModalOpen();
		//console.log(rows);
		$.each(rows.data(), function(index, value){
				ids.push($(this)[0]);
		});
		console.log(ids);
		$.ajax({
			type: "POST",
			url: statusLink,
			data: {'ids':ids, 'value':value, 'section': section,},
			success: function(data){
				//console.log(data);
				setTimeout(function(){
					loadingModalClose();
						if(data == 't'){
							listTable.ajax.reload();
							listTable.ajax.reload(function(){}, false);  //not change page
						successModalOpen();
						}else{
							warningModalOpen();
						}
				}, 500);
			},
			error: function(data){
				//console.log('error'+data);
				setTimeout(function(){
					loadingModalClose();
					warningModalOpen();
				}, 500);
			},
			dataType: 'html'  //xml, json, script, or html
		});
	}else{
	//  warningModalOpen();

	//  $('#warningStatusModal').modal('show');
	}
}
