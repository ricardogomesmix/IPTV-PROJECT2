<?php
use app\models\ChartDraw;
use yii\helpers\Html;
$this->title = 'IPTV Monitor';
$this->params['breadcrumbs'][] = $this->title;

$operationStream = '
    var time = $("#stream-date-range").val().split(" - ");
    var startTime = Date.parse(new Date(time[0]));
    var endTime = Date.parse(new Date(time[1]));
    $("#stream-chart").highcharts().showLoading();
    $.get("index.php?r=monitor/update-warning-line&type=Stream&startTime="+startTime+"&endTime="+endTime,
        function(data,status){
            var obj = eval(data);
            for(var i=0;i<obj[0].length;i++){
                var series=$("#stream-chart").highcharts().series[i];
                series.setData(obj[0][i].data,false);
            }
            $("#stream-chart").highcharts().redraw();
            $("#stream-chart").highcharts().hideLoading();
            updateStreamTooltip(obj[1]);
    });
';
$operationMySql = '
    var time = $("#mysql-date-range").val().split(" - ");
    var startTime = Date.parse(new Date(time[0]));
    var endTime = Date.parse(new Date(time[1]));
    $("#mysql-chart").highcharts().showLoading();
    $.get("index.php?r=monitor/update-warning-line&type=MySql&startTime="+startTime+"&endTime="+endTime,
        function(data,status){
            var obj = eval(data);
            var series=$("#mysql-chart").highcharts().series[0];
            series.setData(obj[0][0].data);
            $("#mysql-chart").highcharts().hideLoading();
            updateTooltip(obj[1], $("#mysql-chart").highcharts());
    });
';
$operationNginx = '
    var time = $("#nginx-date-range").val().split(" - ");
    var startTime = Date.parse(new Date(time[0]));
    var endTime = Date.parse(new Date(time[1]));
    $("#nginx-chart").highcharts().showLoading();
    $.get("index.php?r=monitor/update-warning-line&type=Nginx&startTime="+startTime+"&endTime="+endTime,
        function(data,status){
            var obj = eval(data);
            var series=$("#nginx-chart").highcharts().series[0];
            series.setData(obj[0][0].data);
            $("#nginx-chart").highcharts().hideLoading();
            updateTooltip(obj[1], $("#nginx-chart").highcharts());
    });
