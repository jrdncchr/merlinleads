<!-- Begin page content -->
<div class="col-xs-10 col-xs-offset-1">
    <h4 style="text-align: center; font-weight: bold;">Upgrade</h4>
    <hr style="margin: 10px 300px;"/>
    <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Property</a><br/>

    <h4>Monthly Packages</h4>
    <table class="table table-hover">
        <tr>
            <th width="30%">Package Name</th>
            <th width="15%">Properties</th>
            <th width="15%">Profiles</th>
            <th width="20%">Price</th>
            <th width="20%">Subscribe</th>
        </tr>
        <tr>
            <?php for($i = 0; $i < sizeof($month_plan); $i++) { 
                if($month_plan[$i]['status'] == "Active" && $month_plan[$i]['show'] == 1) {
                ?>
                <tr>
                    <td><?php echo $month_plan[$i]['name']; ?></td>
                    <td><?php echo $month_plan[$i]['number_of_property']; ?></td>
                    <td><?php echo $month_plan[$i]['number_of_profile']; ?></td>
                    <td><?php echo "$" . substr($month_plan[$i]['amount'], 0, -2) . ".00"; ?></td>
                    <td><?php echo $month_plan[$i]['stripe_form']; ?></td>
                </tr>
            <?php }
            } ?>
        </tr>
    </table>
    <h4>Yearly Packages</h4>
    <table class="table table-hover">
        <tr>
            <th width="30%">Package Name</th>
            <th width="15%">Properties</th>
            <th width="15%">Profiles</th>
            <th width="20%">Price</th>
            <th width="20%">Subscribe</th>
        </tr>
        <tr>
            <?php for($i = 0; $i < sizeof($year_plan); $i++) { 
                if($year_plan[$i]['status'] == "Active" && $year_plan[$i]['show'] == 1) {
                ?>
                <tr>
                    <td><?php echo $year_plan[$i]['name']; ?></td>
                    <td><?php echo $year_plan[$i]['number_of_property']; ?></td>
                    <td><?php echo $year_plan[$i]['number_of_profile']; ?></td>
                    <td><?php echo "$" . substr($year_plan[$i]['amount'], 0, -2) . ".00"; ?></td>
                    <td><?php echo $year_plan[$i]['stripe_form']; ?></td>
                </tr>
            <?php } 
            } ?>
        </tr>
    </table>
    <h4>Addons</h4>
    <table class="table table-hover">
        <tr>
            <th width="30%">Package Name</th>
            <th width="15%">Properties</th>
            <th width="15%">Profiles</th>
            <th width="20%">Price</th>
            <th width="20%">Subscribe</th>
        </tr>
        <?php for($i = 0; $i < sizeof($addons); $i++) { 
            if($addons[$i]['status'] == "Active" && $addons[$i]['show'] == 1) {
            ?>
            <tr>
                <td><?php echo $addons[$i]['name']; ?></td>
                <td><?php echo $addons[$i]['number_of_property']; ?></td>
                <td><?php echo $addons[$i]['number_of_profile']; ?></td>
                <td><?php echo "$" . substr($addons[$i]['amount'], 0, -2) . ".00"; ?></td>
                <td><?php echo $addons[$i]['stripe_form']; ?></td>
            </tr>
        <?php } 
        } ?>
    </table>
</div>
