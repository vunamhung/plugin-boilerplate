$("#settings-tab").submit(function() {
	$(this).ajaxSubmit({
		success: function() {
			$("#saveResult").html("<div id='saveMessage' class='successModal'></div>");
			$("#saveMessage")
				.append(`<p>${settingsPage.saveMessage}</p>`)
				.show();
		},
		timeout: 5000,
	});
	setTimeout("jQuery('#saveMessage').hide('slow');", 5000);
	return false;
});
