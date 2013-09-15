var AdminGridModel;
(function($) {
    var agm;
    AdminGridModel = function() {
        var self = this;
//        columns = [];
//        columns[0] = {
//            "name": "number",
//            "display": "#",
//            "type": "number",
//            "sortable": false
//        };
//        columns[1] = {
//            "name": "miniature",
//            "display": Translator.get("Miniature"),
//            "type": "text",
//            "sortable": true
//        };
//        columns[2] = {
//            "name": "name",
//            "display": Translator.get("Name"),
//            "type": "date",
//            "sortable": true
//        };
//        columns[3] = {
//            "name": "lastModified",
//            "display": Translator.get("Last Modified"),
//            "type": "bool",
//            "sortable": false
//        };
//        self.list().columns(columns);
    };
    ListModel.prototype.getUrl = function(page, sort, pageSize, sortDirection) {
        return Routing.generate("HexMediaContentMediaList", {
            page: page,
            sort: sort,
            pageSize: pageSize,
            sortDirection: sortDirection.toLowerCase()
        });
    };

    AdminGridModel.prototype = new GridModel();
    AdminGridModel.prototype.constructor = AdminGridModel;
    $(document).ready(function() {
        if ($(".data-area-grid").get(0)) {
            agm = new AdminGridModel();

            ko.applyBindings(agm, $(".data-area-grid").get(0));
        }
    });
})(jQuery);
