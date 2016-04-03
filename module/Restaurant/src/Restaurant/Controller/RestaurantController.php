<?php namespace Restaurant\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 
 use Restaurant\Model\Restaurant;
 use Restaurant\Form\AddEditRestaurant;

 class RestaurantController extends AbstractActionController
 {
	protected $restaurantTable;
     public function indexAction()
     {
		 return new ViewModel(array(
             'restaurants' => $this->getRestaurantTable()->fetchAll(),
         ));
     }
     public function viewAction()
     {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('restaurant');
        }
         try {
             $r = $this->getRestaurantTable()->getRestaurant($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'index'
             ));
         }
		 return array('restaurant' => $r);
     }

     public function addAction()
     {
		$form=new AddEditRestaurant();
		$form->get('submit')->setValue('Add');
		
		$request=$this->getRequest();
		if($request->isPost()){
			$r=new Restaurant();
			$form->setInputFilter($r->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				$r->exchangeArray($form->getData());
				$this->getRestaurantTable()->saveRestaurant($r);
				return $this->redirect()->toRoute('restaurant');
			}
		}
		
		return array('form'=>$form);
     }

     public function editAction()
     {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'add'
             ));
        }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $r = $this->getRestaurantTable()->getRestaurant($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('restaurant', array(
                 'action' => 'index'
             ));
         }

		$form=new AddEditRestaurant();
         $form->bind($r);
		$form->get('submit')->setValue('Save Changes');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($r->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getRestaurantTable()->saveRestaurant($r);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('restaurant');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );

     }

     public function deleteAction()
     {
		 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('restaurant');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getRestaurantTable()->deleteRestaurant($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('restaurant');
         }

         return array(
             'id'    => $id,
             'restaurant' => $this->getRestaurantTable()->getRestaurant($id)
         );
     }
	 
	 public function getRestaurantTable()
     {
         if (!$this->restaurantTable) {
             $sm = $this->getServiceLocator();
             $this->restaurantTable = $sm->get('Restaurant\Model\RestaurantTable');
         }
         return $this->restaurantTable;
     }
 }

