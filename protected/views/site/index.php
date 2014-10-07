<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="container">
		
		<div class="rov">
			<?php echo $form->labelEx($model,'string'); ?>
			<?php echo $form->textField($model,'string'); ?>
			<?php echo $form->error($model,'string'); ?>
		</div>
		
	</div>
	
	

	<div class="row buttons">
		
		<div>
			<?php echo CHtml::submitButton('Search Contact'); ?>
			<?php echo CHtml::button('Add New Contact', array('onclick' => 'js:document.location.href="/webapp/index.php?r=site/addcontact"', 'class' => 'pull-right'));?>
		</div>
		<?php echo $form->labelEx($model,'Exact Match'); ?>
		<?php echo $form->checkBox($model,'check'); ?>
		<?php echo $form->error($model,'check'); ?>
		
		
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php 

//dispaly results table

	echo "<br><br><br>";

	if(isset($dataProvider))
	{
	
		echo "Number of results: ".(sizeof($dataProvider))."<br><br><br>";
	
		if(sizeof($dataProvider)>0)
		{
		
			echo "<div>";
			echo "<table border='2' style=\"width:100%\">";
			echo "<tr>";
			echo "<td><b>N°</b></td>";
			echo "<td><b>Name</b></td>";
			echo "<td><b>Surname</b></td>";
			echo "<td><b>Phone Number</b></td>";
			echo "<td><b>Edit</b></td>";
			echo "</tr>";
			
			for($i=0; $i<sizeof($dataProvider); $i++)
			{
				echo "<tr>";
				echo "<td>".($i + 1)."</td>";
				echo "<td>".$dataProvider[$i]->name."</td>";
				echo "<td>".$dataProvider[$i]->surname."</td>";
				echo "<td>".$dataProvider[$i]->number."</td>";
				echo "<td>".CHtml::button('Edit', array('submit' => array('site/editcontact', 'id'=>$dataProvider[$i]->id)))."</td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "</div>";
			
		}
	}


?>