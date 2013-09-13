var AdminListModel;
(function($) {
	var alm;
	AdminListModel = function() {
		var self = this, columns;
		columns = [];
		columns[0] = {
			"name": "number",
			"display": "#",
			"type": "number",
			"sortable": false
		};
		columns[1] = {
			"name": "name",
			"display": Translator.get("Name"),
			"type": "text",
			"sortable": true
		};
		columns[2] = {
			"name": "page",
			"display": Translator.get("Page"),
			"type": "text",
			"sortable": true
		};
        columns[3] = {
            "name": "route",
            "display": Translator.get("Route"),
            "type": "text",
            "sortable": true
        };
		columns[4] = {
			"name": "lastModified",
			"display": Translator.get("Last Modified"),
			"type": "date",
			"sortable": true
		};
		self.list().columns(columns);
	};
	ListModel.prototype.getUrl = function(page, sort, pageSize, sortDirection) {
		return Routing.generate("HexMediaContentAreaList", {
			page: page,
			sort: sort,
			pageSize: pageSize,
			sortDirection: sortDirection.toLowerCase()
		});
	};

	AdminListModel.prototype = new ListModel();
	AdminListModel.prototype.constructor = AdminListModel;
	$(document).ready(function() {
		if ($(".data-area-list").get(0)) {
			alm = new AdminListModel();
			alm.deleteConfirm().action = function(data) {
				$.ajax($(data.caller).attr("href"), {
					dataType: "json",
					type: "DELETE",
					success: function(response) {
						alerts.displaySuccess(Translator.get("Succesfully removed."), 3);
						alm.getData();
					},
					error: function(a, b, errorMessage, d) {
						var json, message;
						json = $.parseJSON(a.responseText);
						message = json[0].message;
						alerts.displayError(message, 3);
					}
				});
				return false;
			};
			ko.applyBindings(alm, $(".data-area-list").get(0));
		}
	});
})(jQuery);