';
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">CPU Utilization Beyond Threshold</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, ChartDraw::operation('CPU', 'cpu-data-range', 'cpu-chart'), 'cpu-data-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['cpu-grid', 'serverName'=>'', 'type'=>0], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('cpu-chart', $this, 'CPU Utilization Beyond Threshold', 'CPU Utilization Percentage(%)', '%', $cpuData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">RAM Utilization Beyond Threshold</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, ChartDraw::operation('RAM', 'ram-data-range', 'ram-chart'), 'ram-data-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['ram-grid', 'serverName'=>'', 'type'=>0], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('ram-chart', $this, 'RAM Utilization Beyond Threshold', 'RAM Utilization Percentage(%)', '%', $ramData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">Disk Utilization Beyond Threshold</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, ChartDraw::operation('DISK', 'disk-data-range', 'disk-chart'), 'disk-data-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['disk-grid', 'serverName'=>'', 'type'=>0], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('disk-chart', $this, 'Disk Utilization Beyond Threshold', 'Free Percentage of Disk(%)', '%', $diskData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">Load Utilization Beyond Threshold</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, ChartDraw::operation('LOAD', 'load-data-range', 'load-chart'), 'load-data-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['load-grid', 'serverName'=>'', 'type'=>0], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('load-chart', $this, 'Load Utilization Beyond Threshold', 'Load Utilization Percentage(%)', '%', $loadData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">Disconnected Streams</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, $operationStream, 'stream-date-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['streams-grid','type'=>0], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('stream-chart', $this, 'Disconnected Streams', 'The Numeber of Dead Streams', '', $streamData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">MySQL Fault</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, $operationMySql, 'mysql-date-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['mysql-grid'], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('mysql-chart', $this, 'MySQL Fault', 'Disconnected Number of MySQL', '', $mySqlData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: #eeeeee;">
				<h5 style="font-weight: bold;">Nginx Fault</h5>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
                    <?php 
                        ChartDraw::drawDateRange($range, $minDate, $operationNginx, 'nginx-date-range');
                    ?>
                    <div class="btn-group right">
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-linechart"></i>', null, ['class' => 'btn btn-default']);?>
                    	<?= Html::a('<i class="iconfont iconfont-blue icon-grid"></i>', ['nginx-grid'], ['class' => 'btn btn-default']);?>
                    </div>
                    <br/><br/>
                    
                    <?php
                        echo ChartDraw::drawLineChart('nginx-chart', $this, 'Nginx Fault', 'Disconnected Number of Nginx', '', $nginxData);
                    ?>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="gototop">
	<a href="javascript:;" title="返回顶部"></a>
</div>
<?php 
$this->registerJs("
    function addLine(chart, threshold){
        chart.yAxis[0].addPlotLine({
            value:threshold,
            width:3,
            color: 'red',
            label:{
                text: threshold+'%',
                color:'red',
                align:'below',
                style: {
                   color: 'red',
                }
            },
            zIndex:100
        });
        if(chart==$('#disk-chart').highcharts()){
            chart.yAxis[0].update({
                max:threshold
            });
        }else{
            chart.yAxis[0].update({
                min:threshold
            });
        }
    }
    function updateStreamTooltip(obj){
        var chart = $('#stream-chart').highcharts();
        chart.update({
            tooltip:{
                shared:false,
                formatter:function () {
                    var stream = '';
                    var date = new Date(this.x);
                    var minute = date.getMinutes()<10?'0'+date.getMinutes():date.getMinutes();
                    var time = (1+date.getMonth())+'-'+date.getDate()+' '+date.getHours()+':'+minute+':00';
                    if(obj.length!=0){
                        if(obj.hasOwnProperty(this.series.name)){
                            if(obj[this.series.name].hasOwnProperty(this.x+'')){
                                var stream = '<br/>They are:<br/>';
                                for(var i=0;i<obj[this.series.name][this.x+''].length;i++){
                                    if(i%2==0){
                                        stream = stream + '<b>' + obj[this.series.name][this.x+''][i] + '<b/>  ';
                                    }else{
                                        stream = stream + '<b>' + obj[this.series.name][this.x+''][i] + '<b/><br/>';
                                    }
                                }
                            }
                        }
                    }
                    return 'time:<b>' + time + '</b><br/>'+
                        'count: <b>' + this.y + '</b>' +
                         stream;
                }
            }
        });
    }
    function updateTooltip(obj, chart){
        chart.update({
            tooltip:{
                shared:false,
                formatter:function(){
                    var servers = '';
                    var date = new Date(this.x);
                    var minute = date.getMinutes()<10?'0'+date.getMinutes():date.getMinutes();
                    var time = (1+date.getMonth())+'-'+date.getDate()+' '+date.getHours()+':'+minute+':00';
                    if(obj.length!=0){
                        if(obj.hasOwnProperty(this.x+'')){
                            var servers = '<br/>They are:<br/>';
                            for(var i=0;i<obj[this.x+''].length;i++){
                                servers = servers + '<b>' + obj[this.x+''][i] + '<b/><br/>';
                            }
                        }
                    }
                    return 'time:<b>' + time + '</b><br/>'+
                        'count: <b>' + this.y + '</b>' +
                         servers;
                }
            }
        });
    }
    function updateStreamStatus(){
        $.get('index.php?r=monitor/update-server-status',function(data,status){
            var obj = eval(data);
            console.log(obj);
            $('.hover-window').html(data);
        })
    }
    
    window.onload = function(){
        var cpuChart = $('#cpu-chart').highcharts();
        addLine(cpuChart, $cpuThreshold);
        var ramChart = $('#ram-chart').highcharts();
        addLine(ramChart, $memoryThreshold);
        var diskChart = $('#disk-chart').highcharts();
        addLine(diskChart, $diskThreshold);
        var loadChart = $('#load-chart').highcharts();
        addLine(loadChart, $loadsThreshold);
        var obj = eval($streamData2);
        updateStreamTooltip(obj);
        var obj2 = eval($mySqlData2);
        var chart1 = $('#mysql-chart').highcharts();
        updateTooltip(obj2, chart1);
        var obj3 = eval($nginxData2);
        var chart2 = $('#nginx-chart').highcharts();
        updateTooltip(obj3, chart2);
        updateStreamStatus();
        //setInterval(updateStreamStatus,1000);
        $('.hover-btn').click(function(){
            if($('#hide').html()=='hide'){
                $('.hover-btn').animate({bottom:'0px'});
                $('#hide').html('show');
            }else{
                $('#hide').html('hide');
                $('.hover-btn').animate({bottom:'160px'});
            }
            $('.hover-window').slideToggle();
            
        }); 
    }
");


?>
