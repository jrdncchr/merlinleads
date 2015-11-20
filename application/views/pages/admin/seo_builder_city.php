<div class="col-xs-12">
    <div class='row'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <h2 style="margin-top: 0!important;">SEO Builder - Cities</h2>
            </div>
            <div class="col-xs-6">
                <button id="deleteCityBtn" class="btn btn-danger btn-sm pull-right"><i class="fa fa-minus-circle"></i> Delete </button>
                <button id="showCityModalBtn" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-circle"></i> Add </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table id="dt" class="dataTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>City</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Date Created</th>
                    </tr>
                    </thead></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalContent" style="display: none;">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control required" id="city" placeholder="City">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="zipCode">Zip Code</label>
                <input type="text" class="form-control required" id="zipCode" placeholder="Zip Code">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control required" id="state" placeholder="State">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="stateAbbr">State Abbr</label>
                <input type="text" class="form-control required" id="stateAbbr" placeholder="State Abbr">
            </div>
        </div>
    </div>
    <div class="checkbox">
        <label style="display: inline !important;">
            <input type="checkbox" id="status" style="margin-top: 1px !important;"/>
            Check to activate this city.
        </label>
    </div>

    <hr />
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Select a user to have this city in their SEO Builder:</label>
                <select id="user" class="form-control">
                    <?php foreach($users as $u): ?>
                        <option value="<?php echo $u->id; ?>"><?php echo $u->firstname . " " . $u->lastname; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var update = false, city_already_exist = false;
    var actionUrl = "<?php echo base_url() . "admin2/seo_builder_city" ?>";
    var selectedId, selectedRows, selectedCityName;

    $(document).ready(function() {
        $('#seoBuilderSideLink').addClass('custom-nav-active');
        $('#seoBuilderCityTopLink').addClass('custom-nav-active');
        setupDataTables();
        activateEvents();
    });

    function activateEvents() {

        $("#globalFormModal").find("#globalFormModalContent").html($("#modalContent").html())
            .on("hidden.bs.modal", function() {
                $("#globalFormModal").find("input").val("");
                $("#status").attr("checked", false);
            });

        $("#showCityModalBtn").off("click").click(function() {
            update = false;
            $("#globalFormModal").find(".modal-title").html("Add City");
            showGlobalModal();
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                if(!city_already_exist) {
                    var status = $("#status").is(":checked") ? "Active" : "Inactive";
                    var data = {
                        info: {
                            city_name       : $("#city").val(),
                            zip_code        : $("#zipCode").val(),
                            state           : $("#state").val(),
                            state_abbr      : $("#stateAbbr").val(),
                            status          : status,
                            user_id         : $("#user").val() == "" ? null : $("#user").val()
                        },
                        action: "add"
                    };
                    if(update) {
                        data.id = selectedId;
                        data.action = "update";
                    }
                    proccess({
                        dt: dt,
                        url: actionUrl,
                        data: data,
                        btn: $("#globalSaveBtn"),
                        btnLoadText: "Saving...",
                        btnText: "Save",
                        success: "Successfully Saved.",
                        modal: $('#globalFormModal'),
                        hideModal: true
                    });
                }

            }
        });

        $('#deleteCityBtn').off("click").click(function() {
            selectedRows = $.map($("#dt").DataTable().rows('.selected').data(), function (item) {
                return item.id;
            });
            console.log(selectedRows);
            if(selectedRows.length > 0) {
                showDeleteModal();
            } else {
                toastr.warning("Select an item to delete.");
            }
        });

        $("#city").off("blur").blur(function(data) {
            var validate = true;
            if(update) {
                if($(this).val() == selectedCityName) {
                    validate = false;
                }
            }
            if(validate) {
                $.ajax({
                    url: actionUrl,
                    data: { action: "validate_city", city: $("#city").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.already_exist == true) {
                            city_already_exist = true;
                            $("#city").parent().addClass('has-error');
                            globalFormModalError(true, "City already exists!");
                        } else {
                            city_already_exist = false;
                            $("#city").parent().removeClass('has-error');
                            globalFormModalError(false);
                        }
                    }
                });
            }
        });
    }

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "list" }
            },
            columns: [
                { data: "city_name", width: "30%" },
                { data: "status", width: "20%", render:
                    function(data, type, row) {
                        var textClass = data == "Active" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" + data + "</span></b>";
                    }
                },
                { data: "full_name", width: "30%" },
                { data: "date_created", width: "20%" },
                { data: "id", visible: false},
                { data: "user_id", visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showUpdateModal(data);
                });
            }
        });
    }

    function deleteAction() {
        var data = {
            action: "delete",
            idList: selectedRows
        };
        proccess({
            dt: dt,
            url: actionUrl,
            data: data,
            btn: $("#globalDeleteBtn"),
            btnLoadText: "Deleting...",
            btnText: "Delete",
            success: "Successfully Deleted.",
            modal: $('#globalDeleteModal'),
            hideModal: true
        });
    }

    function showUpdateModal(data) {
        update = true;
        selectedId = data.id;
        selectedCityName = data.city_name;
        $("#globalFormModal").find(".modal-title").html("Update City");
        $("#city").val(data.city_name);
        $("#zipCode").val(data.zip_code);
        $("#state").val(data.state);
        $("#stateAbbr").val(data.state_abbr);
        if(data.status == "Active") {
            $("#status").attr("checked", true);
        } else {
            $("#status").attr("checked", false);
        }
        $("#user").val(data.user_id);
        showGlobalModal();
    }

</script>