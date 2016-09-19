<div class="row" id="app">
    <div class="col-sm-12">
        <h4>Event Notification</h4>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#notification" aria-controls="home" role="tab" data-toggle="tab">Notification Settings</a></li>
            <li role="presentation"><a href="#templates" aria-controls="home" role="tab" data-toggle="tab">Templates</a></li>
            <li role="presentation"><a href="#key_factors" aria-controls="profile" role="tab" data-toggle="tab">Key Factors</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="notification">
                <div class="col-sm-12">
                    <br />
                    <div class="alert alert-info">
                        <i class="fa fa-question-circle"></i> Click the title to show options.
                    </div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success btn-sm" v-on:click="saveEventNotification">Save</button>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="templates">

            </div>
            <div role="tabpanel" class="tab-pane" id="key_factors">

            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = '<?php echo base_url() . 'property/event_notification'; ?>';
    var merlinTemplates = <?php echo json_encode($merlin_templates); ?>;
    var customTemplates = <?php echo json_encode($custom_templates); ?>;

    var vm = new Vue({
        el: "#app",
        data: {
            event_settings: <?php echo json_encode($event_settings); ?>
        },
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
                        loading('success', 'Saving successful.');
                    }
                }, 'json');
            }
        }
    });

    $(function() {
    });
</script>