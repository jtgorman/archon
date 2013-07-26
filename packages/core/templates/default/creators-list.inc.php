<?php
header('Content-Type: application/json');

isset($_ARCHON) or die();

$session= $_SERVER['HTTP_SESSION'];
if ($_ARCHON->Security->Session->verifysession($session)){

   if (isset($_REQUEST['batch_start'])){

            //Handles the zero condition
            $start = ( $_REQUEST['batch_start'] < 1 ? 1: $_REQUEST['batch_start']);

            $arrCreatorsrelated = getrelatedcreators();

            // pulls Batches of 100 across

           $arrCreators =array_slice($_ARCHON->getAllCreators(),$start-1,100,true);
		   header('HTTP/1.0 200 Created');				
				if (empty($arrCreators)) {
					exit ("No matching record(s) found for batch_start=".$_REQUEST['batch_start']);
				}
		   
           // $arrCreators = $_ARCHON->getAllCreators();
				//echo print_R($arrCreators);
            foreach ($arrCreatorsrelated as $creatrel)
             {
                 $arrcreaterel = array($creatrel['RelatedCreatorID']=> $creatrel['CreatorRelationshipTypeID']);
                $arrCreators[$creatrel['CreatorID']]->CreatorRelationships[] = $arrcreaterel;

            }
			array_walk($arrCreators,'Removefield');
            echo json_encode(array_slice(RemoveBad($arrCreators),$start-1,100,true));

        }else{
			header('HTTP/1.0 400 Bad Request');
            echo "batch_start Not found! Please enter a batch_start and resubmit the request.";
        }
} else {
		header('HTTP/1.0 400 Bad Request');
        echo "Please submit your admin credentials to p=core/authenticate";
}

//FUNCTIONS
function getrelatedcreators()
{
    global $_ARCHON;


        $query = "SELECT CreatorID,RelatedCreatorID,CreatorRelationshipTypeID FROM tblCreators_CreatorCreatorIndex";
        $result = $_ARCHON->mdb2->query($query);


        if(PEAR::isError($result))
        {
            trigger_error($result->getMessage(), E_USER_ERROR);
        }

        while($row = $result->fetchRow())
        {
            $arrCreatorsrelated [] = $row;

        }

        $result->free();
        $result->free();
        return $arrCreatorsrelated;

}
function RemoveBad($Creators) {
    
	array_walk($Creators, 'Removefield');		
    return $Creators;
}

function Removefield($item,$key){
	unset($item->LanguageID);
	unset($item->ScriptID);
	unset($item->CreatorType);
	unset($item->CreatorSource);
	unset($item->Repository);
	unset($item->Script);
	unset($item->ToStringFields);
	unset($item->Collections);
	unset($item->Books);
	unset($item->Accessions); 
	unset($item->DigitalContent);
	unset($item->Language);
	unset($item->Creators);

}
?>
