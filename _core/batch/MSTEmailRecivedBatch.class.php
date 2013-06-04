<?php
MLCApplication::InitPackage('MLCUrbanAirship');
class MSTEmailRecivedBatch extends MLCBatchJob{
	public function Exicute(){
		MLCApplication::InitPackage('MLCEmail');
		$arrUsers = array(
			array(
				'email' =>'mlea@mattleaconsulting.com',
				'pass' =>'geekgeek'
			)
		);
		foreach($arrUsers as $intIndex => $arrUser){
			MLCEmailDriver::Connect(
				$arrUser['email'],
				$arrUser['pass'],
				'{imap.gmail.com:993/imap/ssl}INBOX'
			);
			$arrMessages = MLCEmailDriver::GetMessages();
			
			$this->ParseInbox($arrMessages);
			MLCEmailDriver::Close();
		}
	}
	public function ParseInbox($arrMessages){
		
		foreach($arrMessages as $intIndex => $objEmail){
			//_dp($objEmail->GetHeaderInfo());
			$strBody = $objEmail->GetTextBody();			
			if(is_null($strBody)){
				return false;
			}
			$this->ParseEmailHighrise($objEmail);
			$this->ParseEmailAlert($objEmail);

		}
		
	}
	public function ParseEmailAlert(MLCEmailMessage $objEmail){
		
		$strToAddress = $objEmail->GetToAddress();		
		if($strToAddress == __MLC_SALESTOOLS_ALERT_ADDRESS__){
		
			$objEmail->CopyToFolder('{imap.gmail.com:993/imap/ssl}mlc_email_bot');
		}
	}
	public function ParseEmailHighrise($objEmail){
		$arrPeople = MSTDriver::QueryHighrise($objEmail);
		if(
			(count($arrPeople)== 1) && 
			$objEmail->Unseen
		){
			foreach($arrPeople as $intIndex => $objPeople){
				if(SERVER_ENV == 'prod'){
					$objPeople->AttachEmail($strBody, $strSubject);
				}
			}
		}
	}
}
