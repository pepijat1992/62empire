(function ($) {
    "use strict";
    var table = {
        initialize: function () {
            this.basic();
            this.dataScenario();
            this.jsGrid();
            this.customView();
        },
        basic: function () {
            $("#basic").jsGrid({
                height: "450px",
                width: "100%",
                filtering: true,
                editing: true,
                inserting: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 15,
                pageButtonCount: 5,
                deleteConfirm: "Do you really want to delete the client?",
                controller: db,
                fields: [
                    {name: "Name", type: "text", width: 150},
                    {name: "Age", type: "number", width: 50},
                    {name: "Address", type: "text", width: 200},
                    {name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name"},
                    {name: "Married", type: "checkbox", title: "Is Married", sorting: false},
                    {type: "control"}
                ]
            });
        },
        dataScenario: function () {
            $("#dataScenario").jsGrid({
                height: "450px",
                width: "100%",
                sorting: true,
                paging: true,
                data: db.clients,
                fields: [
                    {name: "Name", type: "text", width: 150},
                    {name: "Age", type: "number", width: 50},
                    {name: "Address", type: "text", width: 200},
                    {name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name"},
                    {name: "Married", type: "checkbox", title: "Is Married"}
                ]
            });
        },
        jsGrid: function () {
            $("#jsGrid").jsGrid({
                height: "450px",
                width: "100%",
                editing: true,
                autoload: true,
                paging: true,
                deleteConfirm: function (item) {
                    return "The client \"" + item.Name + "\" will be removed. Are you sure?";
                },
                rowClick: function (args) {
                    showDetailsDialog("Edit", args.item);
                },
                controller: db,
                fields: [
                    {name: "Name", type: "text", width: 150},
                    {name: "Age", type: "number", width: 50},
                    {name: "Address", type: "text", width: 200},
                    {name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name"},
                    {name: "Married", type: "checkbox", title: "Is Married", sorting: false},
                    {
                        type: "control",
                        modeSwitchButton: false,
                        editButton: false,
                        headerTemplate: function () {
                            return $("<button class='btn btn-success btn-sm'>").attr("type", "button").text("Add")
                                    .on("click", function () {
                                        showDetailsDialog("Add", {});
                                    });
                        }
                    }
                ]
            });
            $("#detailsDialog").dialog({
                autoOpen: false,
                width: 400,
                close: function () {
                    $("#detailsForm").validate().resetForm();
                    $("#detailsForm").find(".error").removeClass("error");
                }
            });

            $("#detailsForm").validate({
                rules: {
                    name: "required",
                    age: {required: true, range: [18, 150]},
                    address: {required: true, minlength: 10},
                    country: "required"
                },
                messages: {
                    name: "Please enter name",
                    age: "Please enter valid age",
                    address: "Please enter address (more than 10 chars)",
                    country: "Please select country"
                },
                submitHandler: function () {
                    formSubmitHandler();
                }
            });

            var formSubmitHandler = $.noop;

            var showDetailsDialog = function (dialogType, client) {
                $("#name").val(client.Name);
                $("#age").val(client.Age);
                $("#address").val(client.Address);
                $("#country").val(client.Country);
                $("#married").prop("checked", client.Married);

                formSubmitHandler = function () {
                    saveClient(client, dialogType === "Add");
                };

                $("#detailsDialog").dialog("option", "title", dialogType + " Client")
                        .dialog("open");
            };

            var saveClient = function (client, isNew) {
                $.extend(client, {
                    Name: $("#name").val(),
                    Age: parseInt($("#age").val(), 10),
                    Address: $("#address").val(),
                    Country: parseInt($("#country").val(), 10),
                    Married: $("#married").is(":checked")
                });

                $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

                $("#detailsDialog").dialog("close");
            };
        },
        customView: function () {
            $("#customView").jsGrid({
                height: "450px",
                width: "100%",
                filtering: true,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 15,
                pageButtonCount: 5,
                controller: db,
                fields: [
                    {name: "Name", type: "text", width: 150},
                    {name: "Age", type: "number", width: 50},
                    {name: "Address", type: "text", width: 200},
                    {name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name"},
                    {name: "Married", type: "checkbox", title: "Is Married", sorting: false},
                    {type: "control", modeSwitchButton: false, editButton: false}
                ]
            });
            $(".config-panel input[type=checkbox]").on("click", function () {
                var $cb = $(this);
                $("#customView").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
            });
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        table.initialize();
    });

}(jQuery));