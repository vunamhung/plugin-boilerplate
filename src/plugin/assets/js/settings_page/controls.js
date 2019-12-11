import "jquery.repeater";

$(".repeat-table").repeater();

$(".drag")
	.sortable({
		axis: "y",
		cursor: "pointer",
		opacity: 0.5,
		placeholder: "row-dragging",
		delay: 150,
	})
	.disableSelection();
