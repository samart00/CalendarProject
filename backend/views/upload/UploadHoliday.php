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
$this->title = 'สร้างวันหยุด';
$this->params['breadcrumbs'][] = $this->title;

$str2 = <<<EOT
$('#submit').click(function(){
		var formData = new FormData();
		formData.append('event_name', $('input[id=event_name]').val());
		formData.append('start_date', $('input[id=datetimepicker1]').val());
		formData.append('end_date', $('input[id=datetimepicker2]').val());
		formData.append('description', $('textarea[id=description]').val());
		var type = $('input[name="CheckType"]:checked').val();
		formData.append('type', '3');

		//ต้อง Get ค่าจากDatabase ตอนนี้Fixค่า
		formData.append('color', '#ff3333');

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
$(function () {
     var date = new Date();
     var d = date.getDate(),
         m = date.getMonth(),
         y = date.getFullYear();
     $('#calendar').fullCalendar({
       defaultView: 'listYear',
       header: {
         left: 'prev,next, today, createEvent,createHoliday',
         center: 'title',
         right: 'listYear'
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
               text: 'สร้างวันหยุด',
            	   click:  function(event, jsEvent, view) {
                       $('#modalTitle').html("สร้างวันหยุด");
                       $('#modalBody').html(event.description);
                       $('#eventUrl').attr('href',event.url);
                       $('#calendarModal').modal();
               }
             },
             createHoliday: {
                 text: 'นำเข้าวันหยุด',
              	   click:  function(event, jsEvent, view) {
              		 $('#modalHoliday').html("สร้างวันหยุด");
                     $('#modalBody').html(event.description);
                     $('#eventUrl').attr('href',event.url);
                     $('#HolidayModal').modal();
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

$(function() {
	$('#validate').validator()
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
								  <textarea class="form-control" rows="5" placeholder="รายละเอียด" id="description"></textarea>
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
								  <label for="usr">ชื่อวันหยุด
								  	<span class="required"> * </span>
								  </label>
								  <input type="text" class="form-control" id="event_name_Edit">
								</div>
								<div class="form-group">
								<label for="usr">เริ่มต้น
									<span class="required"> * </span>
								</label>
					                <div class='input-group date' >
					                    <input id='datetimepicker_Start_Edit' type='text' class="form-control" />
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
					                    <input id='datetimepicker_End_Edit' type='text' class="form-control" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					            </div>
								<div class="form-group">
								  <label for="comment">รายละเอียด</label>
								  <textarea class="form-control" rows="5" id="description_Edit"></textarea>
								</div>
								
					        	
					     					        	
					         </div>
					        <div class="modal-footer">
					            <button type="button" class="btn btn-success" data-dismiss="modal" id="submit">บันทึก</button>
					        	<button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
 
				            </div>
				    </div>
				</div>
				</div>
				
			</div>
				
				
				<div id="HolidayModal" class="modal fade">
              		
					<div class="modal-dialog">
					    <div class="modal-content ">
					        <div class="modal-header">
					            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span> <span class="sr-only">close</span></button>
					            <h4 id="modalHoliday" class="modal-title"></h4>
					        </div>
					        <div id="modalBody" class="modal-body">
					        	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

							    <?= $form->field($model, 'HolidayFile')->fileInput() ?>
							
							    <button>Submit</button>
								
							<?php ActiveForm::end() ?>
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


