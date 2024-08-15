"use strict";
var table;
var _e, _diff, _edit;

class Table{
	constructor(initParams){
		//this.ajaxLink = ajaxLink;
		//this.columns = columns;
		this.datatable;
		this.sortingMode = false;
		this.$table = $('#dataTable');
		this.$toolbar = $('#dataTable div.toolbar');
		this.dom = (typeof tableDom != 'undefined')?tableDom:'<"toolbar">Bfrtip';
		this.buttons = (typeof tableButtons != 'undefined')?tableButtons:initParams.export;
		if (initParams) {
			Object.assign(this, initParams)
		}

		this.init();
	}
	init(){
		var self = this;
		self.create(self.order, self.paginate, false, true);
		$('tbody', self.$table).on( 'click', 'tr', function () {
			$(this).toggleClass('selected');
		});
	}
	create(order, paginate, rowReorder, searching){
		var self = this;
		self.datatable = self.$table.DataTable({
			//data: data
			ajax: self.ajaxLink
			//, colReorder: colReorder
			, columns: self.columns
			, columnDefs: (self.sortingMode)?columnDefsSort:columnDefs
			, order: (typeof order != 'undefined')?order:self.order
			, rowReorder: (typeof rowReorder != 'undefined')?rowReorder:self.rowReorder
			, retrieve: false
			, pageLength: (typeof pageLength != 'undefined')?pageLength:10
			, paginate: (typeof paginate != 'undefined')?paginate:self.paginate
			, searching: (typeof searching != 'undefined')?searching:self.searching
			, dom: self.dom
			, buttons: self.buttons
			, fnDrawCallback: function( oSettings ) {
				//do nothing
			}
			, initComplete: function( oSettings ) {
				self.dataTable = this;
				callBack();  //include views list.php
			}
			/*, stateSave: false*/, stateSave: true
			, scrollX: true
		});
		if(typeof rowReorder != 'undefined'){
			if(rowReorder){
				if(typeof rowReorder.pos != 'undefined' && !rowReorder.pos){

				}else{
					self.reorder();
				}
			}
		}
		return self.datatable;
	}//create function eol
	reorder(){
		var self = this;
		var formOrder = [];
		self.datatable.state.clear();
		self.datatable.off( 'row-reorder' );
		self.datatable.on( 'row-reorder', function ( e, diff, edit ) {
			_e = e; _diff = diff; _edit = edit;
			loadingModalOpen();
			for( var i=0, ien=diff.length ; i<ien ; i++ ){
				var id = self.datatable.data()[diff[i].oldPosition].id;
				var pos = self.datatable.data()[diff[i].newPosition].position;
			//	console.log(id+', '+pos);
				formOrder.push([id, pos]);
			}
		//	console.log(diff);
			//console.log(_e); console.log(_diff); console.log(_edit);
			//console.log(formOrder);
			//return;
			var section = $('.c-sidebar-nav-link.c-active').text();

			$.ajax({
				type: "POST",
				url: self.sortLink,
				data: {'order':formOrder, 'section': section},
				success: function(data){
					//console.log(data);
					setTimeout(function(){
						loadingModalClose();
						if(data == 't'){
							self.datatable.ajax.reload();
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
		});
	}//reorder function eol

}
