<?php namespace Restaurant\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Restaurant implements InputFilterAwareInterface
{
	public $id;
	public $name;
	public $city;
	public $country;
	public $rating;
	
	protected $inputFilter;

    public function exchangeArray($data)
    {
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->city  = (!empty($data['city'])) ? $data['city'] : null;
		$this->country = (!empty($data['country'])) ? $data['country'] : null;
		$this->rating  = (!empty($data['rating'])) ? $data['rating'] : null;
    }
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not Used");
	}
	public function getInputFilter()
	{
		if(!$this->inputFilter){
			$inputFilter=new InputFilter();
			$inputFilter->add(array('name'=>'id','required'=>true,'filters'=>
				array(array('name'=>'Int'))
			));
			$inputFilter->add(array('name'=>'name','required'=>true,'filters'=>
				array(array('name'=>'StripTags'),array('name'=>'StringTrim')),'validators'=>
				array(array('name'=>'StringLength','options'=>
					array('encoding'=>'UTF-8','min'=>1,'max'=>100)
				))
			));
			$inputFilter->add(array('name'=>'city','required'=>true,'filters'=>
				array(array('name'=>'StripTags'),array('name'=>'StringTrim')),'validators'=>
				array(array('name'=>'StringLength','options'=>
					array('encoding'=>'UTF-8','min'=>1,'max'=>45)
				))
			));
			$inputFilter->add(array('name'=>'country','required'=>true,'filters'=>
				array(array('name'=>'StripTags'),array('name'=>'StringTrim')),'validators'=>
				array(array('name'=>'StringLength','options'=>
					array('encoding'=>'UTF-8','min'=>1,'max'=>45)
				))
			));
			$inputFilter->add(array('name'=>'rating','required'=>true,'filters'=>
				array(array('name'=>'Int'))
			));
			
			$this->inputFilter=$inputFilter;
		}
		
		return $this->inputFilter;
	}
}