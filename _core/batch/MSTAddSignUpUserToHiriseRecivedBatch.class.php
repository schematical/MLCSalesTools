<?php
MLCApplication::InitPackage('MLCSysConfig');
class MSTAddSignUpUserToHiriseRecivedBatch extends MLCBatchJob{
	public function Exicute(){
		$intIdUser = MLCSys::Get(MSTSys::LastSignUpUserAddedToHighrise);
		
		if(!is_null($intIdUser)){
			$arrUsers = AuthUser::Query(
				sprintf(
					'WHERE idUser > %s ORDER BY idUser DESC',
					$intIdUser
				)
			);
		}else{
			$arrUsers = AuthUser::LoadAll()->getCollection();
		}
		$intLastIdUser = null;
		foreach($arrUsers as $intIndex => $objUser){
			$intLastIdUser = $objUser->IdUser;
			//Add user to highrise			
			$arrPeople = MLCHRPeople::QueryArray($objUser->Email);
			
			if(count($arrPeople) == 0){
				$objHRPerson = new MLCHRPeople();
				$objHRPerson->AddEmail($objUser->Email);
				$objHRPerson->AddSubjectData($objUser->IdUser, MSTHighriseData::id_user);
				$arrParts = explode(' ', $objUser->Username);
				if(strlen($objUser->Username) == 0){
					$objHRPerson->FirstName = "Unknown";
					$objHRPerson->LastName = "Unknown";
				}elseif(count($arrParts) > 1){
					$objHRPerson->FirstName = $arrParts[0];
					$objHRPerson->LastName = $arrParts[1];
				}else{
					$objHRPerson->FirstName = $objUser->Username;
				}
				$arrPeople[] = $objHRPerson;
			}
			foreach($arrPeople as $intIndex => $objHRPerson){
				if(SERVER_ENV == 'prod'){
					$objHRPerson->AddSubjectData($objUser->IdUser, MSTHighriseData::id_user);				
					$objHRPerson->Save();
					//Set Task
					$objHRPerson->AttachTask("Contact new user signup", MLCHRTaskFrame::tomorrow);
					//Add task to follow upMLCSys::Set(MSTSys::LastSignUpUserAddedToHighrise, $intLastIdUser); 
				}
			}
			
		}
		if(!is_null($intLastIdUser)){
			MLCSys::Set(MSTSys::LastSignUpUserAddedToHighrise, $intLastIdUser); 
		}
	}
}
