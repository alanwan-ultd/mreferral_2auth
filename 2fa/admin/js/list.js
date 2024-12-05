
$(function () {
	//table = $('#table_id').DataTable();
	//table.state.clear();
	//table.destroy();
	table = new Table({
		'ajaxLink': ajaxLink,
		'columns': columns,
		'columnDefs': columnDefs,
		'order': order,
		'paginate': paginate,
		'pageLength': pageLength,
		'publishLink': publishLink,
		'sortLink': sortLink,
		'statusLink': statusLink,
		'export': [],
	});
});

listPage = () => {
	table.datatable.state.clear();
	table.sortingMode = false;
	table.datatable.destroy();
	table.create();
}

sortPage = () => {
	table.datatable.state.clear();
	table.sortingMode = true;
	table.$toolbar.removeClass('mode-list').addClass('mode-sort');
	table.datatable.destroy();
	self.sortLink,
		table.create(order, false, { "update": false }, false);
}

publishUpdate = (approval = false) => {
	var rows = table.datatable.rows('.selected');
	var ids = [];
	var titles = [];
	var urls = [];
	if (approval) {
		var url = 'views/submitApproval_save.php?action=submitAllItems';
	} else {
		var url = table.publishLink;
	}
	var section = $('.c-sidebar-nav-link.c-active').text();
	if (rows[0].length > 0) {
		loadingModalOpen();
		//console.log(rows);
		$.each(rows.data(), function (index, value) {
			ids.push($(this)[0].id);

			// if url variable set, will group them to crawl
			if ($(this)[0].url !== undefined && $(this)[0].url) {
				urls.push($(this)[0].url);
			}
		});
		if (approval) {
			var data = {
				'ids': ids,
				'pid': approval_pid,
				'section': section_name,
				'section_name': section,
			};
		} else {
			var data = {
				'ids': ids,
				'pid': approval_pid,
				'section': section,
			};
		}
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function (data) {
				//console.log(data);
				setTimeout(function () {
					loadingModalClose();
					if (data == 't') {
						if (urls !== undefined && urls.length > 0) {
							bulk_crawler(crawler_link, urls);
						}
						table.datatable.ajax.reload();
						table.datatable.ajax.reload(function () { }, false);  //not change page
						successModalOpen();
					} else {
						warningModalOpen();
					}
				}, 500);
				clearCache();
			},
			error: function (data) {
				//console.log('error'+data);
				setTimeout(function () {
					loadingModalClose();
					warningModalOpen();
				}, 500);
			},
			dataType: 'html'  //xml, json, script, or html
		});
	} else {
		//  warningModalOpen();
	}
}

statusUpdate = (value) => {
	//  var self = this;
	var rows = table.datatable.rows('.selected');
	var ids = [];
	var section = $('.c-sidebar-nav-link.c-active').text();

	if (rows[0].length > 0) {
		loadingModalOpen();
		//console.log(rows);
		$.each(rows.data(), function (index, value) {
			ids.push($(this)[0].id);
		});
		$.ajax({
			type: "POST",
			url: table.statusLink,
			data: { 'ids': ids, 'value': value, 'section': section, },
			success: function (data) {
				//console.log(data);
				setTimeout(function () {
					loadingModalClose();
					if (data == 't') {
						table.datatable.ajax.reload();
						table.datatable.ajax.reload(function () { }, false);  //not change page
						successModalOpen();
					} else {
						warningModalOpen();
					}
				}, 500);
			},
			error: function (data) {
				//console.log('error'+data);
				setTimeout(function () {
					loadingModalClose();
					warningModalOpen();
				}, 500);
			},
			dataType: 'html'  //xml, json, script, or html
		});
	} else {
		//  warningModalOpen();

		//  $('#warningStatusModal').modal('show');
	}
}
