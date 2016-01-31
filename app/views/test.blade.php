
@extends('templates/investigacionTemplate')

@section('content')
	<!--
	<div class="row">
	    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	    <script type="text/javascript">
	      google.load("visualization", "1", {packages:["timeline"]});
	      google.setOnLoadCallback(drawChart);

	      function drawChart() {
	        var container = document.getElementById('timeline');
	        var chart = new google.visualization.Timeline(container);
	        var dataTable = new google.visualization.DataTable();

	        dataTable.addColumn({ type: 'string', id: 'President' });
	        dataTable.addColumn({ type: 'date', id: 'Start' });
	        dataTable.addColumn({ type: 'date', id: 'End' });
	        dataTable.addRows([
	          [ 'Washington', new Date(1789, 3, 30), new Date(1797, 2, 4) ],
	          [ 'Adams',      new Date(1797, 2, 4),  new Date(1801, 2, 4) ],
	          [ 'Jefferson',  new Date(1801, 2, 4),  new Date(1809, 2, 4) ]]);

	        chart.draw(dataTable);
	      }
	    </script>
	 
	    <div id="timeline" style="height: 180px;"></div>
	</div>
	-->
	<div class="row">
		<div class="col-md-12">
			<div style="position:relative" class="gantt" id="GanttChartDIV"></div>
	
			<script>
				// here's all the html code neccessary to display the chart object

				// Future idea would be to allow XML file name to be passed in and chart tasks built from file.

				var g = new JSGantt.GanttChart('g',document.getElementById('GanttChartDIV'), 'day');

				g.setShowRes(0); 								// Show/Hide Responsible (0/1)
				g.setShowDur(1); 								// Show/Hide Duration (0/1)
				g.setShowComp(0); 								// Show/Hide % Complete(0/1)
				g.setCaptionType('None');  						// Set to Show Caption (None,Caption,Resource,Duration,Complete)
				g.setShowStartDate(1); 							// Show/Hide Start Date(0/1)
				g.setShowEndDate(1); 							// Show/Hide End Date(0/1)
				g.setDateInputFormat('dd/mm/yy')  				// Set format of input dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
				g.setDateDisplayFormat('dd/mm/yy') 				// Set format to display dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
				g.setFormatArr("day","week","month","quarter") 	// Set format options (up to 4 : "minute","hour","day","week","month","quarter")


				//var gr = new Graphics();

				if( g ) {

					// Parameters (pID, pName, pStart, pEnd, pColor, pLink, pMile, pRes,  pComp, pGroup, pParent, pOpen, pDepend, pCaption)
					// ID, Nombre, Fecha Inicio, Fecha Fin, Color, Link, Milestone, Nombre de recurso, Porcentaje Completo, Cual es el padre, Abierto, Lista de ids que dependen, Nombre que 
					// saldra al lado

					g.AddTaskItem(new JSGantt.TaskItem(1,   'Define Chart API', '', '', 'ff0000', 'http://help.com', 0, 'Brian', 0, 1, 0, 1));
					g.AddTaskItem(new JSGantt.TaskItem(11,  'Chart Object', '7/20/2008', '7/20/2008', 'ff00ff', 'http://www.yahoo.com', 1, 'Shlomy',  100, 0, 1, 1));
					g.AddTaskItem(new JSGantt.TaskItem(12,  'Task Objects', '', '', '00ff00', '', 0, 'Shlomy',   40, 1, 1, 1));
					g.AddTaskItem(new JSGantt.TaskItem(121, 'Constructor Proc', '7/21/2008', '8/9/2008',  '00ffff', 'http://www.yahoo.com', 0, 'Brian T.', 60, 0, 12, 1));
					g.AddTaskItem(new JSGantt.TaskItem(122, 'Task Variables', '8/6/2008',  '8/11/2008', 'ff0000', 'http://help.com', 0, 'Brian',         60, 0, 12, 1,121));
					g.AddTaskItem(new JSGantt.TaskItem(123, 'Task by Minute/Hour', '8/6/2008',  '8/11/2008 12:00', 'ffff00', 'http://help.com', 0, 'Ilan', 60, 0, 12, 1,121));
					g.AddTaskItem(new JSGantt.TaskItem(124, 'Task Functions', '8/9/2008',  '8/29/2008', 'ff0000', 'http://help.com', 0, 'Anyone', 60, 0, 12, 1, 0, 'This is another caption'));
					g.AddTaskItem(new JSGantt.TaskItem(2,   'Create HTML Shell', '8/24/2008', '8/25/2008', 'ffff00', 'http://help.com', 0, 'Brian', 20, 0, 0, 1,122));
					g.AddTaskItem(new JSGantt.TaskItem(3,   'Code Javascript','', '', 'ff0000', 'http://help.com', 0, 'Brian',     0, 1, 0, 1 ));
					g.AddTaskItem(new JSGantt.TaskItem(31,  'Define Variables','7/25/2008', '8/17/2008', 'ff00ff', 'http://help.com', 0, 'Brian', 30, 0, 3, 1, '','Caption 1'));
					g.AddTaskItem(new JSGantt.TaskItem(32,  'Calculate Chart Size', '8/15/2008', '8/24/2008', '00ff00', 'http://help.com', 0, 'Shlomy',   40, 0, 3, 1));
					g.AddTaskItem(new JSGantt.TaskItem(33,  'Draw Taks Items', '', '', '00ff00', 'http://help.com', 0, 'Someone',  40, 1, 3, 1));
					g.AddTaskItem(new JSGantt.TaskItem(332, 'Task Label Table', '8/6/2008',  '8/11/2008', '0000ff', 'http://help.com', 0, 'Brian', 60, 0, 33, 1));
					g.AddTaskItem(new JSGantt.TaskItem(333, 'Task Scrolling Grid', '8/9/2008',  '8/20/2008', '0000ff', 'http://help.com', 0, 'Brian', 60, 0, 33, 1));
					g.AddTaskItem(new JSGantt.TaskItem(34,  'Draw Task Bars', '', '', '990000', 'http://help.com', 0, 'Anybody',  60, 1, 3, 0));
					g.AddTaskItem(new JSGantt.TaskItem(341, 'Loop each Task', '8/26/2008', '9/11/2008', 'ff0000', 'http://help.com', 0, 'Brian', 60, 0, 34, 1));
					g.AddTaskItem(new JSGantt.TaskItem(342, 'Calculate Start/Stop', '9/12/2008', '10/18/2008', 'ff6666', 'http://help.com', 0, 'Brian', 60, 0, 34, 1));
					g.AddTaskItem(new JSGantt.TaskItem(343, 'Draw Task Div', '10/13/2008', '10/17/2008', 'ff0000', 'http://help.com', 0, 'Brian', 60, 0, 34, 1));
					g.AddTaskItem(new JSGantt.TaskItem(344, 'Draw Completion Div', '10/17/2008', '11/04/2008', 'ff0000', 'http://help.com', 0, 'Brian', 60, 0, 34, 1,"342,343"));
					g.AddTaskItem(new JSGantt.TaskItem(35,  'Make Updates', '12/17/2008','2/04/2009','f600f6', 'http://help.com', 0, 'Brian', 30, 0, 3,  1));

					g.Draw();	
					g.DrawDependencies();

				}else{
					alert("not defined");
				}
			</script>

		</div>
	</div>
@stop