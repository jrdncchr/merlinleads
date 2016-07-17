<div id="app">
    <h2>Settings - General</h2>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="trial-period-package">Trial Period Package: </label>
                <select id="trial-period-package" class="form-control" v-model="general.trial_period_package.v">
                    <option value="">Select default package</option>
                    <?php foreach($packages as $package): ?>
                        <option value="<?php echo $package->id; ?>" <?php echo $package->id == $general['trial_period_package']->v ? 'selected' : ''; ?>><?php echo $package->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-success btn-sm" v-on:click="saveGeneralSettings">Save Settings</button>
        </div>
    </div>
</div>

<script>

    var actionUrl = "<?php echo base_url() . "admin/settings" ?>";

    var vm = new Vue({
        el: '#app',
        data: {
            general : <?php echo json_encode($general); ?>
        },
        methods: {
            saveGeneralSettings: function() {
                loading('info', 'Saving settings...');
                $.post(actionUrl, {action: 'save_general', settings: vm.general}, function(res) {
                    if(res.success) {
                        loading('success', 'Saving settings successful!');
                    } else {
                        loading('error', res.message);
                    }
                }, 'json');
            }
        }
    });

    $(function() {
        $('#settingsSideLink').addClass('custom-nav-active');
        $('#settingsGeneralTopLink').addClass('custom-nav-active');
    });

</script>