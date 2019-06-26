<?php
$array_list = array();
$total = 0;
$percent = array();
$colors = array(
    '#f15854',
    '#4d4d4d',
    '#5da5da',
    '#decf3f',
    '#b276b2',
    '#faa43a',
);
$count =0;
foreach(AxianDDR::$etats as $etat=>$label){
    $list_term = new AxianDDREtatList($etat);
    $list_term->prepare_items();
    $total+= $list_term->total_items;
    $array_list[$etat]['list'] = $list_term;
    $array_list[$etat]['total'] = $list_term->total_items;
    $array_list[$etat]['color'] = $colors[$count];
    $count++;
}
?>
<script>
    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        <?php foreach(AxianDDR::$etats as $etat=>$label):?>
                        <?php echo $array_list[$etat]['total'];?>,
                        <?php endforeach;?>
                    ],
                    backgroundColor: [
                        <?php foreach(AxianDDR::$etats as $etat=>$label):?>
                        '<?php echo $array_list[$etat]['color'];?>',
                        <?php endforeach;?>
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    <?php foreach(AxianDDR::$etats as $etat=>$label):?>
                    '<?php echo $label;?>',
                    <?php endforeach;?>
                ]
            },
            options: {
                responsive: true
            }
        };
        var chart = new Chart(ctx, config);
    }
</script>
<div class="ddr-per-status-wrapper row">
    <div class="col-md-6 col-sm-12">
        <div class="ddr-per-status-bloc">
            <div class="" id="heading-chart">
                <h5 class="mb-0">
                    <button class="btn btn-danger btn-block" data-toggle="collapse" data-target="#collapse-chart" aria-expanded="false" aria-controls="collapse-chart">
                        Tickets par état
                    </button>
                </h5>
            </div>

            <div id="collapse-chart" class="collapse show" aria-labelledby="heading-chart" data-parent="#third-col" style="min-height: 400px;position: relative;">
                <canvas id="chart-area"></canvas>
            </div>
        </div>
        <?php
        $count = 1;
        foreach(AxianDDR::$etats as $etat=>$label):?>

            <?php if ( $count == intval(sizeof(AxianDDR::$etats)/2)+1 ) :?>
                </div>
                <div class="col-md-6 col-sm-12">
            <?php endif;?>

            <div class="ddr-per-status-bloc">
                <div class="" id="heading<?php echo $etat;?>">
                    <h5 class="mb-0">
                        <button class="btn btn-danger btn-block" data-toggle="collapse" data-target="#collapse<?php echo $etat;?>" aria-expanded="false" aria-controls="collapse<?php echo $etat;?>">
                            <?php echo $label;?>
                        </button>
                    </h5>
                </div>

                <div id="collapse<?php echo $etat;?>" class="collapse show" aria-labelledby="heading<?php echo $etat;?>" data-parent="#third-col">
                    <?php $array_list[$etat]['list']->display(); ?>
                </div>
            </div>
        <?php
        $count++;
        endforeach;?>
    </div>
</div>

