<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\widget\JSRegister;
use backend\models\Event;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ปฏิทินส่วนบุคคล';
$this->params['breadcrumbs'][] = $this->title;

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

    /* initialize the external events
     -----------------------------------------------------------------*/
     function ini_events(ele) {
         ele.each(function () {

           // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
           // it doesn't need to have a start or end
           var eventObject = {
             title: $.trim($(this).text()) // use the element's text as the event title
           };

           // store the Event Object in the DOM element so we can get to it later
           $(this).data('eventObject', eventObject);

           // make the event draggable using jQuery UI
           $(this).draggable({
             zIndex: 1070,
             revert: false, // will cause the event to go back to its
             revertDuration: 0  //  original position after the drag
           });

         });
       }

     ini_events($('#external-events div.external-event'));

     /* initialize the calendar
      -----------------------------------------------------------------*/
     //Date for the calendar events (dummy data)
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
          
              
           
           
      //Random default events++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
      droppable: false, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
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
								  <input type="text" class="form-control" id="usr">
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
								  <label for="comment">แสดงความคิดเห็น</label>
								  <textarea class="form-control" rows="5" id="comment"></textarea>
								</div>
								<label for="usr">ประเภทกิจกรรม</label>
								<div class="radio">
								  <label><input type="radio" name="optradio">ประชุม</label><br>
								  <label><input type="radio" name="optradio2">ส่วนตัว</label>
					        	</div>
					        	
					      
					        	
					         </div>
					        <div class="modal-footer">
            				      <button type="button" class="btn btn-success" data-dismiss="modal">บันทึก</button>
        						 <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
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