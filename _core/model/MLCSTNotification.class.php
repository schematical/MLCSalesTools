<?php
MLCApplication::InitPackage('MLCNotification');
class MLCSTNotification extends MLCNotificationObjectBase{
    protected $arrData = array();
    public function __construct($objNotification = null){
        parent::__construct($objNotification);

        $this->strEmailTemplate = __MLC_SALESTOOLS_CORE__ . '/email/MLCSTNotification.tpl.php';
    }
    public function GetData(){
        $arrData = parent::GetData();
        $arrData = array_merge($arrData, $this->arrData);
        return $arrData;
    }
    public function SetData($arrData){
        $this->arrData = $arrData;
    }

}