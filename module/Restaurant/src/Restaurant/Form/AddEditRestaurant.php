<?php namespace Restaurant\Form;
use Zend\Form\Form;

class AddEditRestaurant extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('restaurant');
		$this->add(array('name'=>'id','type'=>'Hidden'));
		$this->add(array('name'=>'name','type'=>'Text','options'=>
			array('label'=>"Restaurant Name")
		));
		$this->add(array('name'=>'city','type'=>'Text','options'=>
			array('label'=>"City")
		));
		$this->add(array('name'=>'country','type'=>'Text','options'=>
			array('label'=>"Country")
		));
		$this->add(array('name'=>'rating','type'=>'Radio','options'=>
			array('label'=>"Rating",'value_options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'))
		));
		
		$this->add(array('name'=>'submit','type'=>'submit','attributes'=>
			array('value'=>"Go",'id'=>'submitBtn')
		));
	}
}