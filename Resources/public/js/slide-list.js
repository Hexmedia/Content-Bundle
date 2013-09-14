var AdminListModel;
var listModelInstance;
(function($) {
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
			"name": "title",
			"display": Translator.get("Title"),
			"type": "text",
			"sortable": true
		};
        columns[2] = {
            "name": "published",
            "display": Translator.get("Published"),
            "type": "boolean",
            "sortable": true
        };
        columns[3] = {
            "name": "publishedFrom",
            "display": Translator.get("Published From"),
            "type": "date",
            "sortable": true
        };
        columns[4] = {
            "name": "publishedTo",
            "display": Translator.get("Published To"),
            "type": "date",
            "sortable": true
        };
		columns[5] = {
			"name": "lastModified",
			"display": Translator.get("Last Modified"),
			"type": "date",
			"sortable": true
		};
		self.list().columns(columns);

        self.sliderId = 22;
	};
	ListModel.prototype.getUrl = function(data) {
		return Routing.generate("HexMediaContentSlideList", data);
	};

	AdminListModel.prototype = new ListModel();
	AdminListModel.prototype.constructor = AdminListModel;
	$(document).ready(function() {
		if ($(".data-area-list").get(0)) {
			listModelInstance = new AdminListModel();

            listModelInstance.urlData({
                sliderId: listModelInstance.sliderId
            });

            console.log(listModelInstance.urlData());

			listModelInstance.deleteConfirm().action = function(data) {
				$.ajax($(data.caller).attr("href"), {
					dataType: "json",
					type: "DELETE",
					success: function(response) {
						alerts.displaySuccess(Translator.get("Succesfully removed."), 3);
						listModelInstance.getData();
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
			ko.applyBindings(listModelInstance, $(".data-area-list").get(0));
		}
	});
})(jQuery);
