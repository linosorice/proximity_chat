function alertDeleteCompany(company_id) {
	viewModalAlert('Sei sicuro di voler cancellare la company?', 'Cancellando la company, verranno rimossi anche tutti gli store associati', company_id, deleteCompany);
}

function deleteCompany() {
	$('#modal_action_form').attr('action', '{{ route('company_delete') }}');
	$('#modal_action_form').submit();
}

$(document).ready(function() {
	$('#list-company').DataTable({
		"ordering": false,
		"lengthChange": false,
		"pageLength": 10,
		"columns": [
			{ "width": "70%" },
			{ "width": "30%" }
		]
	});
});