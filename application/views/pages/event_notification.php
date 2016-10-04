<div class="row" id="app">
    <div class="col-sm-12">
        <p><a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties</a></p>
        <h4>Event Notification [ <?php echo $key_factors['property_name']; ?> ]</h4>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#notification" aria-controls="home" role="tab" data-toggle="tab">Notification Settings</a></li>
            <li role="presentation"><a href="#custom_templates" aria-controls="home" role="tab" data-toggle="tab">Custom Templates</a></li>
            <li role="presentation"><a href="#key_factors" aria-controls="profile" role="tab" data-toggle="tab">Key Factors</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="notification">

                <br />
                <div class="alert alert-info">
                    <i class="fa fa-question-circle"></i> Click the title to show options.
                </div>
                <?php if (!$facebook['valid_access_token'] || !$twitter['valid_access_token'] || !$linkedin['valid_access_token']): ?>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i> You have not integrated your Facebook account yet. <a href="<?php echo base_url() . 'main/myaccount/facebook'; ?>">Setup Now</a> <br />
                        <i class="fa fa-exclamation-circle"></i> You have not integrated your Linked In account yet. <a href="<?php echo base_url() . 'main/myaccount/linkedin'; ?>">Setup Now</a> <br />
                        <i class="fa fa-exclamation-circle"></i> You have not integrated your Twitter account yet. <a href="<?php echo base_url() . 'main/myaccount/twitter'; ?>">Setup Now</a> <br />
                    </div>
                <?php endif; ?>
                <div class="panel-group" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default" style="margin-bottom:20px;" v-for="es in event_settings">
                        <div class="panel-heading" role="tab" id="{{ es.event_key }}_heading">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" href="#{{ es.event_key }}" aria-expanded="true" aria-controls="{{ es.event_key }}">
                                            {{ es.name }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-sm-2">
                                    <div class="danero-switch pull-right">
                                        <input id="{{ es.event_key }}_active" type="checkbox" v-model="es.active" name="check" style="display: none;" />
                                        <label for="{{ es.event_key }}_active"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="{{ es.event_key }}" class="panel-collapse collapse {{ es.active ? 'in' : '' }}" role="tabpanel" aria-labelledby="_heading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-primary">{{ es.description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="{{ es.event_key }}_template_type">Type</label>
                                            <select id="{{ es.event_key }}_template_type" class="form-control" v-model="es.template_type">
                                                <option value="merlin">Merlin</option>
                                                <option value="custom">Custom</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="{{ es.event_key }}_template_id">Template</label>
                                            <select id="{{ es.event_key }}_template_id" class="form-control" v-model="es.template_id">
                                                <option v-for="option in getTemplatesByType(es, $event)" v-bind:value="option.id" >{{ option.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group pull-right">
                                            <section v-if="social_accounts.facebook.valid_access_token || social_accounts.twitter.valid_access_token || social_accounts.facebook.valid_access_token">
                                                <label>Social Accounts Available</label>
                                                <div class="form-control-static">
                                                    <section v-if="social_accounts.facebook.valid_access_token">
                                                        <i v-if="es.modules.indexOf('facebook') == -1" class="fa fa-facebook-square fa-2x social" v-on:click="toggleModule(es, $event)"></i>
                                                        <i v-else="es.modules.indexOf('facebook') != -1" class="fa fa-facebook-square fa-3x social account-on" v-on:click="toggleModule(es, $event)"></i>
                                                    </section>
                                                    <section v-if="social_accounts.facebook.valid_access_token">
                                                        <i v-if="es.modules.indexOf('twitter') == -1" class="fa fa-twitter-square fa-2x social" v-on:click="toggleModule(es, $event)"></i>
                                                        <i v-else="es.modules.indexOf('twitter') == -1" class="fa fa-twitter-square fa-3x social account-on" v-on:click="toggleModule(es, $event)"></i>
                                                    </section>
                                                    <section v-if="social_accounts.facebook.valid_access_token">
                                                        <i v-if="es.modules.indexOf('linkedin') == -1" class="fa fa-linkedin-square fa-2x social" v-on:click="toggleModule(es, $event)"></i>
                                                        <i v-else="es.modules.indexOf('linkedin') == -1" class="fa fa-linkedin-square fa-3x social account-on" v-on:click="toggleModule(es, $event)"></i>
                                                    </section>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-sm pull-right" v-on:click="saveEventNotification">Save</button>
            </div>
            <div role="tabpanel" class="tab-pane" id="custom_templates">
                <div class="notice"></div>
                <button class="btn btn-success btn-xs" id="show_add_template" style="margin: 15px 0;">Add Template</button>
                <table id="dt" class="dataTable no-multiple" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Date Created</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="key_factors">
                <div class="form-horizontal">
                    <br />
                    <div class="notice"></div>
                    <div class="form-group">
                        <label for="sale_type" class="col-sm-2 control-label">* Sale Type</label>
                        <div class="col-sm-10">
                            <select class="form-control required" id="saleType" v-model="key_factors.sale_type"><?php echo $sale_types; ?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">* Price</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="price" placeholder="Price" v-model="key_factors.price" value="{{ key_factors.price }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="video_url" class="col-sm-2 control-label">* Video URL</label>
                        <div class="col-sm-10">
                            <input type="url" class="form-control" id="video_url" placeholder="Video URL" v-model="key_factors.video" value="{{ key_factors.video }}" />
                        </div>
                    </div>
                </div>
                <button class="pull-right btn btn-sm btn-success" v-on:click="saveKeyFactors">Save</button>
            </div>
        </div>
    </div>

    <div class="modal fade no-callback" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="form-modal-label">Event Notification Custom Template</h4>
                </div>
                <div class="modal-body" style="padding: 20px 20px;">
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="template_active">* Event</label>
                                <select id="template_active" class="form-control required" v-model="template.event_id">
                                    <option value="">Select Event</option>
                                    <?php foreach($events as $event): ?>
                                        <option value="<?php echo $event->id; ?>"><?php echo $event->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="template_name">* Name</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="template_name" class="form-control required" v-model="template.name" value="{{ template.name }}" />
                                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template_content">* Content</label>
                                <div class="input-group input-group-sm">
                                    <textarea id="template_content" class="form-control required" v-model="template.content" style="height: 50px;">{{ template.content }}</textarea>
                                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="template_delete_btn" type="button" class="btn btn-default btn-sm pull-left" v-on:click="deleteTemplate">Delete</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" v-on:click="saveTemplate">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = '<?php echo base_url() . 'property/event_notification'; ?>';
    var merlinTemplates = <?php echo json_encode($merlin_templates); ?>;
    var customTemplates = <?php echo json_encode($custom_templates); ?>;

    var data = {
        event_settings: <?php echo json_encode($event_settings); ?>,
        template: {
            id: '',
            event_id : '',
            name : '',
            content: ''
        },
        key_factors: <?php echo json_encode($key_factors); ?>,
        social_accounts: {
            facebook: <?php echo json_encode($facebook); ?>,
            linked_in: <?php echo json_encode($linked_in); ?>,
            twitter: <?php echo json_encode($twitter); ?>
        }
    };

    console.log(data);

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            getTemplatesByType: function(es) {
                var allTemplates = es.template_type == 'merlin' ? merlinTemplates : customTemplates;
                var eventTemplates = [];
                for (var i = 0; i < allTemplates.length; i++) {
                    if (allTemplates[i].event_id == es.event_id) {
                        eventTemplates.push(allTemplates[i]);
                    }
                }
                return eventTemplates;
            },
            saveEventNotification: function() {
                loading('info', 'Saving...');
                $.post(actionUrl, { action: 'save_event_settings', event_settings: this.event_settings }, function(res) {
                    if(res.success) {
                        loading('success', 'Saved');
                    }
                }, 'json');
            },
            saveTemplate: function() {
                if(validator.validateForm($('#form-modal'))) {
                    loading('info', 'Saving...');
                    $.post(actionUrl, { action: 'save_custom_template', template: data.template }, function(res) {
                        if(res.success) {
                            dt.fnReloadAjax();
                            loading('success', 'Saved');
                            $('#form-modal').modal('hide');
                        }
                    }, 'json');
                }
            },
            deleteTemplate: function() {
                loading('info', 'Deleting...');
                $.post(actionUrl, { action: 'delete_custom_template', template_id: data.template.id }, function(res) {
                    if(res.success) {
                        dt.fnReloadAjax();
                        loading('success', 'Deleted');
                        $('#form-modal').modal('hide');
                    }
                }, 'json');
            },
            saveKeyFactors: function() {
                if(validator.validateForm($('#key_factors'))) {
                    loading('info', 'Saving...');
                    $.post(actionUrl, { action: 'save_key_factors', key_factors: data.key_factors }, function(res) {
                        if(res.success) {
                            loading('success', 'Saved');
                        }
                    }, 'json');
                }
            },
            toggleModule: function(en, event) {
                if ($(event.currentTarget).hasClass('account-on')) {
                    $(event.currentTarget).removeClass('account-on fa-3x');
                    en.modules = getActiveModules($(event.currentTarget).parent());
                } else {
                    $(event.currentTarget).addClass('account-on fa-3x');
                    en.modules = getActiveModules($(event.currentTarget).parent());
                }
                console.log(en.modules);
            }
        }
    });

    function getActiveModules(parent) {
        var modules = "";
        $(parent).find('i').each(function() {
            if ($(this).hasClass('fa-facebook-square') && $(this).hasClass('account-on')) {
                modules += "facebook|";
            } else if ($(this).hasClass('fa-twitter-square') && $(this).hasClass('account-on')) {
                modules += "twitter|";
            } else if ($(this).hasClass('fa-linkedin-square') && $(this).hasClass('account-on')) {
                modules += "linkedin|";
            }
        });
        return modules.slice(0, -1);
    }

    $(function() {
        setupDataTables();

        $('#show_add_template').on('click', function() {
            $('#form-modal').modal({
                show: true,
                keyboard: false
            });
            data.template.id = '';
            data.template.event_id = '';
            data.template.name = '';
            data.template.content = '';
            $('#template_delete_btn').hide();
        });
    });

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [0, 'asc'],
            "bDestroy": true,
            "filter": false,
            "pageLength": 25,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "custom_templates_list" }
            },
            "columns": [
                { data: "event", width: "20%" },
                { data: "name", width: "65%" },
                { data: "date_created", width: "15%" },
                { data: "id", visible: false },
                { data: "event_id", visible: false },
                { data: "content",visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on("click", function () {
                    var pos = table.fnGetPosition(this);
                    var template = table.fnGetData(pos);
                    data.template.id = template.id;
                    data.template.event_id = template.event_id;
                    data.template.name = template.name;
                    data.template.content = template.content;
                    $('#template_delete_btn').show();
                    $('#form-modal').modal({
                        show: true,
                        keyboard: false
                    });
                });
            }
        });
    }
</script>