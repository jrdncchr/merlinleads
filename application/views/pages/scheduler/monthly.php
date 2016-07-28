<style>
    table {
        table-layout: fixed;
        border-collapse: collapse;
        width: 100%;
    }
    table td {
        height: 100px;
        text-align: center;
    }
    table td .badge {
        display: block !important;
        white-space: normal;
        margin-bottom: 4px;
        text-align: center !important;
    }

    table td .badge span {
        padding: 3px;
        display: block;
    }
    .table thead tr th {
        padding: 15px;
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        border: none !important;
        color: slategray;
    }
    .month_out {
        background-color: #dcdcdc;
        color: darkslategray;
    }
    .today {
        background-color: lavender;
    }
    .redirect-month {
        font-size: 20px !important;
        vertical-align: middle;
    }
    .redirect-month:hover {
        text-decoration: none;
    }

</style>

<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Scheduler - Monthly</h4>

<div class="centered-pills">
    <ul class="nav nav-pills">
        <li role="presentation" class="active">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Scheduler <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/'; ?>">Weekly</a></li>
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/monthly'; ?>">Monthly</a></li>
            </ul>
        </li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/queue'; ?>">Queues</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/category'; ?>">Categories</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/post'; ?>">Posts</a></li>
    </ul>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-sm-12">
        <div class="pull-left">
            <h2 style="margin-top: 0;">
                <a href="<?php echo base_url() . 'scheduler/monthly/' . date('F', strtotime('-1 months', strtotime($selected_month))) . '/' .  date('Y', strtotime(' -1 months', strtotime($selected_month . ' ' . $selected_year))); ?>" class="fa fa-arrow-left redirect-month"></a>&nbsp;
                <?php echo ucfirst($selected_month) . " " . $selected_year; ?>&nbsp;
                <a href="<?php echo base_url() . 'scheduler/monthly/' . date('F', strtotime('+1 months', strtotime($selected_month))) . '/' .  date('Y', strtotime(' +1 months', strtotime($selected_month . ' ' . $selected_year))); ?>" class="fa fa-arrow-right redirect-month"></a>
            </h2>
        </div>
        <div class="form-inline pull-right">
            <div class="form-group">
                <label for="month">Month </label>
                <select id="month" class="form-control">
                    <option value="january">January</option>
                    <option value="february">February</option>
                    <option value="march">March</option>
                    <option value="april">April</option>
                    <option value="may">May</option>
                    <option value="june">June</option>
                    <option value="july">July</option>
                    <option value="august">August</option>
                    <option value="september">September</option>
                    <option value="october">October</option>
                    <option value="november">November</option>
                    <option value="december">December</option>
                </select>
            </div>
            &nbsp;
            <div class="form-group">
                <label for="year">Year </label>
                <select id="year" class="form-control">
                    <?php
                    $startYear = date('Y');
                    $endYear = $startYear +3;
                    for($i = $startYear; $i  <= $endYear; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            &nbsp;
            <button class="btn btn-default btn-sm">Filter</button>
        </div>
        <table class="table table-bordered" style="margin-top: 50px; border: 1px solid #dddddd; table-layout: fixed !important; width: 100%;">
            <thead>
            <tr>
                <th>Sunday</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $day = 1;
                $next_month_day = 1;
                for($tr = 0; $tr <= 5; $tr++) { ?>
                    <tr>
                        <?php for($td = 0; $td <= 6; $td++) { ?>
                            <?php if($tr == 0) { ?>
                                <?php if($td >= $first_day) { ?>
                                    <td class='<?php echo ucfirst($selected_month) . " " . $day == date('F d') ? "today" : "" ?>'>
                                        <?php echo $day; ?>
                                        <?php if(isset($queue[sprintf("%02d", $day)])):
                                            foreach($queue[sprintf("%02d", $day)] as $post):
                                                $class = $post->library == 'user' ? 'badge-user-lib' : 'badge-merlin-lib'; ?>
                                                <div class='badge <?php echo $class; ?>'>
                                                    <span><?php echo $post->time; ?></span>
                                                    <span><?php echo $post->category; ?></span>
                                                        <span>
                                                            <?php echo strpos($post->modules, 'Facebook')!== FALSE ? '<i class="fa fa-facebook"></i>&nbsp;' : ''; ?>
                                                            <?php echo strpos($post->modules, 'Twitter') !== FALSE ? '<i class="fa fa-twitter"></i>&nbsp;' : ''; ?>
                                                            <?php echo strpos($post->modules, 'LinkedIn') !== FALSE ? '<i class="fa fa-linkedin"></i>&nbsp;' : ''; ?>
                                                        </span>
                                                </div>
                                            <?php endforeach;
                                        endif; ?>
                                    </td>
                                <?php $day++;
                                    } else { ?>
                                    <td class="month_out"><?php echo $last_month_total_days - ($first_day-($td+1)); ?> </td>
                                <?php } ?>
                            <?php } else { ?>
                                    <?php if($day <= $current_m_total_days) { ?>
                                        <td class='<?php echo ucfirst($selected_month) . " " . $day == date('F d') ? "today" : "" ?>'>
                                            <?php echo $day; ?>
                                            <?php if(isset($queue[sprintf("%02d", $day)])):
                                                foreach($queue[sprintf("%02d", $day)] as $post):
                                                    $class = $post->library == 'user' ? 'badge-user-lib' : 'badge-merlin-lib'; ?>
                                                    <div class='badge <?php echo $class; ?>'>
                                                        <span><?php echo $post->time; ?></span>
                                                        <span><?php echo $post->category; ?></span>
                                                        <span>
                                                            <?php echo strpos($post->modules, 'Facebook') !== FALSE ? '<i class="fa fa-facebook"></i>&nbsp;' : ''; ?>
                                                            <?php echo strpos($post->modules, 'Twitter') !== FALSE  ? '<i class="fa fa-twitter"></i>&nbsp;' : ''; ?>
                                                            <?php echo strpos($post->modules, 'LinkedIn') !== FALSE  ? '<i class="fa fa-linkedin"></i>&nbsp;' : ''; ?>
                                                        </span>
                                                    </div>
                                                <?php endforeach;
                                            endif; ?>
                                        </td>
                                    <?php $day++;
                                          } else { ?>
                                        <td class="month_out"><?php echo $next_month_day; $next_month_day++; ?></td>
                                    <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>



<script>
    var actionUrl = "<?php echo base_url() . 'scheduler/monthly'; ?>";
    var selectedMonth = "<?php echo $selected_month; ?>";
    var selectedYear = "<?php echo $selected_year; ?>";

    $(function() {
        $('#month').val(selectedMonth);
        $('#year').val(selectedYear);
    });
</script>