function viewModalAlert(modal_h4, modal_p, item_id, function_save) {
	$('#modal_h4').html(modal_h4);
	$('#modal_p').html(modal_p);
	$('#modal_form_item_id').val(item_id);
	$('#modal_action_form').attr('action', '');
	
	if(function_save!=null) {
		$('#modal_save').show();
		$('#modal_save').click(function_save);
	} else {
		$('#modal_save').hide();
		$('#modal_save').click('');
	}
	
	$('#modal_alert').modal('show');
}