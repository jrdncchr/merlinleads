<div id="app" class="col-xs-12">
    <div class="row">
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h4>Event Info</h4>
                <div class="notice"></div>
                <div class="row" id="event-form">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="event_name">* Name</label>
                            <input type="text" class="form-control required" id="event_name" value="{{ event.name }}" v-model="event.name"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="event_active">* Status</label>
                            <select id="event_active" class="form-control" v-model="event.active">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="event_description">* Description</label>
                            <input type="text" class="form-control required" id="event_description" value="{{ event.description }}" v-model="event.description" />
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-xs" v-on:click="saveEvent">Save Info</button>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12">
                <h4>Event Templates</h4>
                <table id="dt" class="dataTable no-multiple" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Default</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn btn-success btn-xs" v-on:click="showAddTemplateModalForm" style="margin-top: 15px;">Add Template</button>
            </div>
        </div>
    </div>

    <div class="modal fade no-callback" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="form-modal-label">Event Template</h4>
                </div>
                <div class="modal-body" style="padding: 20px 20px;">
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="template_name">* Name</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="template_name" class="form-control" v-model="template.name" value="{{ template.name }" />
                                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template_content">* Content</label>
                                <div class="input-group input-group-sm">
                                    <textarea id="template_content" class="form-control" v-model="template.content" style="height: 50px;">{{ template.content }}</textarea>
                                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template_active">* Status</label>
                                <select id="template_active" class="form-control" v-model="template.active">
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="template_is_default">* Default</label>
                                <select id="template_is_default" class="form-control" v-model="template.is_default">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="template-delete-btn" type="button" class="btn btn-default btn-sm pull-left" v-on:click="deleteTemplate">Delete</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" v-on:click="saveTemplate">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . "admin2/events" ?>";

    var data = {
        event: {
            id: <?php echo isset($event) ? json_encode($event->id) : '\'\'' ?>,
            name: <?php echo isset($event) ? json_encode($event->name) : '\'\'' ?>,
            description: <?php echo isset($event) ? json_encode($event->description) : '\'\'' ?>,
            active: <?php echo isset($event) ? json_encode($event->active) : '\'\'' ?>
        },
        template: {
            event_id: <?php echo isset($event) ? json_encode($event->id) : '\'\'' ?>,
            id: '',
            name: '',
            content: '',
            active: 1,
            is_default: 0
        }
    };

    var vm = new Vue({
        el: '#app',
        data: data,
        methods: {
            saveEvent: function() {
                if (validator.validateForm($('#event-form'))) {
                    loading('info', 'Saving...');
                    $.post(actionUrl, {action: 'property_events_save', event: data.event}, function(res) {
                        if (res.success) {
                            loading('success', 'Saving event successful!');
                        } else {
                            loading('error', 'Something went wrong.');
                        }
                    }, 'json');
                }
            },
            saveTemplate: function() {
                if (validator.validateForm($('#form-modal'))) {
                    loading('info', 'Saving...');
                    $.post(actionUrl, {action: 'property_events_templates_save', template: data.template}, function(res) {
                        if (res.success) {
                            dt.fnReloadAjax();
                            loading('success', 'Saving template successful!');
                        } else {
                            loading('error', 'Something went wrong.');
                        }
                        $('#form-modal').modal('hide');
                    }, 'json');
                }
            },
            deleteTemplate: function() {
                if(data.template.is_default == 1) {
                    validator.displayAlertError($('#form-modal'), true, 'You cannot delete a default template.');
                } else {
                    validator.displayAlertError($('#form-modal'), false);

                    loading('info', 'Deleting...');
                    $.post(actionUrl, {action: 'property_events_templates_delete', template_id: data.template.id}, function(res) {
                        if (res.success) {
                            dt.fnReloadAjax();
                            loading('success', 'Deleting template successful!');
                        } else {
                            loading('error', 'Something went wrong.');
                        }
                        $('#form-modal').modal('hide');
                    }, 'json');
                }
            },
            showAddTemplateModalForm: function() {
                $('#template-delete-btn').hide();
                data.template.id = "";
                data.template.name = "";
                data.template.content = "";
                data.template.active = 1;
                $('#form-modal').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                }).find('.modal-title').html('Add Event Template');
            }
        }
    });

    $(document).ready(function() {
        $("#eventsSideLink").addClass("custom-nav-active");
        $('#eventsPropertiesTopLink').addClass("custom-nav-active");
        setupDataTables();
    });

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [3],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "property_events_templates", "event_id": "<?php echo $event->id; ?>" }
            },
            "columns": [
                { data: "name", width: "55%" },
                { data: "is_default", width: "10%", render:
                    function(data, type, row) {
                        return data == 1 ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "";
                    }
                },
                { data: "active", width: "15%", render:
                    function(data, type, row) {
                        var textClass = data == "1" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" +  (data == 1 ? "Active" : "Inactive") + "</span></b>";
                    }
                },
                { data: "date_created", width: "20%" },
                { data: "id", visible: false },
                { data: "content",visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on("click", function () {
                    var pos = table.fnGetPosition(this);
                    var template = table.fnGetData(pos);
                    data.template.id = template.id;
                    data.template.name = template.name;
                    data.template.content = template.content;
                    data.template.active = template.active;
                    data.template.is_default = template.is_default;
                    $('#form-modal').modal({
                        show: true,
                        keyboard: false,
                        backdrop: 'static'
                    }).find('.modal-title').html('Edit Event Template');
                    $('#template-delete-btn').show();
                });
            }
        });
    }

</script>