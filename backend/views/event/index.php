<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\widget\JSRegister;
use backend\models\Event;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = \Yii::getAlias('@web');
$this->title = 'ปฏิทินส่วนบุคคล';
$this->params['breadcrumbs'][] = $this->title;


$str2 = <<<EOT
$('#submit').click(function(){

		var formData = new FormData();
		formData.append('event_name', $('input[id=event_name]').val());
		formData.append('start_date', $('input[id=datetimepicker1]').val());
		formData.append('end_date', $('input[id=datetimepicker2]').val());
		formData.append('description', $('textarea[id=description]').val());
		var type = $('input[name="CheckType"]:checked').val();
		formData.append('type', type);
		
		//ต้อง Get ค่าจากDatabase ตอนนี้Fixค่า
		formData.append('color', (type == 1)?'#1a1aff':'#009900');
		
		var request = new XMLHttpRequest();
		request.open("POST", "$baseUrl/index.php?r=event/save", true);
		request.onreadystatechange = function () {
	        if(request.readyState === XMLHttpRequest.DONE && request.status === 200) {
				debugger;
	       	    var response = request.responseText;
	            if(typeof(response) == "string"){
	            	response = JSON.parse(request.responseText);
	            }
	      
	     

	        }
	    };
		request.send(formData);
		location.reload();

});
EOT;

$this->registerJs($str2, View::POS_END);

?>

<?php JSRegister::begin(); ?>
<script>
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// <?php 
// 	$day = "2017/11/12";
// 	var_dump(getdate($day));
// ?>

// function splitdate(day){
// 	console.log(day);
// 	console.log((day.getFullYear()-543)+'/'+(day.getMonth()+1)+'/'+day.getDate());
// 	//return (day.getFullYear()-543)+'/'+(day.getMonth()+1)+'/'+day.getDate();
// };
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



$(function () {

     var date = new Date();
     var d = date.getDate(),
         m = date.getMonth(),
         y = date.getFullYear();
     $('#calendar').fullCalendar({
       header: {
         left: 'prev,next, today, createEvent',
         center: 'title',
         right: 'listYear,month,agendaWeek,agendaDay'
       },
       buttonText: {
           today: 'วันนี้',
           year: 'ปี',
           month: 'เดือน',
           week: 'สัปดาห์',
           day: 'วัน'
         },
         customButtons: {
        	 createEvent: {
               text: 'สร้างกิจกรรม',
            	   click:  function(event, jsEvent, view) {
                       $('#modalTitle').html("สร้างกิจกรรม");
                       $('#modalBody').html(event.description);
//                        $().html();
                       $('#eventUrl').attr('href',event.url);
                       $('#calendarModal').modal();
               }
             }
           },

      events: [
	  <?php foreach ($value as $field): {?>
	  
		{
		  title: <?php echo "'".$field->Event_name."'";?>,
		
		  
		  start: new Date(<?php echo "\"".$field->Start_Date."\"";?>),
		  end: new Date(<?php echo "\"".$field->End_Date."\"";?>),
		  backgroundColor: <?php echo "\"".$field->Color."\"";?>, //red
		  borderColor: <?php echo "\"".$field->Color."\"";?> //red  
	    },
	  <?php  }?>
	  <?php endforeach; ?>
			  
      ],
     

      editable: false,
      disableDragging: true,
      eventLimit: true,

      //Test
//       eventClick: function(event, element) {

//           event.title = "CLICKED!";

//           $('#calendar').fullCalendar('updateEvent', event);
//       },
//       eventRender: function(event, element) {
//           element.append( "<span class='closeon'>X</span>" );
//           element.find(".closeon").click(function() {
//              $('#calendar').fullCalendar('removeEvents',event._id);
//           });
//       }

      
    });
    
   
  });
$(function () {
	jQuery('#datetimepicker1').datetimepicker();
	jQuery('#datetimepicker2').datetimepicker();
});
	</script>
<?php JSRegister::end(); ?>



<div class="event-index">
   <div class="wrapper">
    <section class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
              	
              	<div id="calendarModal" class="modal fade">
					<div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">X</span> <span class="sr-only">close</span></button>
					            <h4 id="modalTitle" class="modal-title"></h4>
					        </div>
					        <div id="modalBody" class="modal-body">
					        	
					        	<div class="form-group">
								  <label for="usr">หัวข้อกิจกรรม</label>
								  <input type="text" class="form-control" id="event_name">
								</div>
								<div class="form-group">
					                <div class='input-group date' >
					                    <input id='datetimepicker1' type='text' class="form-control" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					            </div>
					            <div class="form-group">
					                <div class='input-group date' >
					                    <input id='datetimepicker2' type='text' class="form-control" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					            </div>
								<div class="form-group">
								  <label for="comment">รายละเอียด</label>
								  <textarea class="form-control" rows="5" id="description"></textarea>
								</div>
								<label for="usr">ประเภทกิจกรรม</label>
								<div class="radio">
								  <label><input type="radio" id="optradio" name="CheckType" value="1">ประชุม</label><br>
								  <label><input type="radio" id="optradio2" name="CheckType" value="2">ส่วนตัว</label>
					        	</div>
					        	
					      
					        	
					         </div>
					        <div class="modal-footer">
					        	<button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            				    <button type="button" class="btn btn-success" data-dismiss="modal" id="submit">บันทึก</button>
        						 
				        </div>
				    </div>
				</div>
				</div>
              	
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>