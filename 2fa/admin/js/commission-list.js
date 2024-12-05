// allowFilter for cash rebate form only
var allowFilter = ['2faCommissionTable'];
var fieldLastModifyDate = 5;

$.fn.dataTable.ext.search.push(
	function (settings, data, dataIndex) {
		if ($.inArray($(settings.nTable).data('table-id'), allowFilter) == -1) {
			// if not table should be ignored
			return true;
		}

		let modify_fm = new Date($('#modify_fm').val());
		let modify_to = new Date($('#modify_to').val());
		// let modify_date = new Date(data[fieldLastModifyDate]).getTime(); // for date format: 2024-05-14 00:00:00.0000000 +08:00
		let dateParts = data[fieldLastModifyDate].split('/'); // for date format: 27/5/2024
		let modify_date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]).getTime();

		modify_fm.setHours(0, 0, 0, 0);
		modify_to.setHours(23, 59, 59, 999);

		// modify_to += (1*24*60*60*1000); //modify_to is day end

		if (((isNaN(modify_fm) && isNaN(modify_to)) ||
			(isNaN(modify_fm) && modify_date <= modify_to) ||
			(modify_fm <= modify_date && isNaN(modify_to)) ||
			(modify_fm <= modify_date && modify_date <= modify_to))) {
			return true;
		}
		return false;
	}
);

$(function () {
	console.log('test 123');
	// check cookies exist to set filter value
	initFilterPanel();
	// calculateTotal();

	// filter
	$('.commission-filter .filter-header').on('click', function () {
		if ($(this).find('.btn-collapse').hasClass('open')) {
			$(this).find('.btn-collapse').removeClass('open');
			$('.commission-filter .filter-group-wrapper').slideUp();
		} else {
			$(this).find('.btn-collapse').addClass('open');
			$('.commission-filter .filter-group-wrapper').slideDown();
		}
	});

	$('.commission-filter .btn-filter').on('click', function () {
		filter();
	});

	$('.commission-filter .btn-reset').on('click', function () {
		$('#modify_fm').val('');
		$('#modify_to').val('');

		filter();
	});
});

function filter() {
	setTimeout(() => {
		table.datatable.destroy();
		table.create();
		setTimeout(() => {
			calculateTotal();
		}, 1000);
	}, 100);

	// set cashrebate filter cookies
	cookieSet('2fa_modify_fm', $('#modify_fm').val(), 30);
	cookieSet('2fa_modify_to', $('#modify_to').val(), 30);
}

function initFilterPanel() {
	const modify_fm = cookieGet('2fa_modify_fm');
	const modify_to = cookieGet('2fa_modify_to');

	if (modify_fm) $('#modify_fm').val(modify_fm);
	if (modify_to) $('#modify_to').val(modify_to);

	// open filter panel
	if (modify_fm || modify_to) {
		$('.commission-filter .btn-collapse').addClass('open');
		$('.commission-filter .filter-group-wrapper').slideDown();
	}

	filter();
}

function calculateTotal() {

	if (!table || !table.datatable) {
		console.error('DataTable instance is not initialized.');
		return;
	}

	let total = 0;

	table.datatable.rows({ filter: 'applied' }).every(function (rowIdx, tableLoop, rowLoop) {
		const rowData = this.data();
		const rawValue = rowData['comm_to_pc'];
		const amount = parseToNumber(rawValue); // Use the helper function below
		if (!isNaN(amount)) {
			total += amount;
		}
	});

	// Display the total (adjust the selector to match your UI)
	$('#totalAmountDisplay span').text(total.toFixed(2));
}

function parseToNumber(value) {
	if (typeof value === 'string') {
		// Remove non-numeric characters except decimal points
		value = value.replace(/[^\d.-]/g, '');
	}
	return parseFloat(value); // Convert to a floating-point number
}