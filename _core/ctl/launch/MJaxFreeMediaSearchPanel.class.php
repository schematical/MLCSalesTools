<?php
class MJaxFreeMediaSearchPanel extends MJaxPanel{
	const FLICKER_URL = 'http://www.flickr.com/search/?l=commderiv&mt=all&adv=1&w=all&m=text&q=';
	 public $txtSearch = null;
	 public $btnSearch = null;
	 public function __construct($objParentControl, $objMDEApp = null) {
        parent::__construct($objParentControl, $objMDEApp);        
        $this->strTemplate = __MDE_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';
		$this->txtSearch = new MJaxTextBox($this);
		
		$this->btnSearch = new MJaxButton($this);
		$this->btnSearch->Text = 'Search';
		$this->btnSearch->AddAction($this, 'btnSearch_click');
		
		
	 }
	 public function btnSearch_click(){
	 	$this->objForm->Redirect(self::FLICKER_URL . $this->txtSearch->Text);
	 }
}
