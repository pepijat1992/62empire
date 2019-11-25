$(document).ready(function () {
    "use strict"; // Start of use strict

// html demo
    $('#html').jstree();
    // inline data demo
    $('#data').jstree({
        'core': {
            'data': [
                {"text": "Root node", "children": [
                        {"text": "Child node 1"},
                        {"text": "Child node 2"}
                    ]}
            ]
        }
    });
    // data format demo
    $('#frmt').jstree({
        'core': {
            'data': [
                {
                    "text": "Root node",
                    "state": {"opened": true},
                    "children": [
                        {
                            "text": "Child node 1",
                            "state": {"selected": true},
                            "icon": "jstree-file"
                        },
                        {"text": "Child node 2", "state": {"disabled": true}}
                    ]
                }
            ]
        }
    });
    // ajax demo
    $('#ajax').jstree({
        'core': {
            'data': {
                "url": "assets/plugins/vakata-jstree/dist/root.json",
                "dataType": "json" // needed only if you do not supply JSON headers
            }
        }
    });
    // lazy demo
    $('#lazy').jstree({
        'core': {
            'data': {
                "url": "https://www.jstree.com/fiddle/?lazy",
                "data": function (node) {
                    return {"id": node.id};
                }
            }
        }
    });
    // data from callback
    $('#clbk').jstree({
        'core': {
            'data': function (node, cb) {
                if (node.id === "#") {
                    cb([{"text": "Root", "id": "1", "children": true}]);
                } else {
                    cb(["Child"]);
                }
            }
        }
    });
    // interaction and events
    $('#evts_button').on("click", function () {
        var instance = $('#evts').jstree(true);
        instance.deselect_all();
        instance.select_node('1');
    });
    $('#evts')
            .on("changed.jstree", function (e, data) {
                if (data.selected.length) {
                    alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
                }
            })
            .jstree({
                'core': {
                    'multiple': false,
                    'data': [
                        {"text": "Root node", "children": [
                                {"text": "Child node 1", "id": 1},
                                {"text": "Child node 2"}
                            ]}
                    ]
                }
            });



    $.fn.extend({
        treed: function (o) {

            var openedClass = 'far fa-folder-open';
            var closedClass = 'far fa-folder';

            if (typeof o !== 'undefined') {
                if (typeof o.openedClass !== 'undefined') {
                    openedClass = o.openedClass;
                }
                if (typeof o.closedClass !== 'undefined') {
                    closedClass = o.closedClass;
                }
            }
            ;

            //initialize each of the top levels
            var tree = $(this);
            tree.addClass("tree");
            tree.find('li').has("ul").each(function () {
                var branch = $(this); //li with children ul
                branch.prepend("<i class='indicator far " + closedClass + "'></i>");
                branch.addClass('branch');
                branch.on('click', function (e) {
                    if (this === e.target) {
                        var icon = $(this).children('i:first');
                        icon.toggleClass(openedClass + " " + closedClass);
                        $(this).children().children().toggle();
                    }
                });
                branch.children().children().toggle();
            });
            //fire event from the dynamically added icon
            tree.find('.branch .indicator').each(function () {
                $(this).on('click', function () {
                    $(this).closest('li').click();
                });
            });
            //fire event to open branch if the li contains an anchor instead of text
            tree.find('.branch>a').each(function () {
                $(this).on('click', function (e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
            //fire event to open branch if the li contains a button instead of text
            tree.find('.branch>button').each(function () {
                $(this).on('click', function (e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
        }
    });

    //Initialization of treeviews
    $('#tree1').treed({openedClass: 'far fa-folder-open', closedClass: 'far fa-folder'});
    $('#tree2').treed({openedClass: 'fas fa-folder-open', closedClass: 'fas fa-folder'});
    $('#tree3').treed({openedClass: 'fas fa-minus', closedClass: 'fas fa-plus'});
});