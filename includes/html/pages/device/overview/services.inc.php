<?php

use LibreNMS\Util\ObjectCache;

if (ObjectCache::serviceCounts()['total'] > 0) {
    // Build the string.
    $break = '';
    $output = '';
    foreach (service_get($device['device_id']) as $data) {
        if ($data['service_status'] == '0') {
            // Ok
            $status = 'green';
        } elseif ($data['service_status'] == '1') {
            // Warning
            $status = 'red';
        } elseif ($data['service_status'] == '2') {
            // Critical
            $status = 'red';
        } else {
            // Unknown
            $status = 'grey';
        }
        $output .= $break . '<a class=' . $status . '>' . strtolower($data['service_type']) . '</a>';
        $break = ', ';
    }

    $services = ObjectCache::serviceCounts(['total', 'ok', 'warning', 'critical']);
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default panel-condensed">
                    <div class="panel-heading">
                    <i class="fa fa-cogs fa-lg icon-theme" aria-hidden="true"></i> <strong>Services</strong>
                    </div>
                    <table class="table table-hover table-condensed table-striped">
                        <tr>
                            <td title="Total"><i class="fa fa-cog" style="color:#0080FF" aria-hidden="true"></i> <?php echo $services['total']?></td>
                            <td title="Status - Ok"><i class="fa fa-cog" style="color:green" aria-hidden="true"></i> <?php echo $services['ok']?></td>
                            <td title="Status - Warning"><i class="fa fa-cog" style="color:orange" aria-hidden="true"></i> <?php echo $services['warning']?></td>
                            <td title="Status - Critical"><i class="fa fa-cog" style="color:red" aria-hidden="true"></i> <?php echo $services['critical']?></td>
                        </tr>
                        <tr>
                            <td colspan='4'><?php echo $output?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
<?php
}
