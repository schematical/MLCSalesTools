<?php
abstract class MSTDriver{
	public static function Init(){

	}
	public static function TriggerNotification($strSubject, $arrData){
        $objAccount = AuthAccount::LoadById(__MST_ACCOUNT__);

        $objNotification = new MLCSTNotification();

        $objNotification->SetData($arrData);
        $objNotification->Subject = $strSubject;

        MLCNotificationDriver::Send($objNotification, $objAccount);

    }
	public static function QueryHighrise($mixEmail){
		if(is_string($mixEmail)){
			$strEmail = $mixEmail;
		}elseif(is_object($mixEmail)){
			if($mixEmail instanceof MLCEmailMessage){
				$strEmail = $mixEmail->GetFromAddress();
			}elseif($mixEmail instanceof AuthUser){
				$strEmail = $mixEmail->Email;
			}
		}
		$arrPeople = MLCHRPeople::QueryArray($strEmail);	
		return $arrPeople;
	}
}