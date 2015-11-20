<div class='row'>
    <div class='col-xs-12'>

        <div class="form-group">
            <div class="col-xs-12">
                <div id="slideshareMessage"></div>
            </div>
        </div>

        <div class="col-xs-5">
            <h5 style="font-weight: bold">Background List</h5>
            <div class="row">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="type" class="col-xs-4 control-label">Background</label>
                        <div class="col-xs-8">
                            <select class="form-control" id="bg">
                                <?php if (isset($images)) {
                                    foreach ($images as $image) {
                                        ?>
                                        <option value="<?php echo $image->image; ?>"><?php echo $image->title; ?></option>
                                    <?php }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-4 control-label">Image</label>
                        <div class="col-xs-8">
                            <img id="bg-preview" src="<?php if (isset($images)) { echo base_url() . IMG . "ppt/bg/" . $images[0]->image; } ?>" class="img img-thumbnail" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-4 control-label"></label>
                        <div class="col-xs-5">
                            <button class="btn btn-danger" id="deleteBtn" type="button"> Trash</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1">
            <h5 style="font-weight: bold">Add new background</h5>
            <div class="row">
                <form class="form-horizontal" id="addForm" method="POST" action="">
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label">Title</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="title" id="title" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label">Image</label>
                        <div class="col-xs-9">
                            <input type="file" name="userfile" id="userfile" size="20" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <button class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modulesSideLink').addClass('custom-nav-active');
        $('#slideshareTopLink').addClass('custom-nav-active');
    });
</script>