<?
	define('STOP_STATISTICS', true);
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
	global $APPLICATION, $DB, $USER;
	
	$default_result = array("result" => false, "err_code" => 0);
	$batch_result = array('result' => array());
	$is_batch = !empty($_REQUEST['is_batch']);
	$source = $is_batch ? $_REQUEST['queries'] : array(array('qid' => 0, 'params' => $_REQUEST));
	
	if(CModule::IncludeModule("vsoft.wishlist") && CModule::IncludeModule("iblock")) {
		foreach($source as $from) {
			$result = $default_result;
			$qid = $from['qid'];
			$params = $from['params'];
			$action = $params["ACTION"];
			
			/*echo '<pre>';print_r($action);echo '</pre>';
			echo '<pre>';print_r($params);echo '</pre>';*/
			
			$WL_USER_ID = CVWishlist::GetWLUserID(false);
			
			switch($action){
				case 'DELETE':
						$wID = intval($params["WID"]);//ID product in wishlist
						if($wID <= 0){
							$pID = intval($params["PID"]); //PRODUCT_ID
							$iID = intval($params["IID"]); //IBLOCK_ID
							if($pID > 0 && $iID > 0){
								$dbWID = CVWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM3" => $pID, "PARAM2" => $iID), array("ID"));
								if($arWID = $dbWID->GetNext()){
									$wID = $arWID["ID"];
								}
							}
						}
						
						if($wID > 0){
							if(CVWishlist::GetCount(array("ID" => $wID, "WL_USER_ID" => $WL_USER_ID)) > 0){
								CVWishlist::Delete($wID);
								$result["result"] = true;
							}else{
								$result["err_code"] = -100;//security exception
							}
						}else{
							$result["err_code"] = -3;//wID doesn't exists, can't delete 0;
						}
					break;
				case 'ADD': 
					$param1 = $params["PARAM1"];
					$param2 = intval($params["PARAM2"])?:false;
					$param3 = intval($params["PARAM3"]);
					
					if($param3 <= 0) {$result["err_code"] = -4;/*unknow element*/ break;}
					
					if(!$param2){
						$param2 = CIBlockElement::GetIBlockByID($param3);
						if(!$param2){$result["err_code"] = -5;/*unknown iblock_id*/ break;}
					}
					
					$dbWishlistElement = CVWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3), array("ID"));
					if($arWishlistElement = $dbWishlistElement->GetNext()){
						//element already exists
						$result["WID"] = $arWishlistElement["ID"];
					}else{
						//add element to wishlist
						$result["WID"] = CVWishlist::Add(array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3));
					}
					
					$result["result"] = true;
					
					break;
				case 'CHECK':
					if($WL_USER_ID){
						$param1 = $params["PARAM1"];
						$param2 = intval($params["PARAM2"])?:false;
						$param3 = intval($params["PARAM3"]);
						
						$dbWishlistElement = CVWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3), array("ID"));
						if($arWishlistElement = $dbWishlistElement->GetNext()){
							//element already exists
							$result["WID"] = $arWishlistElement["ID"];
							$result["result"] = true;
						}
					}
					break;
				default: $result["err_code"] = -2; /*unknown action type*/
					break;
			}
			
			$result["ELEMENTS_COUNT"] = CVWishlist::GetCount(array("WL_USER_ID" => $WL_USER_ID));
			
			if($result['ELEMENTS_COUNT'] <= 0){//remove empty users
				if($WL_USER_ID > 0){
					CVWishlistUser::Delete($WL_USER_ID);
					$_SESSION["V_WL_USER_ID"] = false;
					SetCookie("V_WL_USER_ID", false, false, "/", false);
				}
			}
			
			$batch_result['result'][$qid] = $result;
		}
	}else{
		$result["err_code"] = -1;//Модуль не установлен
	}
	
	echo json_encode(($is_batch ? $batch_result : $batch_result['result'][0]));
	die();
?>