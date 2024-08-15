
$(function(){
	//table = $('#table_id').DataTable();
	//table.state.clear();
	//table.destroy();
	table = new Table({
		'ajaxLink': ajaxLink,
		'approvalLink': approvalLink,
		'columns': columns,
		'columnDefs': columnDefs,
		'order': order,
		'paginate': paginate,
		'pageLength': pageLength,
		'publishLink': publishLink,
		'sortLink': sortLink,
		'statusLink': statusLink,
		'export': exportFile,
	});

});

listPage = ()=>{
	table.datatable.state.clear();
	table.sortingMode = false;
	table.datatable.destroy();
	table.create();
};

sortPage = ()=>{
	table.datatable.state.clear();
	table.sortingMode = true;
	table.$toolbar.removeClass('mode-list').addClass('mode-sort');
	table.datatable.destroy();
	self.sortLink,
	table.create(order, false, {"update": false}, false);
};

multiItemsUpdate = (type, value) => {
	var rows = table.datatable.rows('.selected');
	var ids = [];
	var sectionName = $('.c-sidebar-nav-link.c-active').text();
	var url = '', data = {}, approval_titles = [], crawlerUrls = [];

	if(rows[0].length > 0){
		loadingModalOpen();
		//console.log(rows);

		$.each(rows.data(), function(index, value){
			ids.push($(this)[0].id);
			if(typeof $(this)[0].url != 'undefined') crawlerUrls.push($(this)[0].url);
			if(typeof $(this)[0].title_i18n != 'undefined') approval_titles.push($(this)[0].title_i18n);
		});

		if(type == 'status'){
			url = table.statusLink;
			data = {'ids':ids, 'value':value, 'section_name': sectionName,};
		}else if(type == 'publish'){
			url = table.publishLink;
			data = {'ids':ids, 'section_name': sectionName,};
		}else if(type == 'approval'){
			url = table.approvalLink;
			data = {'ids':ids, 'section_name': sectionName, 'approval_titles': approval_titles,};
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
						//table.datatable.ajax.reload();
						table.datatable.ajax.reload(function(){}, false);  //not change page
						successModalOpen();
						if(type == 'publish'){
							crawler('', crawlerUrls);  //ultd.js
						}
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
		//do nothing
	}
};

copyToClickBoard = (content) => {
	if (!navigator.clipboard) {
		// Clipboard API not available
		console.log(`copied content: ${content}`)
		return
	}

    navigator.clipboard.writeText(content)
    	.then(() => { console.log("Text copied to clipboard...")})
        .catch(err => { console.log('Something went wrong', err);})
}