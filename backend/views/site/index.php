<?php

/* @var $this yii\web\View */

$this->title = 'กระดานข่าว';
?>
<div class="site-index">
	<div class="box box-solid">
		<div class="box-header with-border">
			<div class="row">
				<div class="col-md-4">
					<input id="project_name" name="project_name" type="text" placeholder="ชื่อโครงการ" class="form-control">
				</div>
				<div class="col-md-4">
					<input id="status" name="status" type="text" placeholder="สถานะ" class="form-control">
				</div>
				<div class="col-md-4">
					<input id="sort" name="sort" type="text" placeholder="จัดเรียง" class="form-control">
				</div>
			</div>
		</div>
	</div>
		
<?php for($i=0;$i<7;$i++){?>
	<div class="row">
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header with-border box-height">
					<span>
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header with-border box-height">
					<span>
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header with-border box-height">
					<span>
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
						aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
					</span>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div>
