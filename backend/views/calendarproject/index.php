<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\widget\JSRegister;
use backend\models\Event;
//use backend\models\CsvForm;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;


/*x @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = \Yii::getAlias('@web');
$this->title = 'ปฏิทินโครงการ';
$this->params['breadcrumbs'][] = $this->title;


$str2 = <<<EOT
$('#submit').click(function(){
		var formData = new FormData();
		var eventName = $('input[id=event_name]').val().trim();
		var startDate = $('input[id=datetimepicker1]').val().trim();
		var endDate = $('input[id=datetimepicker2]').val().trim();
		var title = $('input[id=event_name]').val();
		if(title.trim().length > 0){
		if(eventName != "" && startDate != "" && endDate != ""){
			formData.append('event_name', eventName);
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		formData.append('description', $('textarea[id=description]').val());
		var type = $('input[name="CheckType"]:checked').val();
		formData.append('type', type);
		
		//ต้อง Get ค่าจากDatabase ตอนนี้Fixค่า
		formData.append('color', (type == 6)?'#9999ff':'#ccff33');
		
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
		}
	}
});
EOT;

$this->registerJs($str2, View::POS_END);

?>

<?php JSRegister::begin(); ?>
<script>
$(function () {
     var date = new Date();
     var d = date.getDate(),
         m = date.getMonth(),
         y = date.getFullYear();
     $('#calendar').fullCalendar({
       header: {
         left: 'prev,next, today, createEvent,createHoliday',
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
                       $('#modalTitleEdit').html("แก้ไขกิจกรรม");
                       $('#modalBody').html(event.description);
                       $('#eventUrl').attr('href',event.url);
                       $('#calendarModal').modal();
               }
             },
         	createHoliday: {
             text: 'สร้างวันหยุด',
          	   click:  function() {
          		 document.location = "index.php?r=upload";
             }
           }
           },

      events: [
	  <?php foreach ($value as $field): {?>
		{
		  title: <?php echo "'".$field->Event_name."'";?>,
		  start: new Date(<?php echo "\"".$field->Start_Date."\"";?>),
		  end: new Date(<?php echo "\"".$field->End_Date."\"";?>),
		  discription: <?php echo "\"".$field->Discription."\"";?>,
		  backgroundColor: <?php echo "\"".$field->Color."\"";?>,
		  borderColor:"#000000",
		  type: <?php echo "\"".$field->Type."\"";?>,
	    },
	  <?php  }?>
	  <?php endforeach; ?>
			  
      ],
     

      editable: false,
      disableDragging: true,
      eventLimit: true,

      //Test
      eventClick: function(event, element) {
    	  console.log((event));
		  var date_s = event.start;
		  var date_e = event.end;
//     	  console.log((date_s._d).format('m\\/d\\/Y H\\:i'));
//     	  console.log((date_s._d));
    	  $("#event_name_Edit").val(event.title);
    	  $("#datetimepicker_Start_Edit").val((date_s._d).format('Y\\/d\\/m H\\:i'));
    	  $("#datetimepicker_End_Edit").val((date_e._d).format('Y\\/d\\/m H\\:i'));
    	  $("#description_Edit").val(event.discription);
    	  var check_radio = event.type;
    	  if(check_radio == "1"){
    		  $("#optradio_edit").prop('checked', true);
    	  }else if(check_radio == "2"){
    		  $("#optradio2_edit").prop('checked', true);
    	  }
    	  $('#calendarModalEdit').modal('show');
    	  
      },
    }

     <?php
     	if(isset($_FILES['image'])){
     	$errors= array();
     	$file_name = $_FILES['image']['name'];
     	$file_size =$_FILES['image']['size'];
     	$file_tmp =$_FILES['image']['tmp_name'];
     	$file_type=$_FILES['image']['type'];
     	$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
     
     	$expensions= array("csv");
     	
     	if(in_array($file_ext,$expensions)=== false){
     		$errors[]="extension not allowed, please choose a CSV file.";
     	}
     
     	if($file_size > 2097152){
     	   $errors[]='File size must beww excately 2 MB';
     	}
     	

     	$targetfolder = 'images/';
     	
     	//Usage of basename() function
//      	$targetfolder = $targetfolder . basename( $_FILES['image']['name']) ;
//      	$uploads_dir = 'E:/PCMS/CalendarProject1/backend/views/event/images';
     	if(empty($errors)==true){
     		move_uploaded_file($file_tmp,$targetfolder.$file_name);
     	}else{
     		print_r($errors);
     	}
     }
		?>
     
     );
    
   
  });
$(function () {
	jQuery.datetimepicker.setLocale('th');
	jQuery('#datetimepicker1').datetimepicker({
		minDate:'0',
		format:'Y/m/d H:i',
		formatDate:'Y/m/d',
		onShow:function( ct ){
			   this.setOptions({
			    maxDate:jQuery('#datetimepicker1').val()?jQuery('#datetimepicker1').val():false
			   })
			  },
		timepicker:true,
	});
	jQuery('#datetimepicker2').datetimepicker({
		format:'Y/m/d H:i',
		formatDate:'Y/m/d',
		onShow:function( ct ){
			   this.setOptions({
			    minDate:jQuery('#datetimepicker1').val()?jQuery('#datetimepicker1').val():false
			   })
			  },
		 timepicker:true,
	});
	jQuery('#datetimepicker_Start_Edit').datetimepicker({
		minDate:'0',
		format:'Y/m/d H:i',
		formatDate:'Y/m/d',
		onShow:function( ct ){
			   this.setOptions({
			    maxDate:jQuery('#datetimepicker_End_Edit').val()?jQuery('#datetimepicker_End_Edit').val():false
			   })
			  },
		timepicker:false
	});
	jQuery('#datetimepicker_End_Edit').datetimepicker({
		format:'Y/m/d H:i',
		formatDate:'Y/m/d',
		onShow:function( ct ){
			   this.setOptions({
			    minDate:jQuery('#datetimepicker_Start_Edit').val()?jQuery('#datetimepicker_Start_Edit').val():false
			   })
			  },
		 timepicker:false
	});
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
					    <div class="modal-content ">
					        <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span> <span class="sr-only">close</span></button>
					            <h4 id="modalTitle" class="modal-title"></h4>
					        </div>
					       <form action="" role="form" data-toggle="validator" id="validate" method="post">
					        <div id="modalBody" class="modal-body">
														        	
					        	<div class="form-group">
								  <label for="usr">หัวข้อกิจกรรม
								  	<span class="required"> * </span>
								  </label>
								  
								  <input type="text" class="form-control " id="event_name" name="eventName" placeholder="หัวข้อกิจกรรม" data-error="กรุณากรอกข้อมูล">
								  <div class="help-block with-errors"></div>
								</div>
								
								<div class="form-group">
								<label for="usr">เริ่มต้น
									<span class="required"> * </span>
								</label>
					                <div class='input-group date' >
					                    <input id='datetimepicker1' type='text' name="startDate" class="form-control" placeholder="วันที่เริ่มต้น" data-error="กรุณากรอกข้อมูล">
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					                <div class="help-block with-errors"></div>
					            </div>
					            <div class="form-group">
					            <label for="usr">สิ้นสุด
					            	<span class="required"> * </span>
					            </label>
					                <div class='input-group date' >
					                    <input id='datetimepicker2' type='text' name="endDate" class="form-control" placeholder="วันที่สิ้นสุด" data-error="กรุณากรอกข้อมูล">
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					                <div class="help-block with-errors"></div>
					            </div>
								<div class="form-group">
								  <label for="comment">รายละเอียด</label>
								  <textarea class="form-control" rows="5" id="comment" name="comment" placeholder="รายละเอียด" id="description"></textarea>
								</div>
								
								<label for="usr">ประเภทกิจกรรม
							
								</label>
															
								<div class="radio">
								  <label><input type="radio" id="optradio" name="CheckType" value="6" data-error="กรุณาเลือก" checked="checked"><span class="fc-event-dot" style="background-color:#9999ff"></span> ประชุม</label><br>
								  <label><input type="radio" id="optradio2" name="CheckType" value="7" data-error="กรุณาเลือก" ><span class="fc-event-dot" style="background-color:#ccff33"></span> อื่นๆ</label>
					        		<div class="help-block with-errors"></div>
					        	</div>

					         </div>
					         
					        <div class="modal-footer">
					        
<!-- 					        <form action="" name="sendFile" method="POST" enctype="multipart/form-data"> -->
<!-- 					        	<input type="file" onchange="sendFile.submit ();" class="btn btn-success" name="image" /> -->
<!-- 					        </form>	 -->
					        
					        	<button type="submit" class="btn btn-success" id="submit">บันทึก</button>
					        	<button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button> 
				        </div>
				    </div>
				</div>
				</div>
				</form>

				<div id="calendarModalEdit" class="modal fade">
					<div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">X</span> <span class="sr-only">close</span></button>
					            <h4 id="modalTitleEdit" class="modal-title"></h4>
					        </div>
					        <div id="modalBody" class="modal-body">
					        	
					        	<div class="form-group">
								  <label for="usr">หัวข้อกิจกรรม
								  	<span class="required"> * </span>
								  </label>
								  <input type="text" class="form-control" id="event_name_Edit" name="eventName" placeholder="หัวข้อกิจกรรม">
								</div>
								<div class="form-group">
								<label for="usr">เริ่มต้น
									<span class="required"> * </span>
								</label>
					                <div class='input-group date' >
					                    <input id='datetimepicker_Start_Edit' type='text' class="form-control" name="startDate" placeholder="วันที่เริ่มต้น">
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					            </div>
					            <div class="form-group">
					            <label for="usr">สิ้นสุด
					            	<span class="required"> * </span>
					            </label>
					                <div class='input-group date' >
					                    <input id='datetimepicker_End_Edit' type='text' class="form-control" name="endDate" placeholder="วันที่สิ้นสุด">
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					            </div>
								<div class="form-group">
								  <label for="comment">รายละเอียด</label>
								  <textarea class="form-control" rows="5" id="description_Edit"></textarea>
								</div>
								<label for="usr">ประเภทกิจกรรม
								</label>
								<div class="radio" id="type">
								  <label><input type="radio" id="optradio_edit" name="CheckType" value="6"><span class="fc-event-dot" style="background-color:#9999ff"></span> ประชุม</label><br>
								  <label><input type="radio" id="optradio2_edit" name="CheckType" value="7"><span class="fc-event-dot" style="background-color:#ccff33"></span> อื่น</label>
					        	</div>
					        	
					     					        	
					         </div>
					        <div class="modal-footer">
					            <button type="submit" class="btn btn-success" id="submit">บันทึก</button>
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
